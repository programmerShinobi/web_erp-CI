<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<?= form_open('validation_access_edit'); ?>
					<div class="form-group">
						<label>Menu judul</label>
						<input type="hidden" name="access_id" value="<?= $access_item->access_id; ?>">
						<select name="menu_id" class="form-control" required>
							<?php foreach ($list_menu as $item) { ?>
								<option <?php if ($item->menu_id == $access_item->menu_id) {
													echo "selected";
												} ?> value="<?= $item->menu_id ?>"><?= $item->menu_judul; ?></option>
							<?php } ?>
						</select>
						<?= form_error('menu', '<small class="text-danger">', '</small>') ?>
					</div>
					<div class="form-group">
						<label>Role</label>
						<select class="form-control" id="role_id" name="role_id">
							<option disabled selected>-- Pilih Role --</option>
							<?php foreach ($role as $item) { ?>
								<option value="<?php echo $item->role_id; ?>"
									<?php if ($access_item->role_id == $item->role_id)
										{echo 'selected';	} ?> /><?php echo $item->role; ?>
									</option>
							<?php } ?>
						</select>
					</div>
					<a href="<?= base_url("menu") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
					<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
