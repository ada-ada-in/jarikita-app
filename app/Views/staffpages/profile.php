<?= $this->extend('layouth/staff_layout') ?>
<?= $this->section('content') ?>

			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">
					<div class="page-header">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="title">
									<h4>Profile</h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="<?= url_to('admin') ?>">Dashboard</a>
										</li>
										<li class="breadcrumb-item active" aria-current="page">
											Profile
										</li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
							<div class="card-box height-100-p overflow-hidden">
								<div class="profile-tab height-100-p">
									<div class="tab height-100-p">
												<div class="profile-setting">
													<form id="form-edit-profile">
														<ul class="profile-edit-list row">
															<li class="weight-500 col-md-12">
																<h4 class="text-blue h5 mb-20">
																	Edit Your Personal Setting
																</h4>
																<div class="form-group">
																	<label>Nama Lengkap</label>
																	<input
																		class="form-control form-control-lg"
																		type="text"
																		name="username"
																		id="username"
																	/>
																</div>
																<div class="form-group">
																	<label>Email</label>
																	<input
																		class="form-control form-control-lg"
																		type="email"
																		name="email"
																		id="email"
																	/>
																</div>
																<div class="form-group">
																	<label>Nomor Handphone</label>
																	<input
																		class="form-control form-control-lg"
																		type="number"
																		name="no_handphone"
																		id="no_handphone"
																	/>
																</div>
																<div class="form-group">
																	<label>Role</label>
																	<select
																		class="selectpicker form-control form-control-lg"
																		data-style="btn-outline-secondary btn-lg"
																		title="Pilih Role"
																		name="role"
																		id="role"
																	>
																		<option value="admin">Admin</option>
																		<option value="user">Users</option>
																		<option value="buyer">Penyedia Jasa</option>
																	</select>
																</div>
																<div class="form-group">
																	<label>Alamat</label>
																	<input
																		class="form-control form-control-lg"
																		type="text"
																		name="alamat"
																		id="alamat"
																	/>
																</div>
																<div class="form-group">
																	<label>Gambar Profile</label>
																	<input type="file" accept="image/*" class="form-control" name="image" placeholder="Photo">
																</div>
																<div class="form-group">
																	<label>Password</label>
																	<input
																		class="form-control form-control-lg"
																		type="password"
																		name="password"
																		id="password"
																	/>
																</div>
																<div class="form-group">
																	<label>Konfirmasi Password</label>
																	<input
																		class="form-control form-control-lg"
																		type="password"
																		name="confirm_password"
																		id="confirm_password"
																	/>
																</div>
																<div class="form-group">
																	<button
																		class="btn btn-primary btn-lg"
																		type="submit"
																		id="btn-submit"
																	>
																		Simpan
																	</button>
															</li>
														</ul>
													</form>
												</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<script>
	$(document).ready(function() {

			$.ajax({
				url: "/api/v1/users/profile",
				type: "GET",
				dataType: "json",
				success: function(response) {
					const data = response.data[0];
					$('#username').val(data.username);
					$('#email').val(data.email);
					$('#no_handphone').val(data.no_handphone);
					$('#role').val(data.role).change();
					$('#alamat').val(data.alamat);
				},
				error: function(xhr) {
					console.error("Error fetching user data:", xhr);
				}
			});

		$('#form-edit-profile').on('submit',function(e) {
			e.preventDefault();
			const form = $(this);
			const formData = new FormData(form[0]);
			const id = <?= session()->get('id') ?>;

			$.ajax({
				url: `/api/v1/users/${id}`,
				type: "POST",
				dataType: "json",
				data: formData,
				processData: false,
				contentType: false,
				success: function(response) {
					alert(response.message);
					window.location.href = '/admin/profile';
				},
				error: function(xhr) {
					console.error("Error updating user data:", xhr);
				}
			});
		});
	});	
</script>

<?= $this->endSection() ?>