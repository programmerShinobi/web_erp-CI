<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_purchaseorder_edit'); ?>
					<div class="form-group">
						<label for="purchaseorder_kode"> Kode Purchase Order</label>
						<input type="hidden" name="purchaseorder_id" class="form-control" id="purchaseorder_id" value="<?= $purchaseorder_item->purchaseorder_id; ?>">
						<input type="text" name="purchaseorder_kode" class="form-control" id="purchaseorder_kode" value="<?= $purchaseorder_item->purchaseorder_kode; ?>" disabled>
						<input type="hidden" name="purchaseorder_kode" class="form-control" id="purchaseorder_kode" value="<?= $purchaseorder_item->purchaseorder_kode; ?>">
					</div>
					<div class="form-group">
						<label for="purchaseorder_tanggal"> Tanggal Purchase Order</label>
						<input type="date" name="purchaseorder_tanggal" class="form-control form-control-user" id="purchaseorder_tanggal" placeholder="Masukan tanggal Purchase Order" value="<?= $purchaseorder_item->purchaseorder_tanggal; ?>" required>
						<?= form_error('purchaseorder_tanggal', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<div class="form-group">
						<label>Customer</label>
						<?php foreach ($list_customer as $item) {
							if ($item->customer_id == $purchaseorder_item->customer_id) { ?>
								<input type="text" id="searchCustomer" class="form-control" placeholder="Masukan kode customer ..." autocomplete="off" value="<?= $item->customer_kode; ?>">
								<input type="hidden" name="customer_id" id="customerId" value="<?= $item->customer_id; ?>">
								<div class="data-search-customer d-none" id="resultCustomer" value="<?= $item->customer_id; ?>"></div>
							<?php } ?>
						<?php } ?>
					</div>
					<div class="form-group">
						<label>Product</label>
						<?php foreach ($list_product as $item) {
							if ($item->product_id == $purchaseorder_item->product_id) { ?>
								<input type="text" id="searchProduct" class="form-control" placeholder="Masukan part code product ..." autocomplete="off" value="<?= $item->part_kode; ?>">
								<input type="hidden" name="product_id" id="productId" value="<?= $item->product_id; ?>">
								<div class="data-search-product d-none" id="resultProduct" value="<?= $item->product_id; ?>"></div>
							<?php } ?>
						<?php } ?>
					</div>
					<div class="form-group">
						<label for="purchaseorder_jumlah"> Total Purchase Order</label>
						<input type="number" name="purchaseorder_jumlah" class="form-control form-control-user" id="purchaseorder_jumlah" placeholder="Masukan Jumlah Purchase Order" value="<?= $purchaseorder_item->purchaseorder_jumlah; ?>" required>
						Jika tidak perlu masukkan nilai nol "0".
						<?= form_error('purchaseorder_jumlah', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<div class="form-group">
						<label for="purchaseorder_stockopnamesemi"> Stock Opname Semi</label>
						<input type="number" name="purchaseorder_stockopnamesemi" class="form-control form-control-user" id="purchaseorder_stockopnamesemi" placeholder="Masukan Stock Opname Semi Purchase Order" value="<?= $purchaseorder_item->purchaseorder_stockopnamesemi; ?>" required>
						Jika tidak perlu masukkan nilai nol "0".
						<?= form_error('purchaseorder_stockopnamesemi', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<div class="form-group">
						<label for="purchaseorder_stockopnamefinish"> Stock Opname Finsih</label>
						<input type="number" name="purchaseorder_stockopnamefinish" class="form-control form-control-user" id="purchaseorder_stockopnamefinish" placeholder="Masukan stockopnamefinish Purchase Order" value="<?= $purchaseorder_item->purchaseorder_stockopnamefinish; ?>" required>
						Jika tidak perlu masukkan nilai nol "0".
						<?= form_error('purchaseorder_stockopnamefinish', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<a href="<?= base_url("purchaseorder") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
					<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
					<?= form_close(); ?>
				</div>
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
