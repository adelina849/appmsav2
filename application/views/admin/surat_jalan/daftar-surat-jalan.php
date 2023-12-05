<!-- Quick Stats -->
<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
<!-- Quick Stats -->
<div class="row text-center">
    <?php
        $fakturKembali = $this->msa->__count('surat_jalan_detail','status_kirim', 1);
        $fakturBelumKembali = $this->msa->__count('surat_jalan_detail','status_kirim', 0);
        $gagalKirim = $this->msa->__count('surat_jalan_detail','status_kirim', 2);
    ?>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background">
                <h4 class="widget-content-light"><i class="fa fa-file-text-o"></i> <strong>Total</strong> Faktur</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color animation-expandOpen"><?=$allFaktur;?></span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-spring">
                <h4 class="widget-content-light"><i class="fa fa-check-circle-o"></i> Faktur Kembali</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-spring animation-expandOpen"><?=$fakturKembali;?></span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-autumn">
                <h4 class="widget-content-light"><i class="fa fa-exclamation-triangle"></i> Faktur Belum Kembali</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-autumn animation-expandOpen"><?=$fakturBelumKembali;?></span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-night">
                <h4 class="widget-content-light"><i class="fa fa-times-circle"></i> Gagal Kirim</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-night animation-expandOpen"><?=$gagalKirim;?></span></div>
        </a>
    </div>

</div>
<!-- END Quick Stats -->


<div class="block full">
    <!-- All Orders Title -->
    <div class="block-title">
        <div class="block-options pull-right" style="margin-right: 15px;">
        </div>
        <h2><i class="fa fa-external-link"></i> <strong><?= $title; ?></strong></h2>
    </div>

    <div class="row">
        <div class='col-sm-4' style="margin-bottom: 5px;">
            <div class="btn-group btn-group-lg">
                <?php echo form_open('admin/surat_jalan/daftar', array('class' => '"', 'id' => '')); ?>
                <input type="hidden" name="judul" value="<?= $title; ?>">
                <input type="hidden" name="surat_bulan_ini" id="surat_bulan_ini" value="<?= $surat_bulan_ini; ?>">
                <input type="hidden" name="tAwal" id="tAwal" value="<?= $tAwal; ?>">
                <input type="hidden" name="tAkhir" id="tAkhir" value="<?= $tAkhir; ?>">
                <a href="#" data_id_barang="<?= 1; ?>" data-toggle="tooltip" title="Filter Surat Pesanan" class="btn btn-alt btn-sm btn-warning" onclick="$('#modal-filter').modal('show');">
                    <i class="fa fa-search"></i> Filter
                </a>
                <a href="<?=site_url('admin/surat_jalan/form');?>" data-toggle="tooltip" title="Input Surat Jalan" class="btn btn-alt btn-sm btn-primary">
                    <i class="fa fa-plus-circle"></i> Input Surat Jalan
                </a>
                <?php echo form_close(); ?>
            </div>
        </div>
        <div class='col-sm-8'>
            <p class="text-muted"><i class='fa fa-eye fa-fw animation-pulse text-primary'></i>Detail Surat Jalan <i class='fa fa-print fa-fw animation-pulse text-info'></i>Print Surat Jalan</p>
        </div>

    </div>
    <!-- END row -->

    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
            <div class="table-responsive">
                <table id="do" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr class="themed-color themed-background" style="font-weight: bold;">
                            <td class="text-center text-light" style="width: 3%;">NO</td>
                            <td class="text-light" style="width: 10%;">NOMOR</td>
                            <td class="text-light" style="width: 10%;">TANGGAL</td>
                            <td class="text-light" style="width: 20%;">EXSPEDISI</td>
                            <td class="text-light" style="width: 10%;">FAKTUR</td>
                            <td class="text-light" style="width: 10%;">KEMBALI</td>
                            <td class="text-light" style="width: 15%;">BELUM KEMBALI</td>
                            <td class="text-light" style="width: 13%;">GAGAL KIRIM</td>
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
<div class="modal fade" id="modal-filter" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
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
                        <label class="col-md-4 control-label" for="example-daterange1">Masukan Tanggal</label>
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

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var surat_bulan_ini = $("#surat_bulan_ini").val();
        var tAwal = $("#tAwal").val();
        var tAkhir = $("#tAkhir").val();
        $('#do').dataTable( {
            "bpagingType": "bs_two_button",
            "bProcessing": true,
            //"bServerSide": true,	
            //"sAjaxSource": "<?php echo base_url();?>admin/packing/all_unpacking",
            "ajax": {
                url: "<?php echo site_url('admin/surat_jalan/all_surat_jalan') ?>",
                data: {
                    surat_bulan_ini: surat_bulan_ini,
                    tAwal: tAwal,
                    tAkhir: tAkhir,
                },
                type: "POST"
            },                
            "lengthMenu": [[25,100, 200, 100, -1], [25,100, 200, 100, 100, "All"]],
            "aoColumns": [
                { "mData": "no" },
                { "mData": "nomor" },
                { "mData": "tanggal" },
                { "mData": "exspedisi" },
                { "mData": "jumlah" },
                { "mData": "kembali" },
                { "mData": "belum_kembali" },
                { "mData": "gagal" },
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

    function print(surat_jalan_id) {
        $("<iframe>")                             // create a new iframe element
            .hide()                               // make it invisible
            .attr("src", "<?php echo base_url(); ?>admin/surat_jalan/print_surat_jalan/"+surat_jalan_id+"") // point the iframe to the page you want to print
            .appendTo("body");                    // add iframe to the DOM to cause it to load the page
    }       

</script>