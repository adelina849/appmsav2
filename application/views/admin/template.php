<?php $this->load->view('layouts/header'); ?>

<body>
	<div id="page-wrapper">
		<div class="loading">
			<div class="overlay">
				<i class="fa fa-refresh fa-spin text-default"></i> Mohon Tunggu ..
			</div>
		</div>
		<!-- END Preloader -->

		<div id="page-container" class="sidebar-mini sidebar-visible-lg-mini sidebar-no-animations">
			<!-- Alternative Sidebar -->
			<?php $this->load->view('admin/right-chat-sidebar'); ?>
			<!-- END Alternative Sidebar -->

			<!-- Main Sidebar -->
			<?php $this->load->view('admin/left-sidebar'); ?>
			<!-- END Main Sidebar -->

			<!-- Main Container -->
			<div id="main-container">
				<?php $this->load->view('admin/menu-header'); ?>
				<!-- END Header -->

				<!-- Page content -->
				<div id="page-content">
					<?php $this->load->view($view); ?>
				</div>
				<!-- END Page Content -->

				<!-- Footer -->
				<footer class="clearfix">
					<div class="pull-right">
						Crafted with <i class="fa fa-heart text-danger"></i> by <a href="#">CV. Mega Setia Abadi</a>
					</div>
					<div class="pull-left">
						<span>2022</span> &copy; <a href="#">SIM CV. MSA 1.0</a> All right reserved
					</div>
				</footer>
				<!-- END Footer -->
			</div>
			<!-- END Main Container -->
		</div>
		<!-- END Page Container -->
	</div>
	<!-- END Page Wrapper -->
	<?php $this->load->view('layouts/footer'); ?>
</body>

</html>
