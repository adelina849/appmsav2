<!-- Quick Stats -->
<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">

<!-- Quick Stats -->
<div class="row text-center">
    <div class="col-sm-6 col-lg-4">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background">
                <h4 class="widget-content-light"><i class="gi gi-money"></i> <strong>Total</strong> Nilai SP</h4>
            </div>
            <?php

                $s = "SELECT 
                        a.nomor_do,
                        b.id_packing_m,
                        c.id_pesanan_m, c.grand_total
                        FROM packing_do AS a
                        INNER JOIN packing_master AS b
                        ON a.id_packing_m=b.id_packing_m
                        INNER JOIN pesanan_master AS c
                        ON b.id_pesanan_m = c.id_pesanan_m
                        $data_wheres
                        ORDER BY a.nomor_do DESC";

                $q = $this->db->query($s);
                $total_sp = 0;
                $total_do = 0;
                $total_nomor_do=0;
                $nilai_do = 0;

                foreach($q->result() as $dt) {
                    $total_sp+=$dt->grand_total;
                    $total_nomor_do+=1;

                    //HITUNG NILAI FAKTUR DO
                    $QpackingDetail = $this->db->get_where('packing_detail', array('id_packing_m' => $dt->id_packing_m, 'qty_terpacking >' => 0))->result();
                    foreach ($QpackingDetail as $pd) {
                        $harga_total = 0;
                    // $jmlQty = 0;
                        $pdid_barang = $pd->id_barang;
                        //$pdbarang = $this->db->get_where('barang', array('id_barang' => $pd->id_barang))->result();
                        $sp_detail = $this->db->get_where('pesanan_detail', array('id_pesanan_m' => $dt->id_pesanan_m, 'id_barang'=>$pdid_barang))->result();
                        $harga_satuan = (isset($sp_detail[0]->harga_satuan) ? $sp_detail[0]->harga_satuan : 0); 
                        $harga_total = ($pd->qty_terpacking * $harga_satuan);
                        $nilai_do += $harga_total;
                    }

                }
                //str_replace(',', '.', number_format($data->grand_total)) 
            ?>

            <div class="widget-extra-full"><span class="h2 themed-color-spring animation-expandOpen"><?='Rp. '.str_replace(',', '.', number_format($total_sp)) ;?></span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-4">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-spring">
                <h4 class="widget-content-light"><i class="fa fa-money"></i> <strong> Total</strong> Nilai DO</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen"><?='Rp. '.str_replace(',', '.', number_format($nilai_do)) ;?></span></div>
        </a>
    </div>

    <div class="col-sm-6 col-lg-4">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background">
                <h4 class="widget-content-light"><i class="fa fa-truck"></i> <strong>Jumlah Total</strong> DO</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen"><?= $total_nomor_do;?></span></div>
        </a>
    </div>
</div>
<!-- END Quick Stats -->


