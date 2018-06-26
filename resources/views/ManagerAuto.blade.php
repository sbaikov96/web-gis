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

if (isset($_POST['add'])) {
	#Добавление новго авто в БД
	$id = DB::table('auto')->insertGetId(
				['size'     => $_POST['size'], //объём
				'number'    => $_POST['number'], //гос номер
				'id_garage' => $_POST['id_garage'], //идентификатор гаража
				'weight'    => $_POST['weight'], //грузоподъёмность
				'marks'     => $_POST['marks'] // марка
				]);

	#добавление связи ид машины, ид рабочего
	DB::table('auto_worker')->insert([
				['id_auto'   => $id,
				 'id_worker' => $_POST['id_worker']]
				]);
}

if (isset($_POST['update'])) {
	#обновление

	DB::table('auto')->where('id', $_POST['id']) ->update(
				['marks'     => $_POST['marks'], 
			     'size'      => $_POST['size'],
				 'weight'    => $_POST['weight'],
			     'id_garage' => $_POST['id_garage'],
			     'number'    =>$_POST['number']]);

	#обновление связи
	 $res = DB::table('auto_worker')->where('id_auto', $_POST['id'])->update(
				['id_worker' =>$_POST['id_worker']]);
	 if ($res == 0) {
	 DB::table('auto_worker')->insert([
				['id_auto'   => $_POST['id'],
				 'id_worker' => $_POST['id_worker']]
				]);
	 }
}

if (isset($_GET['del'])) {
	DB::table('auto')->where('id', '=', $_GET['del'])->delete(); //удалить машину
	DB::table('auto_worker')->where('id_auto', '=', $_GET['del'])->delete(); //удалить связь
}
$auto = DB::table('auto')->get(); // список  машин
$garage = DB::table('garage')->get(); // список  гаражей
$workers = DB::table('worker')->get(); // список  работников


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
							<li class="breadcrumb-item active">Добавить сотрудника</li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>

			<div class="row">
					   <div class="col-lg-12">
								<div class="card-box">
									<h4 class="header-title m-t-0">Добавление нового автомобиля</h4>

									<form  method="POST">
										{{ csrf_field() }}

										<div class="form-group row">
											<label for="inputEmail3" class="col-4 col-form-label">Марка</label>
											<div class="col-7">
												<input type="text" required parsley-type="email" class="form-control"
													   id="inputEmail3" name="marks" placeholder=" Рено">
											</div>
										</div>

										<div class="form-group row">
											<label for="inputEmail3" class="col-4 col-form-label">Государственный регистрационный знак</label>
											<div class="col-7">
												<input type="text" required parsley-type="email" class="form-control"
													   id="input" name="number" placeholder=" О603НК33">
											</div>
										</div>

										<div class="form-group row">
											<label for="inputEmail3" class="col-4 col-form-label">Объём мусорного контейнера</label>
											<div class="col-7">
												<input type="text" required parsley-type="email" class="form-control"
													   id="inputEmail3" name="size" placeholder="300 куб. м">
											</div>
										</div>

										<div class="form-group row">
											<label for="inputEmail3" class="col-4 col-form-label"> Грузоподъёмность </label>
											<div class="col-7">
												<input type="text" required parsley-type="email" class="form-control"
													   id="inputEmail3" name="weight" placeholder="1500 кг">
											</div>
										</div>

										<div class="form-group row">
											<label for="inputEmail3" class="col-4 col-form-label">К какому гаражу привязать</label>
											<div class="col-7">
												<select  name ='id_garage' class="selectpicker" data-style="btn-custom btn-block">
													<?php 
														foreach ($garage as $key => $value) {
															echo  '<option value="' . $value->id . '"> ' . $value->start_location . '</option>';
														}
													?>
                                                </select>
                                            </div>
										</div>

										<div class="form-group row">
											<label for="inputEmail3" class="col-4 col-form-label">Водитель</label>
											<div class="col-7">
												<select  name ='id_worker' class="selectpicker" data-style="btn-custom btn-block">
													<?php 
														foreach ($workers as $key => $value) {
															echo  '<option value="' . $value->id . '"> ' . $value->name .' '. $value->patronymic .' '. $value->surname .' '. '</option>';
														}
													?>
                                                </select>
                                            </div>
										</div>



										



										<div class="form-group row">
											<div class="col-8 offset-4">
												<button type="submit" name="add" class="btn btn-gradient waves-effect waves-light">
													Добавить
												</button>
												<button type="reset"
														class="btn btn-light waves-effect m-l-5">
													Очистить
												</button>
											</div>
										</div>
									</form>
								</div>

							</div> <!-- end col -->    
						</div>

