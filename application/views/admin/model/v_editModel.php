<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_model_edit'); ?>
					<div class="form-group">
						<label for="model_kode"> Kode model</label>
						<input type="hidden" name="model_id" value="<?= $model_item->model_id; ?>">
						<input type="text" class="form-control form-control-user" id="model_kode" value="<?= $model_item->model_kode; ?>" disabled>
						<input type="hidden" name="model_kode" class="form-control" value="<?= $model_item->model_kode; ?>">
					</div>
					<div class="form-group">
						<label for="model_nama"> Nama model</label>
						<input type="text" name="model_nama" class="form-control form-control-user" id="model_nama" value="<?= $model_item->model_nama; ?>">
						<?= form_error('model_nama', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<a href="<?= base_url("model") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
					<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
