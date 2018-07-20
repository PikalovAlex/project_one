<div class="container">
<form method="post" action="/personal/client/change_order_process" onsubmit="return check_order()">
	<input type="hidden" value="<?=$order->order_id?>" name="id">
	<h2 style="text-align: center">Редактирование заказа</h2>
	<hr>
	<div class="row">
		<?php if (isset($_GET['error'])): ?>
			<h5 style="text-align: center"><i>Ошибка при заполнении формы</i></h5>
		<?php endif;?>
	  <div class="col-xs-2 col-xs-offset-2">
			<label>Дата доставки</label>
	    <input type="text" class="datepicker-here form-control" data-timepicker="false" data-position="right top" name="date" id="date" value="<?=$order->date_start?>" onkeyup="return proverka(this);" onchange="return proverka(this);" required>
	  </div>
	  <div class="col-xs-2 ">
			<label>Объём(м<sup>3</sup>)</label>
	    <input type="text" class="form-control" id="size" name="size" value="<?=$order->order_capacity?>" onchange="count_cost()" onkeyup="count_cost()" required>
	  </div>
	  <div class="col-xs-4">
			<label>Вес(кг)</label>
	    <input type="text" class="form-control" id="comment" name="comment" value="<?=$order->order_comment?>" onchange="count_cost()" onkeyup="count_cost()" required>
	  </div>
	</div>
	<input type="hidden" name="cost" id="cost" value="<?=$order->order_cost?>">
	<input type="hidden" name="endpoint" id="endpoint" value="<?=$order->order_address?>">
	<input type="hidden" name="coordinates" id="coordinates" value="<?=$order->order_coordinates?>">
	<input type="hidden" id="length">
	<div class="row">
		<div class="col-xs-8 col-xs-offset-2 text-center" style="margin-top: 5px; color: grey; font-style: italic">
			<small>
				Внутренние размеры грузовой платформы (длина/ширина/высота) 4190/1980/1560, следовательно, больше <b>10 кубических метров заказать нельзя</b>
			</small>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-8 col-xs-offset-2 text-center">
			<h4 id="destination">Пункт доставки: <?=$order->order_address?></h4>
			<h4 id="sum">Стоимость доставки: <?=$order->order_cost?></h4>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-8 col-xs-offset-2">
			<h4>Новый адрес доставки</h4>
			<div id="map" style="width: 100%; height: 400px">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-8 col-xs-offset-2 text-center">
			<p><input type="submit" class="btn btn-lg btn-primary" value="Сохранить"></p>
		</div>
	</div>
</form>
</div>
<script>
function proverka(input) {
    input.value = input.value.replace(/[^\d],./g, '');
};
function check_order() {
	if (document.getElementById('date').value == '' || document.getElementById('size').value == '' || document.getElementById('endpoint').value == '' || document.getElementById('coordinates').value == '') {
		alert('Не заполнено одно из полей')
		return false;
	}
	var now = new Date();
	var date = document.getElementById('date').value.split('.');
	var goodDate = date[2] + '-' + date[1] + '-' + date[0];
	date = new Date(goodDate);
	if (date == 'Invalid Date') {
		alert('Неверная дата');
		return false;
	}
	if (mkDate(date) < mkDate(now)) {
		alert('Неверная дата');
		return false;
	}
	if (isNaN(parseFloat(document.getElementById('comment').value)) || isNaN(parseFloat(document.getElementById('size').value)) || Number(document.getElementById('size').value) < 0 || Number(document.getElementById('comment').value) < 0) {
		alert('Неверные значения груза');
		return false;
	}
	if (parseInt(document.getElementById('size').value) >= 10) {
		alert('Слишком большой груз, не более 10 кубических метров');
		return false;
	}
	if (parseInt(document.getElementById('comment').value) > 3500) {
		alert('Слишком большой груз, не более 3500 кг');
		return false;
	}
}
$('#my-element').datepicker({
	minDate: new Date()
});
$('.phone_us').mask('(000) 000-0000');
$('#date').mask('00.00.0000')
</script>
<script src="http://yandex.st/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script src="http://api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript">
    ymaps.ready(init);

		function init() {
        myMap = new ymaps.Map('map', {
            center: [52.603230, 39.573220],
            zoom: 12,
            controls: []
        }),
    // Создадим панель маршрутизации.
        routePanelControl = new ymaps.control.RoutePanel({
            options: {
                // Добавим заголовок панели.
                showHeader: true,
                title: 'Расчёт доставки'
            }
        }),
        zoomControl = new ymaps.control.ZoomControl({
            options: {
                size: 'small',
                float: 'none',
                position: {
                    bottom: 145,
                    right: 10
                }
            }
        });
    // Пользователь сможет построить только автомобильный маршрут.
    routePanelControl.routePanel.options.set({
        types: {auto: true}
    });

    routePanelControl.routePanel.state.set({
        fromEnabled: false,
        from: 'Липецк, Московская 30',
        to: ''
     });

    myMap.controls.add(routePanelControl).add(zoomControl);

    // Получим ссылку на маршрут.
    routePanelControl.routePanel.getRouteAsync().then(function (route) {

        // Зададим максимально допустимое число маршрутов, возвращаемых мультимаршрутизатором.
        route.model.setParams({results: 1}, true);

        // Повесим обработчик на событие построения маршрута.
        route.model.events.add('requestsuccess', function () {

            var activeRoute = route.getActiveRoute();
            if (activeRoute) {
                // Получим протяженность маршрута.
                var length = route.getActiveRoute().properties.get("distance");
                // Получим время доставки
                var time = route.getActiveRoute().properties.get("duration");
								var way = route.getActiveRoute().getPaths().get(0);
                // Создадим макет содержимого балуна маршрута.
								var sum = count_cost();
                balloonContentLayout = ymaps.templateLayoutFactory.createClass('<span>' + length.text + '</span>');
								document.getElementById('coordinates').value = route.properties.get('waypoints')[1].coordinates[1] + ',' + route.properties.get('waypoints')[1].coordinates[0];
								document.getElementById('cost').value = sum;
								document.getElementById('endpoint').value = route.properties.get('waypoints')[1].geocoderMetaData.Address.formatted;

								document.getElementById('destination').innerHTML = 'Пункт доставки: ' + route.properties.get('waypoints')[1].geocoderMetaData.Address.formatted;
								document.getElementById('sum').innerHTML = 'Сумма доставки: ' + sum;
                // Зададим этот макет для содержимого балуна.
                route.options.set('routeBalloonContentLayout', balloonContentLayout);
                // Откроем балун.
                activeRoute.balloon.open();
            }
        });

    });
		}
		function count_cost() {
				var w = Number(document.getElementById('comment').value);
				var v = Number(document.getElementById('size').value);
				var l = Number(document.getElementById('length').value).toFixed(0);
				if (w < 0 || v < 0 || isNaN(w) || isNaN(v) || w > 3500 || v >= 10) {
					document.getElementById('sum').innerHTML = 'Неверные значения';
					return;
				}

				var route = $('#route').val();
				$.ajax({
					url: document.location.origin + "/api/calc_cost?v=" + v + "&w=" + w + "&l=" + l,
					method: 'GET',
					success: function(data) {
						var sum = Number(data).toFixed(0);
						document.getElementById('cost').value = sum;
						document.getElementById('sum').innerHTML = 'Сумма доставки: ' + sum + ' руб.';
					}
				});
		}
		function mkDate(today) {
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();

			if(dd<10) {
			    dd = '0'+dd
			}

			if(mm<10) {
			    mm = '0'+mm
			}

			today = mm + '/' + dd + '/' + yyyy;
			return today;
		}
</script>
