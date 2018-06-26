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
<?php
if (isset($_POST['addcase'])) {
	$color = sprintf( '#%02X%02X%02X', rand(0, 255), rand(0, 255), rand(0, 255) );
	DB::table('garage')->insert([
			  ['start_location' => $_POST['start'],
			   'end_location'   => $_POST['end'],
			   'lng'            => @(float)$_POST['lng'],
			   'lat'            => @(float)$_POST['lat'],
			   'count'          => $_POST['count']],
			   'color'          => $color
			  ]);

		$message = 1;
}
	$garage = DB::table('garage')->get();
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
			</div>
			
			<div class="row">
				<?php 
						foreach ($garage as $key => $value) {
							$count = DB::table('auto')->where('id_garage', '=', $value->id)->count();
							$activity = DB::table('auto')->where([['id_garage', '=', $value->id], ['status', '=', 'on']])->count();	


					?>
					<style type="text/css">
						.card-img-overlay:hover {background: rgba( 240,240,240,0.8);;
							transition: 1s}
					</style>
						<div class="col-md-4">
							 <div class="card m-b-30 card-inverse text-white">
									<img class="card-img img-fluid" src="https://maps.googleapis.com/maps/api/staticmap?size=400x300&center=<?php echo $value->start_location;?>&zoom=18&&maptype=roadmap&markers=<?php echo $value->start_location;?>&key=AIzaSyDLzWXCDzG8Ui_APDFhNmq9YRJMbUbBj3Y" alt="Card image">
									<div class="card-img-overlay" >
										<h5 class="card-title text-dark"><?php echo $value->start_location;?></h5><br>
										<p class="card-text text-dark" ><b> В гараже находится <?php echo $count; ?> автомобиля, <?php echo $activity; ?> из них в статусе ожидания </b></p>
										<p class="card-text text-danger">
										</p>
										<a href="DetailGarage?id=<?php echo $value->id?>" class="btn btn-gradient btn-rounded waves-light waves-effect w-md"> открыть</a>
									</div>
								</div>
							</div>
							<?php 
					}?>
			</div>
		</div>
	</div>
</div>
@endsection
