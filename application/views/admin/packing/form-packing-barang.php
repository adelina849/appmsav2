<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">

<div class="block full">
    <!-- All Orders Title -->
    <div class="block-title">
        <div class="block-options pull-right" style="margin-right: 15px;">
            <a href="<?= site_url('admin/packing'); ?>" data-toggle="tooltip" title="daftar surat pesanan" class="btn-link">
                <i class="fa fa-list-alt"></i> Daftar Surat Pesanan
            </a>
        </div>
        <h2><i class="hi hi-cog"></i> <strong><?= $title; ?></strong></h2>
    </div>

    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
            <?php
                $sp = $this->db->get_where('pesanan_master', array('id_pesanan_m' => $id_pesanan))->result();
                $lembaga = $this->db->get_where('lembaga', array('id' => $sp[0]->id_lembaga))->result();
                $pelanggan = $this->db->get_where('pelanggan', array('id' => $sp[0]->id_pelanggan))->result();
                $mitra = $this->db->get_where('mitra', array('id' => $sp[0]->id_mitra))->result();
            ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle"></i> Surat Pesanan
                    <button type="button" class="btn btn-outline btn-primary btn-xs pull-right tampilkan tultip" data-toggle="tooltip" title="Klik untuk menampilkan SP"> <i class="fa fa-plus-circle"></i> Tampilkan SP</button>
                    <button type="button" class="btn btn-outline btn-warning btn-xs pull-right sembunyikan tultip" data-toggle="tooltip" title="Klik untuk sembunyikan SP" style="display:none;"> <i class="fa fa-minus-circle"></i> Sembunyikan SP</button>
                </div>
                <div class="panel-body info" style="display: none;">

                    <h4 class="sub-header"><strong><i class="fa fa-list-alt"></i> Surat Pesanan <?= $sp[0]->nomor_sp; ?></strong></h4>
                    <div class="row">
                        <div class='col-lg-12' style="margin-bottom: 5px;">
                            <div class="table-responsive">
                                <table id="" class="table table-vcenter table-condensed table-bordered">
                                    <thead>
                                        <tr style="font-weight: bold;" class="themed-border themed-background-spring text-light">
                                            <td class="text-center" style="width: 2%;">NO</td>
                                            <td style="width: 5%;">KODE</td>
                                            <td style="width: 30%;">NAMA BARANG</td>
                                            <td style="width: 10%;">SPESIFIKASI</td>
                                            <td style="width: 5%;" class="text-center">SATUAN</td>
                                            <td style="width: 10%;" class="text-center">HARGA (Rp.)</td>
                                            <td style="width: 8%;" class="text-center">DISKON</td>
                                            <td style="width: 5%;" class="text-center">QTY</td>
                                            <td style="width: 10%;" class="text-center">Nilai (Rp.)</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = $jmlQty = 0;
                                        $i = 1;
                                        $detail_pesanan = $this->db->get_where('pesanan_detail', array('id_pesanan_m' => $id_pesanan))->result();

                                        foreach ($detail_pesanan as $kd) {
                                            $id_barang = $kd->id_barang;
                                            $barang = $this->db->get_where('barang', array('id_barang' => $id_barang))->result();
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= ++$no; ?></td>
                                                <td>
                                                    <?= isset($barang[0]->kode_barang) ? $barang[0]->kode_barang : ''; ?>
                                                </td>
                                                <td><?= isset($barang[0]->nama_barang) ? strtoupper($barang[0]->nama_barang) : ''; ?></td>
                                                <td><?= $kd->spesifikasi; ?></td>
                                                <td><?= $kd->satuan; ?></td>
                                                <td class="text-right"><?= str_replace(',', '.', number_format($kd->harga_satuan))  ?></td>
                                                <td class="text-center"><?= $kd->diskon_barang . ' %'; ?></td>
                                                <td class="text-center"><?= $kd->jumlah_beli; ?></td>
                                                <td class="text-right"><?= str_replace(',', '.', number_format($kd->total))  ?></td>
                                            </tr>
                                        <?php
                                            $jmlQty += $kd->jumlah_beli;
                                            $i++;
                                        }
                                        ?>
                                        <tr class="success">
                                            <td colspan="7" class="text-center"><strong>TOTAL</strong></td>
                                            <td class="text-center"><strong><?= $jmlQty; ?></strong></td>
                                            <td class="text-right">
                                                <strong><?= str_replace(',', '.', number_format($sp[0]->grand_total))  ?></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <table class="table table-vcenter table-condensed table-bordered table-hover" width="100%">
                        <tbody>
                            <tr>
                                <td class="text-left" style="width: 1%;"><strong>Tanggal SP</strong></td>
                                <td class="text-left" style="width: 5%;">
                                    <?= $this->tanggal->konversi($sp[0]->tanggal_sp); ?>
                                </td>
                                <td class="text-left" style="width: 1%;"><strong>Kode Lembaga</strong></td>
                                <td class="text-left" style="width: 5%;"> <?= (isset($lembaga[0]->kode) ? $lembaga[0]->kode : ''); ?></td>
                            </tr>

                            <tr>
                                <td class="text-left" style="width: 1%;"><strong>Nomor SP</strong></td>
                                <td class="text-left" style="width: 5%;">
                                    <?= $sp[0]->nomor_sp; ?>
                                </td>
                                <td class="text-left" style="width: 1%;"><strong>Nama Lembaga</strong></td>
                                <td class="text-left" style="width: 5%;"> <?= (isset($lembaga[0]->nama_lembaga) ? $lembaga[0]->nama_lembaga : ''); ?></td>
                            </tr>

                            <tr>
                                <td class="text-left" style="width: 1%;"><strong>Sistem Transaksi</strong></td>
                                <td class="text-left" style="width: 5%;">
                                    <?= strtoupper($sp[0]->sistem_transaksi); ?>
                                </td>
                                <td class="text-left" style="width: 1%;"><strong>Alamat</strong></td>
                                <td class="text-left" style="width: 5%;"> <?= (isset($lembaga[0]->alamat) ? $lembaga[0]->alamat : ''); ?></td>
                            </tr>
                            <tr>
                                <td class="text-left" style="width: 1%;"><strong>ID Mitra</strong></td>
                                <td class="text-left" style="width: 5%;"> <?= (isset($mitra[0]->kode) ? $mitra[0]->kode : ''); ?></td>
                                <td class="text-left" style="width: 1%;"><strong>Jenjang</strong></td>
                                <td class="text-left" style="width: 5%;"> <?= (isset($lembaga[0]->jenjang) ? $lembaga[0]->jenjang : ''); ?></td>
                            </tr>
                            <tr>
                                <td class="text-left" style="width: 1%;"><strong>Nama Mitra</strong></td>
                                <td class="text-left" style="width: 5%;"> <?= (isset($mitra[0]->nama_mitra) ? $mitra[0]->nama_mitra : ''); ?></td>
                                <td class="text-left" style="width: 1%;"><strong>Status</strong></td>
                                <td class="text-left" style="width: 5%;"> <?= (isset($lembaga[0]->status) ? $lembaga[0]->status : ''); ?></td>
                            </tr>

                            <tr>
                                <td class="text-left" style="width: 1%;"><strong>Nama Pelanggan</strong></td>
                                <td class="text-left" style="width: 5%;"> <?= (isset($pelanggan[0]->nama_pelanggan) ? $pelanggan[0]->nama_pelanggan : ''); ?></td>
                                <td class="text-left" style="width: 1%;"><strong>Alamat Pelanggan</strong></td>
                                <td class="text-left" style="width: 5%;"> <?= (isset($pelanggan[0]->alamat) ? $pelanggan[0]->alamat : ''); ?></td>
                            </tr>

                            <tr>
                                <td class="text-left" style="width: 1%;"><strong>Kontak Pelanggan</strong></td>
                                <td class="text-left" style="width: 5%;"> <?= (isset($pelanggan[0]->kontak) ? $pelanggan[0]->kontak : ''); ?></td>
                                <td class="text-left" style="width: 1%;"><strong>Jabatan Pelanggan</strong></td>
                                <td class="text-left" style="width: 5%;"> <?= (isset($pelanggan[0]->jabatan) ? $pelanggan[0]->jabatan : ''); ?></td>
                            </tr>

                        </tbody>
                    </table>            
                </div>
            </div>
        </div>
    </div>
    <!-- END row -->
    <?php echo form_open($action_packing, array('class' => '', 'id' => 'form-validation')); ?>
    <div class="row" style="margin-bottom: 10px;">
        <div class='col-sm-4' style="margin-bottom: 5px;">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
                    <div class="input-date" data-date-format="yyy-mm-dd">
                        <input type="text" id="tanggal_packing" name="tanggal_packing" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Packing" autocomplete="off" required>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-sm-8'>
            <p class="text-muted"><i class='gi gi-package'></i> <b>Jumlah Terpacking <span class="badge"><?=$jumlah_do;?></span></b></p>
        </div>
    </div>

    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
            <div class="table-responsive">
                <input type="hidden" name="id_sp" value="<?= $id_pesanan; ?>">
                <input type="hidden" name="nomor_sp" value="<?= $sp[0]->nomor_sp; ?>">
                <table id="packing" class="a table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr style="font-weight: bold;" class="themed-border themed-background text-light">
                            <td class="text-center" style="width: 2%;">NO</td>
                            <td style="width: 5%;">KODE</td>
                            <td style="width: 30%;">NAMA BARANG</td>
                            <td style="width: 10%;">SPESIFIKASI</td>
                            <td style="width: 5%;" class="text-center">SATUAN</td>
                            <td style="width: 5%;" class="text-center" data-toggle="tooltip" title="QTY barang pada surat pesanan yang belum terpenuhi">QTY</td>
                            <td style="width: 10%;" class="text-center" data-toggle="tooltip" title="QTY barang yang akan dipacking dan jumlah stok barang digudang">TERSEDIA</td>
                            <td style="width: 8%;" class="text-center" data-toggle="tooltip" title="QTY barang untuk SO">SISA SP</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        $i = 1;
                        $hitungTersedia = 0;
                        $detail_pesanan = $this->db->get_where('pesanan_detail', array('id_pesanan_m' => $id_pesanan))->result();

                        foreach ($detail_pesanan as $kd) {
                            $sisa = $qty = $qty_tersedia = 0;
                            $id_barang = $kd->id_barang;

                            $barang = $this->db->get_where('barang', array('id_barang' => $id_barang))->result();

                            #total qty barang pada surat pesanan
                            $qty_sp =  $kd->jumlah_beli;

                            #ambil jumlah qty barang yang dipesan sudah terpacking
                            $Qdetail_terpacking = $this->pesanan->count_qty_terpacking($id_pesanan, $kd->id_barang)->row();
                            $qty_terpacking = (isset($Qdetail_terpacking->total_qty_terpacking) ? $Qdetail_terpacking->total_qty_terpacking : 0);
                            $qty_sebelum_packing = ($qty_sp - $qty_terpacking);


                            $stok_barang = isset($barang[0]->total_stok) ? $barang[0]->total_stok : 0;
                            $qty = ($qty_sp - $qty_terpacking);

                            #kalo jumlah pesanan melebihi stok digudang
                            #maka sisanya akan jadi SO
                            if ($qty > $stok_barang) {
                                $qty_tersedia = $stok_barang;
                                $sisa = $qty - $qty_tersedia;
                            } else {
                                $qty_tersedia = $qty;
                            }

                            if ($sisa >= 0) {
                            }

                        ?>
                            <tr class="<?= ($qty > 0) ? 'success' : 'active'; ?>">
                                <td class="text-center"><?= ++$no; ?></td>
                                <td>
                                    <?= isset($barang[0]->kode_barang) ? $barang[0]->kode_barang : ''; ?>
                                    <input type="hidden" name="id_barang[<?= $i; ?>]" value="<?= $kd->id_barang; ?>">
                                </td>
                                <td><?= isset($barang[0]->nama_barang) ? strtoupper($barang[0]->nama_barang) : ''; ?></td>
                                <td><?= $kd->spesifikasi; ?></td>
                                <td><?= $kd->satuan; ?></td>
                                <td class="text-center">
                                    <span class="badge themed-border-blackberry themed-background-night" style="font-size: 1em; font-weight: bold;">
                                        <?php
                                        // #total qty barang pada surat pesanan
                                        // $qty_sp =  $kd->jumlah_beli;

                                        // #ambil jumlah qty barang yang dipesan sudah terpacking
                                        // $Qdetail_terpacking = $this->pesanan->count_qty_terpacking($id_pesanan, $kd->id_barang)->row();
                                        // $qty_terpacking = (isset($Qdetail_terpacking->total_qty_terpacking) ? $Qdetail_terpacking->total_qty_terpacking : 0);
                                        // $qty_sebelum_packing = ($qty_sp - $qty_terpacking);
                                        echo $qty;
                                        ?>
                                    </span>
                                </td>
                                <td class="text-center">

                                    <div class="input-group">
                                        <input type="hidden" id='qty' name='qty<?= $i; ?>' value='<?= $qty; ?>'>
                                        <input type="hidden" id='stokBarang' name='stokBarang<?= $i;?>' value='<?= $stok_barang; ?>'>
                                        <input type="text" id="tersedia" name="tersedia[<?= $i; ?>]" value="<?= $qty_tersedia; ?>" class="form-control text-center stokTersedia" placeholder='0' onkeypress='return check_int(event)' required>
                                        <span class="input-group-addon text-primary" style="font-weight: bold;">
                                            <?= isset($barang[0]->total_stok) ? $barang[0]->total_stok : ''; ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <input type="hidden" name="no_id" value="<?= $i; ?>">
                                    <input type="hidden" name="sisa_val[<?= $i; ?>]" id="sisaVal<?= $i; ?>" value="<?= $sisa; ?>">
                                    <span class="" id="sisa<?= $i; ?>" style="font-size: 1em; font-weight: bold;">
                                        <?= $sisa; ?>
                                    </span>
                                </td>
                            </tr>
                        <?php
                            $hitungTersedia += $qty_tersedia;
                            $i++;
                        }
                        #jika jumlah qty tersedia semuanya 0 button simpan tidak diaktifkan (tidak boleh packing barang)
                        $disabled = ($hitungTersedia > 0) ? '' : 'disabled';
                        ?>
                    </tbody>
                </table>
                <div class="form-group form-actions">
                    <div class="col-md-12 text-center" style="margin-top: 15px;">
                        <button type="button" class="btn btn-sm btn-default" data-dismiss="modal"><i class="fa fa-refresh"></i> Batal</button>
                        <button type="submit" class="btn btn-sm btn-info simpan" <?= $disabled; ?>><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END row -->
    <?= form_close(); ?>

    <?php
    $q = $this->db->order_by('id_packing_m', 'DESC')->get_where('packing_master', array('id_pesanan_m' => $id_pesanan));
    $Qpacking = $q->result();
    $jumlah_packingan = $q->num_rows();

    $doKe = $tab = 0;
    foreach ($Qpacking as $pm) { // packing master
        $tab+=1;
    ?>
        <h4 class="sub-header">
            <strong><i class="gi gi-package"></i> PACKING KE <?= '('.$jumlah_packingan--.')'; ?></strong>
            <span class="pull-right"><i class="fa fa-calendar"></i> <?= $this->tanggal->konversi($pm->tanggal_packing); ?></span>
        </h4>
        <div class="row" style="padding: 0px 15px 0px 15px;">
            <div class="block full">
                <!-- Block Tabs Title -->
                <div class="block-title">
                    <ul class="nav nav-tabs" data-toggle="tabs">
                        <li class="active" data-toggle="tooltip" title="Daftar DO"><a href="#do<?=$tab;?>">Delivery Order</a></li>
                        <li><a href="#so<?=$tab;?>" data-toggle="tooltip" title="Daftar SO">Standing Order</a></li>
                    </ul>
                </div>
                <!-- END Block Tabs Title -->

                <!-- Tabs Content -->
                <div class="tab-content">
                    <!-- DAFTAR DELIVERY ORDER -->
                    <div class="tab-pane active" id="do<?=$tab;?>">
                        <div class="row">
                            <div class='alert alert-info alert-dismissable' style='margin-left: 15px; margin-right: 15px;'> 
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>                            
                                <i class='fa fa-info-circle fa-fw animation-pulse'></i> Tombol Print DO akan muncul jika DO sudah divalidasi!
                            </div>   
                            <div class="btn-group btn-group-sm" style="margin: 0px 15px 5px 15px;"> 
                                <?php
                                    #cek validasi do
                                    $qValidasi = $this->db->get_where('packing_do', array('id_packing_m' => $pm->id_packing_m));
                                    $id_packing_do = 0;
                                    $tombol_print = '';

                                    #CEK APAKAH DO SUDAH DIVALIDASI
                                    if($qValidasi->num_rows() > 0){
                                        $q = $qValidasi->row();
                                        $id_packing_do = $q->id;
                                        $tombol_print = '<button onclick="printDo('.$id_packing_do.','.$id_pesanan.','.$pm->id_packing_m.');" class="btn btn-alt btn-sm btn-primary validasi" data-toggle="tooltip" title="Validasi Delivery Order">
                                                            <i class="fa fa-print"></i> Print DO
                                                        </button>';
                                    }
                                ?>    
                                <a href="#" onclick="validasi(<?=$id_packing_do.','.$id_pesanan.','.$pm->id_packing_m;?>);" class="btn btn-alt btn-sm btn-primary validasi" data-toggle="tooltip" title="Validasi Delivery Order">
                                    <i class="fa fa-pencil-square-o"></i> Validasi DO 
                                </a>
                                <?php //echo $tombol_print;?> 
                            </div>

                            <div class="btn-group btn-group-sm pull-right">
                                    <?php
                                        $cetak = $pm->cetak;
                                        $pernah_cetak = 'Belum Dicetak';
                                        $class_cetak = 'text-muted';
                                        if($cetak==1){
                                            $pernah_cetak='Sudah Dicetak';
                                            $class_cetak = 'text-success';
                                        }
                                    ?>
                                    
                                <button onclick="#" 
                                class="btn btn-sm btn-alt btn-default" data-toggle="tooltip" title="Sudah pernah di cetak" style="margin: 0px 1px 0px 0px;">
                                    <span class="<?=$class_cetak;?>"><i class="fa fa-check"></i> <?=$pernah_cetak;?></span>
                                </button>

                                <button onclick="pernah_cetak(<?=$id_pesanan.','.$pm->id_packing_m.','.$cetak;?>);" 
                                class="btn btn-sm btn-alt btn-default" data-toggle="tooltip" title="Cetak Form Packing" style="margin: 0px 15px 0px 0px;">
                                    <span class="text-danger"><i class="gi gi-print"></i> Cetak Form Paking</span>
                                </button>        

                            </div>

                            <div class='col-lg-12' style="margin-bottom: 5px;">
                                <div class="table-responsive">
                                    <table id="" class="table table-vcenter table-condensed table-bordered">
                                        <thead>
                                            <tr style="font-weight: bold;" class="themed-border themed-background text-light">
                                                <td class="text-center" style="width: 2%;">NO</td>
                                                <td style="width: 5%;">KODE</td>
                                                <td style="width: 30%;">NAMA BARANG</td>
                                                <td style="width: 15%;">SPESIFIKASI</td>
                                                <td style="width: 10%;" class="text-center">SATUAN</td>
                                                <td style="width: 10%;" class="text-center">QTY PACKING</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = $jmlQty = 0;
                                            $i = 1;
                                            $QpackingDetail = $this->db->get_where('packing_detail', array('id_packing_m' => $pm->id_packing_m, 'qty_terpacking >' => 0))->result();
                                            foreach ($QpackingDetail as $pd) {
                                                $pdid_barang = $pd->id_barang;
                                                $pdbarang = $this->db->get_where('barang', array('id_barang' => $pd->id_barang))->result();
                                            ?>
                                                <tr>
                                                    <td class="text-center"><?= ++$no; ?></td>
                                                    <td>
                                                        <?= isset($pdbarang[0]->kode_barang) ? $pdbarang[0]->kode_barang : ''; ?>
                                                    </td>
                                                    <td><?= isset($pdbarang[0]->nama_barang) ? strtoupper($pdbarang[0]->nama_barang) : ''; ?></td>
                                                    <td><?= $pdbarang[0]->spesifikasi; ?></td>
                                                    <td><?= $pdbarang[0]->satuan; ?></td>
                                                    <td class="text-center"><?= $pd->qty_terpacking; ?></td>
                                                </tr>
                                            <?php
                                                $jmlQty += $pd->qty_terpacking;
                                                $i++;
                                            }
                                            ?>
                                            <tr class="info">
                                                <td colspan="5" class="text-center"><strong>TOTAL</strong></td>
                                                <td class="text-center"><strong><?= $jmlQty; ?></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                    
                    </div>
                    
                    <!-- DAFTAR STANDING ORDER -->
                    <div class="tab-pane" id="so<?=$tab;?>">
                        <div class="table-responsive">
                            <table id="" class="table table-vcenter table-condensed table-bordered">
                                <thead>
                                    <tr style="font-weight: bold;" class="themed-border themed-background-fire text-light">
                                        <td class="text-center" style="width: 2%;">NO</td>
                                        <td style="width: 5%;">KODE</td>
                                        <td style="width: 30%;">NAMA BARANG</td>
                                        <td style="width: 15%;">SPESIFIKASI</td>
                                        <td style="width: 10%;" class="text-center">SATUAN</td>
                                        <td style="width: 10%;" class="text-center">QTY SO</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = $jmlQtySO = $qty_terpacking = $qty_pesanan_awal = $sisa_so = 0;
                                    $i = 1;
                                    $QpackingDetail = $this->db->get_where('packing_detail', array('id_packing_m' => $pm->id_packing_m,'qty_so >' => 0))->result();
                                    foreach ($QpackingDetail as $pd) {
                                        $pdid_barang = $pd->id_barang;
                                        $pdbarang = $this->db->get_where('barang', array('id_barang' => $pd->id_barang))->result();
                                    ?>
                                        <tr>
                                            <td class="text-center"><?= ++$no; ?></td>
                                            <td>
                                                <?= isset($pdbarang[0]->kode_barang) ? $pdbarang[0]->kode_barang : ''; ?>
                                            </td>
                                            <td><?= isset($pdbarang[0]->nama_barang) ? strtoupper($pdbarang[0]->nama_barang) : ''; ?></td>
                                            <td><?= $pdbarang[0]->spesifikasi; ?></td>
                                            <td><?= $pdbarang[0]->satuan; ?></td>
                                            <td class="text-center">
                                                <?php
                                                    echo $pd->qty_so;
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                        $jmlQtySO += $pd->qty_so;
                                        $i++;
                                    }
                                    ?>
                                    <tr class="info">
                                        <td colspan="5" class="text-center"><strong>TOTAL</strong></td>
                                        <td class="text-center"><strong><?= $jmlQtySO; ?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END Tabs Content -->
            </div>
            <!-- END Block Tabs -->        
        </div>
    <?php
    }
    ?>

    <!-- END block-->
