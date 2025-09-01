
<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>

		<!-- Site favicon -->
		<link
			rel="apple-touch-icon"
			sizes="180x180"
			href="/assets/deskapp/vendors/images/apple-touch-icon.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="32x32"
			href="/assets/deskapp/vendors/images/favicon-32x32.png"
		/>
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="/assets/deskapp/vendors/images/favicon-16x16.png"
		/>

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

		<!-- Google Font -->
		<link
			href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
			rel="stylesheet"
		/>
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="/assets/deskapp/vendors/styles/core.css" />
		<link
			rel="stylesheet"
			type="text/css"
			href="/assets/deskapp/vendors/styles/icon-font.min.css"
		/>
		<link rel="stylesheet" type="text/css" href="/assets/deskapp/vendors/styles/style.css" />
		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	</head>
	<body class="login-page">
		<div
			class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
		>
			<div class="container">
				<div class="row align-items-center">
					<div class="col-md-6 col-lg-7 d-none d-md-block">
						<img src="/template/images/jarikita.jpg" width=400" alt="" />
					</div>
					<div class="col-md-6 col-lg-5">
						<div class="login-box bg-white box-shadow border-radius-10">
							<div class="login-title">
								<h2 class="text-center text-primary">Login</h2>
							</div>
							<form id="form-login">
								<div class="input-group custom">
									<input
										type="email"
										class="form-control form-control-lg"
										placeholder="Email"
										name="email"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-user1"></i
										></span>
									</div>
								</div>
								<div class="input-group custom">
									<input
										type="password"
										class="form-control form-control-lg"
										placeholder="**********"
										name="password"
										id="passwordInput"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text" id="togglePassword" style="cursor:pointer;">
											<i class="dw dw-padlock1"></i>
										</span>
									</div>
								</div>
								<div class="row pb-30">
									<div class="col-6">
										<div class="custom-control custom-checkbox">
											<input
												type="checkbox"
												class="custom-control-input"
												id="customCheck1"
											/>
											<label class="custom-control-label" for="customCheck1"
												>Remember</label
											>
										</div>
									</div>
									<div class="col-6">
										<div class="forgot-password">
											<a href="forgot-password.html">Forgot Password</a>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="input-group mb-0">
											<!--
											use code for form submit
											<input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
										-->
											<button
												class="btn btn-primary btn-lg btn-block"
												type="submit"
												>Sign In</button
											>
										</div>
										<div
											class="font-16 weight-600 pt-10 pb-10 text-center"
											data-color="#707373"
										>
											OR
										</div>
										<div class="input-group mb-0">
											<a
												class="btn btn-outline-primary btn-lg btn-block"
												href="/auth/register"
												>Register To Create Account</a
											>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script>
			$(document).ready(function() {
				$('#form-login').on('submit', function (e) {
					e.preventDefault();
					const form = this;
					const formData = {
						 email: $(form).find('input[name="email"]').val(),
						 password: $(form).find('input[name="password"]').val(),
					}
					
					console.log(formData);

					$.ajax({
						url: '/api/v1/auth/login',
						type: 'POST',
						data: JSON.stringify(formData),
						contentType: false,
						processData: false,
						contentType: 'application/json',
						success: function(response) {
							message = response.data.message || 'Login successful';
							alert(message);
							role = response.role;
							if( role === 'admin') {
								window.location.href = '/admin/dashboard';
							} else if (role === 'seller') {
								window.location.href = '/users/dashboard';
							} else if (role === 'staff') {
								window.location.href = '/staff/dashboard';
							} else {
								window.location.href = '/';
							}
							
						},
						error: function(xhr, status, error) {
							try {
								const response = JSON.parse(xhr.responseText);
								alert("email atau password salah");
							} catch (e) {
								alert('An error occurred while logging in.');
							}
						}
					});
				});
					
				$.ajax({
					url: '/api/v1/auth/login',
					type: 'POST',
					success: function(response) {
						console.log('Login status checked successfully:', response);
					},
					error: function(xhr, status, error) {
						console.error('Error checking login status:', error);
					}
				})
			});
		</script>

		<script>
    const passwordInput = document.getElementById('passwordInput');
    const togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // opsional: ganti icon
        togglePassword.innerHTML = type === 'password'
            ? '<i class="dw dw-padlock1"></i>'
            : '<i class="dw dw-eye1"></i>';
    });
</script>

		<!-- js -->
		<script src="/assets/deskapp/vendors/scripts/core.js"></script>
		<script src="/assets/deskapp/vendors/scripts/script.min.js"></script>
		<script src="/assets/deskapp/vendors/scripts/process.js"></script>
		<script src="/assets/deskapp/vendors/scripts/layout-settings.js"></script>
	</body>
</html>
