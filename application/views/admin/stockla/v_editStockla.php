<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_stockla_edit'); ?>
					<div class="form-group">
						<label for="stockla_kode"> Kode Stock Loading Area</label>
						<input type="hidden" name="stockla_id" class="form-control" id="stockla_id" value="<?= $stockla_item->stockla_id; ?>">
						<input type="text" name="stockla_kode" class="form-control" id="stockla_kode" placeholder="Masukan kode Stock Loading Area" value="<?= $stockla_item->stockla_kode; ?>" disabled>
						<input type="hidden" name="stockla_kode" class="form-control" id="stockla_kode" placeholder="Masukan kode Stock Loading Area" value="<?= $stockla_item->stockla_kode; ?>">
						<?= form_error('stockla_kode', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<div class="form-group">
						<label> Purchase Order</label>
						<?php foreach ($list_purchaseorder as $item) {
							if ($item->purchaseorder_id == $stockla_item->purchaseorder_id) { ?>
								<input type="text" id="searchPurchaseorder" class="form-control" placeholder="Masukan kode purchase order ..." autocomplete="off" value="<?= $item->purchaseorder_kode; ?>">
								<input type="hidden" name="purchaseorder_id" id="purchaseorderId" value="<?= $item->purchaseorder_id; ?>">
								<div class="data-search-purchaseorder d-none" id="resultPurchaseorder" value="<?= $item->purchaseorder_id; ?>"></div>
							<?php } ?>
						<?php } ?>
					</div>
					<div class="form-group">
						<label for="stockla_semi"> Semi Stock Loading Area</label>
						<input type="number" name="stockla_semi" class="form-control form-control-user" id="stockla_semi" placeholder="Masukan semi Stock Loading Area" value="<?= $stockla_item->stockla_semi; ?>" required>
						Jika tidak perlu masukkan nilai nol "0".
						<?= "<br>" . form_error('stockla_semi', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<div class="form-group">
						<label for="stockla_finish"> Finish Stock Loading Area</label>
						<input type="number" name="stockla_finish" class="form-control form-control-user" id="stockla_finish" placeholder="Masukan finish Stock Loading Area" value="<?= $stockla_item->stockla_finish; ?>" required>
						Jika tidak perlu masukkan nilai nol "0".
						<?= "<br>" . form_error('stockla_finish', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<a href="<?= base_url("stockla") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
					<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
					<?= form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Searching Purchase Order -->
<script>
	function addPurchaseorder(purchaseorderNama, purchaseorderId) {
		$("#searchPurchaseorder").val(purchaseorderNama);
		$("#purchaseorderId").val(purchaseorderId);
	};
	$(document).ready(function() {
		$("#searchPurchaseorder").on("keyup", function() {
			let searchPurchaseorder = $("#searchPurchaseorder").val();
			$.ajax({
				url: "<?php echo base_url("search_purchaseorder"); ?>",
				type: "POST",
				data: {
					keyword: searchPurchaseorder
				},
				cache: false,
				success: function(result) {
					$("#resultPurchaseorder").removeClass("d-none");
					$("#resultPurchaseorder").html(result);
				}
			});
		})
		$("#searchPurchaseorder").on("blur", function() {
			window.setTimeout(function() {
				$("#resultPurchaseorder").addClass("d-none");
			}, 200)
		})
	})
</script>
