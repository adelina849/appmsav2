<!-- All Orders Block -->
<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
<style>
    .table th {
        font-size: 5px;
    }
</style>
<div class="block full">

    <!-- All Orders Title -->
    <div class="block-title">
        <h2 class=""><i class="fa fa-file animation-pulse" style="margin-top: -7px"></i> <strong><?=$title;?></strong></h2>
        <div class="block-options pull-right" style="margin-right: 15px;">
            <input type='hidden' name='nomor_nota' class='form-control input-sm' id='nomor_nota' value="<?php echo $nomor_nota; ?>">
        </div>
    </div>
    <!-- END All Orders Title -->

    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
            <div class="table-responsive">
                <table id="so_supplier" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr class="themed-color themed-background-amethyst" style="font-weight: bold;">
                            <td class="text-center text-light" style="width: 3%;">NO</td>
                            <td class="text-light" style="width: 15%;">KODE SUPPLIER</td>
                            <td class="text-light">NAMA SUPPLIER</td>
                            <td class="text-center no-sort text-light" style="width: 15%;"><i class="fa fa-cog"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- END row -->

</div>
<!-- END All Orders Block -->
<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script type="text/javascript">
	var table;

	$(document).ready(function() {

		table = $('#so_supplier').DataTable({
			"search": false,
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				url: "<?php echo site_url('admin/pembelian/ajax_list_so_vendor') ?>",
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

	function form_cektak(id_vendor) {
		$(".id_vendor").val(id_vendor);
		$('#FormCetak').modal('show'); // show bootstrap modal when complete loaded
	}
</script>