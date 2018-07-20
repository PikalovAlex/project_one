<div class="container">
	<h2 style="text-align: center">Панель управления</h2>
	<hr>
	<div class="col-xs-8 col-xs-offset-2">
		<h4 style="text-align: center">Информация о водителе <?=$driver->user->fio?></h4>
		<p>
			<b>Паспорт</b>: <?=$driver->driver_pasport?><br>
			<b>Автомобиль, номер</b>: <?=$driver->car->car_number?><br>
			<b>Автомобиль, марка</b>: <?=$driver->car->car_name?><br>
			<b>Выполнено маршрутов</b>: <?=$driver->car->routes->where('route_status', '=', '2')->find_all()->count();?><br>
			<b>Дата последнего маршрута</b>: <?=$driver->car->routes->where('route_status', '=', '2')->order_by('route_id', 'DESC')->find()->route_date;?>
		</p>
		<h4 style="text-align: center">Выполненные маршруты</h4>
		<?php $i = 0; $lastDate = '';
		foreach($driver->car->routes->find_all() as $route): ?>
				<?php ++$i; if ($lastDate != $route->route_date): $i = 1; $lastDate = $route->route_date?>
				<h3>Маршруты за <?=$route->route_date?></h3>
				<?php endif;?>
				<div>
					<h4>Маршрут №<?=$i?></h4>
					<?php $j = 0; foreach ($route->waypoints->find_all() as $waypoint): $j++?>
					<p>
						<b>Точка <?=$j?>:</b><br>
						Адрес: <?=$waypoint->order->order_address?><br>
						Вес: <?=$waypoint->order->order_comment?>кг<br>
						Объём: <?=$waypoint->order->order_capacity?>м<sup>3</sup><br>
						Стоимость: <?=$waypoint->order->order_cost?> руб.<br>
					</p>
					<?php endforeach?>
				</div>
				<hr>

		<?php endforeach; ?>
	</div>
</div>
