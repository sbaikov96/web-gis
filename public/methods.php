<?php
 header('refresh: 60'); 

	require 'rb.php'; 
	R::setup( 'mysql:host=localhost;dbname=gis','root', '' );
	//R::setup( 'mysql:host=localhost;dbname=u3240_laravel','u3240_main', 'qwerty' );


	function log1($id, $progress, $version, $step) {
		$history = R::dispense('history');
		$history->id_case = $id;
		$history->type = 'insert';
		$history->version = $version;
		$history->date = date('Y-m-d H:i:s');
		$history->progress = $progress;
		$history->step = $step;
		$id = R::store($history);
	}

	$all_case = R::find('case'); //все баки

	foreach ($all_case as $value) {
		if ($value->progress_size <= $value->size) {
			#Если в баке меньше его объема, то запускаем заглушку
			$step = rand(0,25) / 100;
			$progress = $value->progress_size + $step;
			if ($progress < 99) {
				$id = $value->id;
				$bean = R::load('case', $value->id); 
				$params = array('progress_size' => $progress); //нужные значения
				$bean->import($params); //приводим в нужный вид для rb
				$id = R::store($bean); // обновляем поле
				echo '<br>Бак: '.$value->id."    Прогресс: ". $progress . ' Шаг: '.$step;
				$version = 'size';
				log1($id, $progress, $version, $step);
			} else{
				$bean = R::load('case', $value->id); 
			$params = array('status' => 'off'); //нужные значения
			$bean->import($params); //приводим в нужный вид для rb
			$id = R::store($bean); // обновляем поле
			}
		} else {
			$bean = R::load('case', $value->id); 
			$params = array('status' => 'off'); //нужные значения
			$bean->import($params); //приводим в нужный вид для rb
			$id = R::store($bean); // обновляем поле
		}

		if ($value->progress_weight <= $value->weight) {
			#Если в баке меньше его веса, то запускаем заглушку
			$step = rand(0,25) / 100;
			$progress = $value->progress_weight + $step;
			if ($progress < 99) {
				$id = $value->id;
				$bean = R::load('case', $value->id); 
				$params = array('progress_weight' => $progress); //нужные значения
				$bean->import($params); //приводим в нужный вид для rb
				$id = R::store($bean); // обновляем поле
				echo '<br>Бак: '.$value->id."    Прогресс: ". $progress . ' Шаг: '.$step;
				$version = 'weight';
				log1($id, $progress, $version, $step);
			} else {
				$bean = R::load('case', $value->id); 
			$params = array('status' => 'off'); //нужные значения
			$bean->import($params); //приводим в нужный вид для rb
			$id = R::store($bean); // обновляем поле
			}
		} else {
			$bean = R::load('case', $value->id); 
			$params = array('status' => 'off'); //нужные значения
			$bean->import($params); //приводим в нужный вид для rb
			$id = R::store($bean); // обновляем поле
		}

	}

	$task = R::find('TaskDetail'); //все баки
	foreach ($task as $key => $value) {
		if ($value->status == 'on') {
			#Значит задание активно
			$bean = R::load('TaskDetail', $value->id); 
			$params = array('status' => 'completed', 'date' => date('Y-m-d H:i:s')); //выполнено
			$bean->import($params); //приводим в нужный вид для rb
			$id = R::store($bean); // обновляем поле
			echo "обновил";
			
			break;
		}
	}
?>