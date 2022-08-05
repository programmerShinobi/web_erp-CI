<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_material_edit'); ?>
					<div class="form-group">
						<label for="material_kode"> Kode Material</label>
						<input type="hidden" name="material_id" value="<?= $material_item->material_id; ?>">
						<input type="text" class="form-control form-control-user" id="material_kode" value="<?= $material_item->material_kode; ?>" disabled>
						<input type="hidden" name="material_kode" class="form-control" value="<?= $material_item->material_kode; ?>">
					</div>
					<div class="form-group">
						<label for="material_nama"> Nama Material</label>
						<input type="text" name="material_nama" class="form-control form-control-user" id="material_nama" value="<?= $material_item->material_nama; ?>">
						<?= form_error('material_nama', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<div class="form-group">
						<label for="material_stok"> Stok Material</label>
						<input type="number" name="material_stok" class="form-control form-control-user" id="material_stok" value="<?= $material_item->material_stok; ?>">
						<?= form_error('material_stok', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<a href="<?= base_url("material") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
					<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
