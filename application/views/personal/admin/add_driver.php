<div class="container">
	<h2 style="text-align: center">Добавление водителя</h2>
	<hr>
	<form method="post" action="/personal/admin/add_driver_process">
	<div class="row">
		<?php if (isset($_GET['error'])): ?>
			<h5 style="text-align: center"><i>Ошибка при заполнении формы</i></h5>
		<?php endif;?>
		<div class="col-xs-4 col-xs-offset-2">
			<label>Имя водителя</label>
			<input type="text" class="form-control" name="name" required>
		</div>
		<div class="col-xs-2">
			<label>Автомобиль</label>
			<select class="form-control" name="car">
				<?php foreach ($cars as $car): ?>
					<option value="<?=$car->car_id?>"><?=$car->car_number?>(<?=$car->car_name?>)</option>
				<?php endforeach ?>
			</select>
		</div>
		<div class="col-xs-2">
			<label>Паспорт</label>
			<input type="text" class="form-control" name="pasport" required>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-2 col-xs-offset-2">
			<label>Логин</label>
			<input type="text" class="form-control" name="login" required>
		</div>
		<div class="col-xs-3">
			<label>Почта</label>
			<input type="text" class="form-control" name="email" required>
		</div>
		<div class="col-xs-3">
			<label>Пароль</label>
			<input type="text" class="form-control" name="password" required>
		</div>
	</div>
	<div class="row" style="margin-top: 10px">
		<div class="col-xs-8 col-xs-offset-2">
			<input type="submit" class="btn btn-lg btn-primary" value="Добавить">
		</div>
	</div>
	</form>
</div>
