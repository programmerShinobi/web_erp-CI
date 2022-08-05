<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?= base_url('vendor/css/bootstrap.min.css'); ?>">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- icon Title -->
	<link rel="icon" href="<?= base_url('vendor/img/Icon/logo.png'); ?>">
	<title><?= $title; ?></title>
	<!-- Custom fonts for this template-->
	<link href="<?= base_url('vendor/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	<!-- Custom styles for this template-->
	<link href="<?= base_url('vendor/css/sb-admin-2.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('vendor/css/custom.css') ?>" rel="stylesheet">
	<!-- Sweet -->
	<script src="<?= base_url('vendor/js/sweet.js'); ?>"></script>
	<!-- Custom -->
	<script src="<?= base_url('vendor/js/custom.js'); ?>"></script>
	<!-- DataTables -->
	<link rel="stylesheet" href="<?php echo base_url('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('vendor/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
	<link rel="stylesheet" href="<?php echo base_url('vendor/datatables-buttons/css/buttons.bootstrap4.min.css') ?>">
	<!-- <link rel="stylesheet" href="<?= base_url('vendor/datatables_old/css/dataTables.bootstrap4.min.css'); ?>"> -->
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?= base_url('vendor/font-awesome/css/all.min.css'); ?>">
	<!-- CKEDITOR -->
	<script src="<?= base_url('vendor/ckeditor/ckeditor.js'); ?>"></script>
	<!-- jQuery -->
	<script src="<?= base_url('vendor/vendor/jquery/jquery.min.js') ?>"></script>
	<!-- AOS -->
	<link rel="stylesheet" href="<?= base_url('vendor/css/aos.css'); ?>">

</head>

<body id="page-top">
	<!-- Page Wrapper -->
	<div id="wrapper">
		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-white text-primary sidebar sidebar-primary accordion" id="accordionSidebar">
			<!-- Sidebar - Brand -->
			<div class="sidebar-heading">
				<a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
					<div class="sidebar-brand-icon rotate-n-15">
						<i class="fas fa-fw fa-globe"></i>
					</div>
					<div class="sidebar-brand-text mx-3">OneCompany</div>
				</a>
			</div>
			<!-- Sidebar Toggler (Sidebar) -->
			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle text-primary border-0 shadow bg-white" id="sidebarToggle"></button>
			</div>

			<?php if ($title == 'Dashboard') { ?>
				<li class="shadow nav-item active">
				<?php } else { ?>
				<li class=" nav-item">
				<?php } ?>
				<a class="nav-link" href="<?= base_url('dashboard'); ?>">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Dashboard</span></a>
				</li>
				<br>
				<?php
				foreach ($menu as $m) {
				?>
					<div class="sidebar-heading">
						<?= $m['menu_judul']; ?>
					</div>
					<hr class=" sidebar-divider my-0">
					<?php
					$me = $m['menu_id'];
					$sub = $this->db->query("SELECT * FROM tb_menu JOIN tb_sub
                      ON tb_menu.menu_id = tb_sub.menu_id
                      WHERE tb_sub.menu_id = '$me'
                      AND tb_sub.sub_status='1'")->result_array();
					foreach ($sub as $s) { ?>
						<?php if ($title == $s['sub_judul']) { ?>
							<li class="shadow nav-item active">
							<?php } else { ?>
							<li class="nav-item">
							<?php } ?>
							<a class="nav-link" href="<?= base_url($s['sub_link']); ?>">
								<i class="<?= $s['sub_icon']; ?>"></i>
								<span><?= $s['sub_judul'];  ?></span></a>
							</li>
						<?php }  ?><br>
					<?php } ?>
					<!-- Sidebar Toggler (Sidebar) -->
					<div class="text-center d-none d-md-inline">
						<button class="rounded-circle text-primary border-0 shadow bg-white" id="sidebarToggle"></button>
					</div>
		</ul>
		<!-- End of Sidebar -->
		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">
			<!-- Main Content -->
			<div id="content">
				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-mute topbar mb-4 static-top shadow">
					<!-- Sidebar Toggle (Topbar) -->
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
						<i class="fa fa-bars"></i>
					</button>
					<!-- Topbar Navbar -->
					<ul class="navbar-nav ml-auto">
						<li class="nav-item no-arrow">
							<div class="nav-link">
								<span class="mr-2 d-none d-lg-inline text-gray-600 small">
									<?php
									$hariIni = date('D');
									if ($hariIni == "Sun") {
										$hariIni = 'Minggu';
									} else if ($hariIni == "Mon") {
										$hariIni = 'Senin';
									} else if ($hariIni == "Tue") {
										$hariIni = 'Selasa';
									} else if ($hariIni == "Wed") {
										$hariIni = 'Rabu';
									} else if ($hariIni == "Thu") {
										$hariIni = 'Kamis';
									} else if ($hariIni == "Fri") {
										$hariIni = 'Jumat';
									} else if ($hariIni == "Sat") {
										$hariIni = 'Sabtu';
									}
									$bulaniIni = date('m');
									if ($bulaniIni == "01") {
										$bulaniIni = 'Januari';
									} else if ($bulaniIni == "02") {
										$bulaniIni = 'Februari';
									} else if ($bulaniIni == "03") {
										$bulaniIni = 'Maret';
									} else if ($bulaniIni == "04") {
										$bulaniIni = 'April';
									} else if ($bulaniIni == "05") {
										$bulaniIni = 'Mei';
									} else if ($bulaniIni == "06") {
										$bulaniIni = 'Juni';
									} else if ($bulaniIni == "07") {
										$bulaniIni = 'Juli';
									} else if ($bulaniIni == "08") {
										$bulaniIni = 'Agustus';
									} else if ($bulaniIni == "09") {
										$bulaniIni = 'September';
									} else if ($bulaniIni == "10") {
										$bulaniIni = 'Oktober';
									} else if ($bulaniIni == "11") {
										$bulaniIni = 'November';
									} else if ($bulaniIni == "12") {
										$bulaniIni = 'Desember';
									}
									echo $hariIni;
									echo ",&nbsp";
									echo date("d");
									echo "&nbsp";
									echo $bulaniIni;
									echo "&nbsp";
									echo date("Y");
									?>
								</span>
							</div>
						</li>
						<div class="topbar-divider d-none d-sm-block"></div>
						<!-- Nav Item - User Information -->
						<li class="nav-item dropdown no-arrow">
							<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user->user_nama; ?></span>
								<img class="img-profile rounded-circle" src="<?= base_url('vendor/img/user/' . $user->user_foto); ?>">
							</a>
							<!-- Dropdown - User Information -->
							<div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
								<a class="dropdown-item" href="<?= base_url('profile'); ?>">
									<i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
									Profile
								</a>
								<a class="dropdown-item" href="<?= base_url('gantiPassword'); ?>">
									<i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
									Ganti Password
								</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
									<i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
									Logout
								</a>
							</div>
						</li>
					</ul>
				</nav>
				<!-- End of Topbar -->
