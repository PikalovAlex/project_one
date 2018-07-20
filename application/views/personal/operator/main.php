<div class="container">
	<h2 style="text-align: center">Панель управления</h2>
	<hr>
	<div class="row">
	  <div class="col-xs-10 col-xs-offset-1">
			<h4>Список заказов</h4>
			<a href="/personal/operator/build_route">Маршруты</a>
			<hr>
			Вывести заказы со статусом <?php foreach ($statuses as $status):?><?php if ((isset($_GET['status'])) && ($_GET['status'] == $status->status_id)): ?><?=$status->status_name?> <?php else: ?><a href="/personal/operator?status=<?=$status->status_id?>"><?=$status->status_name?></a> <?php endif; ?><?php endforeach; ?> <?php if (isset($_GET['status'])): ?><br><a href="/personal/operator">Показать все заказы</a><?php endif;?>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>Клиент</th>
						<th>Адрес доставки</th>
						<th>Дата доставки</th>
						<th>Объём(м<sup>3</sup>)</th>
						<th>Вес(кг)</th>
						<th>Стоимость(руб)</th>
						<th>Статус</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($orders as $order): ?>
					<tr>
						<td>
							<?php if ($order->client_id): ?>
								<?=$order->client->client_name?>
								<br>
								8 <?=$order->client->client_mobile?>
							<?php else: ?>
								<?=$order->user->fio?>
								<br>
								8 <?=$order->user->phone?>
							<?php endif; ?>
						</td>
						<td><?=$order->order_address?></td>
						<td><?=$order->date_start?></td>
						<td><?=$order->order_capacity?></td>
						<td><?=$order->order_comment?></td>
						<td><?=$order->order_cost?></td>
						<td>
							<?=$order->status->status_name?>
							<?php if ($order->status->status_id == 1): ?>
							<br>
							<a href="/personal/operator/order_confirm/<?=$order->order_id?>" class="btn btn-xs btn-success">Подтвердить заказ</a>
							<a href="/personal/operator/cancel_order/<?=$order->order_id?>" class="btn btn-xs btn-danger">Отменить заказ</a>
							<?php endif;?>
						</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
	  </div>
	</div>
</div>
