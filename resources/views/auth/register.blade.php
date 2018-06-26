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
	<body class="bg-accpunt-pages">
		<section>
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<div class="wrapper-page">
							<div class="account-pages">
								<div class="account-box">
									<div class="account-logo-box">
										<h6 class="text-uppercase text-center font-bold mt-4">Регистрация</h6>
									</div>
									<div class="account-content">
										 <form class="form-horizontal" method="POST" action="{{ route('register') }}">
										 {{ csrf_field() }}

											<div class="form-group row m-b-20{{ $errors->has('name') ? ' has-error' : '' }}">

												<div class="col-12">
													<label for="username">Ваше имя</label>
													<input class="form-control" type="text" name="name" id="username" value="{{ old('name') }}" required autofocus>
													@if ($errors->has('name'))
																		<span class="help-block">
																				<strong>{{ $errors->first('name') }}</strong>
																		</span>
																@endif
												</div>
											</div>

											<div class="form-group row m-b-20{{ $errors->has('email') ? ' has-error' : '' }}">
												<div class="col-12">
													<label for="emailaddress">Email </label>
													<input class="form-control" name="email" type="email" id="emailaddress" value="{{ old('email') }}" required>
													@if ($errors->has('email'))
																		<span class="help-block">
																				<strong>{{ $errors->first('email') }}</strong>
																		</span>
																@endif
												</div>
											</div>

											<div class="form-group row m-b-20{{ $errors->has('password') ? ' has-error' : '' }}">
												<div class="col-12">
													<label for="password">Пароль</label>
													<input class="form-control" type="password" required id="password" name="password">
													@if ($errors->has('password'))
																		<span class="help-block">
																				<strong>{{ $errors->first('password') }}</strong>
																		</span>
																@endif
												</div>
											</div>

											<div class="form-group row m-b-20{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
												<div class="col-md-12">
													<label>Повторите пароль</label>
													<input id="password" type="password" class="form-control" name="password_confirmation" required>
													@if ($errors->has('password_confirmation'))
														<span class="help-block">
															<strong>{{ $errors->first('password_confirmation') }}</strong>
														</span>
													@endif
												</div>
											</div>


											<div class="form-group row text-center m-t-10">
												<div class="col-12">
													<button class="btn btn-block btn-gradient waves-effect waves-light" type="submit">Регистрация</button>
												</div>
											</div>

										</form>

										<div class="row m-t-50">
											<div class="col-sm-12 text-center">
												<p class="text-muted">У Вас уже есть аккаунт?  <a href="/login" class="text-dark m-l-5"><b>Войти</b></a></p>
											</div>
										</div>

									</div>
								</div>
							</div>
							<!-- end card-box-->


						</div>
						<!-- end wrapper -->

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
	<script src="assets/plugins/waypoints/lib/jquery.waypoints.min.js"></script>
	<script src="assets/plugins/counterup/jquery.counterup.min.js"></script>
	<script src="assets/pages/jquery.dashboard.init.js"></script>
	<script src="assets/js/jquery.core.js"></script>
	<script src="assets/js/jquery.app.js"></script>
</body>
</html>

