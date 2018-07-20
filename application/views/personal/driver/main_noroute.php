<div class="container">
	<h2 style="text-align: center">Список доступных маршрутов на сегодня</h2>
	<h3 style="text-align: center">Маршрут | <a href="/personal/driver/history">История маршрутов</a></h3>
	<hr>
	<label>Дата
	<input type="text" class="datepicker-here form-control" data-timepicker="false" data-position="right top" name="date" id="date" oninput="datechanged()" required></label>
	<button onclick="getRoutes()" class="btn btn-lg btn-primary">Посмотреть</button>
	<p id="hasOrders"></p>
	<div class="row">
		<div class="col-xs-8">
			<div class="row">
				<div id="map" style="width: 100%; height: 400px">
				</div>
			</div>
		</div>
		<div class="col-xs-4">
			<div id="table1" style="display: none">
				<h2>
					Маршруты
				</h2>
				<div id="routes">
				</div>
			</div>
		</div>
	</div>
</div>
<script src="http://api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript">
		var first = true;
    ymaps.ready(init);
		var routes;
		var routesCnt = 1;
		function init () {
	    myMap = new ymaps.Map('map', {
	        center:[52.603230, 39.573220],
	        zoom: 12
	    });
			getRoutes();
		}

		function getRoutes() {
			var date;
			var today;
			if ($('#date').val() == '') {
				var now = new Date();
				date = now.getDate() + '.' + (now.getMonth() + 1) + '.' + now.getFullYear();
				today = true;
			}
			else {
				date  = $('#date').val();
				today = false;
			}
			var route = $('#route').val();
			$.ajax({
				url: document.location.origin + "/api/route?date=" + date,
				method: 'GET',
				success: function(data) {
					if (data.length == 0) {
						if (today) {
							$('#hasOrders').html('Заказов на сегодня(' + date + ') нет');
						}
						else {
							$('#hasOrders').html('Заказов на данное число(' + date + ') нет');
						}
						return;
					}
					showMap(data, today);
					console.log(data);
					routes = data;
				}
			});
		}

		function showMap(data, today) {
			$('#table1').css('display', 'block');

			var routes = data;
			for (var i = 0; i < routes.length; i++) {
				var _points = routes[i].routes;
				var points = [];
				var text
				if (today) {
					text = '<h2>Маршрут №' + (i + 1) + '<a href="/personal/driver/accept/' + routes[i].route + '" class="btn btn-success btn-sm">Взять</a></h2>';
				}
				else {
					text = '<h2>Маршрут №' + (i + 1) + '</h2>';

				}
				for (var j = 0; j < _points.length; j++) {
					points.push(_points[j].place);
					if (_points[j].id != '-1') {
						text += '<div><p>' + (j) + '. ' + _points[j].place + '(' + _points[j].capacity + 'м<sup>3</sup>), ' + _points[j].weight + '(кг)<br>' + _points[j].name + '(' + _points[j].mobile + ')<br>' + _points[j].cost + 'руб.</p></div>';
					}
				}
				$('#routes').append(text);

				var multiRoute = new ymaps.multiRouter.MultiRoute({
					referencePoints: points,
					params: {
						results: 1
					}
				},
				{
					boundsAutoApply: true
				});
				myMap.geoObjects.add(multiRoute);
			}
		}

	function showTable(data) {
		$('#table1').css('display', 'block');
		if (data.length != 0) {
		var text = '<h2>Маршрут №' + routesCnt + '</h2>';
		var _points = data.routes;
		for (var i = 0; i < data.routes.length; i++) {
			if (_points[i].id != '-1') {
				text += '<div><p>' + i + '. ' + _points[i].place + '(' + _points[i].capacity + 'м<sup>3</sup>)' + _points[i].weight + '(кг)<br>' + _points[i].name + '(' + _points[i].mobile + ')<br>' + _points[i].cost + 'руб.</p></div>';
			}
		}
		$('#routes').append(text);
		}
	}

	$('#date').datepicker({
		onSelect: function(fd, date) {
			$('#routes').html('');
			$('#hasOrders').html('');
			myMap.geoObjects.removeAll();
		}
	});
</script>
