<!-- All Orders Block -->
<style>
    .table th {
        font-size: 5px;
    }
</style>
<div class="block full">

    <!-- All Orders Title -->
    <div class="block-title">
        <h2 class=""><i class="fa fa-eye animation-pulse" style="margin-top: -7px"></i> <strong><?=$title;?></strong></h2>
        <div class="block-options pull-right" style="margin-right: 15px;">
        </div>
    </div>
    <!-- END All Orders Title -->

    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
            <h4><i class='fa fa-clipboard fa-fw animation-pulse'></i> JENIS PEMBELIAN <?=strtoupper($pembelian[0]->jenis_spb);?></h4>
            <br />
        </div>
    </div>    
    <?php
        $supplier = $this->db->get_where('vendor', array('id' => $pembelian[0]->id_supplier))->result();
        $marketing = $this->db->get_where('marketing_supplier', array('id' => $pembelian[0]->id_marketing))->result();    
    ?>

    <div class="table-responsive">
                <table class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <td width="25%">NOMOR SPB</td>
                            <td width="2px">:</td>
                            <td><?=$pembelian[0]->nomor_spb;?></td>
                        </tr>
                        <tr>
                            <td width="25%">TANGGAL SPB</td>
                            <td width="2px">:</td>
                            <td><?=$this->tanggal->konversi($pembelian[0]->tanggal_spb);?></td>
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
                            <td width="25%">SISTEM PEMBAYARAN</td>
                            <td width="2px">:</td>
                            <td><?=strtoupper($pembelian[0]->sistem_pembayaran);?></td>
                        </tr>
                        <tr>
                            <td width="25%">TANGGAL JATUH TEMPO</td>
                            <td width="2px">:</td>
                            <td>
                                <?php 
                                if($pembelian[0]->sistem_pembayaran=='kredit'){
                                    echo strtoupper($pembelian[0]->jatuh_tempo);
                                }else{
                                    echo '-';
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

    <!-- Products Content -->
    <div style="overflow: hidden; overflow-x: auto; ">
		<div class="table-responsive" style="margin-top:15px; width: 2000px;">
			<table class="table table-bordered" id='TabelTransaksi' style="width: auto;">
            <thead>
                    <tr class="themed-background-amethyst text-light">
                        <td class="text-center" style="width: 2%;">NO</td>
                        <td style="width: 5%;">KODE</td>
                        <td style="width: 20%;">NAMA BARANG</td>
                        <td style="width: 10%;">SPESIFIKASI</td>
                        <td style="width: 5%;" class="text-center">SATUAN</td>
                        <td style="width: 5%;" class="text-center">HARGA</td>
                        <td style="width: 5%;" class="text-center">QTY </td>
                        <td style="width: 10%;" class="text-center">JUMLAH HARGA (Rp.)</td>
                    </tr>
                </thead>                
                <tbody>
                <?php
                        $no = $jml = $qty = $hargaSatuan = $total = 0;
                        $i = 1;
                        // $detail = $this->db->get_where('pembelian_detail', array('id_pembelian_m' => $pembelian[0]->id_pembelian_m))->result();
                        $detail = $this->db->query("SELECT a.*, 
                                                        b.kode_barang, b.nama_barang, b.spesifikasi,
                                                        b.satuan
                                                    FROM pembelian_detail a, barang b
                                                    WHERE a.id_pembelian_m='".$pembelian[0]->id_pembelian_m."'
                                                    AND a.id_barang=b.id_barang
                                                    ORDER BY b.kode_barang ASC")->result();
                        foreach ($detail as $pd) {
                            //$jml += $pd->harga_pajak;
                            // $pdid_barang = $pd->id_barang;
                            // $pdbarang = $this->db->get_where('barang', array('id_barang' => $pd->id_barang))->result();

                            $jmlHarga = 0;
                            $qty = $pd->jumlah_beli;
                            $hargaSatuan = $pd->harga_satuan;
                            $jmlHarga = ($qty * $hargaSatuan);
                            $total += $jmlHarga;

                        ?>
                            <tr>
                                <td class="text-center"><?= ++$no; ?></td>
                                <td>
                                    <?= $pd->kode_barang; ?>
                                </td>
                                <td><?= strtoupper($pd->nama_barang); ?></td>
                                <td><?= $pd->spesifikasi; ?></td>
                                <td><?= $pd->satuan; ?></td>
                                <td class="text-right"><?= str_replace(',', '.', number_format($pd->harga_satuan)); ?></td>
                                <td class="text-center"><?= $pd->jumlah_beli; ?></td>
                                <td class="text-right"><?= str_replace(',', '.', number_format($jmlHarga)); ?></td>
                            </tr>
                        <?php
                            //$jmlQty += $pd->qty_terpacking;
                            $i++;
                        }
                        ?>
                        <tr style="font-weight: bold;">
                            <td colspan="7" class="text-right">TOTAL</td>
                            <td class="text-right"><?='Rp. '.str_replace(',', '.', number_format($total));?></td>
                        </tr>
                </tbody>
            </table>
            <br />
        </div>
        <!-- END table responsive -->
    </div>


    <div class="row" style="margin-top: 10px;">
        <div class='col-sm-7'>
            <p class="text-info"></p>
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
                        <input type="text" value='<?=str_replace(',', '.', 'Rp. '.number_format($pembelian[0]->grand_total));?>' id="TotalBayar" class="form-control" placeholder='0' disabled>
                    </div>
                </div>
                

                <div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">
                        JUMLAH PPN
                    </label>
                    <div class="col-md-6">
                        <input type="text" value='<?=str_replace(',', '.', 'Rp. '.number_format($pembelian[0]->ppn));?>' id="ppnShow" class="form-control" placeholder='0' disabled>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; margin-bottom:-15px">
                    <label class="col-md-6 control-label" for="example-hf-email">TOTAL HARGA</label>
                    <div class="col-md-6">
                        <?php
                            $total_harga = ($pembelian[0]->grand_total - $pembelian[0]->ppn);
                        ?>
                        <input type='text' value='<?=str_replace(',', '.', 'Rp. '.number_format($total_harga));?>' id='Netto' class='form-control' disabled>
                    </div>
                </div>

            </form>
        </div>
    </div>


</div>
