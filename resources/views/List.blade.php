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
			$case_off = DB::table('case')->where('task','no')->get(); // список полных баков
			$garage = DB::table('garage')->get(); // список гаражей
			$case_on = DB::table('case')->get(); // список полных баков


		?>
		

		<div class="row">
			<div class="col-12">
				<div class="card-box">
					<h4 class="m-t-0 header-title">Список полных контейнеров</h4>
					<p class="text-muted m-b-15 font-13">
						<?php 

						if (count($case_off) > 0) {

							?>
						<code>Отметьте, пожалуйста, контейнеры, которые нужно вывезти. Заполненные контейнеры выбранны автоматически.</code>.
						<code>Контейнеры, которые заполенились не полностью не отмечены, в скобках указан прогесс заполненности в % (вес+объём)</code>.

						
					</p>

					<form action="/CreateList" method="POST" id='target'>
						{{ csrf_field() }}
						<div class="row icon-list-demo">
							<?php 
								foreach ($case_off as $key => $value) {

									if ($value->status == 'off') {
										$status ='checked';
										$ch = ' ';
										$class = 'text-danger';
									} else {
										$status ='';
										$res = ($value->progress_size * 100) / $value->size;
										$res1 = ($value->progress_weight * 100) / $value->weight; 
										$it = round($res + $res1) / 2;
										$ch = ' ('.$it.'% )';
										$class = 'text-success';

									}


									echo '<div class="col-sm-6 col-md-4 col-lg-4 '.$class.'">';
									echo '<input type="checkbox"  id="agree"  name="case['.$value->id.']" '.$status.' data-plugin="switchery" data-color="#039cfd"/>   '. $value->location. $ch;
									echo '</div>';

								}
							?>
						</div>
						<hr>
						<div class="row icon-list-demo">

						</div>
                        <button type="submit" id="subButton" name='ok' class="btn btn-gradient btn-rounded waves-light waves-effect w-md">Сформировать</button>

                        <?
                    } else {
                    	?>
							<h4>Нет баков!</h4>.
                    	<?
                    }

                        ?>
					</form>


				</div>
			</div>
		</div>

		<div class="row">
			
		</div>
	</div>
</div>




@endsection
