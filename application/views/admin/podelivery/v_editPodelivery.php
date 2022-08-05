<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_podelivery_edit'); ?>
					<div class="form-group">
						<label for="podelivery_kode"> Kode PO - Delivery</label>
						<input type="hidden" name="podelivery_id" class="form-control" id="podelivery_id" value="<?= $podelivery_item->podelivery_id; ?>">
						<input type="text" name="podelivery_kode" class="form-control" id="podelivery_kode" placeholder="Masukan kode PO Delivery" value="<?= $podelivery_item->podelivery_kode; ?>" disabled>
						<input type="hidden" name="podelivery_kode" class="form-control" id="podelivery_kode" placeholder="Masukan kode PO Delivery" value="<?= $podelivery_item->podelivery_kode; ?>">
						<?= form_error('podelivery_kode', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<div class="form-group">
						<label> Purchase Order</label>
						<?php foreach ($list_purchaseorder as $item) {
							if ($item->purchaseorder_id == $podelivery_item->purchaseorder_id) { ?>
								<input type="text" id="searchPurchaseorder" class="form-control" placeholder="Masukan kode Purchase Order ..." autocomplete="off" value="<?= $item->purchaseorder_kode; ?>">
								<input type="hidden" name="purchaseorder_id" id="purchaseorderId" value="<?= $item->purchaseorder_id; ?>">
								<div class="data-search-purchaseorder d-none" id="resultPurchaseorder" value="<?= $item->purchaseorder_id; ?>"></div>
							<?php } ?>
						<?php } ?>
					</div>
					<div class="form-group">
						<label for="podelivery_hasil"> Hasil Delivery</label>
						<input type="number" name="podelivery_hasil" class="form-control form-control-user" id="podelivery_hasil" placeholder="Masukan hasil Purchase Order" value="<?= $podelivery_item->podelivery_hasil; ?>" required>
						Jika tidak perlu masukkan nilai nol "0".
						<?= "<br>".form_error('podelivery_hasil', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<div class="form-group">
						<label for="podelivery_remain"> Remain Delivery</label>
						<input type="number" name="podelivery_remain" class="form-control form-control-user" id="podelivery_remain" placeholder="Masukan remain Purchase Order" value="<?= $podelivery_item->podelivery_remain; ?>" required>
						Jika tidak perlu masukkan nilai nol "0".
						<?= "<br>".form_error('podelivery_remain', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<a href="<?= base_url("podelivery") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
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
