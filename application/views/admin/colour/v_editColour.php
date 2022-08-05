<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_colour_edit'); ?>
					<div class="form-group">
						<input type="hidden" name="colour_id" value="<?= $colour_item->colour_id; ?>">
						<label for="colour_nama"> Nama Colour</label>
						<input type="text" name="colour_nama" class="form-control form-control-user" id="colour_nama" value="<?= $colour_item->colour_nama; ?>">
						<?= form_error('colour_nama', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<a href="<?= base_url("colour") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
					<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
