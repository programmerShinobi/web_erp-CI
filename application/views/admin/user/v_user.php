<?= $this->session->flashdata('pesan'); ?>
<script src="<?= base_url("assets/vendor/ckeditor/ckeditor.js") ?>"></script>
<div class="container-fluid">
	<h4><?= $title; ?></h4>
	<div class="card">
		<div class="card-header">
			<ul class="nav nav-pills" role="tablist">
				<li class="nav-item border border-primary rounded m-1">
					<a class="nav-link active" data-toggle="pill" href="#Semuauser"><i class="fas fa-fw fa-user-tag"></i> Semua User</a>
				</li>
				<li class="nav-item border border-primary rounded m-1">
					<a class="nav-link" data-toggle="pill" href="#userAktif"><i class="fas fa-check"></i> User Aktif</a>
				</li>
				<li class="nav-item border border-primary rounded m-1">
					<a class="nav-link" data-toggle="pill" href="#userNonaktif"><i class="fas fa-times"></i> User Nonaktif</a>
				</li>
			</ul>
		</div>
		<div class="card-body">
			<div class="tab-content">
				<div id="Semuauser" class="tab-pane container active">
					<b><?= "Semua User" ?></b>
					<hr>
					<a href="" data-toggle="modal" data-target="#add" class="btn btn-success btn-sm mb-3"><i class="fa fa-plus"></i> Tambah User</a>
					<a href="<?= base_url("export_user") ?>" target="_blank" class="btn btn-dark btn-sm mb-3"><i class="fa fa-file-export"></i> Export to excel</a>
					<a href="" data-toggle="modal" data-target="#import" class="btn btn-dark btn-sm mb-3"><i class="fa fa-file-import"></i> Import Excel</a>

					<div class="table-responsive">
						<table class="table table-bordered table-hover w-100 display" cellspacing="0" width="100%" id="dataVisibility">
							<thead>
								<tr>
									<th>#</th>
									<th>Nama</th>
									<th>Klasifikasi</th>
									<th>Role</th>
									<th>Nomor HP</th>
									<th>Email</th>
									<th>Status</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($list_user as $item) { ?>
									<?php if ($this->session->userdata('admin_id') != $item->user_id) { ?>
										<tr>
											<td><?= $no++; ?></td>
											<td><?= $item->user_nama; ?></td>
											<td><?= $item->pekerjaan; ?></td>
											<td><?= $item->role; ?></td>
											<td><?= $item->user_noHP; ?></td>
											<td><?= $item->user_email; ?></td>
											<td>
												<center>
													<?php if ($item->user_backlist == 0) {
													?>

														<a href="<?= base_url('process_user_check/' . $item->user_id); ?>" class="btn btn-success btn-sm" onclick="return confirm('Yakin menonaktifkan data?')">
															<i class='fa fa-check'></i>
														</a>

													<?php
													} else {
													?>

														<a href="<?= base_url('process_user_check/' . $item->user_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mengaktifkan data?')">
															<i class="fas fa-times"></i>
														</a>

													<?php
													}
													?>
												</center>
											</td>
											<td>
												<?php if ($item->user_backlist == 0) { ?>
													<div class="form-group card ">
														<a href="<?= base_url('view_user_edit/' . $item->user_id); ?>" class="btn btn-light btn-sm"><i class="fa fa-edit"></i> Edit</a>
													</div>
													<?php if ($user->user_role == 1) { ?>
														<div class="form-group card ">
															<a href="<?= base_url('process_user_delete/' . $item->user_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?')"><i class="fa fa-trash"></i> Hapus</a>
														</div>
													<?php } else {
													}
												} else { ?>
													<div class="form-group card ">
														<a href="#" class="btn btn-default btn-sm"><i class="fa fa-times"></i> </a>
													</div>
												<?php } ?>
											</td>
										</tr>
								<?php }
								} ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="userAktif" class="tab-pane container fade">
					<b><?= "User Aktif" ?></b>
					<hr>
					<a href="" data-toggle="modal" data-target="#add" class="btn btn-success btn-sm mb-3"><i class="fa fa-plus"></i> Tambah User</a>
					<div class="table-responsive">
						<table class="table table-bordered table-hover w-100 display" cellspacing="0" width="100%" id="dataVisibility1">
							<thead>
								<tr>
									<th>#</th>
									<th>Nama</th>
									<th>Klasifikasi</th>
									<th>Role</th>
									<th>Nomor HP</th>
									<th>Email</th>
									<th>Status</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($user_aktif as $item1) { ?>
									<?php if ($this->session->userdata('admin_id') != $item1->user_id) { ?>
										<tr>
											<td><?= $no++; ?></td>
											<td><?= $item1->user_nama; ?></td>
											<td><?= $item1->pekerjaan; ?></td>
											<td><?= $item1->role; ?></td>
											<td><?= $item1->user_noHP; ?></td>
											<td><?= $item1->user_email; ?></td>
											<td>
												<center>
													<a href="<?= base_url('view_user_edit/' . $item1->user_id); ?>" class="btn btn-success btn-sm" onclick="return confirm('Yakin menonaktifkan data?')">
														<i class='fa fa-check'></i>
													</a>
												</center>
											</td>
											<td>
												<div class="form-group card ">
													<a href="<?= base_url('view_user_edit/' . $item->user_id); ?>" class="btn btn-light btn-sm"><i class="fa fa-edit"></i> Edit</a>
												</div>
												<?php if ($user->user_role == 1) { ?>
													<div class="form-group card ">
														<a href="<?= base_url('process_user_delete/' . $item->user_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?')"><i class="fa fa-trash"></i> Hapus</a>
													</div>
												<?php } ?>
											</td>
										</tr>
								<?php }
								} ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="userNonaktif" class="tab-pane container fade">
					<b><?= "User Non Aktif" ?></b>
					<hr>
					<div class="table-responsive">
						<table class="table table-bordered table-hover w-100 display" cellspacing="0" width="100%" id="dataVisibility2">
							<thead>
								<tr>
									<th>#</th>
									<th>Nama</th>
									<th>Klasifikasi</th>
									<th>Role</th>
									<th>Nomor HP</th>
									<th>Email</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($user_nonaktif as $item2) { ?>
									<?php if ($this->session->userdata('admin_id') != $item2->user_id) { ?>
										<tr>
											<td><?= $no++; ?></td>
											<td><?= $item2->user_nama; ?></td>
											<td><?= $item2->pekerjaan; ?></td>
											<td><?= $item2->role; ?></td>
											<td><?= $item2->user_noHP; ?></td>
											<td><?= $item2->user_email; ?></td>
											<td>
												<center>
													<a href="<?= base_url('view_user_edit/' . $item2->user_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mengaktifkan data?')">
														<i class="fas fa-times"></i>
													</a>
												</center>
											</td>
										</tr>
								<?php }
								} ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="import">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Import Data User</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<?= form_open_multipart("import_user") ?>
				<div class="form-group">
					<label>Masukkan File Excel</label>
					<input type="file" name="import_user" class="form-control">
				</div>
				<input type="submit" value="Import" class="btn btn-success btn-sm">
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</div>

