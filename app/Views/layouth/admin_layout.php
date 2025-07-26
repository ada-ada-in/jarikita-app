
<!DOCTYPE html>
<html>
	<?= view('components/include/head') ?>
	<body>
    <!-- header -->
    <?= view('components/include/header') ?>

    <!-- sidebar -->
     <?= view('components/include/sidebar') ?>

		<!-- left-sidebar -->
     <?= view('components/include/leftSidebar') ?>
		<div class="mobile-menu-overlay"></div>

    <!-- main -->
		<div class="main-container">
			<div class="pd-ltr-20 xs-pd-20-10">
				<div class="min-height-200px">  
					<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
          <?= $this->rendersection('content') ?>
          </div>
				</div>
			</div>
		</div>
    		
    
  <?= view('components/include/footer') ?>

  <?= $this->rendersection('script') ?>
	</body>
</html>
