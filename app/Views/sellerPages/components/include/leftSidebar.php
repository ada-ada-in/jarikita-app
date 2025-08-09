		<div class="left-side-bar">
			<div class="brand-logo d-flex flex-column align-items-center justify-content-center text-center py-3">
			<a href="<?= url_to('admin') ?>">
				<img src="/template/images/logo-jari-kita.png" width="60px" alt="Logo" class="dark-logo mb-1 py-3" />
				<img src="/template/images/logo-jari-kita.png" width="60px" alt="Logo Light" class="light-logo py-3" />
			</a>

			<div class="close-sidebar mt-2" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
			</div>
			<div class="menu-block customscroll">
				<div class="sidebar-menu">
					<ul id="accordion-menu">
					<li class="dropdown">
							<a href="<?= url_to('dashboardSeller') ?>" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-house"></span
								><span class="mtext">Dashboard</span>
							</a>
						</li>
						<li class="dropdown">
							<a href="<?= url_to('jasaSeller') ?>" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-archive"></span
								><span class="mtext">Jasa</span>
							</a>
						</li>	
					</ul>
				</div>
			</div>
		</div>