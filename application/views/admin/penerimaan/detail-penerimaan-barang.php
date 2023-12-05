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
            <h4><i class='fa fa-info-circle fa-fw animation-pulse'></i> Detail Penerimaan Barang Nomor Penerimaan <?=$penerimaan_master[0]->nomor_penerimaan;?></h4>
            <br />
        </div>
    </div>    


    <div class="table-responsive">
                <table class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <td width="25%">NOMOR INVOICE</td>
                            <td width="2px">:</td>
                            <td><?=$penerimaan_master[0]->nomor_invoice;?></td>
                        </tr>
                        <tr>
                            <td width="25%">NAMA PENGIRIM</td>
                            <td width="2px">:</td>
                            <td><?=$penerimaan_master[0]->pengirim;?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

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
                        <td class='text-center' style="width: 5%">HARGA SATUAN</td>
                        <td class='text-center' style="width: 5%">Qty</td>
                        <td class='text-center' style="width: 5%">JUMLAH HARGA</td>
                        <td class='text-center' style="width: 5%">PPN</td>
                        <td class='text-center' style="width: 5%">HARGA PAJAK</td>
                        <td class='text-center' style="width: 5%">DISKON PEMBELIAN(Rp.)</td>
                        <td class='text-center' style="width: 5%">HARGA DISKON (Rp.)</td>

                    </tr>
                </thead>                
                <tbody>
                    <?php
                        $q = $this->db->query("SELECT 
                                                penerimaan_detail.* , 
                                                barang.kode_barang AS kode_barang,
                                                barang.nama_barang AS nama_barang,
                                                barang.spesifikasi AS spesifikasi,
                                                barang.satuan AS satuan
                                                FROM penerimaan_detail, barang
                                                WHERE penerimaan_detail.id_penerimaan_m=$id_penerimaan_m
                                                AND penerimaan_detail.id_barang=barang.id_barang
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
                                </td>
                                <td class="text-left success">
                                    <?=$d->satuan;?>
                                </td>
                                <td class="text-right success"><?=str_replace(',', '.', number_format($d->harga_satuan));?></td>                                
                                <td class="text-center success"><?=$d->jumlah_beli;?></td>
                                <td class="text-right success"><?=str_replace(',', '.', number_format($d->total));?></td>                                
                                <td class="text-right success">
                                    <?=str_replace(',', '.', number_format($d->ppn));?>
                                </td>                                
                                <td class="text-right success"><?=str_replace(',', '.', number_format($d->harga_pajak));?></td>              
                                <td class="text-right success"><?=str_replace(',', '.', number_format($d->diskon));?></td>              
                                <td class="text-right success"><?=str_replace(',', '.', number_format($d->harga_diskon));?></td>              
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
                        <input type="text" value='<?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->grand_total));?>' id="TotalBayar" class="form-control" placeholder='0' disabled>
                    </div>
                </div>
                

                <div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">
                        PPN PEMBELIAN
                    </label>
                    <div class="col-md-6">
                        <input type="text" value='<?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->ppn));?>' id="ppnShow" class="form-control" placeholder='0' disabled>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; margin-bottom:-15px">
                    <label class="col-md-6 control-label" for="example-hf-email">NETTO</label>
                    <div class="col-md-6">
                        <input type='text' value='<?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->netto));?>' id='Netto' class='form-control' disabled>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; margin-bottom:-15px">
                    <label class="col-md-6 control-label" for="example-hf-email">DISKON PEMBELIAN</label>
                    <div class="col-md-6">
                        <input type='text' value='<?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->diskon));?>' id='DiskonPembelian' class='form-control' disabled>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; margin-bottom:-15px">
                    <label class="col-md-6 control-label" for="example-hf-email">NETTO BAYAR</label>
                    <div class="col-md-6">
                        <input type='text' value='<?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->netto_bayar));?>' id='NettoBayar' class='form-control' disabled>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; margin-bottom:-15px">
                    <label class="col-md-6 control-label" for="example-hf-email">UANG MUKA</label>
                    <div class="col-md-6">
                        <input type='text' value='<?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->uang_muka));?>' id='UangCash' class='form-control' name="UangCash" placeholder="0" disabled>
                    </div>
                </div>

                <div class="form-group" style="border-bottom:none; margin-bottom:-15px">
                    <label class="col-md-6 control-label" for="example-hf-email">SISA PEMBAYARAN</label>
                    <div class="col-md-6">
                        <input type='text' value='<?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->sisa_bayar));?>' id='SisaBayar' class='form-control' disabled>
                    </div>
                </div>

            </form>
        </div>
    </div>


</div>
