@extends('layouts.app')

@section('content')


	<?php 
		if (Auth::check()) {
        $status = Auth::user()->status;
		switch ($status) {
			case 'free':
                   echo '<script>setTimeout(location="/404", 1)</script>';
				break;
			case 'tech':
                   echo '<script>setTimeout(location="/404", 1)</script>';
				break;
			default:
				# code...
				break;
		}}
		?>
<style type="text/css">
.text-center {
	text-align: center;
}

.map {
	width: 100%;
	height: 400px;
}
</style>

<div class="content-page">
	<div class="content">
		<div class="container-fluid">
		   <div class="row">
				<div class="col-12">
					<div class="page-title-box">
						<h4 class="page-title float-left">Web ГИС предприятия по вывозу мусора</h4>
						<ol class="breadcrumb float-right">
							<li class="breadcrumb-item"><a href="home">Главная</a></li>
							<li class="breadcrumb-item active">Метод наполнения</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
		<?php 

			if (isset($_POST['ok'])){

				foreach ($_POST['case'] as $key => $value) {
						#КОСТЫЛЬ! НЕ ТРОГАТЬ!!
					DB::table('case_garage')->where('id_case', $key)->update(['distance' => 99999999]);
				}

				foreach ($_POST['case'] as $key => $value) {
					#Смотрим принадлежность баков к гаражам
					foreach ($_POST['garage'] as $number => $item) {
						#Выбранные гаражи, создаем таблицу
						$tmp_garage = DB::table('garage')->where ('id' ,'=', $number)->get(); //гараж, который пришёл с POST
						$tmp = DB::table('case')->where ('id' ,'=', $key)->get(); //бак, который пришёл с POST

						$request_params = array('origin' => $tmp[0]->location,
										'destination'=> $tmp_garage[0]->start_location,
										'key'=>'AIzaSyBmDWWD04HGi_HHpeZGjfgPpsFTBVPHXu4'
										);
						$get_params = http_build_query($request_params);
						$str = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/directions/json?'.$get_params));
						$distance = $str->routes[0]->legs[0]->distance->value; // метров до точки Б

						$case_list []= ['id_case' => $key, 'content' => ['case' => $tmp[0]->location, 'origin' =>$tmp_garage[0]->start_location, 'distance' => $distance]]; //массив с найденным для сортировки
						$temp = DB::table('case_garage')->where('id_case' ,'=', $tmp[0]->id)->value('distance');
						$buf = DB::table('case_garage')->where('id_case' ,'=', $tmp[0]->id)->value('id_garage'); 

						if (isset($temp)) {
							#если не пустой тепм
								# Что бы не было конфликта, когда выбраешь не все баки из списка
								# сначала увеличиваем дистанцию на максимум(что бы не бралось минимальное значение страого гаража)
								# и присваваем новое значение к найденному гаражау

								if (($buf <> $tmp_garage[0]->id) && ($temp > $distance)) { // Если текущая дистанция в БД больше, чем проверяемая, то обновляем
									#если запись с этим баком уже есть, то обновим
									DB::table('case_garage')
									->where('id_case', $tmp[0]->id)
									->update(['id_garage' => $tmp_garage[0]->id, 'distance' => $distance]);
								}
							//}
						} else {
							#Если такого бака в таблице нет, то добавим
							DB::table('case_garage')->insert(
									['id_garage' => $tmp_garage[0]->id, 
									 'id_case' => $tmp[0]->id, 
									 'distance' => $distance]);
						}
					}
				}
			}
			$case = DB::table('case')->get(); // список  баков
			$garage = DB::table('garage')->get(); // список гаражей

		?>





<?php
	$string = '';
	if (isset($_POST['case'])) {

		foreach ($_POST['case'] as $key => $value) {
			$tmp_prin = DB::table('case_garage')->where ('id_case' ,'=', $key)->get(); //бак, который пришёл с POST
			$tmp_garage = DB::table('garage')->where ('id' ,'=', $tmp_prin[0]->id_garage)->get(); //id гаража принад этому баку
			$tmp_case = DB::table('case')->where ('id' ,'=', $tmp_prin[0]->id_case)->get(); //id гаража принад этому баку

			$string = $string . '{lat: '.$tmp_case[0]->lat.', 
									lng: '.$tmp_case[0]->lng.', 
									name: "'.$tmp_case[0]->location.'", 
									addres: "заглушка", 
									img: "http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|'.$tmp_garage[0]->color.'"
								},';
		}
		foreach ($_POST['garage'] as $key => $value) {
			#создаём массив для передачи в js
			$tmp_garage = DB::table('garage')->where ('id' ,'=', $key)->get(); //id гаража принад этому баку
			$string = $string . '{lat: '.$tmp_garage[0]->lat.', 
									lng: '.$tmp_garage[0]->lng.', 
									name: "'.$tmp_garage[0]->start_location.'", 
									addres: "заглушка", 
									img: "https://chart.googleapis.com/chart?chst=d_map_pin_icon&chld=home%7C'.$tmp_garage[0]->color.'"},';
		}
		$string = substr($string,0,-1); //удаляем в конце знак табуляции
	}
