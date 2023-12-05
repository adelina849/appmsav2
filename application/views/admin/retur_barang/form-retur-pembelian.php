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
			<a href="<?= site_url('admin/retur_barang/retur_pembelian'); ?>" class="" data-toggle="tooltip" title="Daftar Barang">
				<i class="fa fa-list-alt"></i> Daftar Retur Pembelian
			</a>
		</div>
		<input type="hidden" value="<?= $no_retur ?>" name="no_retur" id="no_retur">
		<input type="hidden" value="<?= $penerimaan_master[0]->id_pembelian_m ?>" name="id_pembelian" id="id_pembelian">
		<input type="hidden" value="<?= $penerimaan_master[0]->id_penerimaan_m ?>" name="id_penerimaan" id="id_penerimaan">
	</div>
	<!-- END All Orders Title -->


    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
            <h4><i class='fa fa-info-circle fa-fw animation-pulse'></i> Form Retur Barang Berdasarkan Penerimaan Barang </h4>
            <br />
            <div class="table-responsive">
                <table id="do" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <tbody>
                        <?php
							$spb = $this->db->get_where('pembelian_master', array('id_pembelian_m' => $penerimaan_master[0]->id_pembelian_m))->result();

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
                            <td width="25%">NOMOR PEMBELIAN</td>
                            <td width="2px">:</td>
                            <td><?=$spb[0]->nomor_spb;?></td>
                        </tr>
                        <tr>
                            <td width="25%">NOMOR PENERIMAAN</td>
                            <td width="2px">:</td>
                            <td><?=$penerimaan_master[0]->nomor_penerimaan;?></td>
                        </tr>
                        <tr>
                            <td width="25%">TANGGAL PENERIMAAN</td>
                            <td width="2px">:</td>
                            <td><?=$this->tanggal->konversi($penerimaan_master[0]->tanggal);?></td>
                        </tr>
                        <tr>
                            <td width="25%">NAMA MARKETING</td>
                            <td width="2px">:</td>
                            <td>
								<?=(isset($marketing[0]->nama_lengkap) ? $marketing[0]->nama_lengkap : '-');?>
								<input type="hidden" value="<?= $spb[0]->id_marketing; ?>" name="id_marketing" id="id_marketing">
							</td>
                        </tr>
                        <tr>
                            <td width="25%">SUPPLIER</td>
                            <td width="2px">:</td>
                            <td>
								<?=strtoupper(isset($supplier[0]->nama_vendor) ? $supplier[0]->nama_vendor : '-');?>
								<input type="hidden" value="<?= $spb[0]->id_supplier; ?>" name="id_supplier" id="id_supplier">
							
							</td>
                        </tr>
                        <tr>
                            <td width="25%">JENIS SPB</td>
                            <td width="2px">:</td>
                            <td>
								<?=$jenis_pembelian;?>
								<input type="hidden" value="<?= $jenis_pembelian; ?>" name="jenis_pembelian" id="jenis_pembelian">							
							</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>    

	<form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">
		<div class="form-group">
			<div class="col-md-4">
			<label for="marketing"><i class="fa fa-calendar"></i> Tanggal Retur</label>
				<div class="input-date" data-date-format="yyy-mm-dd">
				<input type="text" id="tanggal" name="tanggal" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" autocomplete="off">
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6">
				<label for="marketing"><i class="fa fa-pencil"></i> Keterangan</label>
				<input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Alasan Retur Pembelian" autocomplete="off">
			</div>
		</div>
	</form>

	<!-- END Horizontal Form Content -->
	<!-- Products Content -->
    <div style="overflow: hidden; overflow-x: auto; ">
		<div class="table-responsive" style="margin-top:15px; width: 2600px;">
			<table class="table table-bordered" id='TabelTransaksi' style="width: auto;">
				<thead>
					<tr class="themed-background text-light">
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
						<td class='text-center' style="width: 3%">JUMLAH RETUR</td>
                        <td class='text-center' style="width: 5%">JUMLAH HARGA (Rp.)</td>
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
                                <td class="text-right success">
									<?=str_replace(',', '.', number_format($d->harga_satuan));?>
									<input type="hidden" id='harga_satuan' name="harga_satuan[]" value="<?=$d->harga_satuan;?>">
								</td>                                
                                <td class="text-center success"><?=$d->jumlah_beli;?></td>
                                <td class="text-right success"><?=str_replace(',', '.', number_format($d->total));?></td>                                
                                <td class="text-right success">
                                    <?=str_replace(',', '.', number_format($d->ppn));?>
                                </td>                                
                                <td class="text-right success"><?=str_replace(',', '.', number_format($d->harga_pajak));?></td>              
                                <td class="text-right success"><?=str_replace(',', '.', number_format($d->diskon));?></td>              
                                <td class="text-right success"><?=str_replace(',', '.', number_format($d->harga_diskon));?></td> 
                                <td>
                                    <input type='text' placeholder='0' class='form-control text-center' id='jumlah_retur' name='jumlah_retur[]' onkeypress='return check_int(event)'>                                
                                </td>
                                <td>
                                    <input type='hidden' placeholder='0' class='form-control text-center' id='harga_retur' name='harga_retur[]'>   
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
			<div class="col-md-5">
				
			</div>
		</div>
		<div class="col-sm-5">
			<form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">

				<div class="form-group" style="border-bottom:none; padding-bottom:0px">
                    <label class="col-md-6 control-label" for="example-hf-email">
                        TOTAL HARGA 
                    </label>
                    <div class="col-md-6">
                        <input type="text" id="TotalBayar" class="form-control" placeholder='0' disabled>
                        <input type="hidden" id="TotalBayarHidden" name="TotalBayarHidden">
                    </div>
                </div>			
				<div class="form-group" style="border-bottom:none; padding-bottom:0px">
					<label class="col-md-6 control-label" for="example-hf-email">
						JUMLAH QOLI
					</label>
					<div class="col-md-6">
						<input type="number" id="jumlahQoli" class="form-control" placeholder='0'>
					</div>
				</div>

				<div class="form-group" style="border-bottom:none; padding-bottom:0px">
					<label class="col-md-6 control-label" for="example-hf-email">
						JUMLAH IKAT
					</label>
					<div class="col-md-6">
						<input type="number" id="jumlahIkat" class="form-control" placeholder='0'>
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


    //HITUNG SUB TOTAL + CEK STOK BARANG
    $(document).on('keyup', '#jumlah_retur', function() {
        var Indexnya = $(this).parent().parent().index();
        var IndexChexbox = $(this).parent().parent().parent().parent().index();

        var Harga = $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').val();
        var JumlahRetur = $(this).val();

        var SubTotal = parseInt(Harga) * parseInt(JumlahRetur);
        if (SubTotal > 0) {
            var SubTotalVal = SubTotal;
            SubTotal = to_rupiah(SubTotal);
        } else {
            SubTotal = '';
            var SubTotalVal = 0;
        }
        //$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(8) input').val(0);// kalo qty dirubah, set diskon =0
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(14) input').val(SubTotalVal);
        $('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(14) span').html(SubTotal);

        HitungTotalBayar();
    });
	//TOTAL HARGA RETUR
    $(document).on('keydown', '#jumlah_retur', function(e) {
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



    //HITUNG TOTAL BAYAR
    function HitungTotalBayar() {
        var Total = 0;
        var TotalPpn11 = 0;
        var TotalBayar = 0;
        var TotalNetto = 0;
        var TotalDiskon=0;
        var NettoBayar=0;
        $('#TabelTransaksi tbody tr').each(function() {
            if ($(this).find('td:nth-child(13) input').val() > 0) {
                var SubTotal = $(this).find('td:nth-child(14) input').val();
                Total = parseInt(Total) + parseInt(SubTotal);
            }
        });
        //TotalBayar
        $('#TotalBayar').val(to_rupiah(Total));
        $('#TotalBayarHidden').val(Total);

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

	$(document).on('click', 'button#CetakStruk', function() {
		SimpanTransaksi();
	});

	function SimpanTransaksi() {
		var no_urut = $("#no_retur").val();

		var FormData = "tanggal=" + $('#tanggal').val();
		FormData += "&no_retur=" + $('#no_retur').val();
		FormData += "&id_pembelian=" + $('#id_pembelian').val();
		FormData += "&id_penerimaan=" + $('#id_penerimaan').val();
		FormData += "&id_marketing=" + $('#id_marketing').val();
		FormData += "&id_supplier=" + $('#id_supplier').val();
		FormData += "&jenis_pembelian=" + $('#jenis_pembelian').val();
		FormData += "&keterangan=" + $('#keterangan').val();
        FormData += "&TotalBayarHidden=" + $('#TotalBayarHidden').val();
		FormData += "&jumlah_qoli=" + $('#jumlahQoli').val();
		FormData += "&jumlah_ikat=" + $('#jumlahIkat').val();
		FormData += "&" + $('#TabelTransaksi tbody input').serialize();

		$.ajax({
			url: "<?php echo site_url('admin/retur_barang/form_retur_pembelian/'.$id_penerimaan_m.'/barang'); ?>",
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
</script>