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

<?php 
  require_once("assets/fpdf/tfpdf.php"); 

if (isset($_POST['case'])) {
  // header('Location: /List');
}

?>
					<style type="text/css">
						.card-img-overlay:hover {background: rgba( 240,240,240,0.8);;
							transition: 1s}
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
		<div class="row">

		<?
		function CreatePDF($result, $tmp, $value, $buf_size, $buf_weight, $mapa) {
			$textColour = array( 0, 0, 0 );
			$headerColour = array( 100, 100, 100 );
			$tableHeaderTopTextColour = array( 255, 255, 255 );
			$tableHeaderTopFillColour = array( 125, 152, 179 );
			$tableHeaderTopProductTextColour = array( 0, 0, 0 );
			$tableHeaderTopProductFillColour = array( 143, 173, 204 );
			$tableHeaderLeftTextColour = array( 99, 42, 57 );
			$tableHeaderLeftFillColour = array( 184, 207, 229 );
			$tableBorderColour = array( 50, 50, 50 );
			$tableRowFillColour = array( 213, 170, 170 );
			$reportName = "WEB-ГИС предприятия по вывозу мусора";
			$reportNameYPos = 160;
			$logoFile = "logo.png";
			$logoXPos = 50;
			$logoYPos = 108;
			$logoWidth = 110;
			$columnLabels = array( "Q1", "Q2", "Q3", "Q4" );
			$rowLabels = array( "SupaWidget", "WonderWidget", "MegaWidget", "HyperWidget" );
			$data = array(
					  array( 9940, 10100, 9490, 11730 ),
					  array( 19310, 21140, 20560, 22590 ),
					  array( 25110, 26260, 25210, 28370 ),
					  array( 27650, 24550, 30040, 31980 ),
					);

			$pdf = new tFPDF();

			$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
			$pdf->SetFont('DejaVu','',14);

			$str = 'https://maps.googleapis.com/maps/api/staticmap?size=900x450&maptype=roadmap
					'.$mapa.'&key=AIzaSyDLzWXCDzG8Ui_APDFhNmq9YRJMbUbBj3Y&language=ru';
			$local='file.png';
			file_put_contents($local, file_get_contents($str));



			$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
			$pdf->AddPage();
			$pdf->Image($local,20,60);

			$pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
			$pdf->SetFont('DejaVu','U',10);
			$pdf->Cell( 0, 15, $reportName . date('  d.m.o  H:i:s'), 0, 0, 'C' );
			$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
			$pdf->SetFont('DejaVu','',14);
			$pdf->Ln( 6);
			$pdf->Ln( 6);
			$pdf->Write( 6, "Путевой лист для гаража по улице:  ". $tmp[0]->start_location );
			$pdf->Ln( 6);
			$pdf->Write( 6, "Автомобиль марки: " . $value->marks);
			$pdf->Ln( 6);
			$worker = DB::table('auto_worker')->where('id_auto', $value->id)->get(); // готовые машины
			$worker1 = DB::table('worker')->where('id', $worker[0]->id_worker)->get(); // готовые машины
			$pdf->Write( 6, "Водитель: ". $worker1[0]->name . ' ' . $worker1[0]->patronymic . ' ' . $worker1[0]->surname );
			$pdf->Ln( 6);
			$pdf->Write( 6, "Объём мусорного контейнера: " . $value->size . ' куб. м. | Сейчас загружено: ' . $buf_size .' куб. м.');
			$pdf->Ln( 6);
			$pdf->Write( 6, "Грузоподьёмность: " . $value->weight . ' кг. | Сейчас загружено: ' . $buf_weight .' кг.');
			$pdf->Ln(130);
			$pdf->Cell( 0, 15, 'Трассировка пути', 0, 0, 'C' );
			$pdf->Ln( 6);
			$pdf->Ln( 6);

		foreach ($result->routes[0]->legs as $step) {

			$one = $step->start_address;
			$two = $step->end_address;

			$count = 0;
			$find = ",";
			$positions = array();
			for($i = 0; $i<strlen($one); $i++){
				$pos = strpos($one, $find, $count);
				if($pos == $count){
				   $positions[] = $pos;
				}
				$count++;
			}
			$one = substr($one,0,$positions[2]);

			$count = 0;
			$find = ",";
			$positions = array();
			for($i = 0; $i<strlen($two); $i++){
				$pos = strpos($two, $find, $count);
				if($pos == $count){
				   $positions[] = $pos;
				}
				$count++;
			}
			$two = substr($two,0,$positions[2]);


			
			$pdf->Ln( 6);
			$pdf->Ln( 6);
			$pdf->Write( 6, "Начало маршрута ". $one );
			$pdf->Ln( 6);
			$pdf->Write( 6, "Конец маршрута ". $two );
			$pdf->Ln( 6);
			$pdf->Write( 6, "____________________________________________");

		
		}
		$pdf->Ln( 6);
		$name = 'files/' . $tmp[0]->id . date('_H_i_s') .'report.pdf';

		$pdf->Output( $name, "F" );
		return $name;
		}

		function Optimal($str, $tmp){
			/*Вычисляем оптимальный путь между всеми точками (теория графов)*/
		

		$request_params = array('origin' => $tmp[0]->start_location,
								'destination' =>  $tmp[0]->end_location,
								'waypoints' => 'optimize:true|'.$str,
								'language'=> 'ru',
								'key'=>'AIzaSyBmDWWD04HGi_HHpeZGjfgPpsFTBVPHXu4'
								);
		$get_params = http_build_query($request_params);
		$result = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/directions/json?'.$get_params));
		return $result;
	}

		function Check($id, $type, $garage, $tat)
		{
			if ($type == 1) {
				$tmp = DB::table('garage')->where('id', $id)->get(); // список полученных баков
				$count = DB::table('auto')->where([['id_garage', $id],['status','on']])->count(); // список полученных баков
				$auto = DB::table('auto')->where([['id_garage', $id],['status','on']])->get(); // список полученных баков

				$case = DB::table('case')->get(); 


				echo  '
							 <div class="modal fade bs-example-modal-lg'.$tmp[0]->id.'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h5 class="modal-title" id="myLargeModalLabel">Протокол</h5>
                                                </div>
                                                <div class="modal-body">';
                                                $c = 0;
                                                foreach ($auto as $key => $value) {
                                                	#Проход по всем машинам в гараже
                                                	echo "<br><br>Автомобиль ".$value->marks .' заберёт баки с улиц: <br>';
                                                	$flag =0;
                                                	$buf_weight = 0; //сколько поместится в машину кг
                                                	$buf_size = 0; //сколько поместится в машину объём
													$str ='';
													$mapa ='';

													$identify = DB::table('task')->insertGetId(
															['id_auto' => $value->id, 
															 'date'    => date('Y-m-d H:i:s'),
															 'id_garage'    => $id,
														     'status'  => 'on'
															]);

													DB::table('auto')->where('id', $value->id)->update(
																	['status'   => 'wait']); //считаем, что за контейнером уже выехали



                                                	foreach ($tat[$id] as $number => $item) {
                                                		#проход по задействованным бакам в гараже
														$case = DB::table('case')->where('id', $item['id_case'])->get(); 
														if (($buf_size + $case[0]->size < $value->size) && ($buf_weight + $case[0]->weight < $value->weight) && ($item['status'] == 'off')){
															$buf_size = $buf_size + $case[0]->progress_size;
															$buf_weight = $buf_weight + $case[0]->progress_weight;
															$tat[$id][$number]['status'] = 'on'; //их заберут
															$str = $str . $case[0]->location . '|'; //промежуточные точки для запросу к гуглу
															$mapa = $mapa . '&markers=color:red%7Clabel:'.$case[0]->id.'%7C'.$case[0]->lat. ','.$case[0]->lng . '';
															echo $case[0]->location .'<br>';

															echo $case[0]->location .' | вес контейнера - '. $case[0]->weight . ' кг. Уже загружено в машину - '.$buf_weight.' кг. <br>';
															echo $case[0]->location .' | объём контейнера - '. $case[0]->size . ' куб.м. Уже загружено в машину - ' . $buf_size .'<br>';
															$chee = DB::table('TaskDetail')->where([['id_garage', $id], ['id_case', $case[0]->id] ])->get();
															if ((isset($chee[0])) && ($chee[0]->status == 'off')) {
																DB::table('TaskDetail')->where('id', $chee[0]->id)->update(
																	['status'     => 'on',
																	'id_task'   => $identify]);
															} else {
																DB::table('TaskDetail')->insert([
																['id_task'   => $identify,
																'id_case'   => $case[0]->id,
															 	'id_garage'    => $id,
															 	'status' => 'on']
																]);
																DB::table('case')->where('id', $case[0]->id)->update(
																	['task'   => 'yes']); //считаем, что за контейнером уже выехали
															}
															echo "Бак №" . $case[0]->id . ' добавлен К заданию №' . $identify ."<br>" ;
															$flag=$flag+1;
														} elseif ($item['status'] == 'on') {
															echo $case[0]->id .' бак вывезен<br>';
														} elseif ($item['status'] =='off') {
															echo 'Контейнер №'.$case[0]->id .' оставлен в очереди, т.к. нет места<br>';
														}

                                                	}


                                                	if ($flag == 0) {
														DB::table('task')->where('id', '=', $identify)->delete(); //удалить машину
														DB::table('auto')->where('id', $value->id)->update(
																	['status'   => 'on']); //считаем, что за контейнером уже выехали
                                                	} else {
                                                		echo "Маршрут до нахождения оптимального пути:<br>_________";
		$str = substr($str,0,-1); //удаляем в конце знак табуляции
echo '<center> <iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/directions?origin='.$tmp[0]->start_location.'&destination='.$tmp[0]->end_location.'&waypoints='.$str.'&key=AIzaSyDaI2YVXVtnGAYO4Yh_CEjbAbKb0Lfqjlk" allowfullscreen></iframe> </center><br>_________';


                                                		DB::table('task')->where('id', $identify)->update(
																['size'     => $buf_size, 
															     'weight'    =>$buf_weight]);
														$result = Optimal($str, $tmp); //вывод трассировки
														$names = CreatePDF($result, $tmp, $value, $buf_size, $buf_weight, $mapa);

														$ss='';
														foreach ($result->routes[0]->legs as $step) {
															$ss = $ss. $step->start_address.'|';
														}

														echo "Маршрут после нахождения оптимального пути:<br>_________";
		$ss = substr($ss,0,-1); //удаляем в конце знак табуляции
echo '<center> <iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/directions?origin='.$tmp[0]->start_location.'&destination='.$tmp[0]->end_location.'&waypoints='.$ss.'&key=AIzaSyDaI2YVXVtnGAYO4Yh_CEjbAbKb0Lfqjlk" allowfullscreen></iframe> </center><br>_________';
														DB::table('task')->where('id', $identify)->update(
																['size'     => $buf_size,
																 'file'     => $names, 
															     'weight'    =>$buf_weight]);
                                                	}
                                                }
                                               echo ' </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
							 <div class="card m-b-30 card-inverse text-white">
									<img class="card-img img-fluid" src="https://maps.googleapis.com/maps/api/staticmap?size=400x300&center=МУРОМ&zoom=18&&maptype=roadmap&markers=МУРОМ>&key=AIzaSyDLzWXCDzG8Ui_APDFhNmq9YRJMbUbBj3Y" alt="Card image">
									<div class="card-img-overlay" >
										<h5 class="card-title text-dark">'.$tmp[0]->start_location.'</h5><br>
										<p class="card-text text-dark" ><b>' . $count . ' автомобиля готовы к вывозу мусора </b></p>
										<button type="button" class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg'.$tmp[0]->id.'">Протокол</button>
									</div>
								</div>
							</div>

                                    ';
			} else {
				$tmp = DB::table('garage')->where('id', $id)->get(); // список полученных баков
				echo '<div class="col-md-4">
							 <div class="card m-b-30 card-inverse text-white">
									<img class="card-img img-fluid" src="https://maps.googleapis.com/maps/api/staticmap?size=400x300&center=МУРОМ&zoom=18&&maptype=roadmap&markers=МУРОМ>&key=AIzaSyDLzWXCDzG8Ui_APDFhNmq9YRJMbUbBj3Y" alt="Card image">
									<div class="card-img-overlay" >
										<h5 class="card-title text-dark">'.$tmp[0]->start_location.'</h5><br>
										<p class="card-text text-danger" ><b>Нет автомобилей в данном гараже или все на выезде!</b></p>
										<p class="card-text text-danger" ><b>Переместите в этот гараж другой автомбиль или дождитесь пока освободятся дугие автомобили</b></p>

									</div>
								</div>
							</div>';
			}
		}

		
		if (isset($_POST['case'])) {
			foreach ($_POST['case'] as $key => $value) {
				$tmp = DB::table('case_garage')->where('id_case', $key)->get(); 
				$garage [] = ['id_garage' => $tmp[0]->id_garage, 'id_case' => $key]; // задействованные гаражи
				$tat [$tmp[0]->id_garage][] = ['id_case' => $key, 'status' => 'off']; //вспомогательныймассив
				$check [] = ['id' => $key];
			}

			foreach ($garage as $key => $value) {
				$tmp = DB::table('auto')->where([['id_garage', $value['id_garage']],['status','on']])->count(); // список полученных баков
				if ($tmp !=0) {
					#В гараже есть машины
					$garage_on [] = ['id_garage' => $value['id_garage']];
				} else {
					#Если в гараже нет активных машин
					$garage_off [] = ['id_garage' => $value['id_garage']];
				}
			}
			#Исключение 
			if (isset($garage_on))  {
				$one=array_unique($garage_on, SORT_REGULAR); //убираем повторяющиеся
				foreach ($one as $key => $value) {
					$id = $value['id_garage'];
					$type = 1;
					echo Check($id, $type, $garage, $tat);

				}
			}
			if (isset($garage_off)) {
				$two=array_unique($garage_off, SORT_REGULAR); //убираем повторяющиеся
				foreach ($two as $key => $value) {
					$id = $value['id_garage'];
					$type = 0;
					echo Check($id, $type, $garage, $tat);
				}
			}
		} else {

				
			echo " <div class='col-12'> <h2> Не выбраны баки! </h2>";
		}
?>
		</div>
</div>




@endsection
