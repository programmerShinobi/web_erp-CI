<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<h3><?= $title ?></h3>
	<div class="card">
		<div class="card-body">
			<?= form_open('planinjection'); ?>
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
			<a href="" class="btn btn-success btn-sm mb-3" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Plan Injection</a>
			<div class="table-responsive">
				<table class="table table-bordered table-hover mb-5" id="dataMenu">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Tanggal PO</th>
							<!-- <th class="text-center">Kode</th> -->
							<th class="text-center">Kode PO</th>
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
						foreach ($list_planinjection as $item) { ?>
							<tr>
								<td class="text-center"><?= $no++; ?></td>
								<td class="text-center"><?= date('d/m/Y', strtotime($item->purchaseorder_tanggal)) ?></td>
								<!-- <td class="text-center"><?= $item->planinjection_kode; ?></td> -->
								<td class="text-center"><?= $item->purchaseorder_kode; ?></td>
								<td class="text-center"><?= $item->category_nama; ?></td>
								<td class="text-center"><?= $item->model_kode; ?></td>
								<td class="text-center"><?= $item->part_kode; ?></td>
								<td class="text-center"><?= $item->planinjection_hasil; ?></td>
								<td class="text-center"><?= $item->planinjection_remain; ?></td>
								<td class="text-center">
									<div class="form-group card ">
										<a href="<?= base_url('view_planinjection_edit/' . $item->planinjection_id); ?>" class="btn btn-light btn-sm"><i class="fa fa-edit"></i> Edit</a>
									</div>
									<div class="form-group card ">
										<a href="<?= base_url('process_planinjection_delete/' . $item->planinjection_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?')"><i class="fa fa-trash"></i> Hapus</a>
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
$kode = $total_planinjection + 1;
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
				<h5>Tambah Plan Injection</h5>
				<button type="button" data-dismiss="modal" class="close">&times;</button>
			</div>
			<div class="modal-body">
				<?= form_open('planinjection'); ?>
				<div class="form-group">
					<label for="planinjection_kode"> Kode Plan Injection</label>
					<input type="text" name="planinjection_kode" class="form-control" id="planinjection_kode" value="<?= "PI-" . date('Ymd') . $kodeTambah . $kode ?>" disabled>
					<input type="hidden" name="planinjection_kode" class="form-control" id="planinjection_kode" value="<?= "PI-" . date('Ymd') . $kodeTambah . $kode ?>">
					<?= form_error('planinjection_kode', '<small class="text-danger" ><b>', '</b></small>') ?>
				</div>
				<div class="form-group">
					<label> Purchase Order</label>
					<input type="text" id="searchPurchaseorder" class="form-control" placeholder="Masukan kode Purchase Order ..." autocomplete="off">
					<input type="hidden" name="purchaseorder_id" id="purchaseorderId">
					<div class="data-search-purchaseorder d-none" id="resultPurchaseorder"></div>
					<?= form_error('purchaseorder_id', '<small class="text-danger" ><b>', '</b></small>') ?>
				</div>
				<div class="form-group">
					<label for="planinjection_hasil"> Hasil Plan Injection</label>
					<input type="number" name="planinjection_hasil" class="form-control form-control-user" id="planinjection_hasil" placeholder="Masukan hasil plan injection" value="<?= set_value('planinjection_hasil'); ?>" required>
					Jika tidak perlu masukkan nilai nol "0".
					<?= form_error('planinjection_hasil', '<small class="text-danger" ><b>', '</b></small>') ?>
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
