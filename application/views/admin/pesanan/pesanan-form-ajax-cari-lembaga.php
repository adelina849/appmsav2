<!-- All Orders Block -->
<div class="block full">
    <!-- All Orders Title -->
    <div class="block-title">
        <h2><i class="gi gi-message_plus animation-pulse"></i> <strong>Input Surat Pesanan</strong></h2>
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
        </div>

        <div class="form-group">
            <div class="col-lg-8 col-xs-12">
                <div class="input-group">
                    <span class="input-group-addon text-info">
                        <i class="fa fa-bank"></i>
                    </span>
                    <input type="text" name="lembaga" id="lembaga" class="form-control" placeholder="Nama Lembaga">
                    <div id='cari_lembaga' style="padding-top: 35px"></div>
                    <input type="hidden" name="idlembaga" id="idlembaga">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-8 col-xs-12">
                <div class="input-group">
                    <span class="input-group-addon text-info">
                        <i class="gi gi-user"></i>
                    </span>
                    <select id="sistem_transaksi" name="sistem_transaksi" class="select-select2" style="width:100%;">
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php
                        $pelanggan = $this->db->get_where('pelanggan', array('dihapus' => 'tidak'))->result();
                        foreach ($pelanggan as $pelanggans) {
                        ?>
                            <option value="<?= $pelanggans->id; ?>"><?= $pelanggans->nama_pelanggan; ?></option>
                            <option disabled="disabled"><?= 'Kode: ' . $pelanggans->kode; ?></option>
                            <option disabled="disabled"><?= 'Jabatan: ' . $pelanggans->jabatan; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-4 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon text-info">
                        <i class="gi gi-coins"></i>
                    </span>
                    <select id="sistem_transaksi" name="sistem_transaksi" class="select-select2" style="width:100%;">
                        <option value="">-- Sistem Transaksi --</option>
                        <option value="SIPLAH">SIPLAH</option>
                        <option value="NON-SIPLAH">NON SIPLAH</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon text-info">
                        <i class="fa fa-cc-mastercard"></i>
                    </span>
                    <select id="sistem_transaksi" name="sistem_transaksi" class="select-select2" style="width:100%;">
                        <option value="">-- Sistem Pembayaran --</option>
                        <option value="SIPLAH">KREDIT</option>
                        <option value="NON-SIPLAH">TUNAI</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-lg-4 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon text-info">
                        <i class="gi gi-edit"></i>
                    </span>
                    <select id="sistem_transaksi" name="sistem_transaksi" class="select-select2" style="width:100%;">
                        <option value="">-- Tahap Anggaran --</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon text-info"><i class="fa fa-calendar-check-o"></i></span>
                    <div class="input-date" data-date-format="yyy-mm-dd">
                        <input type="text" id="tanggal_pertemuan" name="tanggal_pertemuan" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Jatuh Tempo" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-addon text-primary"><i class="gi gi-barcode"></i></span>
                    <input type="text" name="produk" id="produk" class="form-control" placeholder="Scan Barcode atau Nama Barang">
                    <div id='hasil_pencarian' style="padding-top: 35px"></div>
                </div>
            </div>
            <div class="col-sm-2">
                <div class="input-group">
                    <span class="input-group-addon">Qty</span>
                    <input name="qty" type="number" class="form-control" id="qty" placeholder="0">
                    <spna style="display:none;" id="hreseller"></span>
                </div>
            </div>
            <div class="col-sm-2">
                <button type="reset" data-toggle="tooltip" title="klik F7 menambahkan produk baru" class="btn btn-sm text-light btn-info add-row">
                    <i class="gi gi-cart_in"></i> Tambah Barang (F7)
                </button>
            </div>
            <div class="col-sm-4">
                <p class="showProduk h4 text-primary" style="margin-top: 5px; font-weight: bold;"></p>
            </div>

        </div>
    </form>


    <!-- END Horizontal Form Content -->
    <!-- Products Content -->
    <div class="table-responsive" style="margin-top:15px">
        <table class="table table-bordered table-vcenter" id="TabelTransaksi">
            <thead>
                <tr style="font-weight: bold;">
                    <td class="text-center" style="width: 5%;">NO</td>
                    <td class="text-center" style="width: 10%">KODE</td>
                    <td>NAMA BARANG</td>
                    <td class="text-center" style="width: 15%;">SPESIFIKASI</td>
                    <td class="text-center" style="width: 5%;">SATUAN</td>
                    <td class="text-center" style="width: 15%;">HARGA SATUAN</td>
                    <td class="text-center" style="width: 5%;">QTY</td>
                    <td class="text-right" style="width: 10%;">SUB TOTAL</td>
                    <td class="text-center" style="width: 5%;"><button class="btn btn-xs btn-danger delete-row"><i class="hi hi-trash"></i></button></td>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <!-- END table responsive -->

    <div class="row">
        <div class='col-sm-12'>
            <div class='alert themed-background TotalBayar'>
                <h2 class="pull-right text-light">Total : <span id='TotalBayar'>Rp. 0</span></h2>
                <input type="hidden" id='TotalBayarHidden'>
            </div>
        </div>
    </div>
    <!-- END row -->

    <div class="row">
        <div class="col-sm-8">
            <textarea name='catatan' id='catatan' class='form-control' rows='2' placeholder="Catatan Transaksi (Jika Ada)" style='resize: vertical; width:83%;'></textarea>
            <br />
            <!--
            <p><i class='fa fa-keyboard-o fa-fw'></i> <b>Shortcut Keyboard : </b></p>
            <div class='row'>
                <div class='col-sm-6'>F3 = Fokus ke field Nama Pembeli</div>
                <div class='col-sm-6'>F4 = Fokus ke Jenis Harga</div>
                <div class='col-sm-6'>F5 = Fokus ke Pilih Produk</div>
                <div class='col-sm-6'>F6 = Fokus ke field Qty</div>
                <div class='col-sm-6'>F7 = Tambah baris baru</div>
                <div class='col-sm-6'>F9 = Cetak Struk</div>
                <div class='col-sm-6'>F8 = Fokus ke field bayar</div>
                <div class='col-sm-6'>F10 = Simpan Transaksi</div>
            </div>
-->
        </div>

        <div class="col-sm-4">
            <form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">

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

        $('#lembaga').keyup(function() {
            var lembaga = $("#lembaga").val();
            var Lebar = 94;
            $.ajax({
                url: "<?= ('cari_lembaga'); ?>",
                type: "POST",
                cache: false,
                //data:{keyword:keyword},  
                data: 'nama_lembaga=' + lembaga,

                success: function(data) {
                    $('#cari_lembaga').fadeIn();
                    $('#cari_lembaga').css({
                        'width': Lebar + '%'
                    });
                    $('#cari_lembaga').html(data);
                }
            });
        });

        $(document).on('click', 'li', function() {
            var nama_lembaga = $(this).find('span#nama_lembaga').html();
            var id_lembaga = $(this).find('span#id_lembaga').html();

            $('#cari_lembaga').fadeOut();

            $('#lembaga').val(nama_lembaga);
            $('#idlembaga').val(id_lembaga);
        });
    });
</script>