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
							<a href="<?= url_to('admin') ?>" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-house"></span
								><span class="mtext">Dashboard</span>
							</a>
						</li>
						<li class="dropdown">
							<a href="<?= url_to('lokasi') ?>" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-geo-alt-fill"></span
								><span class="mtext">Lokasi</span>
							</a>
						</li>
						<li class="dropdown">
							<a href="<?= url_to('log') ?>" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-chat-dots"></span
								><span class="mtext">Log Info</span>
							</a>
						</li>
						<li class="dropdown">
							<a href="<?= url_to('jasa') ?>" class="dropdown-toggle no-arrow">
								<span class="micon bi bi-archive"></span
								><span class="mtext">Penyedia Jasa</span>
							</a>
						</li>
						<li class="dropdown">
							<a href="<?= url_to('pengguna') ?>" class="dropdown-toggle no-arrow">
								<span class="micon dw dw-user1"></span
								><span class="mtext">Pengguna</span>
							</a>
						</li>

					</ul>
				</div>
			</div>
		</div>