<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_hole_edit'); ?>
					<div class="form-group">
						<input type="hidden" name="hole_id" value="<?= $hole_item->hole_id; ?>">
						<label for="hole_nama"> Nama Hole</label>
						<input type="text" name="hole_nama" class="form-control form-control-user" id="hole_nama" value="<?= $hole_item->hole_nama; ?>">
						<?= form_error('hole_nama', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<a href="<?= base_url("hole") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
					<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
