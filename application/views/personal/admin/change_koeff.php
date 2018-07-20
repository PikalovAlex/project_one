<div class="container">
	<h2 style="text-align: center">Редактирование коэффициентов</h2>
	<hr>
	<form method="post" action="/personal/admin/change_koeff_process" onsubmit="return check_form()">
	<div class="row">
		<?php if (isset($_GET['error'])): ?>
			<h5 style="text-align: center"><i>Ошибка при заполнении формы</i></h5>
		<?php endif;?>
		<div class="col-xs-2 col-xs-offset-2">
			<label>q</label>
			<input type="text" class="form-control" name="q" id="q" value="<?=$q?>" required>
		</div>
		<div class="col-xs-2">
			<label>c</label>
			<input type="text" class="form-control" name="c" id="c" value="<?=$c?>" required>
		</div>
		<div class="col-xs-2">
			<label>p</label>
			<input type="text" class="form-control" name="p" id="p" value="<?=$p?>" required>
		</div>
	</div>
	<div class="row" style="margin-top: 10px">
		<div class="col-xs-8 col-xs-offset-2">
			<input type="submit" class="btn btn-lg btn-primary" value="Сохранить">
		</div>
	</div>
	</form>
</div>
<script>
function check_form() {
	var q = Number($('#q').val());
	var p = Number($('#p').val());
	var c = Number($('#c').val());
	if (isNaN(q) || isNaN(p) ||isNaN(c) || p <= 0 || c <= 0 || q <= 0) {
		alert('Неверные значения коэффициентов');
		return false;
	}
}
</script>
