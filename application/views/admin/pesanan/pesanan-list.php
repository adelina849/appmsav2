<!-- Quick Stats -->
<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
<div class="row text-center">
    <div class="col-sm-6 col-lg-4">
        <a href="javascript:void(0)" class="widget widget-hover-effect2" data-toggle="tooltip" title="Input surat pesanan baru">
            <div class="widget-extra themed-background">
            <h4 class="widget-content-light"><strong>Total</strong> Pesanan (Rp.)</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 text-primary animation-expandOpen "><?=$total_sp;?></span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-4">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-success">
                <h4 class="widget-content-light"><strong>Jumlah</strong> SP</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen"><?=$count_sp;?></span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-4">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-info">
                <h4 class="widget-content-light"><strong>Semua</strong> Pesanan</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen"><?=$count_sp_all;?></span></div>
        </a>
    </div>
</div>
<div class="block full">
    <!-- All Orders Title -->
    <div class="block-title">
        <div class="block-options pull-right" style="margin-right: 15px;">
            <a href="<?= site_url('admin/pesanan/form_pesanan'); ?>" class="btn btn-alt btn-sm btn-primary" data-toggle="tooltip" title="Input SP Buku">
                <i class="fa fa-plus-circle"></i> Input SP Buku
            </a>
        </div>
        <h2><i class="fa fa-list-alt"></i> <strong><?= $title; ?></strong>
        </h2>
    </div>
    <div class="row">
        <div class='col-sm-12' style="margin-bottom: 5px;">
            <div class="btn-group btn-group-lg">
                <?php echo form_open('admin/pesanan/daftar', array('class' => '"', 'id' => '', 'target' => '_blank')); ?>
                <input type="hidden" name="judul" value="<?= $title; ?>">
                <input type="hidden" name="sp_bulan_ini" id="sp_bulan_ini" value="<?= $sp_bulan_ini; ?>">
                <input type="hidden" name="tAwal" id="tAwal" value="<?= $tAwal; ?>">
                <input type="hidden" name="tAkhir" id="tAkhir" value="<?= $tAkhir; ?>">
                <input type="hidden" name="id_lembaga" id="id_lembaga" value="<?= $id_lembaga; ?>">
                <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?= $id_pelanggan; ?>">

                <a href="#" data_id_barang="<?= 1; ?>" data-toggle="tooltip" title="Filter Surat Pesanan Buku" class="btn btn-alt btn-sm btn-primary" onclick="$('#modal-filter').modal('show');">
                    <i class="fa fa-search"></i> Filter SP Buku
                </a>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <!-- END row -->

    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
            <div class="table-responsive">
                <table id="table_pesanan" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr class="themed-color themed-background" style="font-weight: bold;">
                            <td class="text-center text-light" style="width: 3%;">NO</td>
                            <td class="text-light" style="width: 10%;">NOMOR SP</td>
                            <td class="text-light" style="width: 12%;">TANGGAL</td>
                            <td class="text-light" style="width: 10%;">JENIS SP</td>
                            <td class="text-light" style="width: 10%;">PEMBAYARAN</td>
                            <td class="text-light">NAMA LEMBAGA</td>
                            <td class="text-light">NAMA PELANGGAN</td>
                            <td class="text-light" style="width: 10%;">TOTAL SP (Rp.)</td>
                            <td class="text-center no-sort text-light" style="width: 12%;"><i class="fa fa-cog"></i></td>
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
                <h2 class="modal-title text-center text-primary"><i class="fa fa-search"></i> Filter Surat Pesanan</h2>
            </div>
            <!-- END Modal Header -->
            <!-- Modal Body -->
            <div class="modal-body">
                <?php echo form_open($action_filter, array('class' => 'form-horizontal form-bordered', 'id' => '')); ?>
                <input type="hidden" name="filter" value="filter">
                <fieldset>
                    
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="example-select">Lembaga</label>
                        <div class="col-md-8">
                            <select id="lembaga" name="lembaga" class="option-line-break chosen" style="width:100%;" placeholder="Nama Lembaga">
                                <option value="">-- Pilih Lembaga --</option>
                                <?php
                                $lembaga = $this->db->get_where('lembaga', array('dihapus' => 'tidak'))->result();
                                foreach ($lembaga as $lembagas) {
                                ?>
                                    <option data-description="<?= 'Kode: ' . $lembagas->kode .
                                                                    '<br>Alamat: ' . $lembagas->alamat .
                                                                    '<br>Jenjang: ' . $lembagas->jenjang .
                                                                    '<br>Status: ' . $lembagas->status .
                                                                    '<br>Klasifikasi: ' . $lembagas->klasifikasi; ?>" value="<?= $lembagas->id; ?>">
                                        <?= $lembagas->nama_lembaga; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="example-select">Pelanggan</label>
                        <div class="col-md-8">
                            <select id="pelanggan" name="pelanggan" class="option-line-break" style="width:100%;" placeholder="Nama Lembaga">
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php
                                $pelanggan = $this->db->get_where('pelanggan', array('dihapus' => 'tidak'))->result();
                                foreach ($pelanggan as $pelanggans) {
                                ?>
                                    <option data-description="<?= 'Kode: ' . $pelanggans->kode .
                                                                    '<br>Jabatan: ' . $pelanggans->jabatan .
                                                                    '<br>Kontak: ' . $pelanggans->kontak; ?>" value="<?= $pelanggans->id; ?>">
                                        <?= $pelanggans->nama_pelanggan; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

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

<!--Cetak sp  -->
<div id="FormCetak" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h2 class="modal-title text-center text-primary"><i class="fa fa-file-pdf-o"></i> Cetak Surat Pesanan</h2>
            </div>

            <!-- END Modal Header -->

            <!-- Modal Body -->
            <div class="modal-body">
                <?php echo form_open($action_cetak, array('class' => 'form-horizontal form-bordered"', 'id' => 'form', 'target' => '_blank')); ?>
                <input type="hidden" name="id_pesanan_m" class="id_pesanan_m">
                <fieldset>
                    <div class="form-group" style="margin:0 20px 0 20px">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="fa fa-info-circle"></i> Info!</h4>
                            Anda akan mencetak surat pesanan dalam format file PDF
                        </div>
                    </div>
                </fieldset>
                <div class="form-group form-actions">
                    <div class="col-xs-12 text-center">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Lanjutkan</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
            <!-- END Modal Body -->
        </div>
    </div>
</div>
<!-- END cetak sp -->


<!--HAPUS  -->
<div id="FormHapus" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> Hapus Surat Pesanan</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_delete, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_delete')); ?>
				<input type="hidden" name="id_pesanan_m" class="id_pesanan_m">
				<fieldset>
					<div class="form-group" style="margin:0 20px 0 20px">
						<div class="alert alert-warning alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="gi gi-circle_exclamation_mark"></i> Warning!</h4>
							Semua Data terkait surat pesanan akan dihapus, Apakah anda yakin?
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
        var sp_bulan_ini = $("#sp_bulan_ini").val();
        var tAwal = $("#tAwal").val();
        var tAkhir = $("#tAkhir").val();
        var id_lembaga = $("#id_lembaga").val();
        var id_pelanggan = $("#id_pelanggan").val();

        //alert(sp_bulan_ini);
        //datatables
        table = $('#table_pesanan').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                url: "<?php echo site_url('admin/pesanan/ajax_list_pesanan/buku') ?>",
                data: {
                    sp_bulanini: sp_bulan_ini,
                    tAwal: tAwal,
                    tAkhir: tAkhir,
                    id_pelanggan: id_pelanggan,
                    id_lembaga: id_lembaga
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
            "lengthMenu": [
				[25, 50, 100, -1],
				[25, 50, 100, "All"],
            ],
        });
    });

    $(document).ready(function() {
        $('body').tooltip({
            selector: '[data-toggle="tooltip"]'
        });
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


    function form_cektak(id_pesanan_m) {
        $(".id_pesanan_m").val(id_pesanan_m);
        $('#FormCetak').modal('show'); // show bootstrap modal when complete loaded
    }
	function form_hapus(id_pesanan_m) {
		$(".id_pesanan_m").val(id_pesanan_m);
		$('#FormHapus').modal('show'); // show bootstrap modal when complete loaded
	}

</script>