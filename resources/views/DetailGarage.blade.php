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
							<li class="breadcrumb-item"><a href="#">Главная</a></li>
						</ol>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title">Список машин в гараже</h4>
                                    <p class="text-muted font-14 m-b-20">
                                        For basic styling—light padding and only horizontal dividers—add the base class <code>.table</code> to any <code>&lt;table&gt;</code>.
                                    </p>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Автомобиль</th>
                                            <th>Номер</th>
                                            <th>Вывез баков</th>
                                            <th>Последний выезд</th>
                                            <th>Статус</th>

                                            <th></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        	<?php 
                                            if (isset($_GET['status'])) {
                                                    $check = DB::table('auto')->where('id', '=' , $_GET['status'])->value('status');
                                                    if ($check == 'off') {
                                                        $status = 'on';
                                                    } else {
                                                        $status = 'off';

                                                    }
                                                    DB::table('auto')
                                                                ->where('id', $_GET['status'])
                                                                ->update(['status' => $status]);
                                                }

												$auto = DB::table('auto')->where('id_garage', '=' , $_GET['id'])->get();

                                        		foreach ($auto as $key => $value) {
                                                    $count = 0 ;
                                        			if ($value->status == 'on') {
														$color = "success";
													} else {
														$color = "danger";
													}
                                                    $auto1 = DB::table('task')->where('id_auto', '=' , $value->id)->get();
                                                    foreach ($auto1 as $k => $v) {
                                                        $task = DB::table('TaskDetail')->where([['id_task', '=' , $v->id], ['status', 'completed']])->count();
                                                        $count = $task + $count;
                                                    }
                                        			echo "<tr class='table-".$color."'>";
                                        			echo "<th scope='row'>".$key ."</th>";
                                        			echo "<td>" .$value->marks . "</td>";
                                        			echo "<td>" .$value->number . "</td>";
                                                    echo "<td>".$count."</td>";
                                        			echo "<td>29.05.2018</td>";
                                                    if ($value->status == 'wait') {
                                                        echo "<td>На выезде</td>";
                                                    } elseif ($value->status == 'off') {
                                                        echo "<td>На ремонте</td>";
                                                    }elseif ($value->status == 'on') {
                                                        echo "<td>Готов</td>";
                                                    }

                                        			if ($value->status == 'on') {
                                        				echo "<td><a href='DetailGarage?id=".$value->id_garage."&status=".$value->id."'>Отправить на ремонт </a></td>";
                                        			} elseif ($value->status =='off') {
                                        				echo "<td><a href='DetailGarage?id=".$value->id_garage."&status=".$value->id."'>Снять с ремонта </a></td>";
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
	
	

@endsection
