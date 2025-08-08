<?= $this->extend('layouth/admin_layout') ?>
<?= $this->section('content') ?>

			<div class="xs-pd-20-10 pd-ltr-20">
				<div class="title pb-20">
					<h2 class="h3 mb-0">Dashboard Overview</h2>
				</div>

				<div class="row pb-10">
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark" id="user"></div>
									<div class="font-14 text-secondary weight-500">
										Pengguna
									</div>
								</div>
								<div class="widget-icon">
									<div class="icon" data-color="#00eccf">
										<i class="bi bi-person-fill"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark" id="layanan"></div>
									<div class="font-14 text-secondary weight-500">
										Penyedia Jasa
									</div>
								</div>
								<div class="widget-icon">
									<div class="icon" data-color="#ff5b5b">
										<i class="bi bi-briefcase-fill"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark" id="lokasi">+</div>
									<div class="font-14 text-secondary weight-500">
										Lokasi
									</div>
								</div>
								<div class="widget-icon">
									<div class="icon">
										<i class="bi bi-geo-alt-fill"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
						<div class="card-box height-100-p widget-style3">
							<div class="d-flex flex-wrap">
								<div class="widget-data">
									<div class="weight-700 font-24 text-dark" id="log"></div>
									<div class="font-14 text-secondary weight-500">Log</div>
								</div>
								<div class="widget-icon">
									<div class="icon" data-color="#09cc06">
										<i class="bi bi-chat-fill"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

                <!-- <div class="bg-white pd-20 card-box mb-30">
					<h4 class="h4 text-blue">Area Chart</h4>
					<div id="chart2"></div>
				</div> -->
			</div>


<script>
	$(document).ready(function() {
		$.ajax({
			url: "/api/v1/users/countuser",
			method: "GET",
			dataType: "json",
			success: function(response) {	
				const data = response.data;
				$('#user').text(data);
			},
			error: function(xhr) {
				console.error("Error fetching dashboard data:", xhr);
			}
		});
		$.ajax({
			url: "/api/v1/layanan/countlayanan",
			method: "GET",
			dataType: "json",
			success: function(response) {	
				const data = response.data;
				$('#layanan').text(data);
			},
			error: function(xhr) {
				console.error("Error fetching dashboard data:", xhr);
			}
		});
		$.ajax({
			url: "/api/v1/log/countlog",
			method: "GET",
			dataType: "json",
			success: function(response) {	
				const data = response.data;
				$('#log').text(data);
			},
			error: function(xhr) {
				console.error("Error fetching dashboard data:", xhr);
			}
		});
		$.ajax({
			url: "/api/v1/lokasi/countlokasi",
			method: "GET",
			dataType: "json",
			success: function(response) {	
				const data = response.data;
				$('#lokasi').text(data);
			},
			error: function(xhr) {
				console.error("Error fetching dashboard data:", xhr);
			}
		});
	});
</script>

<?= $this->endSection() ?> 