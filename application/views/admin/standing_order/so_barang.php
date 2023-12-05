<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong>Standing Order - Berdasarkan Barang</strong></h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="so_barang" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr class="themed-color themed-background" style="font-weight: bold;">
							<td class="text-center text-light" style="width: 5%;">NO</td>
							<td class="text-light" style="width: 15%;">KODE</td>
							<td class="text-light" style="width: 20%;">NAMA BARANG</td>
							<td class=" text-light" style="width: 10%;">JENIS</td>
							<td class="text-center text-light no-sort" style="width: 10%;">QTY SP</td>
							<td class="text-center text-light no-sort" style="width: 10%;">QTY TERPACKING</td>
							<td class="text-center text-light no-sort" style="width: 10%;">QTY SO</td>
							<td class="text-center text-light no-sort" style="width: 10%;">HARGA BELI (Rp.)</td>
							<td class="text-center text-right text-light no-sort" style="width: 10%;">JUMLAH TOTAL</td>
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
        $('#so_barang').dataTable( {
            "bpagingType": "bs_two_button",
            "bProcessing": true,
            //"bServerSide": true,	
            //"sAjaxSource": "<?php echo base_url();?>admin/packing/all_unpacking",
            "ajax": {
                url: "<?php echo site_url('admin/standing_order/ajax_list_so_barang') ?>",
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
                { "mData": "jenis" },
                { "mData": "qty_sp" },
                { "mData": "terpacking" },
                { "mData": "so" },
                { "mData": "harga" },
                { "mData": "total" }
            ]
        } );
        $('body').tooltip({
            selector: '[data-toggle="tooltip"]'
        });
    });

	function form_cektak(id_barang) {
		$(".id_barang").val(id_barang);
		$('#FormCetak').modal('show'); // show bootstrap modal when complete loaded
	}
</script>