<?php
$kode = $total_user + 1;
//Support KodeTambah
if ($total_user <= 9) {
	$kodeTambah = "000";
} else if ($total_user <= 99) {
	$kodeTambah = "00";
} else if ($total_user <= 1000) {
	$kodeTambah = "0";
} else if ($total_user <= 10000) {
	$kodeTambah = "";
}
?>

<div class="modal fade" id="add">
	<div class="modal-dialog modal-dialog-scrollable modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5>Tambah User</h5>
				<button type="button" data-dismiss="modal" class="close">&times;</button>
			</div>
			<div class="modal-body">
				<?= form_open('validation_user_add'); ?>
				<div class="row">
					<div class="col-md-6">
						<h5>Data Pribadi</h5>
						<div class="form-group">
							<label>Kode User</label>
							<input type="text" class="form-control" value="<?php echo $kodeTambah . $kode; ?>" disabled>
							<input type="hidden" name="user_noId" class="form-control" value="<?php echo $kodeTambah . $kode; ?>">
						</div>
						<div class="form-group">
							<label>Nama</label>
							<input type="text" name="user_nama" class="form-control" required autofocus>
						</div>
						<div class="form-group">
							<label>Tempat Lahir</label>
							<input type="text" name="user_tempatLahir" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Tanggal Lahir</label>
							<input type="date" name="user_tanggalLahir" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Klasifikasi</label>
							<select class="form-control" id="user_klasifikasi" name="user_klasifikasi">
								<option disabled selected>-- Pilih Klasifikasi --</option>
								<?php foreach ($pekerjaan as $item) { ?>
									<option value="<?php echo $item->pekerjaan_id; ?>"><?php echo $item->pekerjaan; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label>Role</label>
							<select class="form-control" id="user_role" name="user_role">
								<option disabled selected>-- Pilih Role --</option>
								<?php foreach ($role as $item) { ?>
									<option value="<?php echo $item->role_id; ?>"><?php echo $item->role; ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<label>Nomor Induk KTP</label>
							<input type="text" name="user_ktp" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Username</label>
							<input type="text" name="user_username" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" name="user_password" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Alamat</label>
							<input type="text" name="user_alamat" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Nomor HP</label>
							<input type="number" name="user_noHP" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="user_email" class="form-control" required>
						</div>
					</div>
					<div class="col-md-6">
						<h5>Data Orang Tua / Wali</h5>
						<div class="form-group">
							<label>Nama Orang Tua / Wali</label>
							<input type="text" name="orangtua_nama" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Nomor HP Orang Tua / Wali</label>
							<input type="number" name="orangtua_noHP" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Tempat Lahir Orang Tua / Wali</label>
							<input type="text" name="orangtua_tempatLahir" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Tanggal Lahir Orang Tua / Wali</label>
							<input type="date" name="orangtua_tanggalLahir" class="form-control" required>
						</div>
						<h5>Pertanyaan Keamanan</h5>
						<div class="form-group">
							<select name="pertanyaan" class="form-control" required>
								<option disabled selected>-- Pilih Pertanyaan --</option>
								<option value="Siapa nama peliharaan anda?">Siapa nama peliharaan anda?</option>
								<option value="Siapa nama kakek anda?">Siapa nama kakek anda?</option>
								<option value="Siapa nama saudara anda?">Siapa nama saudara anda?</option>
								<option value="Nama sekolah SD anda adalah?">Nama sekolah SD anda adalah?</option>
							</select>
						</div>
						<div class="form-group">
							<input type="text" name="jawaban" class="form-control" required>
						</div>
					</div>
				</div>
				<input type="submit" value="Simpan" class="btn btn-success btn-sm">
				<?= form_close(); ?>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-danger btn-sm">Close</button>
			</div>
		</div>
	</div>
</div>
