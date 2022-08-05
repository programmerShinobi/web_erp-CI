<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<h3><?= $title ?></h3>
	<div class="card">
		<div class="card-body">
			<?= form_open('planprinting'); ?>
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
			<a href="" class="btn btn-success btn-sm mb-3" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Plan printing</a>
			<div class="table-responsive">
				<table class="table table-bordered table-hover mb-5" id="dataMenu">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Tanggal PO</th>
							<!-- <th class="text-center">Kode</th> -->
							<th class="text-center">Kode PO</th>
							<th class="text-center">Customer</th>
							<th class="text-center">Name</th>
							<th class="text-center">Model</th>
							<th class="text-center">Part</th>
							<th class="text-center">Hasil </th>
							<th class="text-center">Remain </th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($list_planprinting as $item) { ?>
							<tr>
								<td class="text-center"><?= $no++; ?></td>
								<td class="text-center"><?= date('d/m/Y', strtotime($item->purchaseorder_tanggal)) ?></td>
								<!-- <td class="text-center"><?= $item->planprinting_kode; ?></td> -->
								<td class="text-center"><?= $item->purchaseorder_kode; ?></td>
								<td class="text-center"><?= $item->customer_kode; ?></td>
								<td class="text-center"><?= $item->category_nama; ?></td>
								<td class="text-center"><?= $item->model_kode; ?></td>
								<td class="text-center"><?= $item->part_kode; ?></td>
								<td class="text-center"><?= $item->planprinting_hasil; ?></td>
								<td class="text-center"><?= $item->planprinting_remain; ?></td>
								<td class="text-center">
									<div class="form-group card ">
										<a href="<?= base_url('view_planprinting_edit/' . $item->planprinting_id); ?>" class="btn btn-light btn-sm"><i class="fa fa-edit"></i> Edit</a>
									</div>
									<div class="form-group card ">
										<a href="<?= base_url('process_planprinting_delete/' . $item->planprinting_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?')"><i class="fa fa-trash"></i> Hapus</a>
									</div>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>

<?php
$kode = $total_planprinting + 1;
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
				<h5>Tambah Plan printing</h5>
				<button type="button" data-dismiss="modal" class="close">&times;</button>
			</div>
			<div class="modal-body">
				<?= form_open('planprinting'); ?>
				<div class="form-group">
					<label for="planprinting_kode"> Kode Plan Printing</label>
					<input type="text" name="planprinting_kode" class="form-control" id="planprinting_kode" value="<?= "PP-" . date('Ymd') . $kodeTambah . $kode ?>" disabled>
					<input type="hidden" name="planprinting_kode" class="form-control" id="planprinting_kode" value="<?= "PP-" . date('Ymd') . $kodeTambah . $kode ?>">
					<?= form_error('planprinting_kode', '<small class="text-danger" ><b>', '</b></small>') ?>
				</div>
				<div class="form-group">
					<label> Purchase Order</label>
					<input type="text" id="searchPurchaseorder" class="form-control" placeholder="Masukan kode Purchase Order ..." autocomplete="off">
					<input type="hidden" name="purchaseorder_id" id="purchaseorderId">
					<div class="data-search-purchaseorder d-none" id="resultPurchaseorder"></div>
					<?= form_error('purchaseorder_id', '<small class="text-danger" ><b>', '</b></small>') ?>
				</div>
				<div class="form-group">
					<label for="planprinting_hasil"> Hasil Plan Printing</label>
					<input type="number" name="planprinting_hasil" class="form-control form-control-user" id="planprinting_hasil" placeholder="Masukan hasil plan printing" value="<?= set_value('planprinting_hasil'); ?>" required>
					Jika tidak perlu masukkan nilai nol "0".
					<?= form_error('planprinting_hasil', '<small class="text-danger" ><b>', '</b></small>') ?>
				</div>
				<!-- <div class="form-group">
					<label for="planprinting_stok"> Stok Plan Printing</label>
					<input type="number" name="planprinting_stok" class="form-control form-control-user" id="planprinting_stok" placeholder="Masukan stok plan printing" value="<?= set_value('planprinting_stok'); ?>" required>
					Jika tidak perlu masukkan nilai nol "0".
					<?= form_error('planprinting_stok', '<small class="text-danger" ><b>', '</b></small>') ?>
				</div> -->
				<!-- <div class="form-group">
					<label for="planprinting_plan"> Plan Printing</label>
					<input type="text" name="planprinting_plan" class="form-control form-control-user" id="planprinting_plan" placeholder="Masukan plan printing" value="<?= set_value('planprinting_plan'); ?>" required>
					Jika tidak perlu masukkan simbol strip "-".
					<?= form_error('planprinting_plan', '<small class="text-danger" ><b>', '</b></small>') ?>
				</div> -->
				<input type="submit" value="Simpan" class="btn btn-success btn-sm">
				<?= form_close(); ?>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-danger btn-sm">Close</button>
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
