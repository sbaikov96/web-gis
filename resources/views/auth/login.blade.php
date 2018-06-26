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
	<script src="assets/js/modernizr.min.js"></script>
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body  class="bg-accpunt-pages">
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div class="wrapper-page">
						<div class="account-pages">
							<div class="account-box">
								<div class="account-logo-box">
									<h6 class="text-uppercase text-center font-bold mt-4">Авторизация</h6>
								</div>
								<div class="account-content">
									<form class="form-horizontal" method="POST" action="{{ route('login') }}">
										{{ csrf_field() }}
										<div class="form-group m-b-20 row">
											<div class="col-12">
												<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
													<label for="email" >E-Mail </label>
													<input id="emailaddress" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
													@if ($errors->has('email'))
														<span class="help-block">
															<strong>{{ $errors->first('email') }}</strong>
														</span>
													@endif
												</div>
											</div>
								 		</div>

										<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
											<label for="password">Пароль</label>
											<div class="form-group row m-b-20">
												<div class="col-12">
													<input id="password" type="password" class="form-control" name="password" required>
													@if ($errors->has('password'))
														<span class="help-block">
															<strong>{{ $errors->first('password') }}</strong>
														</span>
													@endif
												</div>
											</div>
										</div>
										<div class="form-group row m-b-20">
											<div class="col-12">
												<div class="checkbox checkbox-success">
													<input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Запомнить меня
												</div>
											</div>
										</div>
										<div class="form-group row text-center m-t-10">
											<div class="col-12">
												<button class="btn btn-block btn-gradient waves-effect waves-light" type="submit">Войти</button>
												<a class="btn btn-block btn-gradient waves-effect waves-light" href="/"> Главная</a>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	@yield('content')
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/popper.min.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/metisMenu.min.js"></script>
	<script src="assets/js/waves.js"></script>
	<script src="assets/js/jquery.slimscroll.js"></script>
	<script src="../plugins/waypoints/lib/jquery.waypoints.min.js"></script>
	<script src="../plugins/counterup/jquery.counterup.min.js"></script>
	<script src="assets/pages/jquery.dashboard.init.js"></script>
	<script src="assets/js/jquery.core.js"></script>
	<script src="assets/js/jquery.app.js"></script>
</body>
</html>
