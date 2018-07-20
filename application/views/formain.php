<div class="col-lg-2">
	<p><a href="<?php echo URL::site('page/mainclient'); ?>"> Личный кабинет </a></p>
	<p>Вы вошли под именем <?php if(isset($username->username)) echo $username->username; ?></p>
	<form action="mainin" method="post">
	<p><input type="submit" value="Выйти" name="submit" class="btn btn-lg btn-info"></p>
	</form> 
  
	</div>
	</div>
	</div>
</div>
