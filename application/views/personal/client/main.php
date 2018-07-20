<div class="container">
	<h2 style="text-align: center">Личный кабинет</h2>
	<hr>
	<div class="row">
	  <div class="col-xs-10 col-xs-offset-1">
			<h4>Список заказов</h4>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Адрес доставки</th>
						<th>Дата доставки</th>
						<th>Объём(м<sup>3</sup>)</th>
						<th>Вес(кг)</th>
						<th>Стоимость(руб)</th>
						<th>Статус</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($orders as $order): ?>
					<tr>
						<td><?=$order->order_address?></td>
						<td><?=$order->date_start?></td>
						<td><?=$order->order_capacity?></td>
						<td><?=$order->order_comment?></td>
						<td><?=$order->order_cost?></td>
						<td>
							<?=$order->status->status_name?>
							<?php if ($order->status->status_id == 1): ?>
							<?php endif;?>
						</td>
						<td>
							<?php if ($order->status_id == 1):?>
								<a href="/personal/client/change_order/<?=$order->order_id?>" class="btn btn-success btn-xs">Редактировать</a>
								<br>
								<br>
								<a href="/personal/client/delete_order/<?=$order->order_id?>" class="btn btn-danger btn-xs">Удалить</a>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
	  </div>
	</div>
</div>
