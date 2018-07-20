<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Adminka</title>
<?php foreach($styles as $style): ?>
  <link href="<?php echo URL::base(); ?>public/css/<?php echo $style; ?>.css" rel="stylesheet" type="text/css" />
<?php endforeach; ?>
</head>

<body>
	<?php if (!Auth::instance()->logged_in()): ?>
	<div class="col-lg-2">
	<form action="main" method="post" action="<?php echo URL::site('user/login'); ?>" onsubmit="return check_login()">
	<p> Логин &nbsp&nbsp <input type="text" name="username" id="username"><?php if(isset($errors['username'])) echo $errors['username']; ?></p>
	<p> Пароль <input type="password" name="password" id="password"><?php if(isset($errors['password'])) echo $errors['password']; ?></p>
	<p><input type="submit" value="Войти" name="submit" class="btn btn-lg btn-info" onclick="return check_login()"></p>
	</form>
	<p><a class="btn btn-primary" href="<?php echo URL::site('user/register'); ?>"> Зарегистрироваться </a>
	</div>
	<?php else: ?>
	<div class="col-lg-2">
	<p><a href="<?php echo URL::site('personal'); ?>"> Личный кабинет </a></p>
	<p>Вы вошли под именем <?php if(isset($username->username)) echo $username->username; ?></p>
	<form action="mainin" method="post">
	<p><a href="<?php echo URL::site('user/logout'); ?>" class="btn btn-lg btn-info">Выйти</a></p>
	</form>
	</div>
	<?php echo $content; ?>
</body>
</html>
