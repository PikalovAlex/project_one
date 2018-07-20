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
<div id="header"> <!-- первая горизонтальная линия -->
<div class="container-fluid">
<div class="row" style="text-align: center">
    <div class="col-lg-2">
	<p>Username </p>
	<p><a href="<?php echo URL::site('page/mainclient'); ?>"> Личный кабинет </a></p>
	
	

	 <p>  <a class="btn btn-success" href=""> Выйти </a></p>	
	</div>
	 <div class="col-lg-8">
	<h2><a href="<?php echo URL::site(''); ?>">Автоматизированная информационная система логистики грузоперевозок</a></h2> 
	
	</div>
	 <div class="col-lg-2">
	 <p>Контактная информация:</p>
	 <p>Адрес: г. Липецк, ул. Пушкина, д. Колотушкина </p>
	 <p>email: temp@mail.ru </p>
	 <div class="btn-group">
    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
        Дополнительная информация
        <span class="caret"></span>
      </button>
    <ul class="dropdown-menu">
	  <li><a href="<?php echo URL::site('page/price'); ?>">Наши цены</a></li>
      <li><a href="https://vk.com/id107522108" target="_blank">Производство бетона</a></li>
      <li><a href="https://vk.com/ilya.putyatin" target="_blank">Производство песка</a></li>
	  <li><a href="https://vk.com/ionzzer" target="_blank">Производство кирпича</a></li>
	  <li><a href="https://vk.com/id64567002" target="_blank">Производство древесины</a></li>
	   <li><a href="https://vk.com/id64567002" target="_blank">Производство щебня</a></li>
    </ul>
   </div>
	</div>
	</div>
	</div>
</div>
    <?php echo $content; ?>
</body>
</html>