@extends('layouts.app')
 
<?php
			if (isset($_POST['update'])) {
				if (isset($_POST['size'])) {
					$res = ($_POST['alls'] / 100) * $_POST['size']; //конвертируем полученные проценты в куб.м

					if ($_POST['size'] == 100) {
						DB::table('case')
	        			->where('id', $_GET['id'])
	        			->update(['progress_size'   => $res, 'status' => 'off']);
					} else {
						DB::table('case')
	        			->where('id', $_GET['id'])
	        			->update(['progress_size'   => $res]);
					}

				}elseif (isset($_POST['weight'])) {
					$res = ($_POST['allw'] / 100) * $_POST['weight']; //конвертируем полученные проценты в кг
					if ($_POST['weight'] == 100) {
					  DB::table('case')
	        			->where('id', $_GET['id'])
	        			->update(['progress_weight'   => $res,'status' => 'off']);
	        		} else{
	        			 DB::table('case')
	        			->where('id', $_GET['id'])
	        			->update(['progress_weight'   => $res]);
	        		}
				}
			}
			if (isset($_GET['status'])) {
				DB::table('case')
	        			->where('id', $_GET['id'])
	        			->update(['status'   => $_GET['status']]);
			}

				$info = DB::table('history')->where('id_case', '=', $_GET['id'])->get();
				$case = DB::table('case')->where('id', '=', $_GET['id'])->get();
				$res = ($case[0]->progress_size * 100) / $case[0]->size;
				$h = $case[0]->size;
				$res1 = ($case[0]->progress_weight * 100) / $case[0]->weight; 
				$h1 = $case[0]->weight;

				switch ($case[0]->status) {
					case 'off':
						$status = '<p class="text-danger">Заполнен</p>';
						$t = 'on';
						break;
					case 'on':
						$status = '<p class="text-success">Не заполнен</p>';
						$t = 'off';
						break;
				}

			?>

@section('content')
<div class="content-page">
	<div class="content">
		<div class="container-fluid">
		   <div class="row">
				<div class="col-md-12  text-center">
					<br>
				<?php echo "<center><h3>" . $case[0]->location .'</h3></center>'; ?>
				<br>
				</div>
		   		
			</div>
			
			<div class="row">
				<div class="col-md-3 col-sm-6 text-center">
					<form method="POST" action="/detail?id=<? echo $_GET['id']?>">
						{{ csrf_field() }}
						<div class="card-box">
							<input data-plugin="knob" data-width="150" data-height="150"
								   data-displayPrevious=true data-fgColor="#f06292" data-skin="tron"
								   data-cursor=true value="<? echo $res; ?>%" name='size' data-thickness=".2" data-angleOffset=-125
								   data-angleArc=250 />
								   <input type="hidden" name="alls" value="<? echo $h?>">
							<h6 class="text-muted mt-3">Объём бака в %</h6>
							<button class='btn btn-info waves-effect waves-light' name="update"> Установить </button>
						</div>
					</form>
				</div>  

				<div class="col-md-3 col-sm-6 text-center">
					<form method="POST" action="/detail?id=<? echo $_GET['id']?>">
						{{ csrf_field() }}
						<div class="card-box">
							<input data-plugin="knob" data-width="150" data-height="150"
							   data-displayPrevious=true data-fgColor="#f06292" data-skin="tron"
							   data-cursor=true value="<? echo $res1; ?>" name='weight' data-thickness=".2" data-angleOffset=-125
							   data-angleArc=250 />
								   <input type="hidden" name="allw" value="<? echo $h1?>">

							<h6 class="text-muted mt-3">Вес бака в %</h6>
							<button class='btn btn-info waves-effect waves-light' name="update"> Установить </button>
						</div>
					</form>
				</div>  

				<div class="col-md-6 col-sm-6 text-center">
					<div class="card-box">
						<h4 class="text-muted mt-3"><? echo $status; ?></h6>
						<a href="/detail?id=<? echo $_GET['id'].'&status='.$t;?>" class='btn btn-info waves-effect waves-light' name="status"> Установить </a>

						<p class="text-muted mt-3">Данный показатель необходим, для составления списка с заданиями. Если статус "Не заполнен", то никакие действия с данным контейнером производиться не будут. Если статус "Заполнен", то бак поставится в очередь на вывоз </p>


					</div>
				</div>

			</div>

						<div class="row">
							<div class="col-12">
								<div class="card-box table-responsive">
									<p class="text-muted font-14 m-b-30">
									</p>

									<table id="datatable" class="table table-bordered">
										<thead>
										<tr>
											<th>Время</th>
											<th>Действие</th>
											<th>Шаг</th>
											<th>Итог</th>
										</tr>
										</thead>

										<tbody>

											<?php
											foreach ($info as $key) {
												echo "<tr>";
												echo "<td>".$key->date."</td>";
												if ($key->type == 'insert') {
													echo "<td>Пополнение</td>";
												} else {
													echo "<td>Забор</td>";

												}
												echo "<td>".$key->step."</td>";
												echo "<td>".$key->progress."</td>";
												echo "</tr>";
												}
											?>
										
										</tbody>
									</table>
								</div>
							</div>
						</div> <!-- end row -->
			
		</div>
	</div>
</div>
	
	

@endsection
