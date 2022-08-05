<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_category_edit'); ?>
					<div class="form-group">
						<input type="hidden" name="category_id" value="<?= $category_item->category_id; ?>">
						<label for="category_nama"> Nama Category</label>
						<input type="text" name="category_nama" class="form-control form-control-user" id="category_nama" value="<?= $category_item->category_nama; ?>">
						<?= form_error('category_nama', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<a href="<?= base_url("category") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
					<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
