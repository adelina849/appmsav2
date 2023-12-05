
<!-- Quick Stats -->
<div class="row text-center">
    <?php
        $allFaktur = $this->msa->_count('surat_jalan_detail');
        $fakturKembali = $this->msa->__count('surat_jalan_detail','status_kirim', 1);
        $fakturBelumKembali = $this->msa->__count('surat_jalan_detail','status_kirim', 0);
        $gagalKirim = $this->msa->__count('surat_jalan_detail','status_kirim', 2);
        ?>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background">
                <h4 class="widget-content-light"><i class="fa fa-file-text-o"></i> <strong>Total</strong> Faktur</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color animation-expandOpen"><?=$allFaktur;?></span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-spring">
                <h4 class="widget-content-light"><i class="fa fa-check-circle-o"></i> Faktur Kembali</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-spring animation-expandOpen"><?=$fakturKembali;?></span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-autumn">
                <h4 class="widget-content-light"><i class="fa fa-exclamation-triangle"></i> Faktur Belum Kembali</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-autumn animation-expandOpen"><?=$fakturBelumKembali;?></span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-night">
                <h4 class="widget-content-light"><i class="fa fa-times-circle"></i> Gagal Kirim</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-night animation-expandOpen"><?=$gagalKirim;?></span></div>
        </a>
    </div>
</div>
<!-- END Quick Stats -->

