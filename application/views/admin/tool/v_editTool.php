<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_tool_edit'); ?>
					<div class="form-group">
						<label for="tool_kode"> Kode Tool</label>
						<input type="hidden" name="tool_id" value="<?= $tool_item->tool_id; ?>">
						<input type="text" class="form-control form-control-user" id="tool_kode" value="<?= $tool_item->tool_kode; ?>" disabled>
						<input type="hidden" name="tool_kode" class="form-control" value="<?= $tool_item->tool_kode; ?>">
					</div>
					<div class="form-group">
						<label for="tool_nama"> Nama Tool</label>
						<input type="text" name="tool_nama" class="form-control form-control-user" id="tool_nama" value="<?= $tool_item->tool_nama; ?>">
						<?= form_error('tool_nama', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<a href="<?= base_url("tool") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
					<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
