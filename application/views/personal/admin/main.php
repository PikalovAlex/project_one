<div class="container">
	<h2 style="text-align: center">Панель управления</h2>
	<hr>
	<ul class="nav nav-tabs nav-justified">
		<li class="active"><a data-toggle="tab" href="#panel0">Основная информация</a></li>
		<li><a data-toggle="tab" href="#panel1">Коэффициенты</a></li>
		<li><a data-toggle="tab" href="#panel2">Статистика</a></li>
	</ul>
	<div class="tab-content">
		<div id="panel0" class="tab-pane in active">
			<div class="row">
				<div class="col-xs-6">
					<h4>Список автомобилей</h4>
					<a href="/personal/admin/add_car">Добавить автомобиль</a>
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Номер</th>
								<th>Марка</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($cars as $car): ?>
							<tr>
								<td><a href="/personal/admin/change_car/<?=$car->car_id?>"><?=$car->car_number?></a></td>
								<td><?=$car->car_name?></td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<div class="col-xs-6">
					<h4>Список водителей</h4>
					<a href="/personal/admin/add_driver">Добавить водителя</a>
					<table class="table table-bordered table-hover">
						<thead>
							<tr>
								<th>Имя</th>
								<th>Автомобиль</th>
								<th>Паспорт</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($drivers as $driver): ?>
							<tr>
								<td><a href="/personal/admin/change_driver/<?=$driver->driver_id?>"><?=$driver->user->fio?></a></td>
								<td>
										<?=$driver->car->car_number?>(<?=$driver->car->car_name?>)
								</td>
								<td><?=$driver->driver_pasport?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 col-xs-offset-3">
				<h4>Список операторов</h4>
				<a href="/personal/admin/add_operator">Добавить оператора</a>
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Имя</th>
							<th>Последний вход</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($operators as $operator): ?>
						<tr>
							<td><a href="/personal/admin/change_operator/<?=$operator->id?>"><?=$operator->username?></a></td>
							<td>
								<?php if ($operator->last_login): ?>
									<?=date('d.m.Y', $operator->last_login)?>
								<?php else:?>
									---
								<?php endif; ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			</div>
		</div>
		<div id="panel1" class="tab-pane">
			<div class="row">
				<h4>Формула расчёта: <tt><i>sum = v * p + c * l + q * w</i></tt></h4>
				<p>
					Характеристики заказа:<br>
					<b>v</b> - объём груза<br>
					<b>w</b> - вес<br>
					<b>l</b> - длина пути<br>
					<br>
					Коэффициенты:<br>
					<b>p</b> = <?=$p?><br>
					<b>c</b> = <?=$c?><br>
					<b>q</b> = <?=$q?><br>
					<a href="/personal/admin/change_koeff" class="btn btn-sm btn-primary">Задать новые</a>
				</p>
			</div>
		</div>
		<div id="panel2" class="tab-pane">
			<h4 style="text-align: center">Статистика по водителям</h4>
			<div class="col-xs-8 col-xs-offset-2">
				<table class="table table-bordered table-hover">
					<thead>
						<tr>
							<th>Имя</th>
							<th>Автомобиль</th>
							<th>Выполнено всего маршрутов</th>
							<th>Дата последнего маршрута</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($drivers as $driver): ?>
						<tr>
							<td><?=$driver->user->fio?></td>
							<td>
								<?=$driver->car->car_number?>(<?=$driver->car->car_name?>)
							</td>
							<td><?=$driver->car->routes->where('route_status', '=', '2')->find_all()->count();?></td>
							<td><?=$driver->car->routes->where('route_status', '=', '2')->order_by('route_id', 'DESC')->find()->route_date;?></td>
							<td><a href="/personal/admin/driver_history/<?=$driver->driver_id?>" class="btn btn-sm btn-primary">Подробная информация</a></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php foreach ($drivers as $driver): ?>
			<?php endforeach; ?>
			</div
		</div>
	</div>
</div>