</div>

<!-- Modal Validasi-->
<div id="FormValidasi" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-pencil-square-o"></i> Validasi DO</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_validasi, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
				<fieldset>

					<input type="hidden" name="id_packing_do" class="id_packing_do">
                    <input type="hidden" name="id_pesanan" class="id_pesanan">
                    <input type="hidden" name="id_packing_m" class="id_packing_m">

                    <div class="form-group">
                        <label class="col-md-4 control-label" for="example-daterange1">TANGGAL DO</label>
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
                                <div class="input-date" data-date-format="yyy-mm-dd">
                                    <input type="text" id="tanggal_do" name="tanggal_do" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal DO" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <div class="form-group">
						<label class="col-md-4 control-label" for="qoli">JUMLAH QOLI <span class="text-danger">*</span></label>
						<div class="col-md-6">
                            <input type="number" id="qoli" name="qoli" class="form-control" placeholder="0" required>
						</div>
					</div>
	
                    <div class="form-group">
						<label class="col-md-4 control-label" for="ikat">JUMLAH IKAT <span class="text-danger">*</span></label>
						<div class="col-md-6">
                            <input type="number" id="ikat" name="ikat" class="form-control" placeholder="0" required>
						</div>
					</div>

				</fieldset>
				<div class="form-group form-actions">
					<div class="col-md-12 text-center">
						<button type="reset" class="btn btn-sm btn-warning" data-dismiss="modal"><i class="fa fa-repeat"></i> Batal</button>
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
					</div>
				</div>
				<?php echo form_close(); ?>
				<!-- END Form Validation Example Content -->
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
<!-- END Modal Validasi-->

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script>


    $(document).ready(function() {

        $('#packing').dataTable( {               
            "iDisplayLength": -1,
            "lengthChange": false,
            "paging": false
        } );
        $('body').tooltip({
            selector: '[data-toggle="tooltip"]'
        });
    });

    $(document).ready(function() {

        //let sks = $(this).find('[name="sks"]').val();
        $("#packing tbody tr").on('keyup', function() {
            //var huruf = $(this).find(":selected").val();
            let nomorId = $(this).find('[name="no_id"]').val();
            let jumlahBeli = $(this).find('[name="jumlahBeli"]').val();
            let stokBarang = $(this).find('[name="stokBarang' + nomorId + '"]').val();
            let qty = $(this).find('[name="qty' + nomorId + '"]').val();
            let tersedia = $(this).find('[name="tersedia[' + nomorId + ']"]').val();

            let sisa = parseInt(qty) - parseInt(tersedia);
            if (tersedia == '') {
                $('.simpan').attr('disabled', true);
                //$(this).find('[name="tersedia' + nomorId + '"]').val(qty);

                $('#sisa' + nomorId).html(qty);
                $('#sisaVal' + nomorId).val(qty);
            } else {
                if (parseInt(tersedia) > parseInt(stokBarang)) {
                    alert('Tidak diperbolehkan melebihi stok tersedia digudang');
                    $(this).find('[name="tersedia' + nomorId + '"]').focus;
                    $('.simpan').attr('disabled', true);
                } else {
                    //kalau input stok melebihi qty yang dipesan
                    if (parseInt(tersedia) > parseInt(qty)) {
                        sisa = 0;
                        alert('Input barang tersedia Tidak boleh melebihi QTY pesanan');
                        //$('#tersedia' + nomorId).val(jumlahBeli);
                        $(this).find('[name="tersedia' + nomorId + '"]').val(qty);
                    } else {
                        $('#sisa' + nomorId).html(sisa);
                        $('#sisaVal' + nomorId).val(sisa);
                        $('.simpan').attr('disabled', false);

                    }
                }

            }
            //$(this).find('td:nth-child(5) input').val(huruf);
        });
        $(".sembunyikan").click(function() {
            $(".info").hide(500);
            $(".sembunyikan").hide();
            $(".tampilkan").show();
        });
        $(".tampilkan").click(function() {
            $(".info").show(500);
            $(".sembunyikan").show();
            $(".tampilkan").hide();
        });        
    });

    function check_int(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        return (charCode >= 48 && charCode <= 57 || charCode == 8);
    }


    function printDo(id_packing_do, id_pesanan, id_packing_m) {
    //.attr("src", "/url/to/page/to/print")     
        $("<iframe>")                             // create a new iframe element
            .hide()                               // make it invisible
            .attr("src", "<?php echo base_url(); ?>admin/order/print_do/"+id_packing_do+'/'+id_pesanan+'/'+id_packing_m+"") // point the iframe to the page you want to print
            .appendTo("body");                    // add iframe to the DOM to cause it to load the page
    }   
    
    function pernah_cetak(id_pesanan, id_packing_m, pernah_cetak){
        if(pernah_cetak==1){
            var result = confirm("Data packing ini sudah pernah di cetak!. Lanjut Cetak ?");
            if (result == true) {
                print_packing(id_pesanan, id_packing_m)
            } 
        }
        else{
            print_packing(id_pesanan, id_packing_m)
        }
    }

    function print_packing(id_pesanan, id_packing_m) {
    //.attr("src", "/url/to/page/to/print")     
        $("<iframe>")                             // create a new iframe element
            .hide()                               // make it invisible
            .attr("src", "<?php echo base_url(); ?>admin/order/print_packing/"+id_pesanan+'/'+id_packing_m+"") // point the iframe to the page you want to print
            .appendTo("body");                    // add iframe to the DOM to cause it to load the page
    }   

	function validasi(id_packing_do, id_pesanan, id_packing_m) {
        save_method = 'update';
        //$('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('admin/order/ajax_get_do') ?>",
            type: "POST",
            data: 'id_packing_do=' + id_packing_do,
            dataType: "json",
            success: function(data) {

                $('[name="id_packing_do"]').val(id_packing_do);
                $('[name="id_pesanan"]').val(id_pesanan);
                $('[name="id_packing_m"]').val(id_packing_m);
                $('[name="qoli"]').val(data.jumlah_qoli);
                $('[name="ikat"]').val(data.jumlah_ikat);
                $('[name="tanggal_do"]').val(data.tanggal);								
                $('#FormValidasi').modal('show'); 

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }    
</script>