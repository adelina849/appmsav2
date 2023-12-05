<!-- All Orders Block -->
<style>
    .table th {
        font-size: 5px;
    }
</style>
<div class="block full">

    <!-- All Orders Title -->
    <div class="block-title">
        <h2 class=""><i class="fa fa-file-o animation-pulse" style="margin-top: -7px"></i> <strong><?=$title;?></strong></h2>
        <div class="block-options pull-right" style="margin-right: 15px;">
            <input type='hidden' name='nomor_nota' class='form-control input-sm' id='nomor_nota' value="<?php echo $nomor_nota; ?>">
        </div>
    </div>
    <!-- END All Orders Title -->
    <form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">
        <div class="form-group">
            <div class="col-lg-4 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <div class="input-date" data-date-format="yyy-mm-dd">
                        <input type="text" id="tanggal" name="tanggal" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-clipboard"></i>
                    </span>
                    <select id="jenis_spb" name="jenis_spb" class="select-select2 select2" style="width:100%;" disabled>
                        <option value="stok">PEMBELIAN STOK</option>
                    </select>
                </div>
            </div>            
        </div>

        <div class="form-group">
            <div class="col-md-6">
                <label for="marketing"><i class="fa fa-user"></i> Nama Marketing</label>
                <select id="marketing" name="marketing" class="option-line-break" style="width:100%;" placeholder="Nama Marketing">
                    <option value="">-- Pilih Marketing Supplier --</option>
                    <?php
                        $marketing = $this->db
                                            ->order_by('nama_lengkap', 'ASC')
                                            ->get_where('marketing_supplier', array('dihapus' => 'tidak'))
                                            ->result();
                        foreach ($marketing as $marketings) {
                            $supplier = $this->db->get_where('vendor', array('id' => $marketings->id_vendor))->result();
                        ?>
                            <option data-description="<?= 'KODE MARKETING: ' . $marketings->kode .
                                                            '<br>KODE SUPPLIER: ' . $supplier[0]->kode .
                                                            '<br>NAMA SUPPLIER: ' . $supplier[0]->nama_vendor.
                                                            '<br>KONTAK: ' . $supplier[0]->kontak;?>" 
                                                            value="<?= $marketings->id; ?>">
                                <?= $marketings->nama_lengkap; ?>
                            </option>
                        <?php
                        }
                        ?>
                </select>
            </div>

            <div class="col-md-4">
                <label for="pelanggan"><i class="fa fa-info-circle"></i> Hutang Awal</label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                        <input type="text" id="piutang" name="piutang" class="form-control" placeholder="Rp. 0" autocomplete="off" disabled>
                </div>
            </div>                    
        </div>

        <div class="form-group">           
            <div class="col-lg-3 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-cc-mastercard"></i>
                    </span>
                    <select id="sistem_pembayaran" name="sistem_pembayaran" class="select-select2" style="width:100%;">
                        <option value="">-- Sistem Pembayaran --</option>
                        <option value="kredit">KREDIT</option>
                        <option value="tunai">TUNAI</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar-check-o"></i></span>
                    <div class="input-date" data-date-format="yyy-mm-dd">
                        <input type="text" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Jatuh Tempo" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- END Horizontal Form Content -->
    <!-- Products Content -->
    <div style="overflow: hidden; overflow-x: auto; ">
        <div class="table-responsive" style="margin:15px 0px 20px 0px; width: 2600px;">
            <table class="table table-bordered" id='TabelTransaksi' style="width: auto;">
                <thead>
                    <tr class="themed-background-amethyst text-light">
                        <td class='text-center' style="width: 2%;">NO</td>
                        <td style="width: 10%">KODE BARANG</td>
                        <td style="width: 15%">NAMA BARANG</td>
                        <td class='text-center' style="width: 10%">SPESIFIKASI</td>
                        <td class='text-center' style="width: 5%">SATUAN</td>
                        <td class='text-center' style="width: 10%">Harga</td>
                        <td class='text-center' style="width: 3%">Qty</td>
                        <td class='text-center' style="width: 10%">JUMLAH HARGA</td>
                        <td class='text-center' style="width: 8%">PPN</td>
                        <td class='text-center' style="width: 10%">HARGA SETELAH PAJAK</td>
                        <td class='text-center' style="width: 2%"></td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <br />
        </div>
        <!-- END table responsive -->
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class='col-sm-7'>
            <p class="text-info"><i class='fa fa-info-circle fa-fw animation-pulse'></i> <b>Form Surat Pembelian : </b></p>
            <div class='row'>
                <div class='col-sm-12'>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">

                <div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">
                        JUMLAH HARGA
                    </label>
                    <div class="col-md-6">
                        <input type="text" id="TotalBayar" class="form-control" placeholder='0' disabled>
                        <input type="hidden" id="TotalBayarHidden" name="TotalBayarHidden">
                    </div>
                </div>
    
                <div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">
                        JUMLAH PPN
                    </label>
                    <div class="col-md-6">
                        <input type="text" id="ppnShow" class="form-control" placeholder='0' disabled>
                        <input type="hidden" id="ppn" name="ppn">
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none;">
                    <label class="col-md-6 control-label" for="example-hf-email">TOTAL HARGA</label>
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


        for (B = 1; B <= 1; B++) {
            BarisBaru();
        }
        $('#BarisBaru').click(function() {
            BarisBaru();
        });

        $("#TabelTransaksi tbody").find('input[type=text],textarea,select').filter(':visible:first').focus();
    });

    function BarisBaru() {
        var Nomor = $('#TabelTransaksi tbody tr').length + 1;
        var Baris = "<tr>";
        Baris += "<td>" + Nomor + "</td>";
        Baris += "<td>";
        Baris += "<input type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Barang'>";
        Baris += "<div id='hasil_pencarian'></div>";
        Baris += "</td>";
        Baris += "<td></td>";
        Baris += "<td>";
        Baris += "<input type='hidden' name='spesifikasi[]'>";
        Baris += "<span></span>";
        Baris += "</td>";
        Baris += "<td>";
        Baris += "<input type='hidden' name='satuan[]'>";
        Baris += "<span></span>";
        Baris += "</td>";
        
        Baris += "<td>";
        Baris += "<input type='text' class='form-control text-center' id='harga_satuan' name='harga_satuan[]' onkeypress='return check_int(event)' disabled>";
        Baris += "<span></span>";
        Baris += "</td>";

        Baris += "<td><input type='text' class='form-control text-center' id='jumlah_beli' name='jumlah_beli[]' onkeypress='return check_int(event)' disabled></td>";
        
        Baris += "<td>";
        Baris += "<input type='hidden' name='sub_total[]'>";
        Baris += "<span></span>";
        Baris += "</td>";

        //ppn 11
        Baris += "<td>";
        Baris += "<div class='input-group'>";
        Baris += "<input type='hidden' id='ppn11_barang_value'>";
        Baris += "<input type='text' id='ppn11_barang' name='ppn11_barang[]' class='decimal form-control' placeholder='0' disabled>";
        Baris += "<span class='input-group-addon'>";
        Baris += "<input type='checkbox' id='checkbox_ppn_barang' name='checkbox_ppn_barang' value='1'>";
        Baris += "</span>";
        Baris += "</div>";
        Baris += "</td>";

        Baris += "<td>";
        Baris += "<input type='hidden' name='harga_pajak[]'>";
        Baris += "<span></span>";
        Baris += "</td>";       
        Baris += "<td><a href='#' class='' id='HapusBaris'><i class='fa fa-times btn-xs' style='color:red;'></i></a></td>";

        Baris += "</tr>";

        $('#TabelTransaksi tbody').append(Baris);

        $('#TabelTransaksi tbody tr').each(function() {
            // $(this).find('td:nth-child(2) input').focus(); //fokus ke pencarian field kode
            $(this).find('td:nth-child(6) input').focus(); //fokus ke pencarian field kode
        });

        HitungTotalBayar();
    }

    //PENCARIAN KODE
    $(document).on('keyup', '#pencarian_kode', function(e) {
        if ($(this).val() !== '') {
            var charCode = e.which || e.keyCode;
            if (charCode == 40) {
                if ($('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').length > 0) {
                    var Selanjutnya = $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').next();
                    $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');

                    Selanjutnya.addClass('autocomplete_active');
                } else {
                    $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(2)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
                }
            } else if (charCode == 38) {
                if ($('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').length > 0) {
                    var Sebelumnya = $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').prev();
                    $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');

                    Sebelumnya.addClass('autocomplete_active');
                } else {
                    $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(2)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
                }
            } else if (charCode == 13) {
                var Field = $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(2)');
                var Kodenya = Field.find('div#hasil_pencarian li.autocomplete_active span#kodenya').html();
                var Barangnya = Field.find('div#hasil_pencarian li.autocomplete_active span#barangnya').html();
                var Harganya = Field.find('div#hasil_pencarian li.autocomplete_active span#harganya').html();
                var Speknya = Field.find('div#hasil_pencarian li.autocomplete_active span#speknya').html();
                var Satuannya = Field.find('div#hasil_pencarian li.autocomplete_active span#satuannya').html();

                Field.find('div#hasil_pencarian').hide();
                Field.find('input').val(Kodenya);

                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(3)').html(Barangnya);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(4) input').val(Speknya);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(4) span').html(Speknya);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(5) span').html(Satuannya);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(5) input').val(Satuannya);

                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(6) input').removeAttr('disabled').val();
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(6) input').val(Harganya);
                //$('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(6) span').html(to_rupiah(Harganya));
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(7) input').removeAttr('disabled').val(1);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(8) input').val(Harganya);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(8) span').html(to_rupiah(Harganya));
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(9) input').removeAttr('disabled').val(0);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(10) input').removeAttr('disabled').val(0);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(11) input').removeAttr('disabled').val(0);

                var IndexIni = $(this).parent().parent().index() + 1;
                var TotalIndex = $('#TabelTransaksi tbody tr').length;
                if (IndexIni == TotalIndex) {
                    BarisBaru();

                    $('html, body').animate({
                        scrollTop: $(document).height()
                    }, 0);
                } else {
                    $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(6) input').focus();
                }
            } else {
                AutoCompleteGue($(this).width(), $(this).val(), $(this).parent().parent().index());
            }
        } else {
            $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(2)').find('div#hasil_pencarian').hide();
        }

        HitungTotalBayar();
    });

    //HITUNG SUB TOTAL + CEK STOK BARANG
    $(document).on('keyup', '#jumlah_beli', function() {
        var Indexnya = $(this).parent().parent().index();
        var IndexChexbox = $(this).parent().parent().parent().parent().index();

        var Harga = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').val();
        var JumlahBeli = $(this).val();
        var KodeBarang = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2) input').val();

        if(Harga > 0){
            var SubTotal = parseInt(Harga) * parseInt(JumlahBeli);
            if (SubTotal > 0) {
                var SubTotalVal = SubTotal;
                SubTotal = to_rupiah(SubTotal);
            } else {
                SubTotal = '';
                var SubTotalVal = 0;
            }
        }

        //$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input').val(0);// kalo qty dirubah, set diskon =0
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input').val(SubTotalVal);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) span').html(SubTotal);

        //resset pajak ppn pph ke 0
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input').val(0);

        //harga - pajak
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) input').val(SubTotalVal);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) span').html(SubTotal);


        HitungTotalBayar();
    });

    //SUB TOTAL
    $(document).on('keydown', '#jumlah_beli', function(e) {
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


    //HITUNG SUB TOTAL + CEK STOK BARANG
    $(document).on('keyup', '#harga_satuan', function() {
        var Indexnya = $(this).parent().parent().index();
        var IndexChexbox = $(this).parent().parent().parent().parent().index();

        var Harga = $(this).val();
        var JumlahBeli = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input').val();
        var KodeBarang = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2) input').val();

        if(Harga > 0){
            var SubTotal = parseInt(Harga) * parseInt(JumlahBeli);
            if (SubTotal > 0) {
                var SubTotalVal = SubTotal;
                SubTotal = to_rupiah(SubTotal);
            } else {
                SubTotal = '';
                var SubTotalVal = 0;
            }

        }
        //$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input').val(0);// kalo qty dirubah, set diskon =0
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input').val(SubTotalVal);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) span').html(SubTotal);

        //resset pajak ppn pph ke 0
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input').val(0);


        //harga - pajak
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) input').val(SubTotalVal);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) span').html(SubTotal);

        HitungTotalBayar();
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



    //AUTO COMPLITE
    function AutoCompleteGue(Lebar, KataKunci, Indexnya) {
        $('div#hasil_pencarian').hide();
        var Lebar = Lebar + 25;
        var Registered = '';
        $('#TabelTransaksi tbody tr').each(function() {
            if (Indexnya !== $(this).index()) {
                if ($(this).find('td:nth-child(2) input').val() !== '') {
                    Registered += $(this).find('td:nth-child(2) input').val() + ',';
                }
            }
        });

        if (Registered !== '') {
            Registered = Registered.replace(/,\s*$/, "");
        }

        $.ajax({
            url: "<?= ('cari_kode'); ?>",
            type: "POST",
            cache: false,
            data: 'keyword=' + KataKunci + '&registered=' + Registered,
            dataType: 'json',
            success: function(json) {
                if (json.status == 1) {
                    $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2)').find('div#hasil_pencarian').css({
                        'width': Lebar + 'px'
                    });
                    $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
                    $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2)').find('div#hasil_pencarian').html(json.datanya);
                }
                if (json.status == 0) {
                    $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(3)').html('');

                    $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4)').html('');
                    $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4) input').val('');
                    $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(5)').html('');

                    //$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').val('');
                    //$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) span').html('');
                    $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').prop('disabled', true).val('');

                    $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input').prop('disabled', true).val('');
                    $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input').val(0);
                    $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) span').html('');
                    $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input').prop('disabled', true).val('');
                    $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) input').prop('disabled', true).val('');
                    // $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(11) input').prop('disabled', true).val('');
                }
            }
        });

        HitungTotalBayar();
    }
    

    //DAFTAR AUTO COMPLITE
    $(document).on('click', '#daftar-autocomplete li', function() {
        $(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());

        var Indexnya = $(this).parent().parent().parent().parent().index();
        var NamaBarang = $(this).find('span#barangnya').html();
        var Harganya = $(this).find('span#harganya').html();
        var Speknya = $(this).find('span#speknya').html();
        var Satuannya = $(this).find('span#satuannya').html();

        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2)').find('div#hasil_pencarian').hide();
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(3)').html(NamaBarang);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4) input').val(Speknya);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4) span').html(Speknya);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(5) input').val(Satuannya);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(5) span').html(Satuannya);

        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').removeAttr('disabled').val('');
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').val(Harganya);
        //$('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(6) input').val(Harganya);

        // $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) span').html(to_rupiah(Harganya));

        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input').removeAttr('disabled').val(1);

        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input').val(Harganya);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) span').html(to_rupiah(Harganya));
        // $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input').val(0);
        // $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) span').html(to_rupiah(0));

        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input').removeAttr('disabled').val(0);

        //harga + pajak
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) input').val(Harganya);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) span').html(to_rupiah(Harganya));

        var IndexIni = Indexnya + 1;
        var TotalIndex = $('#TabelTransaksi tbody tr').length;
        if (IndexIni == TotalIndex) {
            BarisBaru();
            $('html, body').animate({
                scrollTop: $(document).height()
            }, 0);
        } else {
            $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').focus();
            //$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input').focus();
        }

        HitungTotalBayar();
    });


    //HITUNG TOTAL BAYAR
    function HitungTotalBayar() {
        var Total = 0;
        var TotalPpn11 = 0;
        var TotalBayar = 0;
        var TotalHargaPajak = 0;
        $('#TabelTransaksi tbody tr').each(function() {
            if ($(this).find('td:nth-child(8) input').val() > 0) {
                var SubTotal = $(this).find('td:nth-child(8) input').val();
                Total = parseInt(Total) + parseInt(SubTotal);

                //hitung total ppn11
                var ppn11 = $(this).find('td:nth-child(9) input').val();
                TotalPpn11 = parseInt(TotalPpn11) + parseInt(ppn11)

                //SisaBayarHidden
                var TotalHargaPajak = $(this).find('td:nth-child(10) input').val();
                TotalBayar = parseInt(Total) - parseInt(TotalPpn11)
                //nettoBayar = (Math.floor((TotalNetto - TotalDiskon) / 1000)*1000);

            }
        });

        $('#TotalBayar').val(to_rupiah(Total));
        $('#TotalBayarHidden').val(Total);

        $('#ppnShow').val(to_rupiah(TotalPpn11));
        $('#ppn').val(TotalPpn11);
        //SisaBayarHidden
        $('#SisaBayarHidden').val(TotalBayar);
        $('#SisaBayar').val(to_rupiah(TotalBayar));
    }


    //HITUNG PPN 11
    $(document).on('change', '#checkbox_ppn_barang', function() {
        var Indexnya = $(this).parent().parent().parent().parent().index();

        var Harga = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').val();
        var JumlahBeli = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input').val();

        let checked;

        var SubTotal = parseInt(Harga) * parseInt(JumlahBeli);
        //var SubTotal = parseInt($('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(12) input').val());

        if (SubTotal > 0) {
            var ppn11 = parseFloat(SubTotal * (100/111) * (11/100));
            var pajakVal = ppn11.toFixed(0);
            var TotalDenganPajak = (SubTotal - ppn11);

            if ($(this).prop('checked') == true) {
                checked = true;
                $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input').val(pajakVal);

                //kalo sudah di cek pph21 harus di resset ke 0
                $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) input').val(0);
                $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) input').attr('checked', false);;
            } else {
                checked = false;
                
                $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input').val(0);

                // //kalo sudah di cek pph21 harus di resset ke 0
                // $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) input').val(0);
                // $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) input').attr('checked', false);;

            }            
        } else {
            SubTotal = '';
            var SubTotalVal = 0;
            $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) input').val(SubTotalVal);
            //HitungTotalBayar();
        }

        hitungHargaDenganPajak(Indexnya, checked, SubTotal);
        HitungTotalBayar();
    });


    function hitungHargaDenganPajak(Indexnya, checked, SubTotal){
        if(SubTotal > 0){
            var ppn11 = parseInt($('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input').val());
            // var pph21 = parseInt($('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) input').val());
            // var pph23 = parseInt($('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(11) input').val());

            //var hargaDenganPajak = (Math.ceil((SubTotal - ppn11 - pph21 - pph23) / 1000)*1000);
            var hargaDenganPajak = (Math.ceil((SubTotal - ppn11) / 1000)*1000);

            $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) input').val(hargaDenganPajak.toFixed(0));
            $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(10) span').html(to_rupiah(hargaDenganPajak));
        }
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

    //SHORT CUT KEYBOARD
    $(document).on('keydown', 'body', function(e) {
        var charCode = (e.which) ? e.which : event.keyCode;

        if (charCode == 117) //F6
        {
            $('#jumlah_beli').focus();
            return false;
        }

        if (charCode == 118) //F7
        {
            BarisBaru();
            return false;
        }

        if (charCode == 120) //F9
        {
            SimpanTransaksi();
            //CetakStruk();

            setTimeout(function() {
                $('button#SimpanTransaksi').focus();
            }, 500);

            return false;
        }

        if (charCode == 121) //F10
        {
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').addClass('modal-sm');
            $('#ModalHeader').html('Konfirmasi');
            $('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
            $('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
            $('#ModalGue').modal('show');

            setTimeout(function() {
                $('button#SimpanTransaksi').focus();
            }, 500);

            return false;
        }
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

    $(document).on('click', 'button#CetakStruk', function() {
        SimpanTransaksi();
    });

    function SimpanTransaksi() {
        var no_urut = $("#nomor_nota").val();

        var FormData = "nomor_nota=" + encodeURI($('#nomor_nota').val());
        FormData += "&id_pelanggan=1";
        FormData += "&" + $('#TabelTransaksi tbody input').serialize();
        FormData += "&tanggal=" + $('#tanggal').val();
        FormData += "&no_urut=" + no_urut;
        FormData += "&jenis_spb=" + $('#jenis_spb').val();
        FormData += "&marketing=" + $('#marketing').val();
        FormData += "&sistem_pembayaran=" + $('#sistem_pembayaran').val();
        FormData += "&tanggal_jatuh_tempo=" + $('#tanggal_jatuh_tempo').val();
        FormData += "&ppn=" + $('#ppn').val();
        FormData += "&SisaBayar=" + $('#SisaBayar').val();
        FormData += "&SisaBayarHidden=" + $('#SisaBayarHidden').val();
        FormData += "&grand_total=" + $('#TotalBayarHidden').val();

        $.ajax({
            url: "<?php echo site_url('admin/pembelian/form_stok'); ?>",
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
                    // // window.location.href = "<?php echo site_url('admin/pembelian/form_stok'); ?>";

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
</script>