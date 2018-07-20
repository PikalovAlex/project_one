<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<meta name="description" content="<?php echo $description; ?>" />
<?php foreach($styles as $style): ?>
    <link href="<?php echo URL::base(); ?>public/css/<?php echo $style; ?>.css"
    rel="stylesheet" type="text/css" />
<?php endforeach; ?>

<?php foreach($scripts as $script): ?>
   <script src="<?php echo URL::base(); ?>public/js/<?php echo $script; ?>.js"></script>
<?php endforeach; ?>

</head>

<body>
<div id="header"> <!-- первая горизонтальная линия    -->
<div class="container-fluid">
<div class="row" style="text-align: center">
 <div class="col-lg-2">
	 <p>Контактная информация:</p>
	 <p>Адрес: г. Липецк, ул. Московская, д.30 </p>
	 <p>email: LSTU@mail.ru </p>
	</div>

	 <div class="col-lg-8">
	<h2><a href="<?php echo URL::site(''); ?>">Автоматизированная информационная система логистики грузоперевозок</a></h2>
	</div>

	<?php if (!Auth::instance()->logged_in()): ?>
	<div class="col-lg-2">
	<form method="post" action="<?php echo URL::site('user/login'); ?>" onsubmit="return check_login()">
	<?php if (isset($_GET['errorLogin'])): ?>
		Ошибка при авторизации
	<?php endif;?>
	<p> Логин &nbsp&nbsp <input type="text" name="username" id="username"><?php if(isset($errors['username'])) echo $errors['username']; ?></p>
	<p> Пароль <input type="password" name="password" id="password"><?php if(isset($errors['password'])) echo $errors['password']; ?></p>
	<p><input type="submit" value="Войти" name="submit" class="btn btn-lg btn-info"></p>
	</form>
	<p><a class="btn btn-primary" href="<?php echo URL::site('register'); ?>"> Зарегистрироваться </a>
	</div>
	<script>
		function check_login() {
			if (document.getElementById('username').value == '' || document.getElementById('password').value == '') {
				alert('Не заполнено одно из полей');
				return false;
			}
			else {
				return true;
			}
		}
	</script>
	<?php else: ?>
	<div class="col-lg-2">
	<p><a href="<?php echo URL::site('personal'); ?>"> Личный кабинет </a></p>
	<p>Вы вошли под именем <?php echo Auth::instance()->get_user()->username;?></p>
	<form action="mainin" method="post">
	<p><a href="<?php echo URL::site('user/logout'); ?>" class="btn btn-lg btn-info">Выйти</a></p>
	</form>
	</div>
	<?php endif;?>
	</div>
	</div>
	</div>
  <?php echo $content; ?>
</body>
</html>