<div class="block full">
    <!-- All Orders Title -->
    <div class="block-title">
        <div class="block-options pull-right" style="margin-right: 15px;">
        </div>
        <h2><i class="fa fa-retweet"></i> <strong><?= $title; ?></strong></h2>
    </div>

    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">

            <div class="table-responsive">
                <table id="example-datatable" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr class="themed-color themed-background" style="font-weight: bold;">
                            <td class="text-center text-light" style="width: 3%;">NO</td>
                            <td class="text-light" style="width: 10%;">NO. DO</td>
                            <td class="text-light" style="width: 15%;">NO. SURAT JALAN</td>
                            <td class="text-light" style="width: 30%;">NAMA LEMBAGA</td>
                            <td class="text-light text-center no-sort" style="width: 5%;">JUMLAH QOLI</td>
                            <td class="text-light text-center no-sort" style="width: 5%;">JUMLAH IKAT</td>
                            <td class="text-light text-center" style="width: 10%;">LHFBD</td>
                            <td class="text-light text-center" style="width: 15%;">STATUS KIRIM</td>
                            <td class="text-light text-center no-sort" style="width: 15%;"><i class="fa fa-cog"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //$q = $this->db->get_where('surat_jalan_detail', array('status_kirim' => 0));

                            $s = "SELECT 
                                    surat_jalan_detail.id AS id_detail, surat_jalan_detail.surat_jalan_id, 
                                    surat_jalan_detail.nomor_do, surat_jalan_detail.id_lembaga, surat_jalan_detail.status_kirim,
                                    surat_jalan_master.nomor AS nomor_surat_jalan,
                                    surat_jalan_detail.date_status AS date_status
                                FROM surat_jalan_detail, surat_jalan_master
                                WHERE surat_jalan_detail.surat_jalan_id=surat_jalan_master.id
                                ORDER BY surat_jalan_master.tanggal DESC";
        
                            $q = $this->db->query($s);                            
                            $no = 0;
                            foreach($q->result() as $d)
                            {
                                $id_lembaga = $d->id_lembaga;
                                $qLembaga = $this->db->get_where('lembaga', array('id' => $id_lembaga))->result();
                                $nama_lembaga = strtoupper(isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-');

                                $qDo = $this->db->get_where('packing_do', array('nomor_do' => $d->nomor_do))->result();
                                $qoli = (isset($qDo[0]->jumlah_qoli) ? $qDo[0]->jumlah_qoli : '-');
                                $ikat = (isset($qDo[0]->jumlah_ikat) ? $qDo[0]->jumlah_ikat : '-');
                                $tanggal_do = (isset($qDo[0]->tanggal) ? $qDo[0]->tanggal : 'null');
                                //$sj = $this->db->get_where('surat_jalan_master', array('id' => $d->surat_jalan_id))->result();
                                //$Qtanggal_do =$this->db->get_where('packing_do', array('nomor_do' => $nomor_do))->result();

                            ?>
                                <tr>
                                    <td class="text-center"><?=++$no;?></td>
                                    <td><?=$d->nomor_do;?></td>
                                    <td><?=$d->nomor_surat_jalan;?></td>
                                    <td><?=$nama_lembaga;?></td>
                                    <td class="text-center"><?=$qoli;?></td>
                                    <td class="text-center"><?=$ikat;?></td>
                                    <td class="text-center">
                                        <?php
                                            // $awal  = date_create($d->date_status);
                                            // $akhir = date_create(); // waktu sekarang
                                            // $diff  = date_diff($awal, $akhir);
                                            // $tahun = $diff->y;
                                            // $bulan = $diff->m;
                                            // $hari = $diff->days;
                                            // echo $hari.' ';
                                            if($d->status_kirim == 1 and $d->date_status != null){
                                                // $now = time(); // or your date as well
                                                $date_status = strtotime($d->date_status); // or your date as well
                                                $date_do = strtotime($tanggal_do);
                                                $datediff = $date_status - $date_do;
                                                
                                                echo round($datediff / (60 * 60 * 24)).' Hari';          
                                                    
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                            #status DO: 0 = BELUM KEMBALI
                                            # 1 = KEMBALI
                                            # 2 = GAGAL KIRIM
                                            $status = $bg = '';
                                            if($d->status_kirim == 1){
                                                $status = 'Kembali';
                                                $bg = 'themed-background-spring';

                                            }else if($d->status_kirim==2){
                                                $status = 'Gagal Kirim';
                                                $bg = 'themed-background-autumn';
                                            }else{
                                                $status = 'Belum Kembali';  
                                                $bg = 'themed-background-night';
                                            }
                                            echo '<div class="text-center"><span class="badge '.$bg.'">' . $status . '</span></div>';
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-xs">
                                            <a href="#"
                                                data_id_detail="<?= $d->id_detail; ?>" data-toggle="tooltip" title="Ubah Status Penerimaan Faktur" class="btn btn-alt btn-primary btn-xs status" onclick="$('#FormStatus').modal('show');">
                                                <i class="fa fa-retweet"></i> Status Kirim
                                            </a>
                                        </div>                                           
                                    </td>
                                </tr>
                            <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END row -->
    <!-- END block-->
</div>

<!--STATUS  -->
<div id="FormStatus" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h2 class="modal-title text-center"><i class="fa fa-retweet"></i> STATUS PENGIRIMAN</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_status, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_delete')); ?>
				<input type="hidden" name="id_detail" class="id_detail">
				<fieldset>
					<div class="form-group" style="margin:0 20px 0 20px">
						<div class="alert alert-info alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="fa fa-info-circle"></i> Info!</h4>
							Anda akan merubah status penerimaan DO
						</div>
					</div>

                    <div class="form-group">
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon text-primary"><i class="fa fa-retweet"></i></span>
                                <select id="id_status" name="id_status" class="select-select2" style="width:100%;" required>
                                    <option value="">-- Pilih Status Pengiriman --</option>                              
                                    <option data-description="" value="1">Kembali</option>
                                    <option data-description="" value="2">Gagal Kirim</option>
                                    <option data-description="" value="0">Belum Kembali</option>
                                </select>                    
                            </div>
                        </div>
                    </div>

				</fieldset>
				<div class="form-group form-actions">
					<div class="col-xs-12 text-center">
						<button type="reset" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-sm btn-primary">Ubah Status</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
<!-- END STATUS -->
<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script>
    $(".status").on('click', function() {
		id_detail = $(this).attr("data_id_detail");
		$(".id_detail").val(id_detail);
	});
</script>