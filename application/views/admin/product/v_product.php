<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<h3><?= $title ?></h3>
	<div class="card">
		<div class="card-body">
			<a href="" class="btn btn-success btn-sm mb-3" data-toggle="modal" data-target="#add"><i class="fa fa-plus"></i> Tambah Product</a>
			<div class="table-responsive">
				<table class="table table-bordered table-hover mb-5" id="dataMenu">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Kode</th>
							<th class="text-center">Model</th>
							<th class="text-center">Part Code</th>
							<th class="text-center">Nama</th>
							<th class="text-center">Tool</th>
							<th class="text-center">Hole</th>
							<th class="text-center">Colour</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($list_product as $item) { ?>
							<tr>
								<td class="text-center"><?= $no++; ?></td>
								<td class="text-center"><?= $item->product_kode; ?></td>
								<td class="text-center"><?= $item->model_kode; ?></td>
								<td class="text-center"><?= $item->part_kode; ?></td>
								<td class="text-center"><?= $item->category_nama; ?></td>
								<td class="text-center"><?= $item->tool_kode; ?></td>
								<td class="text-center"><?= $item->hole_nama; ?></td>
								<td class="text-center"><?= $item->colour_nama; ?></td>
								<td class="text-center">
									<div class="form-group card ">
										<a href="<?= base_url('view_product_edit/' . $item->product_id); ?>" class="btn btn-light btn-sm"><i class="fa fa-edit"></i> Edit</a>
									</div>
									<div class="form-group card ">
										<a href="<?= base_url('process_product_delete/' . $item->product_id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin menghapus data?')"><i class="fa fa-trash"></i> Hapus</a>
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
$kode = $total_product + 1;
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
				<h5>Tambah Product</h5>
				<button type="button" data-dismiss="modal" class="close">&times;</button>
			</div>
			<div class="modal-body">
				<?= form_open('product'); ?>
				<div class="form-group">
					<label for="product_kode"> Kode Product</label>
					<input type="text" class="form-control form-control-user" value="<?php echo "PD-" . $kodeTambah . $kode; ?>" disabled>
					<input type="hidden" name="product_kode" class="form-control" id="product_kode" placeholder="Masukan kode product" value="<?= "PD-" . $kodeTambah . $kode; ?>" required>
				</div>
				<div class="form-group">
					<label>Model</label>
					<input type="text" id="searchModel" class="form-control" placeholder="Masukan kode model ..." autocomplete="off">
					<input type="hidden" name="model_id" id="modelId">
					<div class="data-search-model d-none" id="resultModel"></div>
				</div>
				<div class="form-group">
					<label>Part</label>
					<input type="text" id="searchPart" class="form-control" placeholder="Masukan kode part ..." autocomplete="off">
					<input type="hidden" name="part_id" id="partId">
					<div class="data-search-part d-none" id="resultPart"></div>
				</div>
				<div class="form-group">
					<label>Nama</label>
					<input type="text" id="searchCategory" class="form-control" placeholder="Masukan nama category ..." autocomplete="off">
					<input type="hidden" name="category_id" id="categoryId">
					<div class="data-search-category d-none" id="resultCategory"></div>
				</div>
				<div class="form-group">
					<label>Tool</label>
					<input type="text" id="searchTool" class="form-control" placeholder="Masukan Tool ..." autocomplete="off">
					<input type="hidden" name="tool_id" id="toolId">
					<div class="data-search-tool d-none" id="resultTool"></div>
					Jika tidak perlu masukkan simbol strip "-".
				</div>
				<div class="form-group">
					<label>Hole</label>
					<input type="text" id="searchHole" class="form-control" placeholder="Masukan hole ..." autocomplete="off">
					<input type="hidden" name="hole_id" id="holeId">
					<div class="data-search-hole d-none" id="resultHole"></div>
					Jika tidak perlu masukkan simbol strip "-".
				</div>
				<div class="form-group">
					<label>Colour</label>
					<input type="text" id="searchColour" class="form-control" placeholder="Masukan kode colour ..." autocomplete="off">
					<input type="hidden" name="colour_id" id="colourId">
					<div class="data-search-colour d-none" id="resultColour"></div>
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

<!-- Searching Model -->
<script>
	function addModel(modelNama, modelId) {
		$("#searchModel").val(modelNama);
		$("#modelId").val(modelId);
	};
	$(document).ready(function() {
		$("#searchModel").on("keyup", function() {
			let searchModel = $("#searchModel").val();
			$.ajax({
				url: "<?php echo base_url("search_model"); ?>",
				type: "POST",
				data: {
					keyword: searchModel
				},
				cache: false,
				success: function(result) {
					$("#resultModel").removeClass("d-none");
					$("#resultModel").html(result);
				}
			});
		})
		$("#searchModel").on("blur", function() {
			window.setTimeout(function() {
				$("#resultModel").addClass("d-none");
			}, 200)
		})
	})
</script>

<!-- Searching Part -->
<script>
	function addPart(partNama, partId) {
		$("#searchPart").val(partNama);
		$("#partId").val(partId);
	};
	$(document).ready(function() {
		$("#searchPart").on("keyup", function() {
			let searchPart = $("#searchPart").val();
			$.ajax({
				url: "<?php echo base_url("search_part"); ?>",
				type: "POST",
				data: {
					keyword: searchPart
				},
				cache: false,
				success: function(result) {
					$("#resultPart").removeClass("d-none");
					$("#resultPart").html(result);
				}
			});
		})
		$("#searchPart").on("blur", function() {
			window.setTimeout(function() {
				$("#resultPart").addClass("d-none");
			}, 200)
		})
	})
</script>

<!-- Searching Category -->
<script>
	function addCategory(categoryNama, categoryId) {
		$("#searchCategory").val(categoryNama);
		$("#categoryId").val(categoryId);
	};
	$(document).ready(function() {
		$("#searchCategory").on("keyup", function() {
			let searchCategory = $("#searchCategory").val();
			$.ajax({
				url: "<?php echo base_url("search_category"); ?>",
				type: "POST",
				data: {
					keyword: searchCategory
				},
				cache: false,
				success: function(result) {
					$("#resultCategory").removeClass("d-none");
					$("#resultCategory").html(result);
				}
			});
		})
		$("#searchCategory").on("blur", function() {
			window.setTimeout(function() {
				$("#resultCategory").addClass("d-none");
			}, 200)
		})
	})
</script>

<!-- Searching Tool -->
<script>
	function addTool(toolNama, toolId) {
		$("#searchTool").val(toolNama);
		$("#toolId").val(toolId);
	};
	$(document).ready(function() {
		$("#searchTool").on("keyup", function() {
			let searchTool = $("#searchTool").val();
			$.ajax({
				url: "<?php echo base_url("search_tool"); ?>",
				type: "POST",
				data: {
					keyword: searchTool
				},
				cache: false,
				success: function(result) {
					$("#resultTool").removeClass("d-none");
					$("#resultTool").html(result);
				}
			});
		})
		$("#searchTool").on("blur", function() {
			window.setTimeout(function() {
				$("#resultTool").addClass("d-none");
			}, 200)
		})
	})
</script>

<!-- Searching Hole -->
<script>
	function addHole(holeNama, holeId) {
		$("#searchHole").val(holeNama);
		$("#holeId").val(holeId);
	};
	$(document).ready(function() {
		$("#searchHole").on("keyup", function() {
			let searchHole = $("#searchHole").val();
			$.ajax({
				url: "<?php echo base_url("search_hole"); ?>",
				type: "POST",
				data: {
					keyword: searchHole
				},
				cache: false,
				success: function(result) {
					$("#resultHole").removeClass("d-none");
					$("#resultHole").html(result);
				}
			});
		})
		$("#searchHole").on("blur", function() {
			window.setTimeout(function() {
				$("#resultHole").addClass("d-none");
			}, 200)
		})
	})
</script>

<!-- Searching Colour -->
<script>
	function addColour(colourNama, colourId) {
		$("#searchColour").val(colourNama);
		$("#colourId").val(colourId);
	};
	$(document).ready(function() {
		$("#searchColour").on("keyup", function() {
			let searchColour = $("#searchColour").val();
			$.ajax({
				url: "<?php echo base_url("search_colour"); ?>",
				type: "POST",
				data: {
					keyword: searchColour
				},
				cache: false,
				success: function(result) {
					$("#resultColour").removeClass("d-none");
					$("#resultColour").html(result);
				}
			});
		})
		$("#searchColour").on("blur", function() {
			window.setTimeout(function() {
				$("#resultColour").addClass("d-none");
			}, 200)
		})
	})
</script>
