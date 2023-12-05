<!-- Quick Stats -->
<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<div class="block-options pull-right" style="margin-right: 15px;">
			<span data-toggle="modal" data-target="#modal-fadein">
				<a href="<?= site_url('admin/master/barang/form_barang') ?>" type="button" class="btn btn-alt btn-sm btn-primary" data-toggle="tooltip" title="Tambah Data Baru">
					<i class="fa fa-plus-circle"></i> Tambah Data
				</a>
			</span>
		</div>
		<h2><i class="hi hi-cog"></i> <strong>DATA MASTER BARANG</strong>
		</h2>
	</div>
	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="">
				<table id="table_barang" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr class="themed-color themed-background">
							<th class="text-center text-light" style="width: 3%;">NO</th>
							<th class="text-light" style="width: 10%;">KODE</th>
							<th class="text-light">NAMA BARANG</th>
							<th class="text-light">JENIS</th>
							<th class="text-light">JENJANG</th>
							<th class="text-light">MERK</th>
							<th class="text-light">SUPPLIER</th>
							<th class="text-center no-sort text-light" style="width: 15%;"><i class="fa fa-cog"></i></th>
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
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> Hapus Barang</h2>
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

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script type="text/javascript">
	var table;

	$(document).ready(function() {

		//datatables
		table = $('#table_barang').DataTable({

			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('admin/master/barang/ajax_list_barang') ?>",
				"type": "POST"
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