?>
<script type="text/javascript">

	var markersData = [<?php echo $string; ?>];
var map, infoWindow;
 
function initMap() {
	var centerLatLng = new google.maps.LatLng(56.2928515, 43.7866641);
	var mapOptions = {
		center: centerLatLng,
		zoom: 8
	};
	map = new google.maps.Map(document.getElementById("map"), mapOptions);
	infoWindow = new google.maps.InfoWindow();
	google.maps.event.addListener(map, "click", function() {
		infoWindow.close();
	});
	// Определяем границы видимой области карты в соответствии с положением маркеров
	var bounds = new google.maps.LatLngBounds();
	for (var i = 0; i < markersData.length; i++){
		var latLng = new google.maps.LatLng(markersData[i].lat, markersData[i].lng);
		var name = markersData[i].name;
		var address = markersData[i].address;
		var img = markersData[i].img;


		var image = {url: img}

		addMarker(latLng, name, address, image);
		// Расширяем границы нашей видимой области, добавив координаты нашего текущего маркера
		bounds.extend(latLng);
	}
	// Автоматически масштабируем карту так, чтобы все маркеры были в видимой области карты
	map.fitBounds(bounds);
}
google.maps.event.addDomListener(window, "load", initMap);

function addMarker(latLng, name, address, image) {
	var marker = new google.maps.Marker({
		position: latLng,
		map: map,
		icon: image,
		title: name
	});
 
	google.maps.event.addListener(marker, "click", function() {
 
		var contentString = '<div class="infowindow">' +
								'<h3>' + name + '</h3>' +
								'<p>' + address + '</p>' +
							'</div>';
 
		infoWindow.setContent(contentString);
		infoWindow.open(map, marker);
 
	});
}
</script>


		<?php 
			if (isset($_POST['ok'])) {

		?>

		<div class="row">
			<div class="col-lg-12">
				<div class="card-box">

					<div id="map" class="map"></div>
				</div>
			</div>
		</div>


		<?php
}
		?>
		<div class="row">
			<div class="col-12">
				<div class="card-box">
					<h4 class="m-t-0 header-title">Список полных контейнеров</h4>
					<p class="text-muted m-b-15 font-13">
						 <code>Отметьте, пожалуйста, контейнеры, которые нужно вывезти.</code>.
					</p>
					<form action="" method="POST">
						{{ csrf_field() }}
						<div class="row icon-list-demo">
							<?php 
								foreach ($case as $key => $value) {
									echo '<div class="col-sm-6 col-md-4 col-lg-3">';
									echo '<input type="checkbox" name="case['.$value->id.']" checked data-plugin="switchery" data-color="#039cfd"/>   '. $value->location;
									echo '</div>';
								}
							?>
						</div>
						<hr>
						<h4 class="m-t-0 header-title">Список гражей</h4>
						<p class="text-muted m-b-15 font-13">
							 <code>Отметьте, пожалуйста, гаражи, которые необходимо задействовать.</code>.
						</p>
						<div class="row icon-list-demo">
							<?php 
								foreach ($garage as $key => $value) {
									echo '<div class="col-sm-6 col-md-4 col-lg-3">';
									echo '<input type="checkbox" name="garage['.$value->id.']" data-plugin="switchery" data-color="yellow"/>   '. $value->start_location;
									echo '</div>';
								}
							?>
						</div>
                        <button type="submit" name='ok' class="btn btn-gradient btn-rounded waves-light waves-effect w-md">Обновить БД</button>
					</form>
				</div>
			</div>
		</div>

	</div>
</div>

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAgD5jrmV7TZa1AWIKaRTzrjluLSRVph5E&libraries=places&callback=initMap"></script>



@endsection
