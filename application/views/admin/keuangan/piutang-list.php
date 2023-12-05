<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong>Hutang Perusahaan</strong></h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="table_piutang" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr class="themed-color themed-background">
							<th class="text-center text-light" style="width: 5%;">NO</th>
							<th class="text-center text-light" style="width: 10%;">NOMOR SP</th>
							<th class="text-center text-light" style="width: 10%;">Tanggal Pesanan</th>
							<th class="text-center text-light" style="width: 10%;">Jatuh Tempo</th>
							<th class="text-center text-light" style="width: 10%;">Nama Lembaga</th>
							<th class="text-center text-light" style="width: 10%;">Nama Pelanggan</th>
							<th class="text-center text-light" style="width: 10%;">Nama Mitra</th>
							<th class="text-center text-light" style="width: 10%;">Nama Pelaksana</th>
							<th class="text-center text-light" style="width: 10%;">Nominal</th>
							<th class="text-center text-light" style="width: 10%;">Status</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script type="text/javascript">
	var table;

	$(document).ready(function() {

		table = $('#table_piutang').DataTable({
			"search": false,
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				url: "<?php echo site_url('admin/keuangan/piutang/ajax_list_piutang') ?>",
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
