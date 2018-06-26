
		@if (Route::has('login'))
                    @if (!Auth::check())
                    <script>setTimeout(location="/login", 1)</script>
		@else

	
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="assets/images/favicon.ico">
	<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/metismenu.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.css" rel="stylesheet" type="text/css" />
	<!-- Modal css-->
	<link href="assets/plugins/custombox/css/custombox.min.css" rel="stylesheet">
	<!-- Plugins css-->
	<link href="assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" />
	<link href="assets/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />
	<link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="assets/plugins/switchery/switchery.min.css">
    <link rel="stylesheet" href="assets/plugins/morris/knob.css">

	<link rel="stylesheet" type="text/css" href="assets/plugins/jquery.steps/css/jquery.steps.css" />

	<!-- DataTables -->
	<link href="assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<link href="assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<!-- Responsive datatable examples -->
	<link href="assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
	<script src="assets/js/modernizr.min.js"></script>
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

	<!-- Tablesaw css -->
	<link href="assets/plugins/tablesaw/css/tablesaw.css" rel="stylesheet" type="text/css" />
</head>


                     
	<body onload="initialize()">
		<div id="wrapper">
			<div class="topbar">
				<div class="topbar-left">
                </div>
				<nav class="navbar-custom">
					<ul class="list-unstyled topbar-right-menu float-right mb-0">
						<li class="dropdown notification-list">
							<a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <img src="assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle"> {{ Auth::user()->name }} <span class="ml-1"> <i class="mdi mdi-chevron-down"></i> </span>
                            </a>
							<div class="dropdown-menu dropdown-menu-right profile-dropdown ">
								<a href="{{ route('logout') }}" class="dropdown-item notify-item"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fi-head"></i> <span>Выход</span>
                                        </a>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
							</div>
						</li>
					</ul>
					<ul class="list-inline menu-left mb-0">
                        <li class="float-left">
                            <button class="button-menu-mobile open-left waves-light waves-effect">
                                <i class="dripicons-menu"></i>
                            </button>
                        </li>
                        
                    </ul>

				</nav>
			</div>
			<div class="left side-menu">
				<div class="slimscroll-menu" id="remove-scroll">
					<div id="sidebar-menu">
					<ul class="metismenu" id="side-menu">
							<li class="menu-title">Меню</li>
							<li>
								<?php 
								$t100 = 0;
								$all = DB::table('case')->get();
								foreach ($all as $key => $value) {
									$weight = ($value->progress_weight * 100) / $value->weight; 
									$size = ($value->progress_size * 100) / $value->size; 
									$summ = ($weight+$size) / 2;
									if ($summ >= 50 )  {
										$t100++;
									}
								} 
								 ?>
								<a href="home">
									<i class="fi-air-play"></i><span class="badge badge-danger badge-pill pull-right"><?echo $t100; ?></span> <span> Главная </span>
								</a>
							</li>
							
                            <?php
                            $status = Auth::user()->status;

                            switch ($status) {
                            	case 'admin':
                            		#Админское меню
                            	echo '
                            	<li>
                                <a href="javascript: void(0);"><i class="fi-box"></i><span> Администратор </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="ListUser">Список сотрудников</a></li>
                                    <li><a href="adduser">Добавить сотрудника</a></li>
                                    <li><a href="Admin">Модерация пользователей</a></li>

                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);"><i class="fi-box"></i><span> Техник </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="ManagerAuto">Менеджер автомобилей</a></li>
                                    <li><a href="ManagerGarage">Менеджер гаражей</a></li>
                                    <li><a href="AddGarage">Добавить гараж</a></li>
                                    <li><a href="addcase">Добавить контейнер</a></li>
                                </ul>
                                </li>
                                <li>
                                <a href="javascript: void(0);"><i class="fi-box"></i><span> Диспетчер </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="Task">Задания</a></li>
                                    <li><a href="List">Создать маршрут</a></li>
                                    <li><a href="methods">Список баков</a></li>
                                    <li><a href="UpdateList">Пересчитать базу</a></li>

                                </ul>
                           		</li>
                            ';
                            		break;
                            	case 'tech':
                            		#Техник
                            	echo '<li>
                                <a href="javascript: void(0);"><i class="fi-box"></i><span> Техник </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="ManagerAuto">Менеджер автомобилей</a></li>
                                    <li><a href="ManagerGarage">Менеджер гаражей</a></li>
                                    <li><a href="AddGarage">Добавить гараж</a></li>
                                    <li><a href="addcase">Добавить контейнер</a></li>
                                </ul>
                                </li>';
                            		break;

                            	case 'disp':
                            		#Диспетчер
                            	echo '<li>
                                <a href="javascript: void(0);"><i class="fi-box"></i><span> Диспетчер </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="Task">Задания</a></li>
                                    <li><a href="List">Создать маршрут</a></li>
                                    <li><a href="methods">Список баков</a></li>
                                    <li><a href="UpdateList">Пересчитать базу</a></li>

                                </ul>
                           		</li>';
                            		break;
                            	
                            	default:
                            		# code...
                            		break;
                            }

                            ?>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		@yield('content')



		

		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/metisMenu.min.js"></script>
		<script src="assets/js/waves.js"></script>
		<script src="assets/js/jquery.slimscroll.js"></script>
		<script src="assets/plugins/counterup/jquery.counterup.min.js"></script>
		<script src="assets/plugins/chart.js/chart.bundle.js"></script>
		<script src="assets/pages/jquery.dashboard.init.js"></script>

        <script src="assets/plugins/jquery-knob/jquery.knob.js"></script>


		 
		<script src="assets/plugins/tablesaw/js/tablesaw.js"></script>
		<script src="assets/plugins/tablesaw/js/tablesaw-init.js"></script>
		


		<script src="assets/plugins/switchery/switchery.min.js"></script>
		<script src="assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>
		<script src="assets/plugins/select2/js/select2.min.js" type="text/javascript"></script>
		<script src="assets/plugins/bootstrap-select/js/bootstrap-select.js" type="text/javascript"></script>
		<script src="assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
		<script src="assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
		<script src="assets/plugins/bootstrap-maxlength/bootstrap-maxlength.js" type="text/javascript"></script>

		<!-- Init Js file -->
		<script type="text/javascript" src="assets/pages/jquery.form-advanced.init.js"></script>
		<!-- Modal-Effect -->
		<script src="assets/plugins/custombox/js/custombox.min.js"></script>
		<script src="assets/plugins/custombox/js/legacy.min.js"></script>

 		

		

		<!-- Required datatable js -->
		<script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
		<!-- Buttons examples -->
		<script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
		<script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
		<script src="assets/plugins/datatables/jszip.min.js"></script>
		<script src="assets/plugins/datatables/pdfmake.min.js"></script>
		<script src="assets/plugins/datatables/vfs_fonts.js"></script>
		<script src="assets/plugins/datatables/buttons.html5.min.js"></script>
		<script src="assets/plugins/datatables/buttons.print.min.js"></script>
		<!-- Responsive examples -->
		<script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
		<script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

<!--Form Wizard-->
		<script src="assets/plugins/jquery.steps/js/jquery.steps.min.js" type="text/javascript"></script>

		<!--wizard initialization-->
		<script src="assets/pages/jquery.wizard-init.js" type="text/javascript"></script>

		

		<script type="text/javascript">
			$(document).ready(function() {
				$('#datatable').DataTable();

				//Buttons examples
				var table = $('#datatable-buttons').DataTable({
					lengthChange: false,
					buttons: ['copy', 'excel', 'pdf']
				});

				table.buttons().container()
						.appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
			} );

		</script>
		<script src="assets/js/jquery.core.js"></script>
		<script src="assets/js/jquery.app.js"></script>

</body>

                    @endif
                    @endif
</html>
