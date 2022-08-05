<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<h4>Edit data user</h4>
	<div class="card mb-4">
		<div class="card-body">
			<?= form_open_multipart('validation_user_edit'); ?>
			<div class="row">
				<div class="col-md-6">
					<h5>Data Pribadi</h5>
					<div class="form-group">
						<label>Kode User</label>
						<input type="hidden" name="user_id" class="form-control" value="<?= $user_detail->user_id; ?>" required>
						<input type="text" name="user_noId" class="form-control" value="<?= $user_detail->user_noId; ?>" required>
					</div>
					<div class="form-group">
						<label>Nama</label>
						<input type="text" name="user_nama" class="form-control" value="<?= $user_detail->user_nama; ?>" required>
					</div>
					<div class="form-group">
						<label>Tempat Lahir</label>
						<input type="text" name="user_tempatLahir" class="form-control" value="<?= $user_detail->user_tempatLahir; ?>" required>
					</div>
					<div class="form-group">
						<label>Tanggal Lahir</label>
						<input type="date" name="user_tanggalLahir" class="form-control" value="<?= $user_detail->user_tanggalLahir; ?>" required>
					</div>
					<div class="form-group">
						<label>Klasifikasi</label>
						<select class="form-control" id="user_klasifikasi" name="user_klasifikasi">
							<option disabled selected>-- Pilih Klasifikasi --</option>
							<?php foreach ($pekerjaan as $item) { ?>
								<option value="<?php echo $item->pekerjaan_id; ?>"
									<?php if ($user_detail->user_klasifikasi == $item->pekerjaan_id)
									{echo 'selected';} ?> /><?php echo $item->pekerjaan; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>Role</label>
						<select class="form-control" id="user_role" name="user_role">
							<option disabled selected>-- Pilih Role --</option>
							<?php foreach ($role as $item) { ?>
								<option value="<?php echo $item->role_id; ?>"
									<?php if ($user_detail->user_role == $item->role_id)
									{echo 'selected';} ?> /><?php echo $item->role; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label>KTP</label>
						<input type="text" name="user_ktp" class="form-control" value="<?= $user_detail->user_ktp; ?>" required>
					</div>
					<div class="form-group">
						<label>Username</label>
						<input type="text" name="user_username" class="form-control" value="<?= $user_detail->user_username; ?>" required>
					</div>
					<div class="form-group">
						<label>Password</label>
						<div class="input-group">
							<input type="password" name="user_password" class="form-control" placeholder="Isi jika ingin ganti password" id="pass">
							<div class="input-group-append">
								<!-- kita pasang onclick untuk merubah icon buka/tutup mata setiap diklik  -->
								<span id="mybutton" onclick="change()" class="input-group-text">
									<!-- icon mata bawaan bootstrap  -->
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
										<path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
									</svg>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Alamat</label>
						<input type="text" name="user_alamat" class="form-control" value="<?= $user_detail->user_alamat; ?>" required>
					</div>
					<div class="form-group">
						<label>Nomor HP</label>
						<input type="number" name="user_noHP" class="form-control" value="<?= $user_detail->user_noHP; ?>" required>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="user_email" class="form-control" value="<?= $user_detail->user_email; ?>" required>
					</div>
					<img src="<?= base_url("vendor/img/user/" . $user_detail->user_foto); ?>" alt="Foto Petugas" style="max-width: 20%;">
					<div class="form-group">
						<label>Foto User</label>
						<input type="file" name="user_foto" class="form-control">
					</div>
				</div>
				<div class="col-md-6">
					<h5>Data Orang Tua / Wali</h5>
					<div class="form-group">
						<label>Nama Orang Tua / Wali</label>
						<input type="text" name="orangtua_nama" class="form-control" value="<?= $user_detail->orangtua_nama; ?>" required>
					</div>
					<div class="form-group">
						<label>Nomor HP Orang Tua / Wali</label>
						<input type="number" name="orangtua_noHP" class="form-control" value="<?= $user_detail->orangtua_noHP; ?>" required>
					</div>
					<div class="form-group">
						<label>Tempat Lahir Orang Tua / Wali</label>
						<input type="text" name="orangtua_tempatLahir" class="form-control" value="<?= $user_detail->orangtua_tempatLahir; ?>" required>
					</div>
					<div class="form-group">
						<label>Tanggal Lahir Orang Tua / Wali</label>
						<input type="date" name="orangtua_tanggalLahir" class="form-control" value="<?= $user_detail->orangtua_tanggalLahir; ?>" required>
					</div>
					<h5>Pertanyaan Keamanan</h5>
					<div class="form-group">
						<select name="pertanyaan" class="form-control" required>
							<option disabled selected>-- Pilih Pertanyaan --</option>
							<option <?php if ($user_detail->pertanyaan == "Siapa nama peliharaan anda?") {
										echo "selected";
									} ?> value="Siapa nama peliharaan anda?">Siapa nama peliharaan anda?</option>
							<option <?php if ($user_detail->pertanyaan == "Siapa nama kakek anda?") {
										echo "selected";
									} ?> value="Siapa nama kakek anda?">Siapa nama kakek anda?</option>
							<option <?php if ($user_detail->pertanyaan == "Siapa nama saudara anda?") {
										echo "selected";
									} ?> value="Siapa nama saudara anda?">Siapa nama saudara anda?</option>
							<option <?php if ($user_detail->pertanyaan == "Nama sekolah SD anda adalah?") {
										echo "selected";
									} ?> value="Nama sekolah SD anda adalah?">Nama sekolah SD anda adalah?</option>
						</select>
					</div>
					<div class="form-group">
						<input type="text" name="jawaban" class="form-control" value="<?= $user_detail->pertanyaan_jawaban; ?>" required>
					</div>
				</div>
			</div>
			<a href="<?= base_url("user") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
			<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
			<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
			<?= form_close(); ?>
		</div>
	</div>
</div>
