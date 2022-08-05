<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_planprinting_edit'); ?>
					<div class="form-group">
						<label for="planprinting_kode"> Kode Plan Printing</label>
						<input type="hidden" name="planprinting_id" class="form-control" id="planprinting_id" value="<?= $planprinting_item->planprinting_id; ?>">
						<input type="text" name="planprinting_kode" class="form-control" id="planprinting_kode" placeholder="Masukan kode Plan printing" value="<?= $planprinting_item->planprinting_kode; ?>" disabled>
						<input type="hidden" name="planprinting_kode" class="form-control" id="planprinting_kode" placeholder="Masukan kode Plan printing" value="<?= $planprinting_item->planprinting_kode; ?>">
						<?= form_error('planprinting_kode', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<div class="form-group">
						<label> Purchase Order</label>
						<?php foreach ($list_purchaseorder as $item) {
							if ($item->purchaseorder_id == $planprinting_item->purchaseorder_id) { ?>
								<input type="text" id="searchPurchaseorder" class="form-control" placeholder="Masukan kode purchase order ..." autocomplete="off" value="<?= $item->purchaseorder_kode; ?>">
								<input type="hidden" name="purchaseorder_id" id="purchaseorderId" value="<?= $item->purchaseorder_id; ?>">
								<div class="data-search-purchaseorder d-none" id="resultPurchaseorder" value="<?= $item->purchaseorder_id; ?>"></div>
							<?php } ?>
						<?php } ?>
					</div>
					<div class="form-group">
						<label for="planprinting_hasil"> Hasil Plan Printing</label>
						<input type="number" name="planprinting_hasil" class="form-control form-control-user" id="planprinting_hasil" placeholder="Masukan hasil plan printing" value="<?= $planprinting_item->planprinting_hasil; ?>" required>
						Jika tidak perlu masukkan nilai nol "0".
						<?= "<br>" . form_error('planprinting_hasil', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div>
					<!-- <div class="form-group">
						<label for="planprinting_stok"> Stok Plan Printing</label>
						<input type="number" name="planprinting_stok" class="form-control form-control-user" id="planprinting_stok" placeholder="Masukan stok plan printing" value="<?= $planprinting_item->planprinting_stok; ?>" required>
						Jika tidak perlu masukkan nilai nol "0".
						<?= "<br>" . form_error('planprinting_stok', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div> -->
					<!-- <div class="form-group">
						<label for="planprinting_plan"> Plan Plan Printing</label>
						<input type="text" name="planprinting_plan" class="form-control form-control-user" id="planprinting_plan" placeholder="Masukan plan printing" value="<?= $planprinting_item->planprinting_plan; ?>" required>
						Jika tidak perlu masukkan simbol strip "-".
						<?= "<br>" . form_error('planprinting_plan', '<small class="text-danger" ><b>', '</b></small>') ?>
					</div> -->
					<a href="<?= base_url("planprinting") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
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
