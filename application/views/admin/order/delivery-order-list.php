<div class="row text-center">
    <div class="col-sm-12 col-lg-6">
        <!-- Widget -->
        <a href="<?= site_url('admin/order/delivery/' . $id_pesanan . '/list'); ?>" class="widget widget-hover-effect1">
            <div class="widget-simple">
                <div class="widget-icon pull-left themed-background-spring animation-fadeIn">
                    <?= $jumlah_do; ?>
                </div>
                <h3 class="widget-content text-right animation-pullDown">
                    Delivery <strong>Order</strong><br>
                    <small>Detail Pesanan Terpenuhi</small>
                </h3>
            </div>
        </a>
        <!-- END Widget -->
    </div>
    <div class="col-sm-12 col-lg-6">
        <!-- Widget -->
        <a href="<?= site_url('admin/packing'); ?>" class="widget widget-hover-effect1">
            <div class="widget-simple">
                <div class="widget-icon pull-left themed-background-autumn animation-fadeIn">
                    <i class="fa fa-hourglass-o"></i>
                </div>
                <h3 class="widget-content text-right animation-pullDown">
                    Standing <strong>Order</strong><br>
                    <small>Detail Barang Belum Terpenuhi</small>
                </h3>
            </div>
        </a>
        <!-- END Widget -->
    </div>
</div>
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
            #di sp mitra jadi marketing
            $marketing = $this->db->get_where('marketing', array('id' => $sp[0]->id_mitra))->result();
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-info-circle"></i> Surat Pesanan
                    <button type="button" class="btn btn-outline btn-primary btn-xs pull-right tampilkan tultip" data-toggle="tooltip" title="Klik untuk menampilkan SP"> <i class="fa fa-plus-circle"></i> Tampilkan SP</button>
                    <button type="button" class="btn btn-outline btn-warning btn-xs pull-right sembunyikan tultip" data-toggle="tooltip" title="Klik untuk sembunyikan SP" style="display:none;"> <i class="fa fa-minus-circle"></i> Sembunyikan SP</button>
                </div>
                <div class="panel-body info" style="display: none;">
                <table class="table table-vcenter table-condensed table-bordered table-hover" width="100%">
                    <tbody>
                        <tr>
                            <td class="text-left" style="width: 1%;"><strong>Tanggal SP</strong></td>
                            <td class="text-left" style="width: 5%;">
                                <?= $this->tanggal->konversi($sp[0]->tanggal_sp); ?>
                            </td>
                            <td class="text-left" style="width: 1%;"><strong>Kode Lembaga</strong></td>
                            <td class="text-left" style="width: 5%;"> <?= (isset($lembaga[0]->kode) ? $lembaga[0]->alamat : ''); ?></td>
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
                            <td class="text-left" style="width: 1%;"><strong>ID Marketing</strong></td>
                            <td class="text-left" style="width: 5%;"> <?= (isset($marketing[0]->nomor_id) ? $marketing[0]->nomor_id : ''); ?></td>
                            <td class="text-left" style="width: 1%;"><strong>Jenjang</strong></td>
                            <td class="text-left" style="width: 5%;"> <?= (isset($lembaga[0]->jenjang) ? $lembaga[0]->jenjang : ''); ?></td>
                        </tr>
                        <tr>
                            <td class="text-left" style="width: 1%;"><strong>Nama Marketing</strong></td>
                            <td class="text-left" style="width: 5%;"> <?= (isset($marketing[0]->nama_lengkap) ? $marketing[0]->nama_lengkap : ''); ?></td>
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


    <h4 class="sub-header"><strong><i class="fa fa-list-alt"></i> Surat Pesanan <?= $sp[0]->nomor_sp; ?></strong></h4>
    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
            <div class="table-responsive">
                <table id="" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr style="font-weight: bold;" class="themed-border themed-background-spring text-light">
                            <td class="text-center" style="width: 2%;">NO</td>
                            <td style="width: 10%;">KODE</td>
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
    <?php
    $q = $this->db->order_by('id_packing_m', 'DESC')->get_where('packing_master', array('id_pesanan_m' => $id_pesanan));
    $Qpacking = $q->result();
    $jumlah_packingan = $q->num_rows();
    $doKe = $tab = 0;
    foreach ($Qpacking as $pm) { // packing master
        $tab+=1;
    ?>
        <h4 class="sub-header">
            <strong><i class="fa fa-truck"></i> DELIVERY ORDER <?= '('.$jumlah_packingan--.')'; ?></strong>
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
                            <div class="" style="margin: 0px 15px 5px 15px;"> 
                                <?php
                                    #cek validasi do
                                    $qValidasi = $this->db->get_where('packing_do', array('id_packing_m' => $pm->id_packing_m));
                                    //echo $pm->id_packing_m;
                                    $id_packing_do = 0;
                                    $tombol_print =$tombol_faktur = '';

                                    #CEK APAKAH DO SUDAH DIVALIDASI
                                    if($qValidasi->num_rows() > 0){
                                        $q = $qValidasi->row();
                                        $id_packing_do = $q->id;
                                        $tombol_print = '<button onclick="printDo('.$id_packing_do.','.$id_pesanan.','.$pm->id_packing_m.');" class="btn btn-alt btn-sm btn-primary validasi" data-toggle="tooltip" title="Validasi Delivery Order">
                                                            <i class="fa fa-print"></i> Cetak DO
                                                        </button>';
                                        $tombol_faktur = '<button onclick="print_faktur('.$id_packing_do.','.$id_pesanan.','.$pm->id_packing_m.');" class="btn btn-sm btn-info btn-alt" data-toggle="tooltip" title="Cetak Faktur">
                                                            <i class="gi gi-print"></i> Cetak Faktur
                                                        </button>';
                                }
                                ?>    
                                <?=$tombol_print.' '.$tombol_faktur;?> 
                            </div>

                            <div class='col-lg-12' style="margin-bottom: 5px;">
                                <div class="table-responsive">
                                    <table id="" class="table table-vcenter table-condensed table-bordered">
                                        <thead>
                                            <tr style="font-weight: bold;" class="themed-border themed-background text-light">
                                                <td class="text-center" style="width: 2%;">NO</td>
                                                <td style="width: 10%;">KODE</td>
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
                                        <td style="width: 10%;" class="text-center">QTY SO </td>
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
<!-- END Modal Tambah-->

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script>
    $(document).ready(function() {
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

    function printDo(id_packing_do, id_pesanan, id_packing_m) {
    //.attr("src", "/url/to/page/to/print")     
        $("<iframe>")                             // create a new iframe element
            .hide()                               // make it invisible
            .attr("src", "<?php echo base_url(); ?>admin/order/print_do/"+id_packing_do+'/'+id_pesanan+'/'+id_packing_m+"") // point the iframe to the page you want to print
            .appendTo("body");                    // add iframe to the DOM to cause it to load the page
    }   
    
    function print_faktur(id_packing_do, id_pesanan, id_packing_m) {
        $("<iframe>")                             // create a new iframe element
            .hide()                               // make it invisible
            .attr("src", "<?php echo base_url(); ?>admin/order/print_faktur/"+id_packing_do+'/'+id_pesanan+'/'+id_packing_m+"") // point the iframe to the page you want to print
            .appendTo("body");                    // add iframe to the DOM to cause it to load the page
    }       
</script>