<div class="container-fluid">
<div class="row">
		<div class="flex_row"> <!-- вторая горизонтальная линия -->
			<div class="Choise_marka_concrete  col-md-4" >
				<h2 style="text-align:center">Все заказы доставляются машинами одной марки <br> 
					«ГАЗЕЛЬ-БИЗНЕС» ГАЗ-330202</h2>
					<p>Внутренние размеры грузовой платформы (длина/ширина/высота) 4190/1980/1560, следовательно, больше 12 кубических метра заказать нельзя!!! </p>
			</div>
			
			<div class="Order_Date col-md-4" >
				<h2> 2. Выберите дату доставки: </h2>
				<p>	<input type='text' class="datepicker-here" data-timepicker="false" data-position="right top" />	</p>  <!-- вернуть false на true поменять часы и минуты -->
				<h2> 3. Введите объем груза(не больше 12 кубических метров):</h2>
				<p>	<input type='text'>	</p>
			</div>
			<div class="col-md-4">
				<div class="input-group">
					<label for="phone_us"><h2> 3. Обратная связь: </h2> </label>
				   <p>Номер телефона: <input type="text" class="phone_us" id="phone_us"/></p>
				  </div>
				  <p>Контактное лицо: <input type="text" name="Name"/></p>
			</div>
		</div>
</div>		
	<div class="row">	
		<div class="flex_row"> <!-- третья горизонтальная линия -->
				<div class="col-lg-4">
				<h2> 4. Выберите адрес доставки: </h2>
				<div id="map" style="width: 100%; height: 400px">
				</div>
				</div>
				<div class="col-lg-4">
						
					<h2> 5. Введите адрес доставки или поставьте маркер на карту </h2>
					<div class="col-lg-6">
					<p> Пункт доставки: <input type="text" name="pointB" ></p>
					</div>
					<div class="col-lg-6"></div>
				</div>
				<div class="col-lg-4">
				<h2>6. Итого получаем:</h2>
					<p> Километраж: <br><input type="text" name="delivery_cost" ></p>
					<p> Стоимость доставки: <br><input type="text" name="delivery_cost" ></p>
					<p><input type="submit" value="Заказать" name="submit" class="btn btn-lg btn-primary"></p>
				</div>
				
		</div>
		
	</div>
<script>

// Доступ к экземпляру объекта
$('#my-element').data('datepicker')
//$(function() {
$('.phone_us').mask('(000) 000-0000');
//}
</script>
<script type="text/javascript">
    ymaps.ready(init);
    var myMap,
		myPlacemark;
	
    function init(){     
        myMap = new ymaps.Map("map", {
            center: [52.60, 39.59],
            zoom: 12
        });
		//    
		myPlacemark = new ymaps.Placemark([52.625901, 39.537398], { 
            hintContent: 'Точка отправки', 
            balloonContent: 'Бетон' 
        });
		myMap.geoObjects.add(myPlacemark);
		myMap.controls.remove('trafficControl');
		
    }
	        
</script>