<div class="block full">
    <!-- All Orders Title -->
    <div class="block-title">
        <div class="block-options pull-right" style="margin-right: 15px;">
        </div>
        <h2><i class="fa fa-list-alt"></i> <strong><?= $title; ?></strong></h2>
    </div>

    <div class="row">
        <div class='col-sm-4' style="margin-bottom: 5px;">
            <div class="btn-group btn-group-lg">
                <?php echo form_open('admin/packing/surat_pesanan', array('class' => '"', 'id' => '')); ?>
                <input type="hidden" name="judul" value="<?= $title; ?>">
                <input type="hidden" name="sp_bulan_ini" id="sp_bulan_ini" value="<?= $sp_bulan_ini; ?>">
                <input type="hidden" name="tAwal" id="tAwal" value="<?= $tAwal; ?>">
                <input type="hidden" name="tAkhir" id="tAkhir" value="<?= $tAkhir; ?>">
                <input type="hidden" name="id_lembaga" id="id_lembaga" value="<?= $id_lembaga; ?>">
                <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?= $id_pelanggan; ?>">

                <a href="#" data_id_barang="<?= 1; ?>" data-toggle="tooltip" title="Filter Surat Pesanan" class="btn btn-alt btn-sm btn-warning" onclick="$('#modal-filter').modal('show');">
                    <i class="fa fa-search"></i> Filter DO
                </a>
                <?php echo form_close(); ?>
            </div>
        </div>
        <div class='col-sm-8'>
            <p class="text-muted"><i class='fa fa-check-square-o fa-fw animation-pulse'></i> <b>Daftar DO yang sudah divalidasi </b></p>
        </div>

    </div>
    <!-- END row -->

    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
            <div class="table-responsive">
                <table id="do" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr class="themed-color themed-background-spring" style="font-weight: bold;">
                            <td class="text-center text-light" style="width: 3%;">NO</td>
                            <td class="text-light" style="width: 10%;">NOMOR DO</td>
                            <td class="text-light" style="width: 10%;">NOMOR SP</td>
                            <td class="text-light">PELANGGAN</td>
                            <td class="text-light">LEMBAGA</td>
                            <td class="text-light" style="width: 10%;">JENJANG</td>
                            <td class="text-light" style="width: 10%;">STATUS</td>
                            <td class="text-light" style="width: 10%;">PEMBAYARAN</td>
                            <td class="text-light" style="width: 15%;">NILAI FAKTUR (Rp.)</td>
                            <td class="text-light" style="width: 10%;">NILAI SP (Rp.)</td>
                            <td class="text-center no-sort text-light" style="width: 5%;"><i class="fa fa-cog"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <!--<tfoot>
                        <tr>
                            <th colspan="7">Total Nilai SP</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    -->
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

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script type="text/javascript">


    $(document).ready(function() {
        var sp_bulan_ini = $("#sp_bulan_ini").val();
        var tAwal = $("#tAwal").val();
        var tAkhir = $("#tAkhir").val();
        var id_lembaga = $("#id_lembaga").val();
        var id_pelanggan = $("#id_pelanggan").val();

        $('#do').dataTable( {
            "bpagingType": "bs_two_button",
            "bProcessing": true,
            //"bServerSide": true,	
            //"sAjaxSource": "<?php echo base_url();?>admin/packing/all_unpacking",
            "ajax": {
                url: "<?php echo site_url('admin/order/all_dovalidate') ?>",
                data: {
                    sp_bulanini: sp_bulan_ini,
                    tAwal: tAwal,
                    tAkhir: tAkhir,
                    id_pelanggan: id_pelanggan,
                    id_lembaga: id_lembaga
                },
                type: "POST"
            },                
            "lengthMenu": [
				[25, 50, 100, -1],
				[25, 50, 100, "All"],
            ],
            "aoColumns": [
                { "mData": "no" },
                { "mData": "nomor_do" },
                { "mData": "nomor_sp" },
                { "mData": "pelanggan" },
                { "mData": "lembaga" },
                { "mData": "jenjang" },
                { "mData": "status" },
                { "mData": "pembayaran" },
                { "mData": "nilai_do" },
                { "mData": "nilai_sp" },
                { "mData": "aksi" }
            ],

            // "footerCallback": function ( row, data, start, end, display ) {
            //     var api = this.api(), data;
    
            //     // converting to interger to find total
        
    
            //     var intVal = function (i) {
            //     if(typeof i === 'string') {
            //         let multiplier = /[\(\)]/g.test(i) ? -1 : 1;
            //         //
            //         return (i.replace(/[\$,\(\)]/g, '') * multiplier)
            //     }
                
            //     return typeof i === 'number' ?
            //         i : 0;
            //     };


            //     // computing column Total of the complete result 
            //     var nilaiDo = api
            //         .column(7)
            //         .data()
            //         .reduce( function (a, b) {
            //             return intVal(a) + intVal(b);
            //         }, 0 );
            //     var nilaiSp = api
            //         .column(8)
            //         .data()
            //         .reduce( function (a, b) {
            //             return intVal(a) + intVal(b);
            //         }, 0 );
                    
            //     // var tueTotal = api
            //     //     .column( 2 )
            //     //     .data()
            //     //     .reduce( function (a, b) {
            //     //         return intVal(a) + intVal(b);
            //     //     }, 0 );
                                
            //     var	number_string = nilaiSp.toString(),
            //         sisa 	= number_string.length % 3,
            //         rupiah 	= number_string.substr(0, sisa),
            //         ribuan 	= number_string.substr(sisa).match(/\d{3}/g);
                        
            //     if (ribuan) {
            //         separator = sisa ? '.' : '';
            //         rupiah += separator + ribuan.join('.');
            //     }

            //     //document.write(rupiah); // Hasil: 23.456.789            

            //     // Update footer by showing the total with the reference of the column index 
            //     $( api.column( 7 ).footer() ).html('<div class="text-right">'+ nilaiDo+'</div>');
            //     // $( api.column( 2 ).footer() ).html(tueTotal);
            // // console.log(intVal(nilaiSp))            
            // },            

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

</script>