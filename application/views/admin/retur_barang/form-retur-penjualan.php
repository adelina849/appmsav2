<!-- All Orders Block -->
<style>
	.table th {
		font-size: 5px;
	}
</style>
<div class="block full">

	<!-- All Orders Title -->
	<div class="block-title">
		<h2 class=""><i class="fa fa-file-o animation-pulse" style="margin-top: -7px"></i> <strong><?= $title; ?></strong></h2>
		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/retur_barang/retur_penjualan'); ?>" class="" data-toggle="tooltip" title="Daftar Barang">
				<i class="fa fa-list-alt"></i> Daftar Retur Penjualan
			</a>
		</div>
	</div>
	<!-- END All Orders Title -->

    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
            <h4><i class='fa fa-info-circle fa-fw animation-pulse'></i> Form Retur Penjualan Berdasarkan Nomor DO</h4>
            <br />
            <div class="table-responsive">
                <table id="do" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <tbody>
                        <?php
							$do = $this->db->get_where('packing_do', array('id' => $id_packing_do))->result();
							//$nomor_do = $do[0]->nomor_do;
							//$tanggal_do = $do[0]->tanggal;

							// $qPelanggan = $this->db->get_where('pelanggan', array('id' => $data->id_pelanggan))->result();
							// $qLembaga = $this->db->get_where('lembaga', array('id' => $data->id_lembaga))->result();                        
							$sp = $this->db->get_where('pesanan_master', array('id_pesanan_m' => $id_pesanan_m))->result();
							$lembaga = $this->db->get_where('lembaga', array('id' => $sp[0]->id_lembaga))->result();
							$pelanggan = $this->db->get_where('pelanggan', array('id' => $sp[0]->id_pelanggan))->result();
						?>
                        <tr>
                            <td width="25%">NOMOR DO</td>
                            <td width="2px">:</td>
                            <td><?=(isset($do[0]->nomor_do) ? $do[0]->nomor_do : '-');?></td>
                        </tr>
                        <tr>
                            <td width="25%">NAMA PELANGGAN</td>
                            <td width="2px">:</td>
                            <td><?= (isset($pelanggan[0]->nama_pelanggan) ? $pelanggan[0]->nama_pelanggan : '');?></td>
                        </tr>
                        <tr>
                            <td width="25%">NAMA LEMBAGA</td>
                            <td width="2px">:</td>
                            <td><?=(isset($lembaga[0]->nama_lembaga) ? $lembaga[0]->nama_lembaga : '');?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>  

    <?php echo form_open($action_retur, array('class' => '', 'id' => 'form-validation')); ?>
	<input type="hidden" value="<?= $id_packing_do; ?>" name="id_do" id="id_do">
	<input type="hidden" value="<?= $no_retur; ?>" name="no_retur" id="no_retur">
	<input type="hidden" value="<?= $sp[0]->id_mitra; ?>" name="marketing" id="marketing">
	<input type="hidden" value="<?= $sp[0]->id_lembaga; ?>" name="lembaga" id="lembaga">
	<input type="hidden" value="<?= $sp[0]->id_pelanggan; ?>" name="pelanggan" id="pelanggan">
    <div class="row" style="margin-bottom: 0px;">
        <div class='col-sm-4' style="margin-bottom: 5px;">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
                    <div class="input-date" data-date-format="yyy-mm-dd">
                        <input type="text" id="tanggal_retur" name="tanggal_retur" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Retur" autocomplete="off" required>
                    </div>
                </div>
            </div>
        </div>
    </div>


	<!-- END Horizontal Form Content -->
	<!-- Products Content -->
    <div style="overflow: hidden; overflow-x: auto; ">
        <div class="table-responsive" style="margin-top:0px; width: 2600px; overflow: hidden">
			<table class="table table-bordered" id='example-datatable' style="width: auto;">
				<thead>
					<tr class="themed-background-amethyst text-light">
						<td class='text-center' style="width: 2%;">NO</td>
						<td style="width: 3%">KODE BARANG</td>
						<td style="width: 15%">NAMA BARANG</td>
						<td style="width: 5%">SUPPLIER</td>
						<td style="width: 5%">SPESIFIKASI</td>
						<td style="width: 3%">SATUAN</td>
						<td style="width: 5%" class='text-center'>QTY TERPACKING</td>
						<td style="width: 5%" class='text-center'>HARGA SATUAN (Rp.)</td>
						<td style="width: 5%" class='text-center'>JUMLAH HARGA</td>
						<td class='text-center' style="width: 5%">QTY RETUR</td>
					</tr>
				</thead>
				<tbody>

					<?php
                        $no = $jmlQty = $jmlGrandTotal = $jml_total= 0;
                        $ppn = $pph22 = $pph23 = 0;
                        $netto = $nettoBayar = $diskon = 0;
                        $i = 1;
                        $QpackingDetail = $this->db->get_where('packing_detail', array('id_packing_m' => $id_packing_m, 'qty_terpacking >' => 0))->result();
                        foreach ($QpackingDetail as $pd) {
							$harga_total = 0;

                            $pdid_barang = $pd->id_barang;
                            $pdbarang = $this->db->get_where('barang', array('id_barang' => $pd->id_barang))->result();
                            $qvendor = $this->db->get_where('vendor', array('id' => $pdbarang[0]->id_vendor))->result();
					?>
                            <tr>
                                <td class="text-center"><?= ++$no; ?></td>
                                <td>
									<input type="hidden" name="id_barang[<?= $i; ?>]" value="<?= $pdid_barang; ?>">
                                    <?= isset($pdbarang[0]->kode_barang) ? $pdbarang[0]->kode_barang : ''; ?>
                                </td>
                                <td><?= isset($pdbarang[0]->nama_barang) ? strtoupper($pdbarang[0]->nama_barang) : ''; ?></td>
                                <td>
                                    <?php echo isset($qvendor[0]->nama_vendor) ? $qvendor[0]->nama_vendor : ''; ?>
                                </td>
                                <td><?= $pdbarang[0]->spesifikasi; ?></td>
                                <td class="text-left"><?= $pdbarang[0]->satuan; ?></td>
                                <td class="text-center">
									<input type="hidden" id='qty_terpacking' name='qty_terpacking<?= $i; ?>' value='<?= $pd->qty_terpacking; ?>'>

									<span class="badge themed-border-blackberry themed-background-night" style="font-size: 1em; font-weight: bold;">
										<?= $pd->qty_terpacking; ?>
									</span>
								</td>
                                <td class="text-right">
									<?php
                                        // $sp = $this->db->get_where('pesanan_master', array('id_pesanan_m' => $id_pesanan))->result();
                                        $sp_detail = $this->db->get_where('pesanan_detail', array('id_pesanan_m' => $id_pesanan_m, 'id_barang'=>$pdid_barang))->result();
                                        $harga_satuan = (isset($sp_detail[0]->harga_satuan) ? $sp_detail[0]->harga_satuan : 0); 
                                        $total = (isset($sp_detail[0]->total) ? $sp_detail[0]->total : 0); 

                                        // $ppn += (isset($sp_detail[0]->ppn) ? $sp_detail[0]->ppn : 0);
                                        // $pph22 += (isset($sp_detail[0]->pph22) ? $sp_detail[0]->pph22 : 0);
                                        // $pph23 += (isset($sp_detail[0]->pph23) ? $sp_detail[0]->pph23 : 0);
                                        // $diskon += (isset($sp_detail[0]->diskon_nominal) ? $sp_detail[0]->diskon_nominal : 0);

                                        echo str_replace(',', '.', number_format($harga_satuan));
                                    ?>
									
								</td>
                                <td class="text-right">
                                    <?php 
                                        // echo str_replace(',', '.', number_format($total)); 
                                        $harga_total = ($pd->qty_terpacking * $harga_satuan);
                                        //$jmlGrandTotal +=$harga_total;
                                        echo str_replace(',', '.', number_format($harga_total)); 
                                        $jml_total += $harga_total;
                                    ?>
                                </td>
                                <td class="text-center">
									<input type='hidden' name='no_id' value="<?= $i; ?>">
									<input type='text' placeholder='0' value='0' class='form-control text-center' id='qty_retur' name='qty_retur<?= $i; ?>' onkeypress='return check_int(event)'>
								</td>
                            </tr>
                        <?php
                            //$jmlQty += $pd->qty_terpacking;
                            $i++;
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
		</div>
		<div class="col-sm-5">
			<input type='hidden' name='hitung_retur' id='hitung_retur' value=0>
			<div class="form-group" style="border-bottom:none; padding-bottom:0px">
				<label class="col-md-6 control-label" for="example-hf-email">
					JUMLAH QOLI
				</label>
				<div class="col-md-6">
					<input type="number" name="jumlah_qoli" id="jumlahQoli" class="form-control" placeholder='0'>
				</div>
			</div>

			<div class="form-group" style="border-bottom:none; padding-bottom:0px">
				<label class="col-md-6 control-label" for="example-hf-email">
					JUMLAH IKAT
				</label>
				<div class="col-md-6">
					<input type="number" name="jumlah_ikat" id="jumlahIkat" class="form-control" placeholder='0'>
				</div>
			</div>

			<div class="form-group" style="border-bottom:none;">
				<div class='col-sm-6'>
					<button type='reset' class='btn btn-warning btn-block' id='CetakStruks'>
						<i class='fa fa-refresh'></i> Batal
					</button>
				</div>
				<div class='col-sm-6'>
					<button type='submit' class='btn btn-primary btn-block simpan' id='Simpann'>
						<i class='fa fa-floppy-o'></i> Simpan (F10)
					</button>
				</div>
			</div>
		</div>
	</div>
    <?= form_close(); ?>

</div>
<!-- END All Orders Block -->
<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$('.simpan').attr('disabled', true);
		$('#hitung_retur').val(0);
		$("#example-datatable tbody tr").on('keyup', function() {
			//var huruf = $(this).find(":selected").val();
			let nomorId = $(this).find('[name="no_id"]').val();
			let qty_retur = $(this).find('[name="qty_retur' + nomorId + '"]').val();
			let qty_terpacking = $(this).find('[name="qty_terpacking' + nomorId + '"]').val();

			//let sisa = parseInt(qty) - parseInt(tersedia);
			if(qty_retur==''){
				$('.simpan').attr('disabled', true);
			}else{
				if (parseInt(qty_retur) > parseInt(qty_terpacking)) {
					alert('Retur Barang Tidak diperbolehkan melebihi QTY terpacking');
					$(this).find('[name="tersedia' + nomorId + '"]').focus;
					$('.simpan').attr('disabled', true);
				} else {					
					$('#hitung_retur').val(qty_retur);
					$('.simpan').attr('disabled', false);
				}
			}
		});
	});

	function check_int(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        return (charCode >= 48 && charCode <= 57 || charCode == 8);
    }

</script>
