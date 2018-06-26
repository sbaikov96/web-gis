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
if (isset($_POST['status'])) {
	
	DB::table('users')->where('id', $_POST['id']) ->update(
				['status'     => $_POST['status']]);
}
	
	$count = DB::table('users')->get();

	
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
											<th>Имя</th>
											<th>Email</th>
											<th>Права доступа</th>
											<th></th>
											<th></th>


										</tr>
										</thead>
										<tbody>
										<?php 
											foreach ($count as $number => $key) {
												echo "<tr>";
												$flag = ' ';
											if ($key->id == 1) {
										        continue;
										    }
												switch ($key->status) {
													case 'admin':
														$status = 'Администратор';
														$flag = 'selected';
														break;

														case 'disp':
														$status = 'Диспетчер';
														$flag = 'selected';
														break;

														case 'tech':
														$status = 'Техник';
														$flag = 'selected';
														break;

													default:
														$status = 'Не прошёл модерацию';
														$flag = 'selected';


														break;
												}
												echo "<td>".$key->name."</td>";
												echo "<td>".$key->email . "</td>";
												echo "<td>".$status."</td>";
												 ?>
<td>
												<form method="POST" action="Admin">
										{{ csrf_field() }}
											<select  name ='status' class="selectpicker" data-style="btn-custom btn-block">
												<option  value='admin'>Администратор</option>
												<option  value='disp'>Диспетчер</option>
												<option  value='tech'>Техник</option>
												<option  value='free'>Снять права</option>
	                                         </select>
	                                         <input type="hidden" name="id" value="<? echo $key->id ?>">
</td>
<td>
 <button class="btn w-lg btn-custom waves-effect waves-light" name="update" >Назначить</button>
                                         </form>

</td>


<? 
												
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
