<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_customer_edit'); ?>
					<div class="form-group">
						<label for="customer_kode"> Kode Customer</label>
						<input type="hidden" name="customer_id" value="<?= $customer_item->customer_id; ?>">
						<input type="text" class="form-control form-control-user" value="<?= $customer_item->customer_kode; ?>" disabled>
						<input type="hidden" name="customer_kode" class="form-control" id="customer_kode" value="<?= $customer_item->customer_kode; ?>">
					</div>
					<div class="form-group">
						<label for="customer_nama"> Nama Customer</label>
						<input type="text" name="customer_nama" class="form-control form-control-user" id="customer_nama" value="<?= $customer_item->customer_nama; ?>">
						<?= form_error('customer_nama', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<div class="form-group">
						<label for="customer_alamat"> Alamat Customer</label>
						<textarea type="text" name="customer_alamat" class="form-control" id="customer_alamat"><?= $customer_item->customer_alamat; ?></textarea>
						<?= form_error('customer_alamat', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<a href="<?= base_url("customer") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
					<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
