		<div class="header">
			<div class="header-left">
				<div class="menu-icon bi bi-list"></div>
				<!-- <div
					class="search-toggle-icon bi bi-search"
					data-toggle="header_search"
				></div> -->
			</div>
			<div class="header-right">
				<div class="dashboard-setting user-notification">
					<div class="dropdown">
						<a
							class="dropdown-toggle no-arrow"
							href="javascript:;"
							data-toggle="right-sidebar"
						>
							<i class="dw dw-settings2"></i>
						</a>
					</div>
				</div>
				<div class="user-info-dropdown">
					<div class="dropdown">
						<a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
							<span class="user-icon mr-2">
								<img style="width: 50; height: 50px; object-fit: cover;" src="" alt="gambar" id="gambar" />
							</span>
							<span id="user-name"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
							<a class="dropdown-item" href="<?= url_to('profileSeller') ?>">
								<span class="user-icon">
									<i class="dw dw-user1"></i>
								</span> Profile
							</a>
							<a class="dropdown-item" onclick="logout()">
								<i class="dw dw-logout"></i> Log Out
							</a>
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
			console.log("data profile", data);
            $('#user-name').text(data.username)
            $('#gambar').attr('src', '/' + data.avatar_url)
        },
        error: function(xhr) {
            console.error("Error fetching user data:", xhr);
        }
    });
});
function logout() {
    $.ajax({
      url: '/api/v1/auth/logout',
      type: 'POST',
      dataType: 'json',
      success: function(response) {
        alert(response.message);
        window.location.href = '/';
      },
      error: function() {
        alert('An error occurred while logging out. Please try again.');
      }
    });
  }
</script>
