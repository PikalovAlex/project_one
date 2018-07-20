<div class="container">
	<div class="row">
		<div clas="col-xs-8 col-xs-offset-2">
			<h2 style="text-align: center">История выполненных маршрутов</h2>
			<h3 style="text-align: center"><a href="/personal/driver/">Маршрут</a> | История маршрутов</h3>
			<hr>
			<?php $i = 0; $lastDate = '';
			foreach($routes as $route): ?>
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
</div>
