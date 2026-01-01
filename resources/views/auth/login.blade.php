<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="description" content="BGM Traders - Professional Trading Platform">
	<meta name="author" content="BGM Trader">
	<meta name="keywords" content="BGM Trader">

	<title>Login - BGM Traders</title>

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
	<!-- End fonts -->

	<!-- core:css -->
	<link rel="stylesheet" href="{{asset('/assets/vendors/core/core.css')}}">
	<!-- endinject -->

	<!-- inject:css -->
	<link rel="stylesheet" href="{{asset('assets/fonts/feather-font/css/iconfont.css')}}">
	<link rel="stylesheet" href="{{asset('assets/vendors/flag-icon-css/css/flag-icon.min.css')}}">
	<!-- endinject -->

	<!-- Layout styles -->
	<link rel="stylesheet" href="{{asset('assets/css/demo1/style.css')}}">
	<!-- End layout styles -->
	
	<link rel="shortcut icon" href="{{asset('web/images/logo/GMtraders.svg')}}" />
	
	<style>
		:root {
			--primary-color: #10b981;
			--primary-dark: #059669;
			--primary-light: #34d399;
			--success-color: #10b981;
			--error-color: #ef4444;
			--text-primary: #1f2937;
			--text-secondary: #6b7280;
			--border-color: #e5e7eb;
			--bg-light: #f9fafb;
		}

		* {
			box-sizing: border-box;
		}

		body {
			font-family: 'Inter', 'Roboto', sans-serif;
			background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
			min-height: 100vh;
			position: relative;
			overflow-x: hidden;
		}

		body::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: 
				radial-gradient(circle at 20% 30%, rgba(52, 211, 153, 0.4) 0%, transparent 50%),
				radial-gradient(circle at 80% 70%, rgba(5, 150, 105, 0.4) 0%, transparent 50%),
				radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.3) 0%, transparent 60%);
			z-index: 0;
			animation: backgroundShift 15s ease-in-out infinite;
		}

		@keyframes backgroundShift {
			0%, 100% {
				opacity: 1;
				transform: scale(1);
			}
			50% {
				opacity: 0.8;
				transform: scale(1.1);
			}
		}

		body::after {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-image: 
				radial-gradient(circle at 2px 2px, rgba(255, 255, 255, 0.15) 1px, transparent 0);
			background-size: 40px 40px;
			z-index: 0;
			animation: patternMove 20s linear infinite;
		}

		@keyframes patternMove {
			0% {
				transform: translate(0, 0);
			}
			100% {
				transform: translate(40px, 40px);
			}
		}

		.main-wrapper {
			position: relative;
			z-index: 1;
		}

		.auth-page {
			padding: 2rem 1rem;
		}

		.auth-card {
			background: #ffffff;
			border-radius: 32px;
			box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
			overflow: hidden;
			transition: transform 0.3s ease, box-shadow 0.3s ease;
			backdrop-filter: blur(10px);
			border: 1px solid rgba(255, 255, 255, 0.2);
		}

		.auth-card:hover {
			transform: translateY(-8px);
			box-shadow: 0 30px 90px rgba(0, 0, 0, 0.25);
		}

		.auth-form-wrapper {
			padding: 3.5rem 3rem;
			text-align: center;
		}

		.auth-logo-container {
			margin-bottom: 2.5rem;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.auth-logo-container img {
			max-width: 200px;
			width: 100%;
			height: auto;
			filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.1));
			transition: transform 0.3s ease;
		}

		.auth-logo-container img:hover {
			transform: scale(1.05);
		}

		.auth-welcome {
			color: var(--text-secondary);
			font-size: 1.1rem;
			margin-bottom: 2.5rem;
			font-weight: 400;
		}

		.form-control {
			border: 2px solid var(--border-color);
			border-radius: 14px;
			padding: 1rem 1rem 1rem 3rem;
			font-size: 1rem;
			transition: all 0.3s ease;
			background-color: #fff;
			width: 100%;
		}

		.form-control:focus {
			border-color: var(--primary-color);
			box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
			outline: none;
		}

		.form-control::placeholder {
			color: #9ca3af;
		}

		.input-group {
			position: relative;
		}

		.input-icon {
			position: absolute;
			left: 1.25rem;
			top: 50%;
			transform: translateY(-50%);
			color: var(--text-secondary);
			z-index: 10;
			pointer-events: none;
			transition: all 0.3s ease;
		}

		.error-message {
			color: var(--error-color);
			font-size: 0.85rem;
			margin-top: 0.5rem;
			display: flex;
			align-items: center;
			gap: 0.5rem;
			animation: slideDown 0.3s ease;
		}

		@keyframes slideDown {
			from {
				opacity: 0;
				transform: translateY(-10px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.form-check-input {
			width: 1.25rem;
			height: 1.25rem;
			border-radius: 6px;
			border: 2px solid var(--border-color);
			cursor: pointer;
			transition: all 0.3s ease;
		}

		.form-check-input:checked {
			background-color: var(--primary-color);
			border-color: var(--primary-color);
		}

		.form-check-input:focus {
			border-color: var(--primary-color);
			box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
		}

		.form-check-label {
			color: var(--text-secondary);
			font-size: 0.9rem;
			cursor: pointer;
			margin-left: 0.5rem;
		}

		.btn-login {
			background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
			border: none;
			border-radius: 14px;
			padding: 1rem 2rem;
			font-weight: 600;
			font-size: 1.05rem;
			color: white;
			width: 100%;
			transition: all 0.3s ease;
			box-shadow: 0 4px 20px rgba(16, 185, 129, 0.4);
			position: relative;
			overflow: hidden;
		}

		.btn-login::before {
			content: '';
			position: absolute;
			top: 0;
			left: -100%;
			width: 100%;
			height: 100%;
			background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
			transition: left 0.5s ease;
		}

		.btn-login:hover::before {
			left: 100%;
		}

		.btn-login:hover {
			transform: translateY(-2px);
			box-shadow: 0 8px 25px rgba(16, 185, 129, 0.5);
		}

		.btn-login:active {
			transform: translateY(0);
		}

		.forgot-password-link {
			color: var(--primary-color);
			text-decoration: none;
			font-size: 0.9rem;
			font-weight: 500;
			transition: color 0.3s ease;
			display: inline-block;
			margin-top: 1rem;
		}

		.forgot-password-link:hover {
			color: var(--primary-dark);
			text-decoration: underline;
		}

		.divider {
			display: flex;
			align-items: center;
			text-align: center;
			margin: 1.5rem 0;
			color: var(--text-secondary);
			font-size: 0.85rem;
		}

		.divider::before,
		.divider::after {
			content: '';
			flex: 1;
			border-bottom: 1px solid var(--border-color);
		}

		.divider::before {
			margin-right: 0.5rem;
		}

		.divider::after {
			margin-left: 0.5rem;
		}

		@media (max-width: 768px) {
			.auth-form-wrapper {
				padding: 2.5rem 2rem;
			}

			.auth-card {
				border-radius: 24px;
			}

			.auth-logo-container img {
				max-width: 160px;
			}
		}

		@media (max-width: 576px) {
			.auth-form-wrapper {
				padding: 2rem 1.5rem;
			}

			.auth-logo-container img {
				max-width: 140px;
			}

			.auth-welcome {
				font-size: 1rem;
			}
		}
	</style>
</head>
<body>
	<div class="main-wrapper">
		<div class="page-wrapper full-page">
			<div class="page-content d-flex align-items-center justify-content-center">
				<div class="row w-100 mx-0 auth-page">
					<div class="col-md-8 col-lg-6 col-xl-5 mx-auto">
						<div class="card auth-card border-0">
							<div class="auth-form-wrapper">
								<div class="auth-logo-container">
									<img src="{{asset('web/images/logo/GMtraders.svg')}}" alt="BGM Traders Logo" onerror="this.src='{{asset('web/images/logo/green.svg')}}'">
								</div>
								<h5 class="auth-welcome">Welcome back! Please login to your account.</h5>
								
								<form class="forms-sample" action="{{route('store')}}" method="POST">
									@csrf
									
									<div class="mb-4">
										<div class="input-group position-relative">
											<i class="input-icon" data-feather="mail"></i>
											<input 
												type="email" 
												class="form-control @error('email') is-invalid @enderror" 
												id="userEmail"
												name="email" 
												placeholder="Email address"
												value="{{ old('email') }}"
												required
												autocomplete="email"
												autofocus
											>
										</div>
										@error('email')
											<div class="error-message text-start mt-2">
												<i data-feather="alert-circle" style="width: 16px; height: 16px;"></i>
												<span>{{ $message }}</span>
											</div>
										@enderror
									</div>
									
									<div class="mb-4">
										<div class="input-group position-relative">
											<i class="input-icon" data-feather="lock"></i>
											<input 
												type="password" 
												class="form-control @error('password') is-invalid @enderror" 
												id="userPassword"
												name="password"  
												autocomplete="current-password" 
												placeholder="Password"
												required
											>
										</div>
										@error('password')
											<div class="error-message text-start mt-2">
												<i data-feather="alert-circle" style="width: 16px; height: 16px;"></i>
												<span>{{ $message }}</span>
											</div>
										@enderror
									</div>
									
									<div class="d-flex justify-content-between align-items-center mb-4">
										<div class="form-check">
											<input type="checkbox" class="form-check-input" id="authCheck" name="remember">
											<label class="form-check-label" for="authCheck">
												Remember me
											</label>
										</div>
										@if(Route::has('password.request'))
											<a href="{{ route('password.request') }}" class="forgot-password-link">
												Forgot Password?
											</a>
										@endif
									</div>
									
									<div class="mb-3">
										<button type="submit" class="btn btn-login" onclick="this.disabled=true; this.form.submit();">
											Sign In
										</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- core:js -->
	<script src="{{asset('assets/vendors/core/core.js')}}"></script>
	<!-- endinject -->

	<!-- inject:js -->
	<script src="{{asset('assets/vendors/feather-icons/feather.min.js')}}"></script>
	<script src="{{asset('/assets/js/template.js')}}"></script>
	<!-- endinject -->

	<script>
		// Initialize feather icons
		if (typeof feather !== 'undefined') {
			feather.replace();
		}

		// Add smooth focus animations
		document.querySelectorAll('.form-control').forEach(input => {
			input.addEventListener('focus', function() {
				const icon = this.parentElement.querySelector('.input-icon');
				if (icon) {
					icon.style.setProperty('color', 'var(--primary-color)');
					icon.style.setProperty('transform', 'translateY(-50%) scale(1.1)');
				}
			});
			
			input.addEventListener('blur', function() {
				const icon = this.parentElement.querySelector('.input-icon');
				if (icon) {
					icon.style.setProperty('color', 'var(--text-secondary)');
					icon.style.setProperty('transform', 'translateY(-50%) scale(1)');
				}
			});
		});
	</script>

</body>
</html>
