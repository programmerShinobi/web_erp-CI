<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 mx-auto">
			<div class="card">
				<div class="card-body">
					<?= form_open('gantiPassword'); ?>
					<div class="form-group">
						<label>Masukan Password Lama</label>
						<div class="input-group">
							<input type="password" name="passLama" class="form-control" id="pass1">
							<div class="input-group-append">
								<!-- kita pasang onclick untuk merubah icon buka/tutup mata setiap diklik  -->
								<span id="mybutton1" onclick="change1()" class="input-group-text">
									<!-- icon mata bawaan bootstrap  -->
									<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
										<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
										<path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
									</svg>
								</span>
							</div>
						</div>
						<?= form_error('passLama', '<small class="text-danger">', '</small>'); ?>
						</div>
						<div class="form-group">
							<label>Masukan Password Baru</label>
							<div class="input-group">
								<input type="password" name="passBaru" class="form-control" id="pass2">
								<div class="input-group-append">
									<!-- kita pasang onclick untuk merubah icon buka/tutup mata setiap diklik  -->
									<span id="mybutton2" onclick="change2()" class="input-group-text">
										<!-- icon mata bawaan bootstrap  -->
										<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
											<path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
										</svg>
									</span>
								</div>
							</div>
							<?= form_error('passBaru', '<small class="text-danger">', '</small>'); ?>
						</div>
						<div class="form-group">
							<label>Masukan Ulang Password Baru</label>
							<div class="input-group">
								<input type="password" name="passBaru1" class="form-control" id="pass3">
								<div class="input-group-append">
									<!-- kita pasang onclick untuk merubah icon buka/tutup mata setiap diklik  -->
									<span id="mybutton3" onclick="change3()" class="input-group-text">
										<!-- icon mata bawaan bootstrap  -->
										<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
											<path fill-rule="evenodd" d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
										</svg>
									</span>
								</div>
							</div>
							<?= form_error('passBaru1', '<small class="text-danger">', '</small>'); ?>
						</div>
						<input type="submit" value="Simpan" class="btn btn-success btn-sm">
						<?= form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
