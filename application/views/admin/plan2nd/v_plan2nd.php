<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<h3><?= $title ?></h3>
	<div class="card">
		<div class="card-body">
			<?= form_open('plan2nd'); ?>
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
			<a href="" class="btn btn-success btn-sm mb-3" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Plan 2nd</a>
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
						foreach ($list_plan2nd as $item) { ?>
							<tr>
								<td class="text-center"><?= $no++; ?></td>
								<td class="text-center"><?= date('d/m/Y', strtotime($item->purchaseorder_tanggal)) ?></td>
								<!-- <td class="text-center"><?= $item->plan2nd_kode; ?></td> -->
								<td class="text-center"><?= $item->purchaseorder_kode; ?></td>
								<td class="text-center"><?= $item->category_nama; ?></td>
								<td class="text-center"><?= $item->model_kode; ?></td>
								<td class="text-center"><?= $item->part_kode; ?></td>
								<td class="text-center"><?= $item->plan2nd_hasil; ?></td>
								<td class="text-center"><?= $item->plan2nd_remain; ?></td>
								<td class="text-center">
									<div class="form-group card ">
										<a href="<?= base_url('view_plan2nd_edit/' . $item->plan2nd_id); ?>" class="btn btn-light btn-sm"><i class="fa fa-edit"></i> Edit</a>
									</div>
									<div class="form-group card ">
										<a href="<?= base_url('process_plan2nd_delete/' . $item->plan2nd_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?')"><i class="fa fa-trash"></i> Hapus</a>
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
$kode = $total_plan2nd + 1;
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
				<h5>Tambah Plan 2nd</h5>
				<button type="button" data-dismiss="modal" class="close">&times;</button>
			</div>
			<div class="modal-body">
				<?= form_open('plan2nd'); ?>
				<div class="form-group">
					<label for="plan2nd_kode"> Kode Plan 2nd</label>
					<input type="text" name="plan2nd_kode" class="form-control" id="plan2nd_kode" value="<?= "PI-" . date('Ymd') . $kodeTambah . $kode ?>" disabled>
					<input type="hidden" name="plan2nd_kode" class="form-control" id="plan2nd_kode" value="<?= "PI-" . date('Ymd') . $kodeTambah . $kode ?>">
					<?= form_error('plan2nd_kode', '<small class="text-danger" ><b>', '</b></small>') ?>
				</div>
				<div class="form-group">
					<label> Purchase Order</label>
					<input type="text" id="searchPurchaseorder" class="form-control" placeholder="Masukan kode Purchase Order ..." autocomplete="off">
					<input type="hidden" name="purchaseorder_id" id="purchaseorderId">
					<div class="data-search-purchaseorder d-none" id="resultPurchaseorder"></div>
					<?= form_error('purchaseorder_id', '<small class="text-danger" ><b>', '</b></small>') ?>
				</div>
				<div class="form-group">
					<label for="plan2nd_hasil"> Hasil Plan 2nd</label>
					<input type="number" name="plan2nd_hasil" class="form-control form-control-user" id="plan2nd_hasil" placeholder="Masukan hasil plan 2nd" value="<?= set_value('plan2nd_hasil'); ?>" required>
					Jika tidak perlu masukkan nilai nol "0".
					<?= form_error('plan2nd_hasil', '<small class="text-danger" ><b>', '</b></small>') ?>
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
