<div class="block full">
    <!-- All Orders Title -->
    <div class="block-title">
        <div class="block-options pull-right" style="margin-right: 15px;">
        </div>
        <h2><i class="fa fa-external-link"></i> <strong><?= $title; ?></strong></h2>
    </div>

    <form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">
        <div class="form-group">
            <div class="col-lg-4 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <div class="input-date" data-date-format="yyy-mm-dd">
                        <input type="text" id="tanggal" name="tanggal" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Surat Jalan" autocomplete="off">
                    </div>
                    <input type="hidden" id="no_urut" value="<?=$no_urut;?>">
                </div>
            </div>
            <div class="col-lg-4 col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    <select id="exspedisi" name="exspedisi" class="select-select2 select2" style="width:100%;">
                        <option value="">-- Ekspedisi --</option>
                        <option value="yulianto">Yulianto</option>
                    </select>
                </div>        
            </div>
        </div>
    </form>
    <br>
    <form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">
        <div class="form-group">
            <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-addon text-primary"><i class="gi gi-barcode"></i></span>
                    <select id="do" name="do" class="select-select2" style="width:100%;">
                        <option value="">-- Input Nomor DO --</option>
                        <?php
                            $do = $this->db->order_by('id','DESC')->get_where('packing_do', array('dihapus' => 'tidak'))->result();
                            foreach ($do as $data_do) {
                            ?>
                                <option data-description="" value="<?= $data_do->id; ?>">
                                    <?= $data_do->nomor_do; ?>
                                </option>
                            <?php
                            }
                        ?>
                    </select>                    
                    <div id='hasil_pencarian' style="padding-top: 35px"></div>
                </div>
            </div>
            <div class="col-sm-2">
                <div>
                    <button type="reset" data-toggle="tooltip" title="" class="btn btn-sm btn-default add-row">
                        <i class="fa fa-plus-circle"></i> Tambah DO
                    </button>
                </div>
            </div>
        </div>        
        
    </form>


    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
            <div class="table-responsive">
                <table id="TabelTransaksi" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr class="themed-color themed-background" style="font-weight: bold;">
                            <td class="text-center text-light" style="width: 3%;">NO</td>
                            <td class="text-light" style="width: 10%;">NOMOR DO</td>
                            <td class="text-light" style="width: 35%;">NAMA LEMBAGA</td>
                            <td class="text-light text-center" style="width: 10%;">QOLI</td>
                            <td class="text-light text-center" style="width: 10%;">IKAT</td>
                            <td class="text-light text-center" style="width: 15%;">STATUS KIRIM</td>
                            <td class="text-light text-center" style="width: 10%;">LHFBD</td>
                            <td class="text-center no-sort text-light" style="width: 15%;"><button class="btn btn-xs btn-default delete-row"><i class="hi hi-trash"></i></button></td>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8">
            <textarea name='catatan' id='catatan' class='form-control' rows='2' placeholder="Catatan Transaksi (Jika Ada)" style='resize: vertical; width:83%;'></textarea>
            <br />
            <p><i class='fa fa-keyboard-o fa-fw'></i> <b>Shortcut Keyboard : </b></p>
            <div class='row'>
                <div class='col-sm-6'></div>
            </div>
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

    <!-- END row -->
    <!-- END block-->
