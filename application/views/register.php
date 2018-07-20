<div id="advantages">
  <div class="flex_row">
		<div class="col-md-2" >		<!-- первая линия слева -->
		</div>
		<div class="col-md-5 registration" > <!-- Первая линия по центру -->
		<form action="/user/register" method="post">
			<?php if (isset($_GET['error'])): ?>
				<h5 style="text-align: center"><i>Ошибка при заполнении формы</i></h5>
			<?php endif;?>
		<p> Логин <input type="text" name="username" value="" required><?php if(isset($errors['username'])) echo $errors['username']; ?></p>
		<p> Пароль(минимум 8 символов) <input type="password" name="password1" required><?php if(isset($errors['password1'])) echo $errors['password1']; ?></p>
		<p> Еще раз пароль (минимум 8 символов) <input type="password" name="password2" required><?php if(isset($errors['password2'])) echo $errors['password2']; ?></p>
		<p> Электронная почта <input type = "text" name="email" required><?php if(isset($errors['email'])) echo $errors['email']; ?></p>
		<p> ФИО(можно одно имя) <input type = "text" name="fio"required><?php if(isset($errors['fio'])) echo $errors['fio']; ?></p>
		<p> Номер телефона +7<input type="text" name="phone" class="phone_us" id="phone_us" value="" required><?php if(isset($errors['phone'])) echo $errors['phone']; ?></p>
		<div class="col-md-8">
		</div>
		<p><input type="submit" value="Зарегистрироваться" name="submit" class="btn btn-lg btn-primary" ></p>
		</form>
		</div>
   </div>
   <script>$('.phone_us').mask('(000) 000-0000');</script>
</div>
