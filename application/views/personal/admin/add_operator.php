<div class="container">
	<h2 style="text-align: center">Добавление оператора</h2>
	<hr>
	<form method="post" action="/personal/admin/add_operator_process">
	<div class="row">
		<?php if (isset($_GET['error'])): ?>
			<h5 style="text-align: center"><i>Ошибка при заполнении формы</i></h5>
		<?php endif;?>
		<div class="col-xs-8 col-xs-offset-2">
			<label>Имя оператора</label>
			<input type="text" class="form-control" name="name" required>
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
