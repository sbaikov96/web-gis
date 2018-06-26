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
							<li class="breadcrumb-item active">Список сотрудников</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>
<?php 
	$count = DB::table('worker')->get(); // список водителей
	
?>
		<div class="row">
			<div class="col-lg-12">
				<div class="card-box">
					<h4 class="m-t-0 header-title">Список сотрудников</h4>
					<table class="tablesaw table m-b-0" data-tablesaw-sortable data-tablesaw-sortable-switch>
						<thead>
							<tr>
								<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Имя</th>
								<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Фамилия</th>
								<th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">Отчество</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach ($count as $key) {
									echo "<tr>";
									echo "<td>" . $key->name . "</td>";
									echo "<td>" . $key->surname . "</td>";
									echo "<td>" . $key->patronymic . "</td>";
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>




@endsection
