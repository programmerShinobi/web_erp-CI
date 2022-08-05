<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_delivery_edit'); ?>
					<div class="form-group">
						<label for="delivery_kode"> Kode Delivery</label>
						<input type="hidden" name="delivery_id" class="form-control" id="delivery_id" value="<?= $delivery_item->delivery_id; ?>">
						<input type="text" name="delivery_kode" class="form-control" id="delivery_kode" placeholder="Masukan kode Delivery" value="<?= $delivery_item->delivery_kode; ?>" disabled>
						<input type="hidden" name="delivery_kode" class="form-control" id="delivery_kode" placeholder="Masukan kode Delivery" value="<?= $delivery_item->delivery_kode; ?>">
						<?= form_error('delivery_kode', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<div class="form-group">
						<label for="delivery_tanggal"> Tanggal Delivery</label>
						<input type="date" name="delivery_tanggal" class="form-control form-control-user" id="delivery_tanggal" placeholder="Masukan tanggal Delivery" value="<?= $delivery_item->delivery_tanggal; ?>" required>
						<?= "<br>" . form_error('delivery_tanggal', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<div class="form-group">
						<label> Purchase Order</label>
						<?php foreach ($list_purchaseorder as $item) {
							if ($item->purchaseorder_id == $delivery_item->purchaseorder_id) { ?>
								<input type="text" id="searchPurchaseorder" class="form-control" placeholder="Masukan kode purchase order ..." autocomplete="off" value="<?= $item->purchaseorder_kode; ?>">
								<input type="hidden" name="purchaseorder_id" id="purchaseorderId" value="<?= $item->purchaseorder_id; ?>">
								<div class="data-search-purchaseorder d-none" id="resultPurchaseorder" value="<?= $item->purchaseorder_id; ?>"></div>
							<?php } ?>
						<?php } ?>
					</div>
					<div class="form-group">
						<label for="delivery_hasil"> Hasil Delivery</label>
						<input type="number" name="delivery_hasil" class="form-control form-control-user" id="delivery_hasil" placeholder="Masukan hasil Delivery" value="<?= $delivery_item->delivery_hasil; ?>" required>
						Jika tidak perlu masukkan nilai nol "0".
						<?= "<br>" . form_error('delivery_hasil', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<!-- <div class="form-group">
						<label for="delivery_plan"> Plan Delivery</label>
						<input type="number" name="delivery_plan" class="form-control form-control-user" id="delivery_plan" placeholder="Masukan plan Delivery" value="<?= $delivery_item->delivery_plan; ?>" required>
						Jika tidak perlu masukkan nilai nol "0".
						<?= "<br>" . form_error('delivery_plan', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div> -->
					<!-- <div class="form-group">
						<label for="delivery_balance"> Balance Delivery</label>
						<input type="text" name="delivery_balance" class="form-control form-control-user" id="delivery_balance" placeholder="Masukan balance Delivery" value="<?= $delivery_item->delivery_balance; ?>" required>
						Jika tidak perlu masukkan simbol strip "-".
						<?= "<br>" . form_error('delivery_balance', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div> -->
					<!-- <div class="form-group">
						<label for="delivery_remark"> Remark Delivery</label>
						<input type="text" name="delivery_remark" class="form-control form-control-user" id="delivery_remark" placeholder="Masukan remark Delivery" value="<?= $delivery_item->delivery_remark; ?>" required>
						Jika tidak perlu masukkan simbol strip "-".
						<?= "<br>" . form_error('delivery_remark', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div> -->
					<a href="<?= base_url("delivery") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
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
