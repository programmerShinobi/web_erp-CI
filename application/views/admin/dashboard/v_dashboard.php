<?= $this->session->flashdata('pesan'); ?>
<div class="container-fluid">
	<h3><?= $title ?></h3>
	<div class="card">
		<div class="card-header">
			<ul class="nav nav-pills" role="tablist">
				<li class="nav-item border border-primary rounded m-1">
					<a class="nav-link active" data-toggle="pill" href="#all"><i class="fas fa-object-group"></i> All</a>
				</li>
				<?php if ($user->user_role == 1 || $user->user_role == 2){?>	
					<li class="nav-item border border-primary rounded m-1">
						<a class="nav-link" data-toggle="pill" href="#po"><i class="fas fa-bookmark nav-icon"></i> PO</a>
					</li>
				<?php } if ($user->user_role == 1 || $user->user_role == 3){?>
				<li class="nav-item border border-primary rounded m-1">
					<a class="nav-link" data-toggle="pill" href="#injection"><i class="fas fa-puzzle-piece nav-icon"></i> Injection</a>
				</li>
				<?php } if ($user->user_role == 1 || $user->user_role == 4){?>
				<li class="nav-item border border-primary rounded m-1">
					<a class="nav-link" data-toggle="pill" href="#_2nd"><i class="fas fa fa-history nav-icon"></i> 2nd Process</a>
				</li>
				<?php } if ($user->user_role == 1 || $user->user_role == 5) {?>
				<li class="nav-item border border-primary rounded m-1">
					<a class="nav-link" data-toggle="pill" href="#ipqc"><i class="fas fa-solid fa-window-restore nav-icon"></i> IPQC</a>
				</li>
				<?php } if ($user->user_role == 1 || $user->user_role == 6) {?>
				<li class="nav-item border border-primary rounded m-1">
					<a class="nav-link" data-toggle="pill" href="#oqc"><i class="fas fa-solid fa-window-restore nav-icon"></i> OQC</a>
				</li>
				<?php } if ($user->user_role == 1 || $user->user_role == 7) {?>
				<li class="nav-item border border-primary rounded m-1">
					<a class="nav-link" data-toggle="pill" href="#la"><i class="fas fa-solid fa-window-restore nav-icon"></i> Loading Area</a>
				</li>
				<li class="nav-item border border-primary rounded m-1">
					<a class="nav-link" data-toggle="pill" href="#delivery"><i class="fas fa-paper-plane nav-icon"></i> Delivery</a>
				</li>
				<?php } ?>
			</ul>
		</div>
		<div class="card-body">
			<div class="tab-content">
				<?= form_open('dashboard'); ?>
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
				<div id="all" class="tab-pane active">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataVisibility1">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Tanggal PO</th>
									<!-- <th class="text-center">Kode PO</th> -->
									<th class="text-center">Customer</th>
									<th class="text-center">Name</th>
									<th class="text-center">Model</th>
									<th class="text-center">Part</th>
									<th class="text-center">Total PO</th>
									<th class="text-center">Stock Op. Semi</th>
									<th class="text-center">Stock Op. Finish</th>
									<th class="text-center">Hasil Injection</th>
									<th class="text-center">Hasil 2nd Process</th>
									<th class="text-center">Hasil IPQC</th>
									<th class="text-center">Hasil Delivery</th>
									<th class="text-center">Hasil Printing</th>
									<th class="text-center">Hasil Spray</th>
									<th class="text-center">Hasil Assy</th>
									<th class="text-center">Hasil OQC</th>
									<th class="text-center">Finish Loading Area</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($list_dashboard as $itemAll) { ?>
									<tr>
										<td class="text-center"><?= $no++; ?></td>
										<td class="text-center"><?= date('d/m/Y', strtotime($itemAll->purchaseorder_tanggal)) ?></td>
										<!-- <td class="text-center"><?= $itemAll->purchaseorder_kode; ?></td> -->
										<td class="text-center"><?= $itemAll->customer_kode; ?></td>
										<td class="text-center"><?= $itemAll->category_nama; ?></td>
										<td class="text-center"><?= $itemAll->model_kode; ?></td>
										<td class="text-center"><?= $itemAll->part_kode; ?></td>
										<td class="text-center"><?= $itemAll->purchaseorder_jumlah; ?></td>
										<td class="text-center"><?= $itemAll->purchaseorder_stockopnamesemi; ?></td>
										<td class="text-center"><?= $itemAll->purchaseorder_stockopnamefinish; ?></td>
										<td class="text-center"><?= $itemAll->planinjection_hasil; ?></td>
										<td class="text-center"><?= $itemAll->plan2nd_hasil; ?></td>
										<td class="text-center"><?= $itemAll->stockipqc_finish; ?></td>
										<td class="text-center"><?= $itemAll->delivery_hasil; ?></td>
										<td class="text-center"><?= $itemAll->planprinting_hasil; ?></td>
										<td class="text-center"><?= $itemAll->planspray_hasil; ?></td>
										<td class="text-center"><?= $itemAll->planassy_hasil; ?></td>
										<td class="text-center"><?= $itemAll->stockoqc_finish; ?></td>
										<td class="text-center"><?= $itemAll->stockla_finish; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="po" class="tab-pane fade">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataVisibility2">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Tanggal PO</th>
									<!-- <th class="text-center">Kode PO</th> -->
									<th class="text-center">Customer</th>
									<th class="text-center">Name</th>
									<th class="text-center">Model</th>
									<th class="text-center">Part</th>
									<th class="text-center">Total PO</th>
									<th class="text-center">Stock Opname Semi</th>
									<th class="text-center">Stock Opname Finish</th>
									<th class="text-center">Remain PO</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($list_dashboard as $itemPO) { ?>
									<tr>
										<td class="text-center"><?= $no++; ?></td>
										<td class="text-center"><?= date('d/m/Y', strtotime($itemPO->purchaseorder_tanggal)) ?></td>
										<!-- <td class="text-center"><?= $itemPO->purchaseorder_kode; ?></td> -->
										<td class="text-center"><?= $itemPO->customer_kode; ?></td>
										<td class="text-center"><?= $itemPO->category_nama; ?></td>
										<td class="text-center"><?= $itemPO->model_kode; ?></td>
										<td class="text-center"><?= $itemPO->part_kode; ?></td>
										<td class="text-center"><?= $itemPO->purchaseorder_jumlah; ?></td>
										<td class="text-center"><?= $itemPO->purchaseorder_stockopnamesemi; ?></td>
										<td class="text-center"><?= $itemPO->purchaseorder_stockopnamefinish; ?></td>
										<td class="text-center"><?= $itemPO->purchaseorder_remain; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="injection" class="tab-pane fade">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataVisibility3">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Tanggal PO</th>
									<!-- <th class="text-center">Kode PO</th> -->
									<th class="text-center">Customer</th>
									<th class="text-center">Name</th>
									<th class="text-center">Model</th>
									<th class="text-center">Part</th>
									<th class="text-center">Total PO</th>
									<th class="text-center">Hasil Injection</th>
									<th class="text-center">Remain Injection</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($list_dashboard as $itemInjection) { ?>
									<tr>
										<td class="text-center"><?= $no++; ?></td>
										<td class="text-center"><?= date('d/m/Y', strtotime($itemInjection->purchaseorder_tanggal)) ?></td>
										<!-- <td class="text-center"><?= $itemInjection->purchaseorder_kode; ?></td> -->
										<td class="text-center"><?= $itemInjection->customer_kode; ?></td>
										<td class="text-center"><?= $itemInjection->category_nama; ?></td>
										<td class="text-center"><?= $itemInjection->model_kode; ?></td>
										<td class="text-center"><?= $itemInjection->part_kode; ?></td>
										<td class="text-center"><?= $itemInjection->purchaseorder_jumlah; ?></td>
										<td class="text-center"><?= $itemInjection->planinjection_hasil; ?></td>
										<td class="text-center"><?= $itemInjection->planinjection_remain; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="_2nd" class="tab-pane fade">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataVisibility11">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Tanggal PO</th>
									<!-- <th class="text-center">Kode PO</th> -->
									<th class="text-center">Customer</th>
									<th class="text-center">Name</th>
									<th class="text-center">Model</th>
									<th class="text-center">Part</th>
									<th class="text-center">Total PO</th>
									<th class="text-center">Hasil 2nd Process</th>
									<th class="text-center">Remain 2nd Process</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($list_dashboard as $item2nd) { ?>
									<tr>
										<td class="text-center"><?= $no++; ?></td>
										<td class="text-center"><?= date('d/m/Y', strtotime($item2nd->purchaseorder_tanggal)) ?></td>
										<!-- <td class="text-center"><?= $item2nd->purchaseorder_kode; ?></td> -->
										<td class="text-center"><?= $item2nd->customer_kode; ?></td>
										<td class="text-center"><?= $item2nd->category_nama; ?></td>
										<td class="text-center"><?= $item2nd->model_kode; ?></td>
										<td class="text-center"><?= $item2nd->part_kode; ?></td>
										<td class="text-center"><?= $item2nd->purchaseorder_jumlah; ?></td>
										<td class="text-center"><?= $item2nd->plan2nd_hasil; ?></td>
										<td class="text-center"><?= $item2nd->plan2nd_remain; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="printing" class="tab-pane fade">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataVisibility4">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Tanggal PO</th>
									<!-- <th class="text-center">Kode PO</th> -->
									<th class="text-center">Customer</th>
									<th class="text-center">Name</th>
									<th class="text-center">Model</th>
									<th class="text-center">Part</th>
									<th class="text-center">Total PO</th>
									<th class="text-center">Hasil Printing</th>
									<th class="text-center">Remain Printing</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($list_dashboard as $itemPrint) { ?>
									<tr>
										<td class="text-center"><?= $no++; ?></td>
										<td class="text-center"><?= date('d/m/Y', strtotime($itemPrint->purchaseorder_tanggal)) ?></td>
										<!-- <td class="text-center"><?= $itemPrint->purchaseorder_kode; ?></td> -->
										<td class="text-center"><?= $itemPrint->customer_kode; ?></td>
										<td class="text-center"><?= $itemPrint->category_nama; ?></td>
										<td class="text-center"><?= $itemPrint->model_kode; ?></td>
										<td class="text-center"><?= $itemPrint->part_kode; ?></td>
										<td class="text-center"><?= $itemPrint->purchaseorder_jumlah; ?></td>
										<td class="text-center"><?= $itemPrint->planprinting_hasil; ?></td>
										<td class="text-center"><?= $itemPrint->planprinting_remain; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="spray" class="tab-pane fade">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataVisibility5">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Tanggal PO</th>
									<!-- <th class="text-center">Kode PO</th> -->
									<th class="text-center">Customer</th>
									<th class="text-center">Name</th>
									<th class="text-center">Model</th>
									<th class="text-center">Part</th>
									<th class="text-center">Total PO</th>
									<th class="text-center">Hasil Spray</th>
									<th class="text-center">Remain Spray</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($list_dashboard as $itemSpray) { ?>
									<tr>
										<td class="text-center"><?= $no++; ?></td>
										<td class="text-center"><?= date('d/m/Y', strtotime($itemSpray->purchaseorder_tanggal)) ?></td>
										<!-- <td class="text-center"><?= $itemSpray->purchaseorder_kode; ?></td> -->
										<td class="text-center"><?= $itemSpray->customer_kode; ?></td>
										<td class="text-center"><?= $itemSpray->category_nama; ?></td>
										<td class="text-center"><?= $itemSpray->model_kode; ?></td>
										<td class="text-center"><?= $itemSpray->part_kode; ?></td>
										<td class="text-center"><?= $itemSpray->purchaseorder_jumlah; ?></td>
										<td class="text-center"><?= $itemSpray->planspray_hasil; ?></td>
										<td class="text-center"><?= $itemSpray->planspray_remain; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="assy" class="tab-pane fade">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataVisibility6">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Tanggal PO</th>
									<!-- <th class="text-center">Kode PO</th> -->
									<th class="text-center">Customer</th>
									<th class="text-center">Name</th>
									<th class="text-center">Model</th>
									<th class="text-center">Part</th>
									<th class="text-center">Total PO</th>
									<th class="text-center">Hasil Assy</th>
									<th class="text-center">Remain Assy</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($list_dashboard as $itemAssy) { ?>
									<tr>
										<td class="text-center"><?= $no++; ?></td>
										<td class="text-center"><?= date('d/m/Y', strtotime($itemAssy->purchaseorder_tanggal)) ?></td>
										<!-- <td class="text-center"><?= $itemAssy->purchaseorder_kode; ?></td> -->
										<td class="text-center"><?= $itemAssy->customer_kode; ?></td>
										<td class="text-center"><?= $itemAssy->category_nama; ?></td>
										<td class="text-center"><?= $itemAssy->model_kode; ?></td>
										<td class="text-center"><?= $itemAssy->part_kode; ?></td>
										<td class="text-center"><?= $itemAssy->purchaseorder_jumlah; ?></td>
										<td class="text-center"><?= $itemAssy->planassy_hasil; ?></td>
										<td class="text-center"><?= $itemAssy->planassy_remain; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="ipqc" class="tab-pane fade">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataVisibility7">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Tanggal PO</th>
									<!-- <th class="text-center">Kode PO</th> -->
									<th class="text-center">Customer</th>
									<th class="text-center">Name</th>
									<th class="text-center">Model</th>
									<th class="text-center">Part</th>
									<th class="text-center">Total PO</th>
									<th class="text-center">Hasil IPQC</th>
									<th class="text-center">Remain IPQC</th>

								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($list_dashboard as $itemIPQC) { ?>
									<tr>
										<td class="text-center"><?= $no++; ?></td>
										<td class="text-center"><?= date('d/m/Y', strtotime($itemIPQC->purchaseorder_tanggal)) ?></td>
										<!-- <td class="text-center"><?= $itemIPQC->purchaseorder_kode; ?></td> -->
										<td class="text-center"><?= $itemIPQC->customer_kode; ?></td>
										<td class="text-center"><?= $itemIPQC->category_nama; ?></td>
										<td class="text-center"><?= $itemIPQC->model_kode; ?></td>
										<td class="text-center"><?= $itemIPQC->part_kode; ?></td>
										<td class="text-center"><?= $itemIPQC->purchaseorder_jumlah; ?></td>
										<td class="text-center"><?= $itemIPQC->stockipqc_finish; ?></td>
										<td class="text-center"><?= $itemIPQC->stockipqc_remain; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="oqc" class="tab-pane fade">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataVisibility8">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Tanggal PO</th>
									<!-- <th class="text-center">Kode PO</th> -->
									<th class="text-center">Customer</th>
									<th class="text-center">Name</th>
									<th class="text-center">Model</th>
									<th class="text-center">Part</th>
									<th class="text-center">Total PO</th>
									<th class="text-center">Hasil OQC</th>
									<th class="text-center">Remain OQC</th>

								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($list_dashboard as $itemOQC) { ?>
									<tr>
										<td class="text-center"><?= $no++; ?></td>
										<td class="text-center"><?= date('d/m/Y', strtotime($itemOQC->purchaseorder_tanggal)) ?></td>
										<!-- <td class="text-center"><?= $itemOQC->purchaseorder_kode; ?></td> -->
										<td class="text-center"><?= $itemOQC->customer_kode; ?></td>
										<td class="text-center"><?= $itemOQC->category_nama; ?></td>
										<td class="text-center"><?= $itemOQC->model_kode; ?></td>
										<td class="text-center"><?= $itemOQC->part_kode; ?></td>
										<td class="text-center"><?= $itemOQC->purchaseorder_jumlah; ?></td>
										<td class="text-center"><?= $itemOQC->stockoqc_finish; ?></td>
										<td class="text-center"><?= $itemOQC->stockoqc_remain; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="la" class="tab-pane fade">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataVisibility9">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Tanggal PO</th>
									<!-- <th class="text-center">Kode PO</th> -->
									<th class="text-center">Customer</th>
									<th class="text-center">Name</th>
									<th class="text-center">Model</th>
									<th class="text-center">Part</th>
									<th class="text-center">Total PO</th>
									<th class="text-center">Semi Loading Area</th>
									<th class="text-center">Finish Loading Area</th>

								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($list_dashboard as $itemLA) { ?>
									<tr>
										<td class="text-center"><?= $no++; ?></td>
										<td class="text-center"><?= date('d/m/Y', strtotime($itemLA->purchaseorder_tanggal)) ?></td>
										<!-- <td class="text-center"><?= $itemLA->purchaseorder_kode; ?></td> -->
										<td class="text-center"><?= $itemLA->customer_kode; ?></td>
										<td class="text-center"><?= $itemLA->category_nama; ?></td>
										<td class="text-center"><?= $itemLA->model_kode; ?></td>
										<td class="text-center"><?= $itemLA->part_kode; ?></td>
										<td class="text-center"><?= $itemLA->purchaseorder_jumlah; ?></td>
										<td class="text-center"><?= $itemLA->stockla_semi; ?></td>
										<td class="text-center"><?= $itemLA->stockla_finish; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				<div id="delivery" class="tab-pane fade">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="dataVisibility10">
							<thead>
								<tr>
									<th class="text-center">No</th>
									<th class="text-center">Tanggal PO</th>
									<!-- <th class="text-center">Kode PO</th> -->
									<th class="text-center">Customer</th>
									<th class="text-center">Name</th>
									<th class="text-center">Model</th>
									<th class="text-center">Part</th>
									<th class="text-center">Total PO</th>
									<th class="text-center">Hasil Delivery</th>
									<th class="text-center">Remain Delivery</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1;
								foreach ($list_dashboard as $itemDelivery) { ?>
									<tr>
										<td class="text-center"><?= $no++; ?></td>
										<td class="text-center"><?= date('d/m/Y', strtotime($itemDelivery->purchaseorder_tanggal)) ?></td>
										<!-- <td class="text-center"><?= $itemDelivery->purchaseorder_kode; ?></td> -->
										<td class="text-center"><?= $itemDelivery->customer_kode; ?></td>
										<td class="text-center"><?= $itemDelivery->category_nama; ?></td>
										<td class="text-center"><?= $itemDelivery->model_kode; ?></td>
										<td class="text-center"><?= $itemDelivery->part_kode; ?></td>
										<td class="text-center"><?= $itemDelivery->purchaseorder_jumlah; ?></td>
										<td class="text-center"><?= $itemDelivery->delivery_hasil; ?></td>
										<td class="text-center"><?= $itemDelivery->delivery_remain; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
