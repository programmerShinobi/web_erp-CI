<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_plan2nd_edit'); ?>
					<div class="form-group">
						<label for="plan2nd_kode"> Kode Plan 2nd</label>
						<input type="hidden" name="plan2nd_id" class="form-control" id="plan2nd_id" value="<?= $plan2nd_item->plan2nd_id; ?>">
						<input type="text" name="plan2nd_kode" class="form-control" id="plan2nd_kode" placeholder="Masukan kode Plan 2nd" value="<?= $plan2nd_item->plan2nd_kode; ?>" disabled>
						<input type="hidden" name="plan2nd_kode" class="form-control" id="plan2nd_kode" placeholder="Masukan kode Plan 2nd" value="<?= $plan2nd_item->plan2nd_kode; ?>">
						<?= form_error('plan2nd_kode', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<div class="form-group">
						<label> Purchase Order</label>
						<?php foreach ($list_purchaseorder as $item) {
							if ($item->purchaseorder_id == $plan2nd_item->purchaseorder_id) { ?>
								<input type="text" id="searchPurchaseorder" class="form-control" placeholder="Masukan kode purchase order ..." autocomplete="off" value="<?= $item->purchaseorder_kode; ?>">
								<input type="hidden" name="purchaseorder_id" id="purchaseorderId" value="<?= $item->purchaseorder_id; ?>">
								<div class="data-search-purchaseorder d-none" id="resultPurchaseorder" value="<?= $item->purchaseorder_id; ?>"></div>
							<?php } ?>
						<?php } ?>
					</div>
					<div class="form-group">
						<label for="plan2nd_hasil"> Hasil Plan 2nd</label>
						<input type="number" name="plan2nd_hasil" class="form-control form-control-user" id="plan2nd_hasil" placeholder="Masukan hasil plan 2nd" value="<?= $plan2nd_item->plan2nd_hasil; ?>" required>
						Jika tidak perlu masukkan nilai nol "0".
						<?= "<br>" . form_error('plan2nd_hasil', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<!-- <div class="form-group">
						<label for="plan2nd_plan"> Plan 2nd</label>
						<input type="text" name="plan2nd_plan" class="form-control form-control-user" id="plan2nd_plan" placeholder="Masukan plan 2nd" value="<?= $plan2nd_item->plan2nd_plan; ?>" required>
						Jika tidak perlu masukkan simbol strip "-".
						<?= "<br>" . form_error('plan2nd_plan', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div> -->
					<a href="<?= base_url("plan2nd") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
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
