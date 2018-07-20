<div class="col-lg-2">
	<p><a href="<?php echo URL::site('page/mainclient'); ?>"> Личный кабинет </a></p>
	
	<form action="main" method="post">
	<p> Логин &nbsp&nbsp <input type="text" name="username" ><?php if(isset($errors['username'])) echo $errors['username']; ?></p>
	<p> Пароль <input type="password" name="password"><?php if(isset($errors['password'])) echo $errors['password']; ?></p>	
	<p><input type="submit" value="Войти" name="submit" class="btn btn-lg btn-info"></p>
	</form> 
	
	<p><a class="btn btn-primary" href="<?php echo URL::site('page/registration'); ?>"> Зарегистрироваться </a>  
	</div>
	</div>
	</div>
</div>
