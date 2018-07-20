<div class="container">
	<h2 style="text-align: center">Добавление автомобиля</h2>
	<hr>
	<form method="post" action="/personal/admin/add_car_process">
	<div class="row">
		<?php if (isset($_GET['error'])): ?>
			<h5 style="text-align: center"><i>Ошибка при заполнении формы</i></h5>
		<?php endif;?>
		<div class="col-xs-8 col-xs-offset-2">
			<label>Марка автомобиля</label>
			<input type="text" class="form-control" name="name" required>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4 col-xs-offset-2">
			<label>Номер автомобиля</label>
			<input type="text" class="form-control" name="number" required>
		</div>
		<div class="col-xs-2">
			<label>Тип автомобиля</label>
			<input type="text" class="form-control" name="type" required>
		</div>
		<input type="hidden" class="form-control" name="capacity" value="10">
	</div>
	<div class="row" style="margin-top: 10px">
		<div class="col-xs-8 col-xs-offset-2">
			<input type="submit" class="btn btn-lg btn-primary" value="Добавить">
		</div>
	</div>
	</form>
</div>
