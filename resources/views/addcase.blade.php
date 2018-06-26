@extends('layouts.app')

@section('content')
	<?php 
	if (Auth::check()) {
        $status = Auth::user()->status;
		
		switch ($status) {
			case 'free':
                   echo '<script>setTimeout(location="/404", 1)</script>';
				break;
			case 'disp':
                   echo '<script>setTimeout(location="/404", 1)</script>';
				break;
			default:
				# code...
				break;
		}}
		?>
<script type="text/javascript">
			var autocompletes, marker, infowindow, map;
		function initMap() {
				 map = new google.maps.Map(document.getElementById('map'), {
		          center: {lat: 55.57619655127353, lng: 42.03792083740245},
		          zoom: 13
		        });
		        infowindow = new google.maps.InfoWindow();

		        marker = new google.maps.Marker({
		          map: map
		        });


				var inputs = document.querySelector('#address');
				autocompletes = new google.maps.places.Autocomplete(inputs);

				
				google.maps.event.addListener(autocompletes, 'place_changed', function () {
					marker.setVisible(false);
					infowindow.close();


		            var place = autocompletes.getPlace();
		            if (!place.geometry) {
			            // User entered the name of a Place that was not suggested and
			            // pressed the Enter key, or the Place Details request failed.
			            window.alert("No details available for input: '" + place.name + "'");
			            return;
			        }
			        
			         // If the place has a geometry, then present it on a map.
			         //console.log(place);
			          if (place.geometry.viewport) {
			            map.fitBounds(place.geometry.viewport);
			          } else {
			            map.setCenter(place.geometry.location);
			            map.setZoom(17);  // Why 17? Because it looks good.
			          }
			          
			          marker.setIcon(({
			            url: place.icon,
			            /*size: new google.maps.Size(71, 71),
			            origin: new google.maps.Point(0, 0),
			            anchor: new google.maps.Point(17, 34),*/
			            scaledSize: new google.maps.Size(35, 35)
			          }));
			          marker.setPosition(place.geometry.location);
			          marker.setVisible(true);
			          
			          var address = '';
			          if (place.address_components) {
			            address = [
			              (place.address_components[0] && place.address_components[0].short_name || ''),
			              (place.address_components[1] && place.address_components[1].short_name || ''),
			              (place.address_components[2] && place.address_components[2].short_name || '')
			            ].join(' ');
			          }

			          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
			          infowindow.open(map, marker);




		            document.getElementById('latitude').value = place.geometry.location.lat();
		            document.getElementById('longitude').value = place.geometry.location.lng();
		            /*alert(place.name);*/
		            var city = '';
		            var street = '';
		            var house = '';
		            var region = '';
		            var country = '';
		            
		            var tmp = '';
		            place.address_components.forEach(function(item, i, arr) {
		            	//console.log(item);
		            	tmp = item.long_name;
		            	if(item.types) {
							item.types.forEach(function(t) {
								//console.log(t);
								switch (t) {
									case 'street_number' :
									house = tmp;
									break;
									case 'route' :
									street = tmp;
									break;
									case 'administrative_area_level_1' :
									case 'administrative_area_level_2' :
									region = tmp;
									break;
									case 'country' :
									country = tmp;
									break;
									case 'postal_town' :
									case 'locality' :
									city = tmp;
									break;
								}
							});
						}
		        	});
		        	document.getElementById('city').value = city;
		        	document.getElementById('street').value = street;
		        	document.getElementById('house').value = house;
		        	document.getElementById('region').value = region;
		        	document.getElementById('country').value = country;
		    	});
			}
			
</script>

<?php

if (isset($_POST['addcase'])) {
	$text = $_POST['city'] .', '.$_POST['street'].' '.$_POST['house'];
	DB::table('case')->insert([
			  ['location' => $text,
			  'lng' => @(float)$_POST['longitude'],
			  'lat' => @(float)$_POST['latitude'],
			  'weight' => @(float)$_POST['weight'],
			  'size' => @(float)$_POST['size']]
			  ]);

		$message = 1;
}
?>

<div class="content-page">
	<div class="content">
		<div class="container-fluid">

		   <div class="row">
				<div class="col-12">
					<div class="page-title-box">
						<h4 class="page-title float-left">Web ГИС предприятия по вывозу мусора</h4>
						<ol class="breadcrumb float-right">
							<li class="breadcrumb-item"><a href="#">Главная</a></li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
				<?php
				if (isset($message)) {
					echo '<div class="alert alert-custom alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				Объект на улице '.$_POST["address"].' успешно создан.        
			 </div>';
				}
				?>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<form method="post">
										{{ csrf_field() }}

						<div class="card-box">
							<h4 class="header-title m-t-0">Добавление новго объекта</h4>
							<p class="text-muted font-14 m-b-20"> Для успешного добавления новго бъекта (бака), необходимо заполнить адрес,вес и объём контейнера</p>
							<p class="text-muted font-14 m-b-20"> Перетащите метку на карте или введите ближайший адрес для установки точки. </p>
							<hr>
							<div class="form-group row">
								<label for="inputEmail3"  class="col-4 col-form-label">Адрес<span class="text-danger">*</span></label>
								<div class="col-7">
									<input type="text" name="address" required  class="form-control" id="address"  placeholder="г. Муром, ул. Орловская, 23">
								</div>
							</div>
								<input type="hidden" name="city" id ="city">
									<input type="hidden" name="street" id ="street">
									<input type="hidden" name="house" id ="house">
									<input type="hidden" name="" id ="city">
							<div class="form-group row">
								<label for="inputEmail3" class="col-4 col-form-label">Объем бака<span class="text-danger">*</span></label>
								<div class="col-7">
									<input type="text" name="size"  class="form-control" required id="inputEmail3" placeholder="300 куб. л">
								</div>
							</div>
							<div class="form-group row">
								<label for="inputEmail3" class="col-4 col-form-label">Грузоподъёмнсть<span class="text-danger">*</span></label>
								<div class="col-7">
									<input type="text" name="weight"  class="form-control" required id="inputEmail3" placeholder="300 кг.">
								</div>
							</div>

							<hr>
							<div class="form-group row">
								<label for="inputEmail3" class="col-4 col-form-label">Широта<span class="text-danger"></span></label>
								<div class="col-7">
									<input type="text" class="form-control"   name="latitude" id="latitude"/>
								</div>
							</div>

							<div class="form-group row">
								<label for="inputEmail3" class="col-4 col-form-label">Долгота<span class="text-danger"></span></label>
								<div class="col-7">
									<input type="text" class="form-control"  name="longitude" id="longitude"/>
								</div>
							</div>
							<hr>

							<div class="form-group row">
								<div class="col-8 offset-4">
									<button class="btn btn-gradient waves-effect waves-light" name="addcase"> Добавить </button> 
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="col-lg-6">
					<div class="card-box">
						<h4 class="m-t-0 m-b-20 header-title"><b>Установить координаты</b></h4>
						<div id="map" style="height: 505px; margin: 10px; width: 460px;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgD5jrmV7TZa1AWIKaRTzrjluLSRVph5E&libraries=places&callback=initMap"></script>

@endsection
