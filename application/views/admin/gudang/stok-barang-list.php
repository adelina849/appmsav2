<!-- Quick Stats -->
<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
<div class="row text-center">

	<div class="col-sm-6 col-lg-3">
		<a href="javascript:void(0)" class="widget widget-hover-effect2">
			<div class="widget-extra themed-background-info">
				<h4 class="widget-content-light"><strong>Total</strong> Inventory (Rp.)</h4>
			</div>
			<div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">
				<?= $total_inventory; ?></span>
			</div>
		</a>
	</div>

	<div class="col-sm-6 col-lg-3">
		<a href="javascript:void(0)" class="widget widget-hover-effect2">
			<div class="widget-extra themed-background-success">
				<h4 class="widget-content-light"><strong>Stok</strong> Ready</h4>
			</div>
			<div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen"><?= $ready;?></span></div>
		</a>
	</div>

	<div class="col-sm-6 col-lg-3">
		<a href="javascript:void(0)" class="widget widget-hover-effect2">
			<div class="widget-extra themed-background-danger">
				<h4 class="widget-content-light"><strong>Stok</strong> Kosong</h4>
			</div>
			<div class="widget-extra-full"><span class="h2 text-danger animation-expandOpen"><?= $kosong;?></span></div>
		</a>
	</div>
	<div class="col-sm-6 col-lg-3">
		<a href="javascript:void(0)" class="widget widget-hover-effect2">
			<div class="widget-extra themed-background-warning">
				<h4 class="widget-content-light"><strong>Semua</strong> Barang</h4>
			</div>
			<div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen"><?= (int)$ready+(int)$kosong; ?></span></div>
		</a>
	</div>
</div>

<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong>GUDANG - STOK BARANG <?= $title ?></strong>
		</h2>
	</div>
	<div class="row">
		<div class='col-sm-12' style="margin-bottom: 5px;">
			<div class="btn-group btn-group-lg">
				<?php echo form_open('admin/gudang/stok_opname/daftar', array('class' => '"', 'id' => 'filter_state', 'target' => '_blank')); ?>
				<input type="hidden" name="judul" value="<?= $title; ?>">
				<input type="hidden" name="id_gudang_filter" id="id_gudang_filter" value="<?= $id_gudang; ?>">
				<input type="hidden" name="status_stok" id="status_stok" value="<?= $status_stok; ?>">
				<input type="hidden" name="supplier" id="supplier" value="<?= $supplier; ?>">

				<a href="#" data_id_barang="<?= 1; ?>" data-toggle="tooltip" title="Filter Stok Opname" class="btn btn-alt btn-sm btn-warning" onclick="$('#modal-filter').modal('show');">
					<i class="fa fa-search"></i> Filter Stok
				</a>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="">
				<table id="table_barang" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr class="themed-color themed-background">
							<td class="text-center text-light" style="width: 3%;">NO</td>
							<td class="text-light" style="width: 10%;">KODE</td>
							<td class="text-light">NAMA BARANG</td>
							<td class="text-light" style="width: 10%;">SUPPLIER</td>
							<td class="text-light" style="width: 15%;">LOKASI</td>
							<td class="text-light" style="width: 10%;">HPP (Rp.)</td>
							<td class="text-light" style="width: 10%;">STOK</td>
							<td class="text-light" style="width: 15%;">JUMLAH HARGA</td>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!--HAPUS  -->
<div id="FormHapus" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> Hapus Stok</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_delete, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_delete')); ?>
				<input type="hidden" name="id_barang" class="id_barang">
				<fieldset>
					<div class="form-group" style="margin:0 20px 0 20px">
						<div class="alert alert-warning alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="gi gi-circle_exclamation_mark"></i> Warning!</h4>
							Semua Data terkait akan dihapus, Apakah anda yakin?
						</div>
					</div>
				</fieldset>
				<div class="form-group form-actions">
					<div class="col-xs-12 text-center">
						<button type="reset" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-sm btn-primary">Hapus</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
<!-- END HAPUS -->

<!-- Modal Filter-->
<div class="modal fade" id="modal-filter" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">

	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title text-center text-primary"><i class="fa fa-search"></i> Filter Stok Barang</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_filter, array('class' => 'form-horizontal form-bordered', 'id' => 'filter_form')); ?>
				<input type="hidden" name="filter" value="filter">
				<fieldset>

					<div class="form-group">
						<label class="col-md-4 control-label" for="vendor">Supplier </label>
						<div class="col-md-8">
							<select id="vendor" name="vendor" class="select-select2 select2" style="width:100%;">
								<option value="">-- Pilih Supplier Barang --</option>
								<?php
									$vendor = $this->db->order_by('nama_vendor','ASC')->get_where('vendor', array('dihapus' => 'tidak'))->result();
									foreach ($vendor as $v) { ?>
										<option value="<?= $v->id;?>"><?= $v->nama_vendor ?></option>
									<?php 
								} 
								?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="example-select">Lokasi Gudang</label>
						<div class="col-md-8">
							<select id="gudang" name="gudang" class="select-select2 select2" style="width:100%;" placeholder="Nama Gudang">

								<option value="">-- Pilih Gudang --</option>
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
						<label class="col-md-4 control-label" for="example-select">Status Stok Barang</label>
						<div class="col-md-8">
							<select id="status_stok" name="status_stok" class="form-control" style="width:100%;" placeholder="Nama Gudang">
								<option value="" disabled selected>-- Pilih Status Stok --</option>
								<option value="tersedia">Stok Tersedia</option>
								<option value="kosong">Stok Kosong</option>
							</select>
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

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script type="text/javascript">
	var table;

	$(document).ready(function() {

		var id_gudang = $("#id_gudang_filter").val();
		var status_stok = $("#status_stok").val();
		var supplier = $("#supplier").val();
		//datatables
		table = $('#table_barang').DataTable({

			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('admin/gudang/stok_barang/ajax_list_barang') ?>",
				"type": "POST",
				data: {
					id_gudang: id_gudang,
					status_stok: status_stok,
					supplier: supplier,
				},
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

	function form_hapus(id_barang) {
		$(".id_barang").val(id_barang);
		$('#FormHapus').modal('show'); // show bootstrap modal when complete loaded
	}
</script>
