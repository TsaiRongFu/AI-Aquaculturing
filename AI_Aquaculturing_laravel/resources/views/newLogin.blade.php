<!DOCTYPE html>
<html lang="zh-TW">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="description" content="" />
		<meta name="author" content="" />
		<title>AI Aquaculturing</title>
		<link rel="icon" href="https://www.flaticon.com/svg/static/icons/svg/1057/1057285.svg" type="image/ico">
		<link rel="stylesheet" href="{{ asset('/customAuth/style.css')}}">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
		<style>
			.custom {
				/* background-image: url("https://i.imgur.com/mcCqSub.gif"); */
				background-image: url({{ asset('image/Bubble.GIF') }});
				background-size: cover;
				background-color: rgba(0, 0, 0, .1);
				background-blend-mode: multiply;
			}
		</style>
	</head>
	<body class="custom">
		<div id="layoutAuthentication">
			<div id="layoutAuthentication_content">
				<main>
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-lg-5">
								<div class="card shadow-lg border-0 rounded-lg mt-5">
									<div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
									<div class="card-body">
										<form method="POST" class="user" action="{{ route('login') }}">
											@csrf
											<div class="form-group">
												<label class="small mb-1" for="inputEmailAddress">Email</label>
												<input id="email" type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter email address" />
												@error('email')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
											<div class="form-group">
												<label class="small mb-1" for="inputPassword">Password</label>
												<input id="password" type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter password" />
												@error('password')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror
											</div>
											<div class="form-group">
												<div class="custom-control custom-checkbox">
													<input class="form-check-input custom-control-input custom-control-user" id="rememberPasswordCheck" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}/>
													<label class="custom-control-label" for="rememberPasswordCheck">Remember Me</label>
												</div>
											</div>
											<div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
												<button type="submit" class="btn btn-primary btn-user btn-block">
													{{ __('Login') }}
												</button>
											</div>
										</form>
									</div>
									<div class="card-footer text-center">
										<div class="small">
											<!-- <a href="register">Need an account? Sign up!</a><br> -->
											<a href="/">Back to homepage!</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</main>
			</div>

			<div id="layoutAuthentication_footer">
				<footer class="py-4 bg-light mt-auto">
					<div class="container-fluid">
						<div class="align-items-center justify-content-between small">
							<div class="text-muted" style="text-align: center;">Copyright© AI Aquaculturing 2020</div>
						</div>
					</div>
				</footer>
			</div>
		</div>

		<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
		<script src="js/scripts.js"></script>
	</body>
</html>