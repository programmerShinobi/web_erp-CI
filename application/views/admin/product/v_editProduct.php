<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<div class="card">
				<div class="card-body">
					<?= form_open('process_product_edit'); ?>
					<div class="form-group">
						<label for="product_kode"> Kode Product</label>
						<input type="hidden" name="product_id" class="form-control form-control-user" value="<?= $product_item->product_id; ?>">
						<input type="text" class="form-control form-control-user" value="<?= $product_item->product_kode; ?>" disabled>
						<input type="hidden" name="product_kode" class="form-control" id="product_kode" value="<?= $product_item->product_kode; ?>" required>
					</div>
					<div class="form-group">
						<label>Model</label>
						<?php foreach ($list_model as $item1) {
							if ($item1->model_id == $product_item->model_id) { ?>
								<input type="text" id="searchModel" class="form-control" autocomplete="off" value="<?= $item1->model_kode; ?>">
								<input type="hidden" name="model_id" id="modelId" value="<?= $item1->model_id; ?>">
								<div class="data-search-model d-none" id="resultModel" value="<?= $item1->model_id; ?>"></div>
							<?php } ?>
						<?php } ?>
					</div>
					<div class="form-group">
						<label>Part</label>
						<?php foreach ($list_part as $item2) {
							if ($item2->part_id == $product_item->part_id) { ?>
								<input type="text" id="searchPart" class="form-control" autocomplete="off" value="<?= $item2->part_kode; ?>">
								<input type="hidden" name="part_id" id="partId" value="<?= $item2->part_id; ?>">
								<div class="data-search-part d-none" id="resultPart" value="<?= $item2->part_id; ?>"></div>
							<?php } ?>
						<?php } ?>
					</div>
					<div class="form-group">
						<label>Nama</label>
						<?php foreach ($list_category as $item3) {
							if ($item3->category_id == $product_item->category_id) { ?>
								<input type="text" id="searchCategory" class="form-control" autocomplete="off" value="<?= $item3->category_nama; ?>">
								<input type="hidden" name="category_id" id="categoryId" value="<?= $item3->category_id; ?>">
								<div class="data-search-category d-none" id="resultCategory" value="<?= $item3->category_id; ?>"></div>
							<?php } ?>
						<?php } ?>
					</div>
					<div class="form-group">
						<label>Tool</label>
						<?php foreach ($list_tool as $item4) {
							if ($item4->tool_id == $product_item->tool_id) { ?>
								<input type="text" id="searchTool" class="form-control" placeholder="Masukan Tool ..." autocomplete="off" value="<?= $item4->tool_kode; ?>">
								<input type="hidden" name="tool_id" id="toolId" value="<?= $item4->tool_id; ?>">
								<div class="data-search-tool d-none" id="resultTool" value="<?= $item4->tool_id; ?>"></div>
							<?php } ?>
						<?php } ?>
						Jika tidak perlu masukkan simbol strip "-".
					</div>
					<div class="form-group">
						<label>Hole</label>
						<?php foreach ($list_hole as $item5) {
							if ($item5->hole_id == $product_item->hole_id) { ?>
								<input type="text" id="searchHole" class="form-control" placeholder="Masukan hole ..." autocomplete="off" value="<?= $item5->hole_nama; ?>">
								<input type="hidden" name="hole_id" id="holeId" value="<?= $item5->hole_id; ?>">
								<div class="data-search-hole d-none" id="resultHole" value="<?= $item5->hole_id; ?>"></div>
							<?php } ?>
						<?php } ?>
						Jika tidak perlu masukkan simbol strip "-".
					</div>
					<div class="form-group">
						<label>Colour</label>
						<?php foreach ($list_colour as $item6) {
							if ($item6->colour_id == $product_item->colour_id) { ?>
								<input type="text" id="searchColour" class="form-control" autocomplete="off" value="<?= $item6->colour_nama; ?>">
								<input type="hidden" name="colour_id" id="colourId" value="<?= $item6->colour_id; ?>">
								<div class="data-search-colour d-none" id="resultColour" value="<?= $item6->colour_id; ?>"></div>
							<?php } ?>
						<?php } ?>
					</div>
					<a href="<?= base_url("product") ?>" class="btn btn-info btn-sm mb"><i class="fas fa-chevron-left"></i> Kembali</a>
					<button type="reset" class="btn btn-danger btn-sm"><i class="fa fa-sync"></i> Reset</button>
					<button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Simpan</button>
					<?= form_close(); ?>
				</div>
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
