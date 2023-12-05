
<!-- Quick Stats -->
<div class="row text-center">
    <div class="col-sm-6 col-lg-4">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background">
                <h4 class="widget-content-light"><i class="fa fa-external-link"></i> <strong>Total</strong> Surat Jalan</h4>
            </div>
            <?php

                $allFaktur_do = $this->msa->_count('surat_jalan_detail');
                $sql_sj = "SELECT count(DISTINCT surat_jalan_id) as total_surat_jalan
                    FROM surat_jalan_detail";

                $q_sj = $this->db->query($sql_sj)->row();    
                $x = "SELECT 
                            sj.nomor_do,
                            a.nomor_do,
                            b.id_packing_m,
                            c.id_pesanan_m, c.grand_total
                        FROM 
                            surat_jalan_detail AS sj
                        INNER JOIN packing_do AS a
                        ON sj.nomor_do=a.nomor_do
                        INNER JOIN packing_master AS b
                        ON a.id_packing_m=b.id_packing_m
                        INNER JOIN pesanan_master AS c
                        ON b.id_pesanan_m = c.id_pesanan_m
                        ORDER BY a.nomor_do DESC";

                $z = $this->db->query($x);
                $total_sp = 0;
                $total_do = 0;
                $total_nomor_do=0;
                $nilai_do = 0;

                foreach($z->result() as $dt) {
                    $total_sp+=$dt->grand_total;
                    $total_nomor_do+=1;

                    //HITUNG NILAI FAKTUR DO
                    $QpackingDetail = $this->db->get_where('packing_detail', array('id_packing_m' => $dt->id_packing_m, 'qty_terpacking >' => 0))->result();
                    foreach ($QpackingDetail as $pd) {
                        $harga_total = 0;
                    // $jmlQty = 0;
                        $pdid_barang = $pd->id_barang;
                        //$pdbarang = $this->db->get_where('barang', array('id_barang' => $pd->id_barang))->result();
                        $sp_detail = $this->db->get_where('pesanan_detail', array('id_pesanan_m' => $dt->id_pesanan_m, 'id_barang'=>$pdid_barang))->result();
                        $harga_satuan = (isset($sp_detail[0]->harga_satuan) ? $sp_detail[0]->harga_satuan : 0); 
                        $harga_total = ($pd->qty_terpacking * $harga_satuan);
                        $nilai_do += $harga_total;
                    }

                }

            ?>

            <div class="widget-extra-full"><span class="h2 themed-color-spring animation-expandOpen"><?=$q_sj->total_surat_jalan;?></span></div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-4">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background-spring">
                <h4 class="widget-content-light"><i class="fa fa-truck"></i> <strong> Total</strong> DO</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen"><?= $allFaktur_do ;?></span></div>
        </a>
    </div>

    <div class="col-sm-6 col-lg-4">
        <a href="javascript:void(0)" class="widget widget-hover-effect2">
            <div class="widget-extra themed-background">
                <h4 class="widget-content-light"><i class="fa fa-money"></i> <strong>Total</strong> Rupiah</h4>
            </div>
            <div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen"><?= 'Rp. '.str_replace(',', '.', number_format($nilai_do)) ;?></span></div>
        </a>
    </div>
</div>
<!-- END Quick Stats -->


<div class="block full">
    <!-- All Orders Title -->
    <div class="block-title">
        <div class="block-options pull-right" style="margin-right: 15px;">
        </div>
        <h2><i class="fa fa-check-circle-o"></i> <strong><?= $title; ?></strong></h2>
    </div>

    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">

            <div class="table-responsive">
                <table id="example-datatable" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr class="themed-color themed-background-spring" style="font-weight: bold;">
                            <td class="text-center text-light" style="width: 3%;">NO</td>
                            <td class="text-light" style="width: 10%;">NO. DO</td>
                            <td class="text-light" style="width: 15%;">NO. SURAT JALAN</td>
                            <td class="text-light" style="width: 30%;">NAMA LEMBAGA</td>
                            <td class="text-light text-center" style="width: 10%;">LHFD</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //$q = $this->db->get_where('surat_jalan_detail', array('status_kirim' => 0));

                            $s = "SELECT 
                                    surat_jalan_detail.id AS id_detail, surat_jalan_detail.surat_jalan_id, 
                                    surat_jalan_detail.nomor_do, surat_jalan_detail.id_lembaga, surat_jalan_detail.status_kirim,
                                    surat_jalan_master.nomor AS nomor_surat_jalan,
                                    surat_jalan_master.tanggal AS tanggal
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

                                // $qDo = $this->db->get_where('packing_do', array('nomor_do' => $d->nomor_do))->result();
                                // $qoli = (isset($qDo[0]->jumlah_qoli) ? $qDo[0]->jumlah_qoli : '-');
                                // $ikat = (isset($qDo[0]->jumlah_ikat) ? $qDo[0]->jumlah_ikat : '-');
                                //$sj = $this->db->get_where('surat_jalan_master', array('id' => $d->surat_jalan_id))->result();


                            ?>
                                <tr>
                                    <td class="text-center"><?=++$no;?></td>
                                    <td><?=$d->nomor_do;?></td>
                                    <td><?=$d->nomor_surat_jalan;?></td>
                                    <td><?=$nama_lembaga;?></td>
                                    <td class="text-center">
                                        <?php
                                            $awal  = date_create($d->tanggal);
                                            $akhir = date_create(); // waktu sekarang
                                            $diff  = date_diff($awal, $akhir);
                                            $tahun = $diff->y;
                                            $bulan = $diff->m;
                                            $hari = $diff->days;

                                            echo $hari.' Hari';
                                        ?>
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

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script></script>