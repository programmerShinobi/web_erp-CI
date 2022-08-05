<?= $this->session->flashdata('pesan'); ?>

<div class="container konten">
	<div class="row justify-content-center">
		<div class="col-md-4">
			<div class="o-hidden border-0 shadow-lg " data-aos="fade-down" data-aos-duration="1000">
				<h4>LOGIN</h4>
			</div>
		</div>
	</div>
	<!-- Outer Row -->
	<div class="row justify-content-center">
		<div class="col-md-4">
			<div class="o-hidden border-0 shadow-lg " data-aos="fade-up" data-aos-duration="1000">
				<!-- Nested Row within Card Body -->
				<div class="row">
					<div class="col-lg-12">
						<div class="p-5">
							<!-- <div class="text-center"><br>
						<h1 class="h4 text-900 text-dark mb-4">LOGIN</h1>
					</div> -->
							<?= form_open('index'); ?>
							<div class="form-group">
								<input type="text" class="form-control form-control-user" placeholder="Masukan username" name="username" autofocus>
								<?= form_error('username', '<small class="text-danger">', '</small>') ?>
							</div>
							<div class="form-group">
								<div class="input-group">
									<input type="password" class="form-control form-control-user" placeholder="Masukan Password" name="password" id="pass">
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
								<?= form_error('password', '<small class="text-danger">', '</small>') ?>
							</div>
							<center>
								<div class="form-group">

									<label class="text-dark"><?= $img; ?></label>
									<input type="text" name="captcha" class="form-control form-control-user" placeholder="Masukan CAPTCHA">
									<?= form_error('captcha', '<small class="text-danger">', '</small>') ?>
									<!--<?= $text; ?>-->
								</div>
							</center>
							<button type="submit" class="btn btn-primary btn-user btn-block"><i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i>Login</button>
							</form>
							<hr>
							<div class="text-center" data-aos="fade-left" data-aos-duration="3000">
								<a class="small" href="<?= base_url('lupaPassword'); ?>">Lupa Password?</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
