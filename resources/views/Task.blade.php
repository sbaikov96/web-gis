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
		}
	}
        
		?>
<div class="content-page">
	<div class="content">
		<div class="container-fluid">
			
			<?php 
			if (isset($_POST['add'])) {
					$tmp1 = DB::table('TaskDetail')->where('id_task', $_POST['id_task'])->count(); 
					DB::table('TaskDetail')->where([['id_task', $_POST['id_task']], ['status', '<>', 'completed']])->update(['status'=> 'completed', 'date'    => date('Y-m-d H:i:s')]);
					DB::table('task')->where('id', $_POST['id_task'])->update(['status' => 'completed', 'date'    => date('Y-m-d H:i:s')]);

					$case = DB::table('TaskDetail')->where('id_task', $_POST['id_task'])->get();
					
					foreach ($case as $key => $value) {
						DB::table('case')->where('id', $value->id_case)
							->update(['task'            => 'no',
									  'status'          => 'on',
									  'progress_size'   => 0,
									  'progress_weight' =>0]);
					}
					
					$wait = DB::table('task')->where('id', $_POST['id_task'])->get();
					DB::table('auto')->where('id', $wait[0]->id_auto)->update(['status' => 'on']);

			}
			if (isset($_POST['list'])) {
				$buf = DB::table('TaskDetail')->where('id_task', $_POST['id_task'])->get(); 
				foreach ($buf as $key => $value) {
					if (isset($_POST['case'][$value->id])) {
						#если id_task пришёл постом
						DB::table('TaskDetail')->where('id', $value->id)->update(['status'=> 'completed']);
					}else {
						DB::table('TaskDetail')->where('id', $value->id)->update(['status' => 'on']);
					}
				}
			}
			$all = DB::table('task')->get(); // список принадлежащих контейнеров этому гаражу
			$table = DB::table('task')->where('status', 'on')->get(); // список принадлежащих контейнеров этому гаражу
			$off = DB::table('task')->where('status', '<>', 'on')->get(); // список принадлежащих контейнеров этому гаражу
?>
			<div class="row">
			   <div class="col-lg-12">
					<div class="card-box">
						<h4 class="m-t-0 header-title">Актуальные задания</h4>
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Водитель</th>
									<th>Автомобиль</th>
									<th>Кол-во баков</th>
									<th>Вес/объём</th>
									<th>Дата отправления</th>
									<th>Статус</th>
									<th></th>

								</tr>
							</thead>
							<tbody>
								<?php 
									foreach ($table as $key => $value) {
										$auto = DB::table('auto')->where('id', $value->id_auto)->first();
										$worker = DB::table('auto_worker')->where('id_auto', $auto->id)->get(); 
										$worker1 = DB::table('worker')->where('id', $worker[0]->id_worker)->get(); 
										$text =  $worker1[0]->name . ' ' . $worker1[0]->patronymic . ' ' . $worker1[0]->surname;

										$detail_task = DB::table('TaskDetail')->where([['id_task', $value->id], ['status','<>', 'off']])->count(); 


										switch ($value->status) {
											case 'on':
												$status = 'В пути';
												break;
											case 'completed':
												$status = 'Завершено';
												break;
											case 'check':
												$status = 'Прибыл';
												break;
											default:
												$status = 'Ошбика';
												break;
										}

										echo "<tr>";
										echo "<th scope='row'>".$value->id."</th>";
										echo "<td>".$text."</td>";
										echo "<td>". $auto->marks ."</td>";
										echo "<td>".$detail_task."</td>";
										echo "<td>".$value->weight. " кг. / ". $value->size." куб. м.</td>";
										echo "<td>" .$value->date . "</td>";
										echo "<td>".$status."</td>";
										echo '<td><button type="button" class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg'.$value->id.'">Открыть</button></td>';
										echo "</tr>";
									}
								?>
									

							</tbody>
						</table>
					</div>
				</div>
			</div>

<div class="row">
                            <div class="col-12">
                                <div class="card-box table-responsive">
                                    <h4 class="m-t-0 header-title"><b>Завершённые задания</b></h4>
                                    <p class="text-muted font-14 m-b-30">
                                    </p>

                                    <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                         <th>#</th>
										<th>Водитель</th>
										<th>Автомобиль</th>
										<th>Кол-во баков</th>
										<th>Вес/объём</th>
										<th>Дата отправления</th>
										<th></th>
                                        </tr>
                                        </thead>


                                        <tbody>
                                        <?php 
									foreach ($off as $key => $value) {
										$auto = DB::table('auto')->where('id', $value->id_auto)->first();
										$worker = DB::table('auto_worker')->where('id_auto', $auto->id)->get(); 
										$worker1 = DB::table('worker')->where('id', $worker[0]->id_worker)->get(); 
										$text =  $worker1[0]->name . ' ' . $worker1[0]->patronymic . ' ' . $worker1[0]->surname;

										$detail_task = DB::table('TaskDetail')->where([['id_task', $value->id], ['status', 'completed']])->count(); 

										echo "<tr>";
										echo "<th scope='row'>".$value->id."</th>";
										echo "<td>".$text."</td>";
										echo "<td>". $auto->marks ."</td>";
										echo "<td>".$detail_task."</td>";
										echo "<td>".$value->weight. " кг. / ". $value->size." куб. м.</td>";
										echo "<td>" .$value->date . "</td>";
										echo '<td><button type="button" class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg'.$value->id.'">Открыть</button></td>';
										echo "</tr>";
									}
								?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
			<?php
			foreach ($all as $key => $value) {

			?>
			<div class="modal fade bs-example-modal-lg<?echo $value->id ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h5 class="modal-title" id="myLargeModalLabel">Лист №<?php echo $value->id ?></h5>
						</div>
						<div class="modal-body">
							<form method="post">
								{{ csrf_field() }}
							<table class="table">
							<thead>
								<tr>
									<th>Контейнер (ул.)</th>
									<th>Время вывоза</th>
									<th>Статус</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$worker = DB::table('TaskDetail')->where([['id_task', $value->id],['status','<>', 'off']])->get(); 
								foreach ($worker as $number => $item) {
									$case = DB::table('case')->where('id', $item->id_case)->get(); 
									echo '<input type="hidden" name="id_task" value="'.$value->id.'">';

									switch ($item->status) {
											case 'on':
												$status = '<input type="checkbox"  name="case['.$item->id.']"  data-plugin="switchery" data-color="#1bb99a"/>';
												break;
											case 'completed':
												$status = '<input type="checkbox" name="case['.$item->id.']" checked data-plugin="switchery" data-color="#1bb99a"/>';
												break;
											default:
												$status = 'Ошбика';
												break;
										}
									 echo '<tr>';
										echo '<td>'.$case[0]->location.'</td>';
										echo '<td>'.$item->date.'</td>';
										echo '<td>'.$status.'</td>';
									 echo '<tr>';
}
echo "</tbody>
						</table>";
						if ($value->status == 'on') {
								?>
						<button type="submit" name="list" class="btn btn-info waves-effect waves-light">Обновить</button>
						<button type="submit" name="add" class="btn btn-info waves-effect waves-light">Закрыть поездку</button>
						<a class="btn btn-info waves-effect waves-light" href='<?php echo $value->file;?>'> Скачать путевой лист </a>
						<br><p class="text-mute">Если Вы заранее закроете поездку, то время забора бака проставится системное </p>
<? }else {
	echo "<p> Здание завершено: ".$value->date;

}?>

</form>

						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->


<?php 
}
?>
		</div>
	</div>
</div>
@endsection