<!-- Signup modal content -->


						
						<div class="row">

							<?php  
							foreach ($auto as $key => $value) {
								if ($value->status == 'on') {
									$color = "success";
								} else {
									$color = "danger";
								}
							?>

							<div id="signup-modal<?php echo $key ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <form class="form-horizontal" method="POST">
										{{ csrf_field() }}
                                                        <div class="form-group m-b-25">
                                                            <div class="col-12">
                                                                <label for="username">Марка</label>
                                                                <input class="form-control" name="marks" type="text" id="username" required="" value="<?php echo $value->marks?>">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="id" value="<?php echo $value->id ?>">
                                                        <div class="form-group m-b-25">
                                                            <div class="col-12">
                                                                <label for="username">Государственный регистрационный знак</label>
                                                                <input class="form-control" name="number" type="text" id="username" required="" value="<?php echo $value->number?>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group m-b-25">
                                                            <div class="col-12">
                                                                <label for="username">Объём контейнера</label>
                                                                <input class="form-control" name="size" type="text" id="username" required="" value="<?php echo $value->size?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
															<label for="inputEmail3" class="col-4 col-form-label"> Грузоподъёмность </label>
															<div class="col-7">
																<input type="text" required parsley-type="email" class="form-control"
																	   id="inputEmail3" name="weight" placeholder="1500 кг" value="<?php echo $value->weight?>">
															</div>
														</div>

                                                        <div class="form-group row">
															<label for="inputEmail3" class="col-4 col-form-label">К какому гаражу привязать</label>
															<div class="col-7">
																<select  name ='id_garage' class="selectpicker" data-style="btn-custom btn-block">
																	<?php 
																		foreach ($garage as $k => $v) {
																			if (  $value->id_garage == $v->id) {
																				echo  '<option selected value="' . $v->id . '"> ' . $v->start_location . '</option>';
																			} else {
																				echo  '<option  value="' . $v->id . '"> ' . $v->start_location . '</option>';
																			}

																		}
																	?>
                                                				</select>
                                            				</div>
														</div>

														<div class="form-group row">
															<label for="inputEmail3" class="col-4 col-form-label">Водитель</label>
															<div class="col-7">
																<select  name ='id_worker' class="selectpicker" data-style="btn-custom btn-block">
																	<?php 
																		foreach ($workers as $k => $v) {
																			echo  '<option value="' . $v->id . '"> ' . $v->name .' '. $v->patronymic .' '. $v->surname .' '. '</option>';
																		}
																	?>
				                                                </select>
				                                            </div>
														</div>


                                                        <div class="form-group account-btn text-center m-t-10">
                                                            <div class="col-12">
                                                                <button class="btn w-lg btn-rounded btn-primary waves-effect waves-light" name="update" type="submit">Обновить</button>
                                                            </div>
                                                        </div>

                                                    </form>


                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
							<div class="col-md-6 col-lg-3">
                                <div class="card m-b-30">
                                    <div class="card-body">
                                        <h5 class="card-title text-<?php echo $color ?>"><?php echo $value->marks ?></h5>
                                        <p class="card-text"><b>Автомобиль находится в гараже по улице:</b> <?php echo DB::table('garage')
								->where('id', $value->id_garage)->value('start_location') ?> </p>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><b>Номер:</b> <?php echo $value->number;?></li>
                                        <li class="list-group-item"><b>Объём контейнера:</b> <?php echo $value->size;?> </li>
                                        <li class="list-group-item"><b>Грузоподъёмность:</b> <?php echo $value->weight;?> </li>

                                        <?php  
                                        	$id_work = DB::table('auto_worker')->where('id_auto', $value->id)->value('id_worker');
                                        	$res = DB::table('worker')->where('id', '=' ,$id_work)->get();
                                        	if (count($res) > 0) {
                                        		echo '<li class="list-group-item"><b>Водитель:</b>' . $res[0]->name . ' ' . $res[0]->surname . ' '. $res[0]->patronymic. '</li>';
                                        	} else {
                                        		echo '<li class="list-group-item"><b>Водитель:</b> Не привязан</li>';
                                        	}
                                        ?>
                                    </ul>
                                    <div class="card-body">
                                        <a href="ManagerAuto?del=<?php echo $value->id ?>"  class="card-link">Удалить</a>
                                        <a href="#" class="card-link" data-toggle="modal" data-target="#signup-modal<?php echo $key ?>">Изменить</a>
                                    </div>
                                </div>
                            </div>
                            <?php  
                       		 }
                        	?>
						</div>
		</div>
	</div>
</div>
@endsection
