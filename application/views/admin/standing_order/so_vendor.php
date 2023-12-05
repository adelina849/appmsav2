<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong>Standing Order - Berdasarkan Supplier</strong></h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="table_so" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr class="themed-color themed-background">
							<th class="text-center text-light" style="width: 5%;">NO</th>
							<th class="text-light" style="width: 20%;">KODE SUPPLIER</th>
							<th class="text-light">NAMA SUPPLIER</th>
							<td class="text-center no-sort text-light" style="width: 15%;"><i class="fa fa-cog"></i></td>
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

	$(document).ready(function() {
        //var surat_bulan_ini = $("#surat_bulan_ini").val();
        var surat_bulan_ini = 1;
        $('#table_so').dataTable( {
            "bpagingType": "bs_two_button",
            "bProcessing": true,
            //"bServerSide": true,	
            //"sAjaxSource": "<?php echo base_url();?>admin/packing/all_unpacking",
            "ajax": {
                url: "<?php echo site_url('admin/standing_order/ajax_vendor') ?>",
                data: {
                    surat_bulan_ini: surat_bulan_ini,
                },
                type: "POST"
            },                
            "lengthMenu": [
				[25, 50, 100, -1],
				[25, 50, 100, "All"],
            ],
            "aoColumns": [
                { "mData": "no" },
                { "mData": "kode" },
                { "mData": "nama" },
                { "mData": "aksi" }
            ]
        } );
        $('body').tooltip({
            selector: '[data-toggle="tooltip"]'
        });
    });


	function print(id_vendor) {
        $("<iframe>")                             // create a new iframe element
            .hide()                               // make it invisible
            .attr("src", "<?php echo base_url(); ?>admin/standing_order/print_so_supplier/"+id_vendor+"") // point the iframe to the page you want to print
            .appendTo("body");                    // add iframe to the DOM to cause it to load the page
    }       
</script>