			</div>
			<!-- End of Main Content -->
			<!-- Footer -->
			<footer class="sticky-footer bg-mute">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright &copy; <?= date('Y'); ?> OneCompany</span>
					</div>
				</div>
			</footer>
			<!-- End of Footer -->
			</div>
			<!-- End of Content Wrapper -->
			</div>
			<!-- End of Page Wrapper -->
			<!-- Scroll to Top Button-->
			<a class="scroll-to-top rounded" href="#page-top">
				<i class="fas fa-angle-up"></i>
			</a>
			<!-- Logout Modal-->
			<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
							<a class="btn btn-primary" href="<?= base_url('logout'); ?>">Logout</a>
						</div>
					</div>
				</div>
			</div>
			<!-- Status Buku Modal-->
			<div class="modal fade" id="statusBukuModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Ready to Disable?</h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">Select "Disable" below if you are ready to end your current session.</div>
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
							<a class="btn btn-primary" href="<?= base_url('process_buku_check/' . $item->buku_id); ?>">Disable</a>
						</div>
					</div>
				</div>
			</div>
			<!-- Status Anggota Modal-->
			<div class="modal fade" id="statusAnggotaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Ready to Disable?</h5>
							<button class="close" type="button" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">Select "Disable" below if you are ready to end your current session.</div>
						<div class="modal-footer">
							<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
							<a class="btn btn-primary" href="<?= base_url('process_anggota_check/' . $item->user_id); ?>">Disable</a>
						</div>
					</div>
				</div>
			</div>
			<!-- Core plugin JavaScript-->
			<script src="<?= base_url('vendor/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
			<!-- Custom scripts for all pages-->
			<script src="<?= base_url('vendor/js/sb-admin-2.min.js'); ?>"></script>
			<!-- Demo -->
			<script src="<?= base_url('/vendor/js/demo.js'); ?>"></script>
			<!-- Bootstrap core JavaScript-->
			<script src="<?= base_url('vendor/vendor/jquery/jquery.min.js'); ?>"></script>
			<script src="<?= base_url('vendor/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
			<script src="<?= base_url('vendor/js/sweet.js'); ?>"></script>
			<script src="<?= base_url('vendor/js/custom.js'); ?>"></script>
			<!-- Core Bootstrap -->
			<script src="<?= base_url('vendor/vendor/bootstrap/js/bootstrap.min.js'); ?>"></script>
			<script src="<?= base_url('vendor/vendor/bootstrap/js/cari.js'); ?>"></script>
			<!-- Font Awesome -->
			<script src="<?= base_url('vendor/font-awesome/js/all.min.js') ?>"></script>
			<!-- Font Awesome -->
			<script src="https://kit.fontawesome.com/0c21508fc5.js" crossorigin="anonymous"></script>

			<!-- AOS -->
			<script src="<?= base_url('vendor/js/aos.js'); ?>"></script>
			<!-- DataTables-->
			<!--<script src="<?= base_url(); ?>vendor/datatables_old/js/jquery.dataTables.js"></script>-->
			<!--<script src="<?= base_url(); ?>vendor/datatables_old/js/dataTables.bootstrap4.min.js"></script>-->
			<script src="<?php echo base_url() ?>vendor/datatables/jquery.dataTables.min.js"></script>
			<script src="<?php echo base_url() ?>vendor/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
			<script src="<?php echo base_url() ?>vendor/datatables-responsive/js/dataTables.responsive.min.js"></script>
			<script src="<?php echo base_url() ?>vendor/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
			<script src="<?php echo base_url() ?>vendor/datatables-buttons/js/dataTables.buttons.min.js"></script>
			<script src="<?php echo base_url() ?>vendor/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
			<script src="<?php echo base_url() ?>vendor/jszip/jszip.min.js"></script>
			<script src="<?php echo base_url() ?>vendor/pdfmake/pdfmake.min.js"></script>
			<script src="<?php echo base_url() ?>vendor/pdfmake/vfs_fonts.js"></script>
			<script src="<?php echo base_url() ?>vendor/datatables-buttons/js/buttons.html5.min.js"></script>
			<script src="<?php echo base_url() ?>vendor/datatables-buttons/js/buttons.print.min.js"></script>
			<script src="<?php echo base_url() ?>vendor/datatables-buttons/js/buttons.colVis.min.js"></script>
			<script>
				// membuat fungsi change
				function change() {

					// membuat variabel berisi tipe input dari id='pass', id='pass' adalah form input password 
					var x = document.getElementById('pass').type;

					//membuat if kondisi, jika tipe x adalah password maka jalankan perintah di bawahnya
					if (x == 'password') {

						//ubah form input password menjadi text
						document.getElementById('pass').type = 'text';

						//ubah icon mata terbuka menjadi tertutup
						document.getElementById('mybutton').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																	<path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
																	<path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829z"/>
																	<path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
																	</svg>`;
					} else {
						//ubah form input password menjadi text
						document.getElementById('pass').type = 'password';
						//ubah icon mata terbuka menjadi tertutup
						document.getElementById('mybutton').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																	<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
																	<path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
																	</svg>`;
					}
				}
			</script>
			<script>
				// membuat fungsi change
				function change1() {

					// membuat variabel berisi tipe input dari id='pass1', id='pass1' adalah form input password 
					var x1 = document.getElementById('pass1').type;

					//membuat if kondisi, jika tipe x1 adalah password maka jalankan perintah di bawahnya
					if (x1 == 'password') {

						//ubah form input password menjadi text
						document.getElementById('pass1').type = 'text';

						//ubah icon mata terbuka menjadi tertutup
						document.getElementById('mybutton1').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																	<path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
																	<path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829z"/>
																	<path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
																	</svg>`;
					} else {
						//ubah form input password menjadi text
						document.getElementById('pass1').type = 'password';
						//ubah icon mata terbuka menjadi tertutup
						document.getElementById('mybutton1').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																	<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
																	<path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
																	</svg>`;
					}
				}
			</script>
			<script>
				// membuat fungsi change
				function change2() {

					// membuat variabel berisi tipe input dari id='pass2', id='pass2' adalah form input password 
					var x2 = document.getElementById('pass2').type;

					//membuat if kondisi, jika tipe x2 adalah password maka jalankan perintah di bawahnya
					if (x2 == 'password') {

						//ubah form input password menjadi text
						document.getElementById('pass2').type = 'text';

						//ubah icon mata terbuka menjadi tertutup
						document.getElementById('mybutton2').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																	<path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
																	<path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829z"/>
																	<path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
																	</svg>`;
					} else {
						//ubah form input password menjadi text
						document.getElementById('pass2').type = 'password';
						//ubah icon mata terbuka menjadi tertutup
						document.getElementById('mybutton2').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																	<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
																	<path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
																	</svg>`;
					}
				}
			</script>
			<script>
				// membuat fungsi change
				function change3() {

					// membuat variabel berisi tipe input dari id='pass3', id='pass3' adalah form input password 
					var x3 = document.getElementById('pass3').type;

					//membuat if kondisi, jika tipe x3 adalah password maka jalankan perintah di bawahnya
					if (x3 == 'password') {

						//ubah form input password menjadi text
						document.getElementById('pass3').type = 'text';

						//ubah icon mata terbuka menjadi tertutup
						document.getElementById('mybutton3').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-slash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																	<path d="M10.79 12.912l-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
																	<path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708l-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829z"/>
																	<path fill-rule="evenodd" d="M13.646 14.354l-12-12 .708-.708 12 12-.708.708z"/>
																	</svg>`;
					} else {
						//ubah form input password menjadi text
						document.getElementById('pass3').type = 'password';
						//ubah icon mata terbuka menjadi tertutup
						document.getElementById('mybutton3').innerHTML = `<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
																	<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
																	<path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
																	</svg>`;
					}
				}
			</script>
			<!-- Datatable Sekolah-->
			<script>
				$(function() {
					$("#dataVisibility").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataVisibility_wrapper .col-md-6:eq(0)');
				});
				$(function() {
					$("#dataVisibility1").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataVisibility1_wrapper .col-md-6:eq(0)');
				});
				$(function() {
					$("#dataVisibility2").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataVisibility2_wrapper .col-md-6:eq(0)');
				});
				$(function() {
					$("#dataVisibility3").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"iDisplayLength": 10,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataVisibility3_wrapper .col-md-6:eq(0)');
				});
				$(function() {
					$("#dataVisibility4").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"iDisplayLength": 10,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataVisibility4_wrapper .col-md-6:eq(0)');
				});
				$(function() {
					$("#dataVisibility5").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataVisibility5_wrapper .col-md-6:eq(0)');
				});
				$(function() {
					$("#dataVisibility6").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataVisibility6_wrapper .col-md-6:eq(0)');
				});
				$(function() {
					$("#dataVisibility7").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataVisibility7_wrapper .col-md-6:eq(0)');
				});
				$(function() {
					$("#dataVisibility8").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataVisibility8_wrapper .col-md-6:eq(0)');
				});
				$(function() {
					$("#dataVisibility9").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataVisibility9_wrapper .col-md-6:eq(0)');
				});
				$(function() {
					$("#dataVisibility10").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataVisibility10_wrapper .col-md-6:eq(0)');
				});
				$(function() {
					$("#dataVisibility11").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataVisibility11_wrapper .col-md-6:eq(0)');
				});
				$(function() {
					$("#dataMenu").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"iDisplayLength": 10,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataMenu_wrapper .col-md-6:eq(0)');
				});
				$(function() {
					$("#dataAccessMenu").DataTable({
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": false,
						"responsive": true,
						"buttons": ["copy", "colvis"],
					}).buttons().container().appendTo('#dataAccessMenu_wrapper .col-md-6:eq(0)');
				});
			</script>
			</body>

			</html>
