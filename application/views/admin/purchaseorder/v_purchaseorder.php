<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<h3><?= $title ?></h3>
	<div class="card">
		<div class="card-body">
			<?= form_open('purchaseorder'); ?>
			<div class="row">
				<div class="col">
					<label>Period Start</label>
					<input type="date" class="form-control" name="start_order_date" id="inputStartDate">
				</div>
				<div class="col">
					<label>Period End</label>
					<input type="date" class="form-control" name="end_order_date" id="inputEndDate">
				</div>
			</div>
			<input type="submit" class="btn btn-primary btn-sm my-3" value="Filter">
			<?= form_close(); ?>
			<a href="" class="btn btn-success btn-sm mb-3" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Purchase Order</a>
			<div class="table-responsive">
				<table class="table table-bordered table-hover mb-5" id="dataMenu">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Tanggal PO</th>
							<th class="text-center">Kode PO</th>
							<th class="text-center">Customer</th>
							<!-- <th class="text-center">Product</th> -->
							<th class="text-center">Name</th>
							<th class="text-center">Model</th>
							<th class="text-center">Part</th>
							<th class="text-center">Total PO</th>
							<th class="text-center">Stock-Op. Semi</th>
							<th class="text-center">Stock-Op. Finish</th>
							<th class="text-center">Prod. Remain</th>
							<?php if ($user->user_role == 1 || $user->user_role == 2){?>	
								<th class="text-center">Aksi</th>
							<?php }?>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($list_purchaseorder as $item) { ?>
							<tr>
								<td class="text-center"><?= $no++; ?></td>
								<td class="text-center"><?= date('d/m/Y', strtotime($item->purchaseorder_tanggal)) ?></td>
								<td class="text-center"><?= $item->purchaseorder_kode; ?></td>
								<td class="text-center"><?= $item->customer_kode; ?></td>
								<!-- <td class="text-center"><?= $item->product_kode; ?></td> -->
								<td class="text-center"><?= $item->category_nama; ?></td>
								<td class="text-center"><?= $item->model_kode; ?></td>
								<td class="text-center"><?= $item->part_kode; ?></td>
								<td class="text-center"><?= $item->purchaseorder_jumlah; ?></td>
								<td class="text-center"><?= $item->purchaseorder_stockopnamesemi; ?></td>
								<td class="text-center"><?= $item->purchaseorder_stockopnamefinish; ?></td>
								<td class="text-center"><?= $item->purchaseorder_remain; ?></td>
								<?php if ($user->user_role == 1 || $user->user_role == 2){?>		
									<td class="text-center">
										<div class="form-group card ">
											<a href="<?= base_url('view_purchaseorder_edit/' . $item->purchaseorder_id); ?>" class="btn btn-light btn-sm"><i class="fa fa-edit"></i> Edit</a>
										</div>
										<div class="form-group card ">
											<a href="<?= base_url('process_purchaseorder_delete/' . $item->purchaseorder_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?')"><i class="fa fa-trash"></i> Hapus</a>
										</div>
									</td>
								<?php }?>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>

<?php
$kode = $total_purchaseorder + 1;
//Support KodeTambah
if ($kode <= 9) {
	$kodeTambah = "000";
} else if ($kode <= 99) {
	$kodeTambah = "00";
} else if ($kode <= 1000) {
	$kodeTambah = "0";
} else if ($kode <= 10000) {
	$kodeTambah = "";
}
?>
<div class="modal fade" id="add">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5>Tambah Purchase Order</h5>
				<button type="button" data-dismiss="modal" class="close">&times;</button>
			</div>
			<div class="modal-body">
				<?= form_open('purchaseorder'); ?>
				<div class="form-group">
					<label for="purchaseorder_kode"> Kode Purchase Order</label>
					<input type="text" name="purchaseorder_kode" class="form-control" id="purchaseorder_kode" placeholder="Masukan kode PO Delivery" value="<?= "PO-" . date('Ymd') . $kodeTambah . $kode ?>" disabled>
					<input type="hidden" name="purchaseorder_kode" class="form-control" id="purchaseorder_kode" placeholder="Masukan kode PO Delivery" value="<?= "PO-" . date('Ymd') . $kodeTambah . $kode ?>">
					<?= form_error('purchaseorder_kode', '<small class="text-danger" ><b>', '</b></small>') ?>
				</div>
				<div class="form-group">
					<label for="purchaseorder_tanggal"> Tanggal Purchase Order</label>
					<input type="date" name="purchaseorder_tanggal" class="form-control form-control-user" id="purchaseorder_tanggal" placeholder="Masukan tanggal PO Delivery" value="<?= set_value('purchaseorder_tanggal'); ?>" required>
					<?= form_error('purchaseorder_tanggal', '<small class="text-danger" ><b>', '</b></small>') ?>
				</div>
				<div class="form-group">
					<label>Customer</label>
					<input type="text" id="searchCustomer" class="form-control" placeholder="Masukan kode customer ..." autocomplete="off">
					<input type="hidden" name="customer_id" id="customerId">
					<div class="data-search-customer d-none" id="resultCustomer"></div>
				</div>
				<div class="form-group">
					<label>Product</label>
					<input type="text" id="searchProduct" class="form-control" placeholder="Masukan part code product ..." autocomplete="off">
					<input type="hidden" name="product_id" id="productId">
					<div class="data-search-product d-none" id="resultProduct"></div>
				</div>
				<div class="form-group">
					<label for="purchaseorder_jumlah"> Total Purchase Order</label>
					<input type="number" name="purchaseorder_jumlah" class="form-control form-control-user" id="purchaseorder_jumlah" placeholder="Masukan jumlah Purchase Order" value="<?= set_value('purchaseorder_jumlah'); ?>" required>
					Jika tidak perlu masukkan nilai nol "0".
					<?= form_error('purchaseorder_jumlah', '<small class="text-danger" ><b>', '</b></small>') ?>
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

<!-- Searching Customer -->
<script>
	function addCustomer(customerNama, customerId) {
		$("#searchCustomer").val(customerNama);
		$("#customerId").val(customerId);
	};
	$(document).ready(function() {
		$("#searchCustomer").on("keyup", function() {
			let searchCustomer = $("#searchCustomer").val();
			$.ajax({
				url: "<?php echo base_url("search_customer"); ?>",
				type: "POST",
				data: {
					keyword: searchCustomer
				},
				cache: false,
				success: function(result) {
					$("#resultCustomer").removeClass("d-none");
					$("#resultCustomer").html(result);
				}
			});
		})
		$("#searchCustomer").on("blur", function() {
			window.setTimeout(function() {
				$("#resultCustomer").addClass("d-none");
			}, 200)
		})
	})
</script>

<!-- Searching Product -->
<script>
	function addProduct(productNama, productId) {
		$("#searchProduct").val(productNama);
		$("#productId").val(productId);
	};
	$(document).ready(function() {
		$("#searchProduct").on("keyup", function() {
			let searchProduct = $("#searchProduct").val();
			$.ajax({
				url: "<?php echo base_url("search_product"); ?>",
				type: "POST",
				data: {
					keyword: searchProduct
				},
				cache: false,
				success: function(result) {
					$("#resultProduct").removeClass("d-none");
					$("#resultProduct").html(result);
				}
			});
		})
		$("#searchProduct").on("blur", function() {
			window.setTimeout(function() {
				$("#resultProduct").addClass("d-none");
			}, 200)
		})
	})
</script>
