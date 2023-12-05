<!-- All Orders Block -->
<style>
    .table th {
        font-size: 5px;
    }
</style>
<div class="block full">

    <!-- All Orders Title -->
    <div class="block-title">
        <h2 class=""><i class="gi gi-inbox_in animation-pulse" style="margin-top: -7px"></i> <strong><?=$title;?></strong></h2>
        <div class="block-options pull-right" style="margin-right: 15px;">
        <input type='hidden' name='nomor_nota' class='form-control input-sm' id='nomor_nota' value="<?php echo $nomor_nota; ?>">
        <input type='hidden' name='nomor_spb' class='form-control input-sm' id='nomor_spb' value="<?php echo $spb[0]->nomor_spb; ?>">
        </div>
    </div>
    <!-- END All Orders Title -->

    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
            <h4><i class='fa fa-info-circle fa-fw animation-pulse'></i> Form Penerimaan Barang berdasarkan surat pembelian (SPB)</h4>
            <br />
            <div class="table-responsive">
                <table id="do" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <tbody>
                        <?php
                            $supplier = $this->db->get_where('vendor', array('id' => $spb[0]->id_supplier))->result();
                            $marketing = $this->db->get_where('marketing_supplier', array('id' => $spb[0]->id_marketing))->result();
                            $jenis_pembelian='';

                            if($spb[0]->jenis_spb=='so'){
                                $jenis_pembelian = 'SO';
                            }else{
                                $jenis_pembelian='STOK';
                            }
                        
                        ?>
                        <tr>
                            <td width="25%">NOMOR SURAT</td>
                            <td width="2px">:</td>
                            <td><?=(isset($spb[0]->nomor_spb) ? $spb[0]->nomor_spb : '-');?></td>
                        </tr>
                        <tr>
                            <td width="25%">TANGGAL PEMBELIAN</td>
                            <td width="2px">:</td>
                            <td><?=(isset($spb[0]->nomor_spb) ? $spb[0]->tanggal_spb : '-');?></td>
                        </tr>
                        <tr>
                            <td width="25%">NAMA MARKETING</td>
                            <td width="2px">:</td>
                            <td><?=(isset($marketing[0]->nama_lengkap) ? $marketing[0]->nama_lengkap : '-');?></td>
                        </tr>
                        <tr>
                            <td width="25%">SUPPLIER</td>
                            <td width="2px">:</td>
                            <td><?=strtoupper(isset($supplier[0]->nama_vendor) ? $supplier[0]->nama_vendor : '-');?></td>
                        </tr>
                        <tr>
                            <td width="25%">JENIS SPB</td>
                            <td width="2px">:</td>
                            <td><?=$jenis_pembelian;?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>    

    <form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">
        <div class="form-group">           
            <div class="col-lg-3 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-files-o"></i></span>
                    <input type="text" id="invoice" name="invoice" class="form-control" placeholder="Nomor Invoice" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-5 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" id="pengirim" name="pengirim" class="form-control" placeholder="Nama Pengirim" autocomplete="off">
                </div>
            </div>
        </div>
    </form>


    <!-- Products Content -->
    <div style="overflow: hidden; overflow-x: auto; ">
        <div class="table-responsive" style="margin-top:15px; width: 2600px;">
            <table class="table table-bordered" id='TabelTransaksi' style="width: auto;">
                <thead>
                    <tr class="themed-background-blackberry text-light">
                        <td class='text-center' style="width: 2%;">NO</td>
                        <td style="width: 5%">KODE BARANG</td>
                        <td style="width: 15%">NAMA BARANG</td>
                        <td class='text-center' style="width: 10%">SPESIFIKASI</td>
                        <td class='text-center' style="width: 5%">SATUAN</td>
                        <td class='text-center' style="width: 5%">Harga</td>
                        <td class='text-center' style="width: 5%">Qty</td>
                        <td class='text-center' style="width: 5%">JUMLAH HARGA</td>
                        <td class='text-center' style="width: 5%">PPN</td>
                        <td class='text-center' style="width: 5%">HARGA SETELAH PAJAK</td>

                        <td class='text-center' style="width: 5%">HARGA SPB</td>
                        <td class='text-center' style="width: 5%">Qty SPB</td>
                        <td class='text-center' style="width: 5%">JUMLAH HARGA SPB</td>
                        <td class='text-center' style="width: 5%">HARGA PAJAK</td>
                        <td class='text-center' style="width: 5%">DISKON (%)</td>
                        <td class='text-center' style="width: 5%">DISKON PEMBELIAN(Rp.)</td>
                        <td class='text-center' style="width: 5%">HARGA DISKON (Rp.)</td>

                    </tr>
                </thead>                
                <tbody>
                    <?php
                        $q = $this->db->query("SELECT 
                                                pembelian_detail.* , 
                                                barang.kode_barang AS kode_barang,
                                                barang.nama_barang AS nama_barang,
                                                barang.spesifikasi AS spesifikasi,
                                                barang.satuan AS satuan
                                                FROM pembelian_detail, barang
                                                WHERE pembelian_detail.id_pembelian_m=$id_pembelian_m
                                                AND pembelian_detail.id_barang=barang.id_barang
                                                ORDER BY barang.nama_barang ASC");
                        $no = 1;
                        //$result = array();
                        //$result['total'] = $q->num_rows();
                        //$row = array();

                        foreach($q->result() as $d) {
                            ?>
                            <tr>
                                <td class="text-center success"><?=$no;?></td>
                                <td class="text-left success">
                                    <?=$d->kode_barang;?>
                                    <input type='hidden' class='form-control' name='kode_barang[]' id='pencarian_kode' value="<?=$d->kode_barang;?>">
                                </td>
                                <td class="text-left success"><?=$d->nama_barang;?></td>
                                <td class="text-left success">
                                    <?=$d->spesifikasi;?>
                                    <input type='hidden' name='spesifikasi[]' value="<?=$d->spesifikasi;?>">
                                </td>
                                <td class="text-left success">
                                    <?=$d->satuan;?>
                                    <input type='hidden' name='satuan[]' value="<?=$d->satuan;?>">
                                </td>
                                <td class="text-right success"><?=str_replace(',', '.', number_format($d->harga_satuan));?></td>                                
                                <td class="text-center success"><?=$d->jumlah_beli;?></td>
                                <td class="text-right success"><?=str_replace(',', '.', number_format($d->total));?></td>                                
                                <td class="text-right success">
                                    <?=str_replace(',', '.', number_format($d->ppn));?>
                                    <input type="hidden" name='ppn1[]' id='ppn1' value='<?=$d->ppn;?>'>
                                </td>                                
                                <td class="text-right success"><?=str_replace(',', '.', number_format($d->harga_pajak));?></td>  
                                
                                <td>
                                    <input type='text' placeholder='0' class='form-control text-right' id='harga_satuan' name='harga_satuan[]' onkeypress='return check_int(event)'>                                
                                </td>
                                <td>
                                    <input type='text' placeholder='0' class='form-control text-center' id='jumlah_beli_spb' name='jumlah_beli_spb[]' onkeypress='return check_int(event)'>                                
                                </td>
                                <td>
                                    <input type='hidden' placeholder='0' class='form-control text-center' id='sub_total_spb' name='sub_total_spb[]'>   
                                    <span></span>                                                                 
                                </td>
                                <td>
                                    <input type='hidden' placeholder='0' class='form-control text-right' id='harga_pajak' name='harga_pajak[]'>
                                    <span></span>                                                                                                 
                                </td>
                                <td>
                                    <input type='text' class='decimal form-control text-center' id='diskon_barang' name='diskon_barang[]' placeholder='0.0'>                                
                                </td>
                                <td>
                                    <input type='hidden' placeholder='0' class='form-control text-right' id='diskon_pembelian' name='diskon_pembelian[]'>                                
                                    <span></span> 
                                </td>
                                <td>
                                    <input type='hidden' placeholder='0' class='form-control text-right' id='diskon_harga' name='diskon_harga[]'>                                
                                    <span></span> 
                                </td>
                            </tr>    
                            <?php
                            $no++;
                        }	            
                    ?>

                </tbody>


            </table>
            <br />
        </div>
        <!-- END table responsive -->
    </div>


    <div class="row" style="margin-top: 10px;">
        <div class='col-sm-7'>
            <p class="text-info"><i class='fa fa-info-circle fa-fw animation-pulse'></i> <b>Form Penerimaan Barang : </b></p>
            <div class='row'>
                <div class='col-sm-12'>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">
                <div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">
                        TOTAL HARGA BARANG
                    </label>
                    <div class="col-md-6">
                        <input type="text" id="TotalBayar" class="form-control" placeholder='0' disabled>
                        <input type="hidden" id="TotalBayarHidden" name="TotalBayarHidden">
                    </div>
                </div>
                

                <div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">
                        PPN PEMBELIAN
                    </label>
                    <div class="col-md-6">
                        <input type="text" id="ppnShow" class="form-control" placeholder='0' disabled>
                        <input type="hidden" id="ppn" name="ppn">
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; margin-bottom:-15px">
                    <label class="col-md-6 control-label" for="example-hf-email">NETTO</label>
                    <div class="col-md-6">
                        <input type='hidden' id='NettoHidden' class='form-control'>
                        <input type='text' id='Netto' class='form-control' disabled>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; margin-bottom:-15px">
                    <label class="col-md-6 control-label" for="example-hf-email">DISKON PEMBELIAN</label>
                    <div class="col-md-6">
                        <input type='hidden' id='DiskonPembelianHidden' class='form-control'>
                        <input type='text' id='DiskonPembelian' class='form-control' disabled>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; margin-bottom:-15px">
                    <label class="col-md-6 control-label" for="example-hf-email">NETTO BAYAR</label>
                    <div class="col-md-6">
                        <input type='hidden' id='NettoBayarHidden' class='form-control'>
                        <input type='text' id='NettoBayar' class='form-control' disabled>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; margin-bottom:-15px">
                    <label class="col-md-6 control-label" for="example-hf-email">UANG MUKA</label>
                    <div class="col-md-6">
                        <input type='text' id='UangCash' class='form-control' name="UangCash" placeholder="0" value="0">
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; margin-bottom:-15px">
                    <label class="col-md-6 control-label" for="example-hf-email">SISA PEMBAYARAN</label>
                    <div class="col-md-6">
                        <input type='hidden' id='SisaBayarHidden' class='form-control'>
                        <input type='text' id='SisaBayar' class='form-control' disabled>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none;">
                    <div class='col-sm-6'>
                        <button type='reset' class='btn btn-warning btn-block' id='CetakStruks'>
                            <i class='fa fa-refresh'></i> Batal
                        </button>
                    </div>
                    <div class='col-sm-6'>
                        <button type='button' class='btn btn-primary btn-block' id='Simpann'>
                            <i class='fa fa-floppy-o'></i> Simpan (F10)
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>


</div>
<!-- END All Orders Block -->
<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script>
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



//HITUNG SUB TOTAL + CEK STOK BARANG
    $(document).on('keyup', '#harga_satuan', function() {
        var Indexnya = $(this).parent().parent().index();
        var IndexChexbox = $(this).parent().parent().parent().parent().index();

        var Harga = $(this).val();
        var JumlahBeli = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(12) input').val();
        var HargaPajak = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input').val();

        if(Harga > 0){
            var SubTotal = parseInt(Harga) * parseInt(JumlahBeli);
            var HPajak = 0;
            if (SubTotal > 0) {
                var SubTotalVal = SubTotal;
                SubTotal = to_rupiah(SubTotal);

                var HPajak = SubTotalVal - parseInt(HargaPajak);
            } else {
                SubTotal = '';
                var SubTotalVal = 0;
            }

        }
        //$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input').val(0);// kalo qty dirubah, set diskon =0
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(13) input').val(SubTotalVal);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(13) span').html(SubTotal);

        //HARGA PAJAK
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(14) input').val(HPajak);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(14) span').html(HPajak);

        //resset pajak ppn pph ke 0


        //harga - pajak

        // HitungTotalBayar();
    });


    //HARGA BARANG
    $(document).on('keydown', '#harga_satuan', function(e) {
        var charCode = e.which || e.keyCode;
        if (charCode == 9) {
            var Indexnya = $(this).parent().parent().index() + 1;
            var TotalIndex = $('#TabelTransaksi tbody tr').length;
            if (Indexnya == TotalIndex) {
                BarisBaru();
                return false;
            }
            //$('#diskon_barang').val(0);
        }

        HitungTotalBayar();
    });


    //HITUNG SUB TOTAL + CEK STOK BARANG
    $(document).on('keyup', '#jumlah_beli_spb', function() {
        var Indexnya = $(this).parent().parent().index();
        var IndexChexbox = $(this).parent().parent().parent().parent().index();

        var Harga = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(11) input').val();
        var JumlahBeli = $(this).val();

        var HargaPajak = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input').val();

        var SubTotal = parseInt(Harga) * parseInt(JumlahBeli);
        var HPajak=0;
        if (SubTotal > 0) {
            var SubTotalVal = SubTotal;
            SubTotal = to_rupiah(SubTotal);

            var HPajak = SubTotalVal - parseInt(HargaPajak);

        } else {
            SubTotal = '';
            var SubTotalVal = 0;
        }
        //$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input').val(0);// kalo qty dirubah, set diskon =0
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(13) input').val(SubTotalVal);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(13) span').html(SubTotal);

        //HARGA PAJAK
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(14) input').val(HPajak);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(14) span').html(to_rupiah(HPajak));


        //NOMINAL DISKON
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(16) input').val(0);


        //HARGA DISKON
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(17) input').val(HPajak);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(17) span').html(to_rupiah(HPajak));


        HitungTotalBayar();
    });

    //SUB TOTAL
    $(document).on('keydown', '#jumlah_beli_spb', function(e) {
        var charCode = e.which || e.keyCode;
        if (charCode == 9) {
            var Indexnya = $(this).parent().parent().index() + 1;
            var TotalIndex = $('#TabelTransaksi tbody tr').length;
            if (Indexnya == TotalIndex) {
                BarisBaru();
                return false;
            }
            //$('#diskon_barang').val(0);
        }

        HitungTotalBayar();
    });



    //HITUNG DISKON BARANG =  HARGA - TOTAL PAJAK * DISKON BARANG
    $(document).on('keyup', '#diskon_barang', function() {
        var Indexnya = $(this).parent().parent().index();
        var Indexnya2 = $(this).parent().parent().parent().index();
        var DiskonBarang = $(this).val();
        var PersenDiskon = parseFloat(DiskonBarang) / 100;

        var HargaSetelahPajak = parseInt($('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(14) input').val());
        var nominalDiskon = 0;
        var HargaSetelahDiskon = HargaSetelahPajak;

        if (parseFloat(DiskonBarang) > 0) {
            nominalDiskon = PersenDiskon * HargaSetelahPajak;
            //HargaSetelahDiskon = HargaSetelahPajak - nominalDiskon;
            HargaSetelahDiskon = (Math.floor(((HargaSetelahPajak - nominalDiskon).toFixed(0)) / 1000) * 1000);

            nominalDiskon = (Math.floor(((PersenDiskon * HargaSetelahPajak).toFixed(0))/100)*100);
            HargaSetelahDiskon = (HargaSetelahPajak - nominalDiskon).toFixed(0);


        } 

        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(16) input').val(nominalDiskon);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(16) span').html(to_rupiah(nominalDiskon));

        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(17) input').val(HargaSetelahDiskon);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(17) span').html(to_rupiah(HargaSetelahDiskon));

        HitungTotalBayar();
    });
    //SUB TOTAL
    $(document).on('keydown', '#diskon_barang', function(e) {
        var charCode = e.which || e.keyCode;
        if (charCode == 9) {
            var Indexnya = $(this).parent().parent().index() + 1;
            var TotalIndex = $('#TabelTransaksi tbody tr').length;
            if (Indexnya == TotalIndex) {
                BarisBaru();
                return false;
            }
        }

        HitungTotalBayar();
    });


    //HITUNG TOTAL BAYAR
    function HitungTotalBayar() {
        var Total = 0;
        var TotalPpn11 = 0;
        var TotalBayar = 0;
        var TotalNetto = 0;
        var TotalDiskon=0;
        var NettoBayar=0;
        $('#TabelTransaksi tbody tr').each(function() {
            if ($(this).find('td:nth-child(12) input').val() > 0) {
                var SubTotal = $(this).find('td:nth-child(13) input').val();
                Total = parseInt(Total) + parseInt(SubTotal);

                //hitung total ppn
                var ppn11 = $(this).find('td:nth-child(9) input').val();
                TotalPpn11 = parseInt(TotalPpn11) + parseInt(ppn11)

                //SisaBayarHidden
                TotalNetto = parseInt(Total) - parseInt(TotalPpn11)
                //TotalNetto = (Math.floor((TotalNetto - TotalDiskon) / 1000)*1000);

                //TOTAL DISKON PEMBELIAN
                var SubTotalDiskon = $(this).find('td:nth-child(16) input').val();
                TotalDiskon = parseInt(TotalDiskon) + parseInt(SubTotalDiskon);

                //HITUNG NETTO BAYAR
                NettoBayar = TotalNetto - TotalDiskon;


            }
        });
        //TotalBayar
        $('#TotalBayar').val(to_rupiah(Total));
        $('#TotalBayarHidden').val(Total);

        $('#ppnShow').val(to_rupiah(TotalPpn11));
        $('#ppn').val(TotalPpn11);

        $('#Netto').val(to_rupiah(TotalNetto));
        $('#NettoHidden').val(TotalNetto);

        $('#DiskonPembelian').val(to_rupiah(TotalDiskon));
        $('#DiskonPembelianHidden').val(TotalDiskon);

        $('#NettoBayar').val(to_rupiah(NettoBayar));
        $('#NettoBayarHidden').val(NettoBayar);
               
        $('#SisaBayar').val(to_rupiah(NettoBayar));
        $('#SisaBayarHidden').val(NettoBayar);
    }

    $(document).on('keyup', '#UangCash', function() {
        HitungSisaBayar();
    });

    //TOTAL KEMBALIAN
    function HitungSisaBayar() {
        var UangMuka = $('#UangCash').val();
        var NettoBayar = $('#NettoBayarHidden').val();

        if ((parseInt(UangMuka) >= 0) && (parseInt(UangMuka) <= parseInt(NettoBayar))) {
            var Selisih = parseInt(NettoBayar) - parseInt(UangMuka);
            $('#SisaBayar').val(to_rupiah(Selisih));
            $('#SisaBayarHidden').val(Selisih);
        } else {
            $('#SisaBayar').val('');
            $('#SisaBayarHidden').val('');

        }
    }

    //BUTTON SIMPAN DI CLICK
    $(document).on('click', '#Simpann', function() {
        $('.modal-dialog').removeClass('modal-lg');
        $('.modal-dialog').addClass('modal-sm');
        $('#ModalHeader').html('Konfirmasi');
        $('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
        $('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
        $('#ModalGue').modal('show');

        setTimeout(function() {
            $('button#SimpanTransaksi').focus();
        }, 500);
    });

    //BUTTON MODAL DI CLICK
    $(document).on('click', 'button#SimpanTransaksi', function() {
        SimpanTransaksi();
    });

    function SimpanTransaksi() {
        var no_urut = $("#nomor_nota").val();
        var nomor_spb = $("#nomor_spb").val();

        var FormData = "nomor_nota=" + encodeURI($('#nomor_nota').val());
        FormData += "&id_pelanggan=1";
        FormData += "&" + $('#TabelTransaksi tbody input').serialize();
        FormData += "&tanggal=" + $('#tanggal').val();
        FormData += "&invoice=" + $('#invoice').val();
        FormData += "&pengirim=" + $('#pengirim').val();
        FormData += "&no_urut=" + no_urut;
        FormData += "&nomor_spb=" + nomor_spb;
        FormData += "&ppn=" + $('#ppn').val();
        FormData += "&TotalBayarHidden=" + $('#TotalBayarHidden').val();
        FormData += "&NettoHidden=" + $('#NettoHidden').val();
        FormData += "&DiskonPembelianHidden=" + $('#DiskonPembelianHidden').val();
        FormData += "&NettoBayarHidden=" + $('#NettoBayarHidden').val();
        FormData += "&UangCash=" + $('#UangCash').val();
        FormData += "&SisaBayarHidden=" + $('#SisaBayarHidden').val();

        $.ajax({
            url: "<?php echo site_url('admin/penerimaan/form_penerimaan/'.$id_pembelian_m); ?>",
            type: "POST",
            cache: false,
            data: FormData,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    //alert(data.pesan);
                    $('.modal-dialog').removeClass('modal-lg');
                    $('.modal-dialog').addClass('modal-sm');
                    $('#ModalHeader').html('Sukses !');
                    $('#ModalContent').html(data.pesan);
                    $('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
                    $('#ModalGue').modal('show');
                    // // window.location.href = "<?php echo site_url('admin/penerimaan/form_penerimaan'); ?>";

                } else {
                    $('.modal-dialog').removeClass('modal-lg');
                    $('.modal-dialog').addClass('modal-sm');
                    $('#ModalHeader').html('Oops !');
                    $('#ModalContent').html(data.pesan);
                    $('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
                    $('#ModalGue').modal('show');
                }
            }
        });
    } 
    //KONVERSI KE RUPIAH
    function to_rupiah(angka) {
        var rev = parseInt(angka, 10).toString().split('').reverse().join('');
        var rev2 = '';
        for (var i = 0; i < rev.length; i++) {
            rev2 += rev[i];
            if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
                rev2 += '.';
            }
        }
        return 'Rp. ' + rev2.split('').reverse().join('');
    }

    function check_int(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        return (charCode >= 48 && charCode <= 57 || charCode == 8);
    }


    $(function() {
        $("input.decimal").bind("change keyup input", function() {
            var position = this.selectionStart - 1;
            //remove all but number and .
            var fixed = this.value.replace(/[^0-9\.]/g, "");
            if (fixed.charAt(0) === ".")
                //can't start with .
                fixed = fixed.slice(1);

            var pos = fixed.indexOf(".") + 1;
            if (pos >= 0)
                //avoid more than one .
                fixed = fixed.substr(0, pos) + fixed.slice(pos).replace(".", "");

            if (this.value !== fixed) {
                this.value = fixed;
                this.selectionStart = position;
                this.selectionEnd = position;
            }
        });

        $("input.integer").bind("change keyup input", function() {
            var position = this.selectionStart - 1;
            //remove all but number and .
            var fixed = this.value.replace(/[^0-9]/g, "");

            if (this.value !== fixed) {
                this.value = fixed;
                this.selectionStart = position;
                this.selectionEnd = position;
            }
        });
    });

    //HAPUS BARIS
    $(document).on('click', '#HapusBaris', function(e) {
        e.preventDefault();
        $(this).parent().parent().remove();

        var Nomor = 1;
        $('#TabelTransaksi tbody tr').each(function() {
            $(this).find('td:nth-child(1)').html(Nomor);
            Nomor++;
        });

        HitungTotalBayar();
    });

</script>