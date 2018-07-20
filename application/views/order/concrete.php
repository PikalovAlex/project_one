<div class="container-fluid">
<div class="row">
		<div class="flex_row"> <!-- вторая горизонтальная линия -->
			<div class="Choise_marka_concrete  col-md-4" >
				<h2 style="text-align:center">1.Выберите марку бетона:</h2>
				<div class="form-group">
					<select class="form-control">
						<option value="Марка100">M100 (садовые дорожки, небольшие заборы)</option>
						<option value="Марка200">M200 (перекрытия для частных домов)</option>
						<option value="Марка300">M300 (перекрытия для многоэтажных зданий)</option>
						<option value="Марка400">M400 (спецобъекты)</option>
					</select>
				</div>
			</div>
			
			<div class="Order_amount col-md-4" >
				<h2 style="text-align:center"> 2. Введите объём: </h2>
				<p style="text-align:center"> Объём: <input type="text" pattern = "[0-9]{1,4}" name="amount"></p>
			</div>
			<div class="Order_Date  col-md-4">
				<h2 style="text-align:center"> 3. Выберите время и дату доставки: </h2>
				<p style= "margin-left: 14%">	<input type='text' class="datepicker-here" data-timepicker="true" data-position="right top" />	</p>
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
						<div class="form-group">
						<h2> 5. Доставка:</h2>
							<input type="radio" name="t">по городу
							<input type="radio" name="t">по области
						</div>
						<h2> Введите адрес доставки или поставьте маркер на карту </h2>
					<div class="col-lg-6">
					
					<p> Пункт доставки: <input type="text" name="delivery_point" ></p>
					<p> Итого получаем:
					<p> Количество машин <input type="text" name="count_car" ></p>
					<p> Километраж: <input type="text" name="delivery_cost" ></p>
					<p> Стоимость доставки: <input type="text" name="delivery_cost" ></p>
					</div>
					<div class="col-lg-6"></div>
				</div>
				<div class="col-lg-4">
					<div class="input-group">
					<label for="phone_us"><h2> 6. Обратная связь: </h2> </label>
				   <p>Номер телефона: <input type="text" class="phone_us" id="phone_us"/></p>
				  </div>
				  <p>Контактное лицо: <input type="text" name="Name"/></p>
					<p><input type="submit" value="Заказать" name="submit" class="btn btn-lg btn-primary" style="margin-left: 150px; margin-top: 100px"></p>
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
            hintContent: 'Пункт А', 
            balloonContent: 'Бетон' 
        });
		myMap.geoObjects.add(myPlacemark);
		myMap.controls.remove('trafficControl');
    }
	        
</script>
