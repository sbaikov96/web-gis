@extends('layouts.app')

@section('content')
<div class="content-page">
	<div class="content">
		<div class="container-fluid">
		   <div class="row">
				<div class="col-md-4"> 
				</div>
			</div>

<?php 
	$t25 = 0;
	$t50 = 0;
	$t75 = 0;
	$t100 = 0;
	$s = Auth::user()->status;
	$all = DB::table('case')->get();
	foreach ($all as $key => $value) {
		$weight = ($value->progress_weight * 100) / $value->weight; 
		$size = ($value->progress_size * 100) / $value->size; 
		$summ = ($weight+$size) / 2;
		if (($summ >= 0 ) && ($summ <=25)) {
			$t25++;
		}elseif (($summ >= 25 ) && ($summ <=50)) {
			$t50++;
		}
		elseif (($summ >= 50 ) && ($summ <=75)) {
			$t75++;
		}
		elseif ($summ >= 75 )  {
			$t100++;
		}
	} 
			$table = DB::table('task')->where('status', 'on')->get(); // список принадлежащих контейнеров этому гаражу

	
?>
			<div class="row">
				<div class="col-md-3">
					<div class="card m-b-30 text-white bg-success text-xs-center">
						<div class="card-body">
							<blockquote class="card-bodyquote">
								<h1 class='text-center display-2' > <? echo $t25;?> </h1>
								<footer> <p class="text-center"> контейнеров заполненых от 0% до 25% </p> </footer>
							</blockquote>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card m-b-30 text-white bg-primary text-xs-center">
						<div class="card-body">
							<blockquote class="card-bodyquote">
								<h1 class='text-center display-2' > <? echo $t50;?> </h1>
								<footer> <p class="text-center"> контейнеров заполненых 25% до 50% </p> </footer>
							</blockquote>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card m-b-30 text-white bg-warning text-xs-center">
						<div class="card-body">
							<blockquote class="card-bodyquote">
								<h1 class='text-center display-2' > <? echo $t75;?> </h1>
								<footer> <p class="text-center"> контейнеров заполненых от 50% до 75% </p> </footer>
							</blockquote>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="card m-b-30 text-white bg-danger text-xs-center">
						<div class="card-body">
							<blockquote class="card-bodyquote">
								<h1 class='text-center display-2' > <? echo $t100;?> </h1>
								<footer> <p class="text-center"> контейнеров заполненых от 75% до 100% </p> </footer>
							</blockquote>
						</div>
					</div>
				</div>
			</div>
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
										if ($s <> 'free') {
										echo '<td><button type="button" class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-lg'.$value->id.'">Открыть</button></td>';
										}

										echo "</tr>";
									}
								?>
									

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php
			foreach ($table as $key => $value) {

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

@endsection
