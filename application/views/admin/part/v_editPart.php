<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_part_edit'); ?>
					<div class="form-group">
						<label for="part_kode"> Kode Part</label>
						<input type="hidden" name="part_id" value="<?= $part_item->part_id; ?>">
						<input type="text" class="form-control form-control-user" id="part_kode" value="<?= $part_item->part_kode; ?>" disabled>
						<input type="hidden" name="part_kode" class="form-control" value="<?= $part_item->part_kode; ?>">
					</div>
					<div class="form-group">
						<label for="part_nama"> Nama Part</label>
						<input type="text" name="part_nama" class="form-control form-control-user" id="part_nama" value="<?= $part_item->part_nama; ?>">
						<?= form_error('part_nama', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<a href="<?= base_url("part") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
					<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
