<!-- All Orders Block -->
<style>
    .table th {
        font-size: 5px;
    }
</style>
<div class="block full">

    <!-- All Orders Title -->
    <div class="block-title">
        <h2><i class="gi gi-message_plus animation-pulse"></i> <strong>Input Surat Pesanan</strong></h2>
        <div class="block-options pull-right" style="margin-right: 15px;">
            <a href="<?= site_url('admin/pesanan'); ?>" class="" data-toggle="tooltip" title="Daftar Surat Pesanan">
                <i class="fa fa-list-alt"></i> Daftar Surat Pesanan
            </a>

            <input type='hidden' name='nomor_nota' class='form-control input-sm' id='nomor_nota' value="<?php echo $nomor_nota; ?>">
        </div>
    </div>
    <!-- END All Orders Title -->
    <form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">
        <div class="form-group">
            <div class="col-lg-4 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
                    <div class="input-date" data-date-format="yyy-mm-dd">
                        <input type="text" id="tanggal_pesanan" name="tanggal_pesanan" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Pemesanan" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon text-info">
                        <i class="gi gi-more_windows"></i>
                    </span>
                    <select id="jenis_sp" name="jenis_sp" class="select-select2 select2" style="width:100%;">
                        <option value="">-- Jenis SP --</option>
                        <option value="buku">Buku</option>
                        <option value="non-buku">Non Buku</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="form-group">
            <div class="col-md-4 text-info">
                <label for="lembaga"><i class="fa fa-bank"></i> Pilih Lembaga</label>
                <select id="lembaga" name="lembaga" class="option-line-break" style="width:100%;" placeholder="Nama Lembaga">
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

            <div class="col-md-3 text-info">
                <label for="pelanggan"><i class="fa fa-user"></i> Nama Pelanggan</label>
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

            <div class="col-md-3 text-info">
                <label for="mitra"><i class="fa fa-users"></i> Nama Mitra</label>
                <select id="mitra" name="mitra" class="option-line-break" style="width:100%;" placeholder="Nama Mitra">
                    <option value="">-- Pilih Mitra --</option>
                    <?php
                    $mitra = $this->db->get_where('mitra', array('dihapus' => 'tidak'))->result();
                    foreach ($mitra as $mitras) {
                    ?>
                        <option data-description="<?= 'Kode: ' . $mitras->kode; ?>" value="<?= $mitras->id; ?>">
                            <?= $mitras->nama_mitra . ' = ' . $mitras->id; ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
            </div>

        </div>

        <div class="form-group">
            <div class="col-lg-3 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon text-info">
                        <i class="gi gi-coins"></i>
                    </span>
                    <select id="sistem_transaksi" name="sistem_transaksi" class="select-select2 select2" style="width:100%;">
                        <option value="">-- Sistem Transaksi --</option>
                        <option value="siplah">SIPLAH</option>
                        <option value="non-siplah">NON SIPLAH</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon text-info">
                        <i class="fa fa-cc-mastercard"></i>
                    </span>
                    <select id="sistem_pembayaran" name="sistem_pembayaran" class="select-select2" style="width:100%;">
                        <option value="">-- Sistem Pembayaran --</option>
                        <option value="kredit">KREDIT</option>
                        <option value="tunai">TUNAI</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon text-info"><i class="fa fa-calendar-check-o"></i></span>
                    <div class="input-date" data-date-format="yyy-mm-dd">
                        <input type="text" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Jatuh Tempo" autocomplete="off">
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group">
            <div class="col-lg-3 col-xs-3">
                <div class="input-group">
                    <span class="input-group-addon text-info">
                        <i class="gi gi-edit"></i>
                    </span>
                    <select id="tahun_anggaran" name="tahun_anggaran" class="select-select2" style="width:100%;">
                        <option value="">-- Tahun Anggaran --</option>
                        <?php
                        $tahun = date('Y');
                        for ($i = $tahun; $i >= 2015; $i--) {
                        ?>
                            <option value="<?= $i; ?>"><?= $i; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-xs-3">
                <div class="input-group">
                    <span class="input-group-addon text-info">
                        <i class="gi gi-edit"></i>
                    </span>
                    <select id="tahap_anggaran" name="tahap_anggaran" class="select-select2" style="width:100%;">
                        <option value="">-- Tahap Anggaran --</option>
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                        ?>
                            <option value="<?= $i; ?>"><?= $i; ?></option>

                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </form>

    <!-- END Horizontal Form Content -->
    <!-- Products Content -->
    <div class="table-responsive" style="margin-top:15px">
        <table class="table table-bordered" id='TabelTransaksi'>
            <thead>
                <tr style="font-weight: bold;">
                    <td style='width:2%;' class='text-center'>No</td>
                    <td style='width:20%;'>Kode Barang</td>
                    <td style='width:28%;'>Nama Barang</td>
                    <td style='width:10%;' class='text-center'>Spesifikasi</td>
                    <td style='width:7%;' class='text-center'>Satuan</td>
                    <td style='width:10%;' class='text-center'>Harga</td>
                    <td style='width:5%;' class='text-center'>Qty</td>
                    <td style='width:5%;' class='text-center'>%</td>
                    <td style='width:10%;' class='text-center'>Sub Total</td>
                    <td style='width:3%;' class='text-center'></td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <br />
        <div class='alert alert-info TotalBayar'>
            <button id='BarisBaru' class='btn btn-default pull-left'><i class='fa fa-plus fa-fw'></i> Baris Baru (F7)</button>
            <h2 class="pull-right">Total : <span id='TotalBayar'>Rp. 0</span></h2>
            <input type="hidden" id='TotalBayarHidden'>
        </div>
    </div>
    <!-- END table responsive -->

    <div class="row">
        <div class='col-sm-7'>
            <p class="text-info"><i class='fa fa-info-circle fa-fw animation-pulse'></i> <b>Form Surat Pesanan : </b></p>
            <div class='row'>
                <div class='col-sm-12'>
                    <ul class="fa-ul list-li-push">
                        <li><i class="fa fa-li fa-check"></i> PPN 11 , PPH 22, PPH 23 diisi persentase, jika tidak ada masing-masing field diisi angka 0 (NOL)</li>
                        <li><i class="fa fa-li fa-check"></i> Diskon diisi nominal diskon yang diberikan , jika tidak ada diskon field diisi angka 0 (Nol)</li>
                        <li><i class="fa fa-li fa-check"></i> Uang Muka diisi nominal uang muka dari pelanggan, jika tidak ada uang muka field diisi angka 0 (Nol)</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">

                <div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">
                        PPN 11 (11%)
                    </label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="hidden" id="ppnTidakDibulatkan">
                            <input type="text" id="ppn" name="ppn" class="form-control" placeholder='0' disabled>
                            <span class="input-group-addon">
                                <input type="checkbox" id="checkbox_ppn" name="checkbox_ppn" value="1">
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">PPH 22 (1.5%)</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="hidden" id="pph22TidakDibulatkan">
                            <input type="text" id="pph22" name="pph22" class="form-control" placeholder='0' disabled>
                            <span class="input-group-addon">
                                <input type="checkbox" id="checkbox_pph22" name="checkbox_pph22" value="1">
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">PPH 23 (2%)</label>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="hidden" id="pph23TidakDibulatkan">
                            <input type="text" id="pph23" name="pph23" class="form-control" placeholder='0' disabled>
                            <span class="input-group-addon">
                                <input type="checkbox" id="checkbox_pph23" name="checkbox_pph23" value="1">
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">Netto</label>
                    <div class="col-md-6">
                        <input type="hidden" id='TotalBayarDipotongPajak'>
                        <input type='text' name='netto' id='netto' class='form-control' placeholder='0' disabled>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">Diskon (%)</label>
                    <div class="col-md-2">
                        <div class="input-group">
                            <input type='text' name='diskon' id='diskon' class='form-control text-center' placeholder='0' onkeypress='return check_int(event)'>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <input type='text' name='nominalDiskon' id='nominalDiskon' class='form-control' placeholder='0' disabled>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">Netto Bayar</label>
                    <div class="col-md-6">
                        <input type="hidden" id='NettoBayarHidden'>
                        <input type='text' name='netto_bayar' id='netto_bayar' class='form-control' placeholder='0' disabled>
                    </div>
                </div>


                <div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">Uang Muka (F8)</label>
                    <div class="col-md-6">
                        <input type='text' name='cash' id='UangCash' class='form-control' placeholder='0' onkeypress='return check_int(event)'>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none;">
                    <label class="col-md-6 control-label" for="example-hf-email">Sisa Pembayaran</label>
                    <div class="col-md-6">
                        <input type='hidden' id='SisaBayarHidden' class='form-control'>
                        <input type='text' id='SisaBayar' class='form-control' disabled>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none;">
                    <div class='col-sm-6'>
                        <button type='button' class='btn btn-warning btn-block' id='CetakStruk'>
                            <i class='fa fa-print'></i> Cetak (F9)
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
    //PENCARIAN LEMBAGA    
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
        Baris += "<input type='hidden' name='harga_satuan[]'>";
        Baris += "<span></span>";
        Baris += "</td>";
        Baris += "<td><input type='text' class='form-control text-center' id='jumlah_beli' name='jumlah_beli[]' onkeypress='return check_int(event)' disabled></td>";
        Baris += "<td>";
        Baris += "<input type='text' class='form-control text-center' id='diskon_barang' name='diskon_barang[]' onkeypress='return check_int(event)' disabled>";
        Baris += "</td>";

        Baris += "<td>";
        Baris += "<input type='hidden' name='sub_total[]'>";
        Baris += "<span></span>";
        Baris += "</td>";
        Baris += "<td><a href='#' class='' id='HapusBaris'><i class='fa fa-times btn-xs' style='color:red;'></i></a></td>";
        Baris += "</tr>";

        $('#TabelTransaksi tbody').append(Baris);

        $('#TabelTransaksi tbody tr').each(function() {
            // $(this).find('td:nth-child(2) input').focus(); //fokus ke pencarian field kode
            $(this).find('td:nth-child(7) input').focus(); //fokus ke pencarian field kode
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
                var Speknya = $(this).find('span#speknya').html();
                var Satuannya = $(this).find('span#satuannya').html();

                Field.find('div#hasil_pencarian').hide();
                Field.find('input').val(Kodenya);

                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(3)').html(Barangnya);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(4) input').val(Speknya);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(4) span').html(Speknya);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(5)').html(Satuannya);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(5) input').val(Satuannya);

                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(6) input').val(Harganya);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(6) span').html(to_rupiah(Harganya));
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(7) input').removeAttr('disabled').val(1);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(8) input').removeAttr('disabled').val(0);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(9) input').val(Harganya);
                $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(9) span').html(to_rupiah(Harganya));

                var IndexIni = $(this).parent().parent().index() + 1;
                var TotalIndex = $('#TabelTransaksi tbody tr').length;
                if (IndexIni == TotalIndex) {
                    BarisBaru();

                    $('html, body').animate({
                        scrollTop: $(document).height()
                    }, 0);
                } else {
                    $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(5) input').focus();
                }
            } else {
                AutoCompleteGue($(this).width(), $(this).val(), $(this).parent().parent().index());
            }
        } else {
            $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(2)').find('div#hasil_pencarian').hide();
        }

        HitungTotalBayar();
    });


    //HITUNG DISKON BARANG =  SUB TOTAL * DISKON BARANG
    $(document).on('keyup', '#diskon_barang', function() {
        // txtPajak.val(pajak.toFixed(2));
        var Indexnya = $(this).parent().parent().index();
        var DiskonBarang = $(this).val();
        var PersenDiskon = parseFloat(parseInt(DiskonBarang) / 100);

        var Harga = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').val();
        var JumlahBeli = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input').val();

        var SubTotal = parseInt(Harga) * parseInt(JumlahBeli);
        if (SubTotal > 0) {
            if (parseInt(DiskonBarang) >= 0) {
                var SubTotalVal = SubTotal - (SubTotal * PersenDiskon);
                SubTotal = to_rupiah(SubTotalVal);
            } else {
                SubTotal = '';
                var SubTotalVal = 0;
            }
        } else {
            SubTotal = '';
            var SubTotalVal = 0;
        }

        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input').val(SubTotalVal);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) span').html(SubTotal);

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

        //HitungTotalBayar();
    });


    //HITUNG SUB TOTAL + CEK STOK BARANG
    $(document).on('keyup', '#jumlah_beli', function() {
        var Indexnya = $(this).parent().parent().index();
        var Harga = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').val();
        var JumlahBeli = $(this).val();
        var KodeBarang = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(2) input').val();

        var SubTotal = parseInt(Harga) * parseInt(JumlahBeli);
        if (SubTotal > 0) {
            var SubTotalVal = SubTotal;
            SubTotal = to_rupiah(SubTotal);
        } else {
            SubTotal = '';
            var SubTotalVal = 0;
        }
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input').val(0);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input').val(SubTotalVal);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) span').html(SubTotal);

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
            //$('#diskon_barang').val(0);
        }

        HitungTotalBayar();
    });

    //AUTO COMPLITE
    function AutoCompleteGue(Lebar, KataKunci, Indexnya) {
        $('div#hasil_pencarian').hide();
        var Lebar = Lebar + 25;
        var jenis_barang = $('#jenis_sp').val();
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
        //jenis sp harus dipilih untuk memfilter jenis barang yang ditampilkan
        if (jenis_sp == '') {
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').addClass('modal-sm');
            $('#ModalHeader').html('Oops !');
            $('#ModalContent').html('data.pesan');
            $('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
            $('#ModalGue').modal('show');

        } else {
            $.ajax({
                url: "<?= ('cari_kode'); ?>",
                type: "POST",
                cache: false,
                data: 'keyword=' + KataKunci + '&registered=' + Registered + '&jenis_barang=' + jenis_barang,
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
                        //alert('status 0');
                        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(3)').html('');

                        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4)').html('');
                        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4) input').val('');
                        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(5)').html('');

                        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').val('');
                        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) span').html('');
                        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input').prop('disabled', true).val('');
                        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input').prop('disabled', true).val('');
                        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input').val(0);
                        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) span').html('');
                    }
                }
            });
        }

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
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').val(Harganya);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) span').html(to_rupiah(Harganya));
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(7) input').removeAttr('disabled').val(1);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input').removeAttr('disabled').val(0);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) input').val(Harganya);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(9) span').html(to_rupiah(Harganya));

        var IndexIni = Indexnya + 1;
        var TotalIndex = $('#TabelTransaksi tbody tr').length;
        if (IndexIni == TotalIndex) {
            BarisBaru();
            $('html, body').animate({
                scrollTop: $(document).height()
            }, 0);
        } else {
            $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(5) input').focus();
        }

        HitungTotalBayar();
    });



    //HITUNG TOTAL BAYAR
    function HitungTotalBayar() {
        var Total = 0;
        $('#TabelTransaksi tbody tr').each(function() {
            if ($(this).find('td:nth-child(9) input').val() > 0) {
                var SubTotal = $(this).find('td:nth-child(9) input').val();
                Total = parseInt(Total) + parseInt(SubTotal);
            }
        });

        $('#TotalBayar').html(to_rupiah(Total));
        $('#TotalBayarHidden').val(Total);

        $('#TotalBayarDipotongPajak').val(Total);
        $('#netto').val(to_rupiah(Total));

        $('#checkbox_ppn').attr('checked', false);
        $('#checkbox_pph22').attr('checked', false);
        $('#checkbox_pph23').attr('checked', false);

        $('#ppn').val('');
        $('#pph22').val('');
        $('#pph23').val('');
        $('#diskon').val('');
        $('#nominalDiskon').val();
        $('#UangCash').val('');
        $('#SisaBayar').val('');
        $('#SisaBayarHidden').val('');

    }

    //ppn11 di click
    $(document).on('change', '#checkbox_ppn', function() {
        var persen = 11;
        var checkedPajak;
        if ($(this).prop('checked') == true) {
            checkedPajak = true;
            HitungPajak(persen, checkedPajak);
        } else {
            checkedPajak = false;
            HitungPajak(persen, checkedPajak);
        }
    });

    //pph 22 di click
    $(document).on('change', '#checkbox_pph22', function() {
        var persen = 1.5;
        var checkedPajak;
        if ($(this).prop('checked') == true) {
            checkedPajak = true;
            HitungPajak(persen, checkedPajak);
        } else {
            checkedPajak = false;
            HitungPajak(persen, checkedPajak);
        }
    });

    //pph 23 di click
    $(document).on('change', '#checkbox_pph23', function() {
        var persen = 2;
        var checkedPajak;
        if ($(this).prop('checked') == true) {
            checkedPajak = true;
            HitungPajak(persen, checkedPajak);
        } else {
            checkedPajak = false;
            HitungPajak(persen, checkedPajak);
        }
    });

    function HitungPajak(persen, checkedPajak) {

        var valPersen, pajak, netto, txtPajak, txtPajakTidakDibulatkan;
        var dpp; // Dasar Perhitungan Pajak
        var TotalBayar = $('#TotalBayarHidden').val();

        if (persen == 11) {
            dpp = parseFloat(TotalBayar) * (100 / 111);
            valPersen = (11 / 100);
            txtPajak = $('#ppn');
            txtPajakTidakDibulatkan = $('#ppnTidakDibulatkan');
        } else if (persen == 1.5) {
            dpp = parseFloat(TotalBayar) * (100 / 111);
            valPersen = (1.5 / 100);
            txtPajak = $('#pph22');
            txtPajakTidakDibulatkan = $('#pph22TidakDibulatkan');
        } else if (persen == 2) {
            dpp = parseFloat(TotalBayar);
            valPersen = (2 / 100);
            txtPajak = $('#pph23');
            txtPajakTidakDibulatkan = $('#pph23TidakDibulatkan');
        } else {
            valPersen = 1;
        }

        if (checkedPajak) {
            var sebelumPajak = $('#TotalBayarDipotongPajak').val();
            pajak = dpp * parseFloat(valPersen);
            netto = parseFloat(sebelumPajak) - parseFloat(pajak);

            $('#netto').val(to_rupiah(netto));
            $('#TotalBayarDipotongPajak').val(netto);
            txtPajak.val(pajak.toFixed(2)); //2 angka dibelakang koma (dibulatkan)
            txtPajakTidakDibulatkan.val(pajak); // tidak dibulatkan, untuk mengembalikan nilai awal ketika di uncheck

        } else {
            var sebelumPajak = $('#TotalBayarDipotongPajak').val();
            pajak = txtPajakTidakDibulatkan.val();
            netto = parseFloat(sebelumPajak) + parseFloat(pajak);
            $('#TotalBayarDipotongPajak').val(netto);
            $('#netto').val(to_rupiah(netto));
            txtPajakTidakDibulatkan.val('');
            txtPajak.val('');
        }
        $('#diskon').val('');
        $('#nominalDiskon').val();
        $('#UangCash').val('');
        $('#NettoBayarHidden').val('');
        $('#netto_bayar').val('');
        $('#SisaBayar').val('');
        $('#SisaBayarHidden').val('');


    }

    //diskon
    $(document).on('keyup', '#diskon', function() {
        HitungTotalDiskon();
    });

    function HitungTotalDiskon() {
        var Diskon = $('#diskon').val();
        //var TotalBayar = $('#TotalBayarHidden').val();
        var TotalBayarDipotongPajak = $('#TotalBayarDipotongPajak').val();

        if ((parseInt(Diskon) >= 0) && (parseInt(Diskon) <= 100)) {
            var nomoinalDiskon = ((parseInt(Diskon) / 100) * parseInt(TotalBayarDipotongPajak));
            var Selisih = parseInt(TotalBayarDipotongPajak) - parseInt(nomoinalDiskon);

            $('#NettoBayarHidden').val(Selisih);
            $('#netto_bayar').val(to_rupiah(Selisih));
            $('#nominalDiskon').val(to_rupiah(nomoinalDiskon));

        } else {
            $('#netto_bayar').val('');
            $('#nominalDiskon').val();

        }

        // if ((parseInt(Diskon) >= 0) && (parseInt(Diskon) <= parseInt(TotalBayarDipotongPajak))) {
        //     var Selisih = parseInt(TotalBayarDipotongPajak) - parseInt(Diskon);
        //     var nomoinalDiskon;

        //     $('#NettoBayarHidden').val(Selisih);
        //     $('#netto_bayar').val(to_rupiah(Selisih));
        // } else {
        //     $('#netto_bayar').val('');
        // }
    }

    //UANG CASH / uang muka
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
            CetakStruk();

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
        //CetakStruk();
        SimpanTransaksi();
    });

    $(document).on('click', 'button#CetakStruk', function() {
        //CetakStruk();
        SimpanTransaksi();
    });

    function SimpanTransaksi() {
        var FormData = "nomor_nota=" + encodeURI($('#nomor_nota').val());
        FormData += "&id_pelanggan=1";
        FormData += "&" + $('#TabelTransaksi tbody input').serialize();
        FormData += "&tanggal_pesanan=" + $('#tanggal_pesanan').val();
        FormData += "&jenis_sp=" + $('#jenis_sp').val();
        FormData += "&lembaga=" + $('#lembaga').val();
        FormData += "&pelanggan=" + $('#pelanggan').val();
        FormData += "&mitra=" + $('#mitra').val();
        FormData += "&sistem_transaksi=" + $('#sistem_transaksi').val();
        FormData += "&sistem_pembayaran=" + $('#sistem_pembayaran').val();
        FormData += "&tanggal_jatuh_tempo=" + $('#tanggal_jatuh_tempo').val();
        FormData += "&tahap_anggaran=" + $('#tahap_anggaran').val();
        FormData += "&tahun_anggaran=" + $('#tahun_anggaran').val();
        FormData += "&ppn=" + $('#ppn').val();
        FormData += "&pph22=" + $('#pph22').val();
        FormData += "&pph23=" + $('#pph23').val();
        FormData += "&netto=" + $('#TotalBayarDipotongPajak').val();
        FormData += "&diskon=" + $('#diskon').val();
        FormData += "&netto_bayar=" + $('#NettoBayarHidden').val();
        FormData += "&SisaBayar=" + $('#SisaBayar').val();
        FormData += "&SisaBayarHidden=" + $('#SisaBayarHidden').val();
        FormData += "&uang_muka=" + $('#UangCash').val();
        FormData += "&grand_total=" + $('#TotalBayarHidden').val();

        $.ajax({
            url: "<?php echo site_url('admin/pesanan/form_pesanan'); ?>",
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
                    // // window.location.href = "<?php echo site_url('admin/pesanan/form_pesanan'); ?>";

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

    function CetakStruk() {
        if ($('#TotalBayarHidden').val() > 0) {
            if ($('#UangCash').val() !== '') {
                var FormData = "nomor_nota=" + encodeURI($('#nomor_nota').val());
                FormData += "&id_pelanggan=1";
                FormData += "&" + $('#TabelTransaksi tbody input').serialize();
                FormData += "&cash=" + $('#UangCash').val();
                FormData += "&catatan=" + encodeURI($('#catatan').val());
                FormData += "&grand_total=" + $('#TotalBayarHidden').val();

                window.open("<?php echo site_url('pesanan/transaksi_cetaks/?'); ?>" + FormData, '_blank');
            } else {
                $('.modal-dialog').removeClass('modal-lg');
                $('.modal-dialog').addClass('modal-sm');
                $('#ModalHeader').html('Oops !');
                $('#ModalContent').html('Harap masukan Total Bayar');
                $('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
                $('#ModalGue').modal('show');
            }
        } else {
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').addClass('modal-sm');
            $('#ModalHeader').html('Oops !');
            $('#ModalContent').html('Harap pilih barang terlebih dahulu');
            $('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
            $('#ModalGue').modal('show');

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
</script>