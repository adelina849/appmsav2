<!-- Quick Stats -->
<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">

<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<div class="block-options pull-right" style="margin-right: 15px;">
			<span data-toggle="modal" data-target="#modal-fadein">
				<button type="button" class="btn btn-alt btn-sm btn-primary" data-toggle="tooltip" title="Tambah Data">
					<i class="fa fa-plus-circle"></i> Mulai Stok Opname Baru
				</button>
			</span>
		</div>
		<h2><i class="hi hi-cog"></i> <strong><?= $title; ?></strong>
		</h2>
	</div>
	<div class="row">
		<div class='col-sm-12' style="margin-bottom: 5px;">
			<div class="btn-group btn-group-lg">
				<?php echo form_open('admin/gudang/stok_opname/daftar', array('class' => '"', 'id' => 'filter_state', 'target' => '_blank')); ?>
				<input type="hidden" name="judul" value="<?= $title; ?>">
				<input type="hidden" name="so_bulan_ini" id="so_bulan_ini" value="<?= $so_bulan_ini; ?>">
				<input type="hidden" name="tAwal" id="tAwal" value="<?= $tAwal; ?>">
				<input type="hidden" name="tAkhir" id="tAkhir" value="<?= $tAkhir; ?>">
				<input type="hidden" name="id_gudang_filter" id="id_gudang_filter" value="<?= $id_gudang; ?>">

				<a href="#" data_id_barang="<?= 1; ?>" data-toggle="tooltip" title="Filter Stok Opname" class="btn btn-alt btn-sm btn-warning" onclick="$('#modal-filter').modal('show');">
					<i class="fa fa-search"></i> Filter Stok Opname
				</a>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="table_so" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr class="themed-color themed-background" style="font-weight: bold;">
							<td class="text-center text-light" style="width: 3%;">NO</td>
							<td class="text-light" style="width: 10%;">KODE SO</td>
							<td class="text-light" style="width: 10%;">TANGGAL MULAI</td>
							<td class="text-light" style="width: 10%;">GUDANG</td>
							<td class="text-light" style="width: 10%;">STATUS</td>
							<td class="text-center no-sort text-light" style="width: 5%;"><i class="fa fa-cog"></i></td>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal Filter-->
<div class="modal fade" id="modal-filter" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title text-center text-primary"><i class="fa fa-search"></i> Filter Stok Opname</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_filter, array('class' => 'form-horizontal form-bordered', 'id' => 'filter_form')); ?>
				<input type="hidden" name="filter" value="filter">
				<fieldset>

					<div class="form-group">
						<label class="col-md-4 control-label" for="example-select">Lokasi Gudang</label>
						<div class="col-md-8">
							<select id="gudang" name="gudang" class="option-line-break select-select2 select2" style="width:100%;" placeholder="Nama Gudang">
								<option value="" disabled selected>-- Pilih Gudang --</option>
								<?php
								foreach ($list_gudang as $g) {
								?>
									<option data-description="<?= 'Kode: ' . $g->kode .
																	'<br>Nama Gudang: ' . $g->gudang;  ?>" value="<?= $g->id; ?>">
										<?= $g->gudang; ?>
									</option>
								<?php
								}
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="example-daterange1">Masukan Tanggal SO</label>
						<div class="col-md-8">
							<div class="input-group input-daterange" data-date-format="yyyy-mm-dd">
								<input type="text" id="tanggal1" name="awal" class="form-control text-center" placeholder="Awal" autocomplete="off" required>
								<span class="input-group-addon"><i class="fa fa-angle-right"></i></span>
								<input type="text" id="tanggal2" name="akhir" class="form-control text-center" placeholder="Akhir" autocomplete="off" required>
							</div>
						</div>
					</div>
				</fieldset>
				<div class="form-group form-actions">
					<div class="col-md-8 col-md-offset-4 text-right">
						<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Batal</button>
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Tampilkan</button>
					</div>
				</div>
				<?php echo form_close(); ?>
				<!-- END Form Validation Example Content -->
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
<!-- END Modal Filter-->

<!-- Modal Tambah-->
<div class="modal fade" id="modal-fadein" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-money"></i> Tambah Stok Opname</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_add, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label" for="kode_so">Kode Stok Opname<span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="kode_so" name="kode_so" value="<?= $generate_kode; ?>" class="form-control" placeholder=".." readonly required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="id_gudang">Gudang <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<select id="id_gudang" name="id_gudang" class="select-select2 select2" style="width:100%;" required>
								<option value="" selected disabled>-- Pilih Gudang --</option>
								<?
								foreach ($list_gudang as $data) { ?>
									<option value="<?= $data->id ?>"><?= $data->gudang ?></option>
								<? } ?>
							</select>
						</div>
					</div>
				</fieldset>
				<div class="form-group form-actions">
					<div class="col-md-8 col-md-offset-4 text-right">
						<button type="reset" class="btn btn-sm btn-warning" data-dismiss="modal"><i class="fa fa-repeat"></i> Batal</button>
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Mulai SO</button>
					</div>
				</div>
				<?php echo form_close(); ?>
				<!-- END Form Validation Example Content -->
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
<!-- END Modal Tambah-->

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script type="text/javascript">
	var table;

	$(document).ready(function() {
		var so_bulan_ini = $("#so_bulan_ini").val();
		var tAwal = $("#tAwal").val();
		var tAkhir = $("#tAkhir").val();
		var id_gudang = $("#id_gudang_filter").val();

		table = $('#table_so').DataTable({
			"searching": false,
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				url: "<?php echo site_url('admin/gudang/stok_opname/ajax_list_so') ?>",
				data: {
					so_bulanini: so_bulan_ini,
					tAwal: tAwal,
					tAkhir: tAkhir,
					id_gudang: id_gudang,
				},
				type: "POST"
			},
			'language': {
				"search": "",
			},
			//Set column definition initialisation properties.
			"columnDefs": [{
				"targets": [0], //first column / numbering column
				"orderable": false, //set not orderable
			}, ],

		});
		$('body').tooltip({
			selector: '[data-toggle="tooltip"]'
		});

	});
</script>
