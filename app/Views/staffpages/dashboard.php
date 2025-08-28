<?= $this->extend('layouth/Staff_layout') ?>
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
									<div class="weight-700 font-24 text-dark" id="layanan"></div>
									<div class="font-14 text-secondary weight-500">
										Tanngungan Pembayaran
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

                <!-- <div class="bg-white pd-20 card-box mb-30">
					<h4 class="h4 text-blue">Area Chart</h4>
					<div id="chart2"></div>
				</div> -->
			</div>


<script>
	$(document).ready(function() {
		$.ajax({
			url: "/api/v1/layanan/countlayanan/users",
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
	});
</script>

<?= $this->endSection() ?> 