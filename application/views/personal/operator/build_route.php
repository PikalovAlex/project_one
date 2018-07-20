<div class="container">
	<h2 style="text-align: center">Маршруты</h2>
	<hr>
	<label>Дата
	<input type="text" class="datepicker-here form-control" data-timepicker="false" data-position="right top" name="date" id="date" oninput="datechanged()" required></label>
	<button onclick="build()" class="btn btn-lg btn-primary">Построить маршрут</button>
	<div class="row">
		<div class="col-xs-8">
			<div class="row">
				<div id="map" style="width: 100%; height: 400px">
				</div>
			</div>
			<div class="row">
				<div id="table3" style="display: none">
					<h2>
						Построенные маршруты
					</h2>
					<div id="readyroutes">
					</div>
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
			<div id="table2" style="display: none">
				<h2>
					Оставшиеся заказы
				</h2>
				<div id="orders">
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
		}

		function route_map(data) {
			var _points = data.routes;
			var points = [];
			for (var i = 0; i < data.routes.length; i++) {
				points.push(_points[i].place);
				console.log(_points[i].coordinates);
			}

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

	function showTable(data) {
		$('#table1').css('display', 'block');
		$('#table2').css('display', 'block');
		var text = '';
		for (var i = 0; i < data.orders.length; i++) {
			console.log(i);
			var orders = data.orders[i];
			// console.log(data.orders[i]);
			text += '<div><p>' + (i + 1) + '. ' + orders.place + '(' + orders.capacity + 'м<sup>3</sup>)' + orders.weight + '(кг)<br>' + orders.name + '(' + orders.mobile + ')<br>' + orders.cost + 'руб.</p></div>';
		}
		$('#orders').html(text);

		if (data.routes.length != 0) {
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

	function showReadyRoutes(data) {
		$('#table3').css('display', 'block');

		var routes = data.readyroutes;
		for (var i = 0; i < data.readyroutes.length; i++) {
			var text = '<h2>Маршрут №' + (i + 1) + '</h2>';
			var _points = routes[i];
			var points = [];
			for (var j = 0; j < _points.length; j++) {
				points.push(_points[j].place);
				if (_points[j].id != '-1') {
					text += '<div><p>' + (j) + '. ' + _points[j].place + '(' + _points[j].capacity + 'м<sup>3</sup>)' + _points[j].weight + '(кг)<br>' + _points[j].name + '(' + _points[j].mobile + ')<br>' + _points[j].cost + 'руб.</p></div>';
				}
			}
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
			$('#readyroutes').append(text);
		}
	}

	function build() {
		var date = $('#date').val();
		if (date == '') {
			alert('Не задана дата');
		}
		$.ajax({
		url: document.location.origin + "/api/routes?date=" + date,
		method: 'GET',
		success: function(data) {
			if (data == 'nope') {
				alert('На данную дату уже построен маршрут');
				return;
			}
			else if (data == 'nothing') {
				alert('Заказов на выбранную дату нет');
				return;
			}
			if (data.readyroutes.length == 0 && data.routes.length == 0 && data.orders.length == 0) {
				alert('Нет заказов');
				return;
			}
			// console.log(data.routes[0].place);
			if (first) {
				showReadyRoutes(data);
				first = false;
			}
			route_map(data);
			showTable(data);
			console.log(data);
			routes = data;
			routesCnt++;
		}
	});
	}

	$('#date').datepicker({
		onSelect: function(fd, date) {
			$('#readyroutes').html('');
			$('#routes').html('');
			$('#orders').html('');
			myMap.geoObjects.removeAll();
			first = true;
		}
	});
</script>
