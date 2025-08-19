
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
						<img src="/template/images/jarikita.jpg" width="400" alt="" />
					</div>
					<div class="col-md-6 col-lg-5">
						<div class="login-box bg-white box-shadow border-radius-10">
							<div class="login-title">
								<h2 class="text-center text-primary">Register</h2>
							</div>
							<form id="form-register">
								<div class="input-group custom">
									<input
										type="text"
										class="form-control form-control-lg"
										placeholder="Nama Lengkap"
										name="username"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-user1"></i
										></span>
									</div>
								</div>
                                <div class="input-group custom">
									<input
										type="email"
										class="form-control form-control-lg"
										placeholder="Email"
										name="email"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-email1"></i
										></span>
									</div>
								</div>
                                <div class="input-group custom">
									<input
										type="number"
										class="form-control form-control-lg"
										placeholder="Nomor Handphone"
										name="no_handphone"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-user1"></i
										></span>
									</div>
								</div>
                                <div class="input-group custom">
									<input
										type="text"
										class="form-control form-control-lg"
										placeholder="Alamat"
										name="alamat"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="icon-copy dw dw-user1"></i
										></span>
									</div>
								</div>
                                <div class="input-group custom">
									<input type="file" accept="image/*" class="form-control" name="image" placeholder="Photo" required>
								</div>
                                <div class="input-group custom">
									<select name="role" id="" class="form-control form-control-lg">
										<option value="" selected disabled>Pilih Role</option>
										<option value="user">Pengguna</option>
										<option value="seller">Penawar Jasa</option>
									</select>
								</div>
								<div class="input-group custom">
									<input
										type="password"
										class="form-control form-control-lg"
										placeholder="Password"
										name="password"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="dw dw-padlock1"></i
										></span>
									</div>
								</div>
                                <div class="input-group custom">
									<input
										type="password"
										class="form-control form-control-lg"
										name="confirm_password"
										placeholder="Konfirmasi Password"
									/>
									<div class="input-group-append custom">
										<span class="input-group-text"
											><i class="dw dw-padlock1"></i
										></span>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="input-group mb-0">
											<button
												class="btn btn-primary btn-lg btn-block"
												type="submit"
												>Create Account</button
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
												href="/auth/login"
												>Login</a
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
			
		$('#form-register').on('submit', function (e) {
			e.preventDefault();
			const form = this;
			const formData = new FormData(form);

			$.ajax({
				url: '/api/v1/auth/register',
				type: 'POST',
				data: formData,
				processData: false,
				contentType: false, 
				success: function (response) {
					console.log(response.data);
					alert(response.message);
					window.location.href = '/auth/login';
				},
				error: function (xhr, status, error) {
					try {
        				const isJSON = xhr.getResponseHeader("Content-Type")?.includes("application/json");
						 if (xhr.responseText && isJSON) {
							const response = JSON.parse(xhr.responseText);
							let errorMessage = '';

							if (response.messages) {
								for (const key in response.messages) {
									errorMessage += `${response.messages[key]}\n`;
								}
							} else if (response.message) {
								errorMessage = response.message;
							} else {
								errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
							}

							alert(errorMessage);
						} else {
							console.error("Bukan JSON:", xhr.responseText);
							alert('Respons dari server bukan format JSON.');
						}
					} catch (e) {
						console.error('Gagal parse response error:', e);
						alert('Terjadi kesalahan saat memproses respons error.');
					}
				}
				})
			});
		});
</script>

		<!-- js -->
		<script src="/assets/deskapp/vendors/scripts/core.js"></script>
		<script src="/assets/deskapp/vendors/scripts/script.min.js"></script>
		<script src="/assets/deskapp/vendors/scripts/process.js"></script>
		<script src="/assets/deskapp/vendors/scripts/layout-settings.js"></script>
	</body>
</html>
