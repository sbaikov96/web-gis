@extends('layouts.app')

@section('content')
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
	if (isset($_GET['reset'])) {
		 DB::table('case')
	        ->where('id', $_GET['id'])
	        ->update(['progress_size'   => 0.0, 
	        		  'progress_weight' => 0.0,
	        		  'status'          => 'on'
	        		]);

	    DB::table('history')->insert([
			  ['id_case' => $_GET['id'],
			  'type' => 'reset',
			  'date' => date('Y-m-d H:i:s'),
			  'progress' => 0,
			  'step' => 0]
			]);
	}
	$count = DB::table('case')->get();

	
?>
		<div class="row">
			<div class="col-lg-12">
								<div class="card-box">
									<h4 class="m-t-0 header-title">Информация по бакам в инфографике</h4>
									<p class="text-muted font-14 m-b-20">
									</p>
									<table class="table">
										<thead>
										<tr>
											<th>Адресс</th>
											<th>Объём</th>
											<th>Вес</th>
											<th>% заполненого веса</th>
											<th>% заполненого объёма</th>
											<th>Детальная карточка</th>
											<th></th>
										</tr>
										</thead>
										<tbody>
										<?php 
											foreach ($count as $key) {
												echo "<tr>";
												echo "<td>".$key->location."</td>";
												echo "<td>".$key->size . "</td>";
												echo "<td>".$key->weight."</td>";
												$res = ($key->progress_size * 100) / $key->size; 
												echo '<td> '. round($res, 2).'%
												<div class="progress m-b-20">
													<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: '.$res.'%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												</td>';
												$res = ($key->progress_weight * 100) / $key->weight ; 
												echo '<td> '. round($res, 2).'%
												<div class="progress m-b-20">
													<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: '.$res.'%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												</td>';
												echo "<td> <a href='/detail?id=".$key->id."' class='btn btn-info waves-effect waves-light' > Открыть </a></td>";
												echo "<td><a href='/methods?reset=on&id=".$key->id."'> Сбросить </a></td>";
											}
										?>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
		</div>
	</div>
</div>




@endsection
