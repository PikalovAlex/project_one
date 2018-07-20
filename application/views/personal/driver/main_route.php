<div class="container">
	<h2 style="text-align: center"><?php if ($route): ?>Маршрут на сегодня<?php else: ?>Маршрутов нет<?php endif;?></h2>
	<h3 style="text-align: center">Маршрут | <a href="/personal/driver/history">История маршрутов</a></h3>
	<hr>
	<input type="hidden" id="route" value="<?=$route?>">
	<div class="row">
		<div class="col-xs-8">
			<div id="map" style="width: 100%; height: 400px">
			</div>
		</div>
		<div class="col-xs-4">
			<div class="row">
				<h2>
					Маршрут
				</h2>
				<div id="routes">
				</div>
			</div>
			<div class="row">
				<a href="/personal/driver/ready" class="btn btn-danger ">Закончить маршрут</a>
			</div>
		</div>
	</div>
</div>
<script src="http://yandex.st/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script src="http://api-maps.yandex.ru/2.1/?load=package.full&lang=ru-RU" type="text/javascript"></script>
<script>
$('#my-element').datepicker({
	minDate: new Date()
});
</script>
<script type="text/javascript">
    ymaps.ready(init);
		var routes;
		var myMap;
		function init () {
		    myMap = new ymaps.Map('map', {
		        center:[52.603230, 39.573220],
		        zoom: 12
		    });
				getRoute();
		}

		function showMap(data) {
			var points = [];

			for (var i = 0; i < data.length; i++) {
				var _points = data[i];
				points.push(_points.place);
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
		var text='';
		var _points = data;
		for (var j = 0; j < data.length; j++) {
			if (j == 0) {
				text += '<div><p>' + (j + 1) + '. ' + _points[j].place + '</p></div>';
			}
			else {
				text += '<div><p>' + (j + 1) + '. ' + _points[j].place + '(' + _points[j].capacity + 'м<sup>3</sup>)' + _points[j].weight + '(кг)<br>' + _points[j].name + '(' + _points[j].mobile + ')<br>' + _points[j].cost + 'руб.</p></div>';
			}
		}
		$('#routes').append(text);
	}

	function getRoute() {
		var route = $('#route').val();
		$.ajax({
		url: document.location.origin + "/api/rt?route=" + route,
		method: 'GET',
		success: function(data) {
			showMap(data);
			showTable(data);
			console.log(data);
			routes = data;
		}
	});
	}
</script>