</div>

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script>


    // ADD ROW (TOMBOL TAMBAH DI CLICK)
    $(document).ready(function() {
        $(".add-row").click(function() {
            var IdDo = $("#do").val();
            listDo();
        });

        // Find and remove selected table rows
        $(".delete-row").click(function() {
            $("table tbody").find('input[name="record"]').each(function() {
                if ($(this).is(":checked")) {
                    $(this).parents("tr").remove();
                }
            });
        });
    });

    function listDo() {
        var IdDo = $("#do").val();
        //var Nomor_do = $("#nomor_donya").html();
        let nomor_do= '';
        let jumlah_ikat= '';
        let jumlah_qoli= '';
        let tanggal= '';
        let kepala_gudang= '';
        let pengirim = '';
        let nama_lembaga='-';
        let status_kirim = 'Dikirm';
        let lhfbd = 0; // lama hari do belum kirim

        if (IdDo != '') {
            $.ajax({
                url: "<?php echo site_url('admin/surat_jalan/ajax_detail_do'); ?>",
                type: "POST",
                data: 'id_do=' + IdDo,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        nomor_do = data.nomor_do;
                        nama_lembaga = data.nama_lembaga;
                        id_lembaga = data.id_lembaga;
                        jumlah_qoli = data.jumlah_qoli;
                        jumlah_ikat = data.jumlah_ikat;

                    } else {
                        $('.modal-dialog').removeClass('modal-lg');
                        $('.modal-dialog').addClass('modal-sm');
                        $('#ModalHeader').html('Oops !');
                        $('#ModalContent').html(data.pesan);
                        $('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
                        $('#ModalGue').modal('show');
                    }
                },
                async: false // ajax akan selesai sebelum baris terakhir dieksekusi
            });     
            
            var Nomor = $('#TabelTransaksi tbody tr').length + 1;
            var Baris = "<tr>";
            Baris += "<td class='text-center'>";
            Baris += "<span>" + Nomor + "</span>";
            Baris += "<input type='hidden' id='nomor_do' name='nomor_do[]' value='" + nomor_do + "'>";
            Baris += "</td>";
            Baris += "<td>" + nomor_do + "</td>";
            Baris += "<td>";
            Baris += "<span>" + nama_lembaga + "</span>";
            Baris += "<input type='hidden' id='id_lembaga' name='id_lembaga[]' value='" + id_lembaga + "'>";
            Baris += "</td>";
            Baris += "<td class='text-center'>" + jumlah_qoli + "</td>";
            Baris += "<td class='text-center'>" + jumlah_ikat + "</td>";
            Baris += "<td>" + status_kirim + "</td>";
            Baris += "<td>" + lhfbd +' Hari'+ "</td>";
            Baris += "<td class='text-center'><input type='checkbox' name='record'></td>";
            Baris += "</tr>";

            $("table tbody").append(Baris);
            $('#do option:selected').val('');
            $('#do').focus();

        } else {
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').addClass('modal-sm');
            $('#ModalHeader').html('Oops !');
            $('#ModalContent').html('Harap pilih nomor DO selain yang ada di daftar DO');
            $('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
            $('#ModalGue').modal('show');
        }
    }

    //BUTTON SIMPAN DI CLICK
    $(document).on('click', '#Simpann', function() {
        $('.modal-dialog').removeClass('modal-lg');
        $('.modal-dialog').addClass('modal-sm');
        $('#ModalHeader').html('Konfirmasi');
        $('#ModalContent').html("Apakah anda yakin ingin menyimpan surat jalan ini?");
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
        //cek kalo dipilih diinput nama pelanggan
        
        if ($('#tanggal').val() == '') 
        {
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').addClass('modal-sm');
            $('#ModalHeader').html('Oops !');
            $('#ModalContent').html('Harap input tanggal surat jalan terlebih dahulu!');
            $('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
            $('#ModalGue').modal('show');
        }
        else if($('#exspedisi').val() == '')
        {
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').addClass('modal-sm');
            $('#ModalHeader').html('Oops !');
            $('#ModalContent').html('Harap pilih exspedisi terlebih dahulu!');
            $('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
            $('#ModalGue').modal('show');
        }
        else{
            var tanggal = $("#tanggal").val();
            var exspedisi = $("#exspedisi").val();
            var catatan = $("#catatan").val();
            var no_urut = $("#no_urut").val();
            // var nm_pembeli_regular = $("#namaPembeli").html();

            var FormData = "nomor_do=" + encodeURI($('#nomor_nota').val());
            FormData += "&tanggal=" + tanggal;
            FormData += "&exspedisi=" + exspedisi;
            FormData += "&catatan=" + catatan;
            FormData += "&no_urut=" + no_urut;
            FormData += "&" + $('#TabelTransaksi tbody input').serialize();
            FormData += "&catatan=" + encodeURI($('#catatan').val());

            $.ajax({
                url: "<?php echo site_url('admin/surat_jalan/form'); ?>",
                type: "POST",
                cache: false,
                data: FormData,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        $('.modal-dialog').removeClass('modal-lg');
                        $('.modal-dialog').addClass('modal-sm');
                        $('#ModalHeader').html('Sukses !');
                        $('#ModalContent').html(data.pesan);
                        $('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
                        $('#ModalGue').modal('show');

                        //alert(data.pesan);
                        //window.location.href="<?php echo site_url('transaksi/penjualan'); ?>";
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
    }

    function CetakStruk() {
        if ($('#TotalBayarHidden').val() > 0) {
            if ($('#UangCash').val() !== '') {
                //cek kalo dipilih diinput nama pelanggan
                var id_pelanggan = 0;
                var id_reseller = $("#IDReseller").html();
                var nm_pembeli_regular = $("#namaPembeli").html();

                if (id_reseller != '') {
                    id_pelanggan = id_reseller;
                }

                var FormData = "nomor_nota=" + encodeURI($('#nomor_nota').val());
                FormData += "&id_pelanggan=" + id_pelanggan;
                FormData += "&nm_pembeli_regular=" + nm_pembeli_regular;
                FormData += "&" + $('#TabelTransaksi tbody input').serialize();
                FormData += "&cash=" + $('#UangCash').val();
                FormData += "&catatan=" + encodeURI($('#catatan').val());
                FormData += "&grand_total=" + $('#TotalBayarHidden').val();
                FormData += "&jenis_pembayaran=" + $('#jenis_pembayaran option:selected').val();

                window.open("<?php echo site_url('transaksi/transaksi_cetaks/?'); ?>" + FormData, '_blank');
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

    //PENCARIAN KODE
    // $(document).ready(function() {
    //     $('#nomor_do').keyup(function() {
    //         var keyword = $(this).val();
    //         var Lebar = 88;
    //         if (keyword != '') {
    //             $.ajax({
    //                 //alert(keyword);
    //                 url: "<?php echo site_url('admin/surat_jalan/cari_kode_do'); ?>",
    //                 type: "POST",
    //                 cache: false,
    //                 //data:{keyword:keyword},  
    //                 data: 'keyword=' + keyword + '&registered=' + 1,

    //                 success: function(data) {
    //                     $('#hasil_pencarian').fadeIn();
    //                     $('#hasil_pencarian').css({
    //                         'width': Lebar + '%'
    //                     });
    //                     $('#hasil_pencarian').html(data);
    //                 }
    //             });
    //         }
    //     });
    //     $(document).on('click', 'li', function() {

    //         //var NamaBarang = $(this).find('span#barangnya').html();
    //         var kodenya = $(this).find('span#nomor_donya').html();
    //         var id_packing_do = $(this).find('span#id_packing_donya').html();

    //         //$('#id_do').html(id_packing_donya);
    //         $('#nomor_do').val(kodenya);
    //         $('#hasil_pencarian').fadeOut();
    //         //$('#qty').focus();
    //     });
    // });  

</script>