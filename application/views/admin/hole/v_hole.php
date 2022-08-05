<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<h3><?= $title ?></h3>
	<div class="card">
		<div class="card-body">
			<a href="" class="btn btn-success btn-sm mb-3" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Hole</a>
			<a href="<?= base_url("export_hole") ?>" target="_blank" class="btn btn-dark btn-sm mb-3"><i class="fa fa-file-export"></i> Export to Excel</a>
			<a href="" data-toggle="modal" data-target="#import" class="btn btn-dark btn-sm mb-3"><i class="fa fa-file-import"></i> Import Excel</a>
			<div class="table-responsive">
				<table class="table table-bordered table-hover mb-5" id="dataMenu">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Nama</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($list_hole as $item) { ?>
							<?php if ($item->hole_nama != "-"){ ?>
								<tr>
									<td class="text-center"><?= $no++; ?></td>
									<td class="text-center"><?= $item->hole_nama; ?></td>
									<td class="text-center">
										<div class="form-group card ">
											<a href="<?= base_url('view_hole_edit/' . $item->hole_id); ?>" class="btn btn-light btn-sm"><i class="fa fa-edit"></i> Edit</a>
										</div>
										<div class="form-group card ">
											<a href="<?= base_url('process_hole_delete/' . $item->hole_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?')"><i class="fa fa-trash"></i> Hapus</a>
										</div>
									</td>
								</tr>
							<?php } 
						}?>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>

<div class="modal fade" id="add">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5>Tambah Hole</h5>
				<button type="button" data-dismiss="modal" class="close">&times;</button>
			</div>
			<div class="modal-body">
				<?= form_open('hole'); ?>
				<div class="form-group">
					<label for="hole_nama"> Nama hole</label>
					<input type="text" name="hole_nama" class="form-control form-control-user" id="hole_nama" placeholder="Masukan nama hole" value="<?= set_value('hole_nama'); ?>" required>
					<?= form_error('hole_nama', '<small class="text-danger" ><b>', '</b></small>') ?>
				</div>
				<input type="submit" value="Simpan" class="btn btn-success btn-sm">
				<?= form_close(); ?>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-danger btn-sm">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="import">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h4>Import Data Hole</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<?= form_open_multipart("import_hole") ?>
				<div class="form-group">
					<label>Masukkan File Excel</label>
					<input type="file" name="import_hole" class="form-control">
				</div>
				<input type="submit" value="Import" class="btn btn-success btn-sm">
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</div>
