<!-- Quick Stats -->
<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
<div class="block full">
    <!-- All Orders Title -->
    <div class="block-title">
        <div class="block-options pull-right" style="margin-right: 15px;">
        </div>
        <h2><i class="fa fa-clipboard"></i> <strong><?= $title; ?></strong></h2>
    </div>

    <div class="row">
        <div class='col-sm-4' style="margin-bottom: 5px;">
            <div class="btn-group btn-group-lg">
                <?php echo form_open('admin/pembelian/daftar', array('class' => '"', 'id' => '')); ?>
                <input type="hidden" name="judul" value="<?= $title; ?>">
                <input type="hidden" name="surat_bulan_ini" id="surat_bulan_ini" value="<?= $surat_bulan_ini; ?>">
                <input type="hidden" name="tAwal" id="tAwal" value="<?= $tAwal; ?>">
                <input type="hidden" name="tAkhir" id="tAkhir" value="<?= $tAkhir; ?>">
                <input type="hidden" name="supplier" id="supplier" value="<?= $supplier; ?>">
                <a href="#" data_id_barang="<?= 1; ?>" data-toggle="tooltip" title="Filter Surat Pembelian" class="btn btn-alt btn-sm btn-warning" onclick="$('#modal-filter').modal('show');">
                    <i class="fa fa-search"></i> Filter Surat Pembelian
                </a>
                <?php echo form_close(); ?>
            </div>
        </div>
        <div class='col-sm-8'>
            <p class="text-muted"><i class='fa fa-print fa-fw animation-pulse text-info'></i>Print Surat Pembelian</p>
        </div>

    </div>
    <!-- END row -->

    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
            <div class="table-responsive">
                <table id="do" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr class="themed-color themed-background-amethyst" style="font-weight: bold;">
                            <td class="text-center text-light" style="width: 3%;">NO</td>
                            <td class="text-light" style="width: 10%;">NOMOR</td>
                            <td class="text-light" style="width: 25%;">MARKETING</td>
                            <td class="text-light" style="width: 20%;">SUPPLIER</td>
                            <td class="text-light" style="width: 10%;">PEMBELIAN</td>
                            <td class="text-light" style="width: 10%;">PEMBAYARAN</td>
                            <td class="text-light" style="width: 10%;">JATUH TEMPO</td>
                            <td class="text-light" style="width: 10%;">TOTAL (Rp.)</td>
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
    <!-- END block-->
</div>

<!-- Modal Filter-->
<div class="modal fade" id="modal-filter" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title text-center text-primary"><i class="fa fa-search"></i> Filter Data</h2>
            </div>
            <!-- END Modal Header -->
            <!-- Modal Body -->
            <div class="modal-body">
                <?php echo form_open($action_filter, array('class' => 'form-horizontal form-bordered', 'id' => '')); ?>
                <input type="hidden" name="filter" value="filter">
                <fieldset>

                    <div class="form-group">
						<label class="col-md-4 control-label" for="vendor">SUPPLIER </label>
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
                        <label class="col-md-4 control-label" for="example-daterange1">MASUKAN TANGGAL</label>
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



<!--HAPUS  -->
<div id="FormHapus" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> Hapus Surat Pembelian</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_delete, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_delete')); ?>
				<input type="hidden" name="id_pembelian_m" class="id_pembelian_m">
				<fieldset>
					<div class="form-group" style="margin:0 20px 0 20px">
						<div class="alert alert-warning alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="gi gi-circle_exclamation_mark"></i> Warning!</h4>
							Semua Data terkait surat pembelian ini akan dihapus, Apakah anda yakin?
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
    $(document).ready(function() {
        var surat_bulan_ini = $("#surat_bulan_ini").val();
        var tAwal = $("#tAwal").val();
        var tAkhir = $("#tAkhir").val();
        var supplier = $("#supplier").val();
        $('#do').dataTable( {
            "bpagingType": "bs_two_button",
            "bProcessing": true,
            //"bServerSide": true,	
            //"sAjaxSource": "<?php echo base_url();?>admin/packing/all_unpacking",
            "ajax": {
                url: "<?php echo site_url('admin/pembelian/all_surat_pembelian') ?>",
                data: {
                    surat_bulan_ini: surat_bulan_ini,
                    tAwal: tAwal,
                    tAkhir: tAkhir,
                    supplier: supplier,
                },
                type: "POST"
            },                
            "lengthMenu": [
				[25, 50, 100, -1],
				[25, 50, 100, "All"],
            ],
            "aoColumns": [
                { "mData": "no" },
                { "mData": "nomor" },
                { "mData": "marketing" },
                { "mData": "supplier" },
                { "mData": "pembelian" },
                { "mData": "pembayaran" },
                { "mData": "tempo" },
                { "mData": "total" },
                { "mData": "aksi" }
            ]
        } );
        $('body').tooltip({
            selector: '[data-toggle="tooltip"]'
        });
    });
    
    var table;
    $(document).ready(function() {
        //select 2 line break option
        function formatResult(result) {
            if (!result.id) return result.text;

            var myElement = $(result.element);

            var markup = '<div class="clearfix">' +
                '<p style="margin-bottom: 0px">' + result.text + '</p>' +
                '<p>' + $(myElement).data('description') + '</p>' +
                '</div>';

            return markup;
        }

        function formatSelection(result) {
            return result.full_name || result.text;
        }

        $(".option-line-break").select2({
            escapeMarkup: function(m) {
                return m;
            },
            closeOnSelect: false,
            templateResult: formatResult,
            templateSelection: formatSelection
        });

    });

    function print(pembelian_id) {
        $("<iframe>")                             // create a new iframe element
            .hide()                               // make it invisible
            .attr("src", "<?php echo base_url(); ?>admin/pembelian/print_surat_pembelian/"+pembelian_id+"") // point the iframe to the page you want to print
            .appendTo("body");                    // add iframe to the DOM to cause it to load the page
    }       
	function form_hapus(id_pembelian_m) {
		$(".id_pembelian_m").val(id_pembelian_m);
		$('#FormHapus').modal('show'); // show bootstrap modal when complete loaded
	}

</script>