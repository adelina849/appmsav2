<html>
    <head>
        <title>Print DO</title>
        <style>
            /* style sheet for "A4" printing 
            @media print and (width: 21cm) and (height: 29.7cm) {
                @page {
                    margin: 3cm;
                }
            }

            /* style sheet for "letter" printing 
            @media print and (width: 8.5in) and (height: 11in) {
                @page {
                    margin: 1in;
                }
            }

            /* A4 Landscape
            @page {
                size: A4 landscape;
                margin: 10%;
            }
            */


            /* style sheet for "A4" printing */
            @media print {
                @page {
                    size: auto;
                    margin: 2cm 0.5cm;
                }

                /* in case @page {margin: 5cm 0 5cm 0;} doesn't work */
                
                body * {
                    visibility: hidden;
                    /* padding-top: 5cm !important;
                    padding-bottom: 5cm !important;               */
                    font-size: 10px;
                }
                .no-print{
                    display: none;
                }
                .section-to-print, .section-to-print * {
                    visibility: visible;
                }
                .section-to-print {
                    position: absolute;
                    left: 30px;
                    right: 30px;
                    top: 20px;
                }  
                table tr{
                    line-height: 10px;
                } 
                table tr .detail{
                    border: solid 1px #ccc;
                }
                .head tr{
                    border: solid 1px #red;
                    line-height: 15px;
                }                
            }
        </style>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/ico.png">
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/proui/img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/proui/img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/proui/img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/proui/img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/proui/img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/proui/img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/proui/img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="<?php echo base_url(); ?>assets/proui/img/icon180.png" sizes="180x180">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/proui/css/bootstrap.min.css">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/proui/css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/proui/css/main.css">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/proui/css/themes.css">
        <!-- END Stylesheets -->

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/sweetalert2/sweetalert2.min.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/gaya.css">

        <!-- Modernizr (browser feature detection library) -->
        <script src="<?php echo base_url(); ?>assets/proui/js/vendor/modernizr.min.js"></script>
    </head>
    <body class="section-to-print">
        <h4 class="text-center">
            <strong>
                <?php
                    echo $title.'<br />';
                    $do = $this->db->get_where('packing_do', array('id' => $id_packing_do))->result();
                    $nomor_do = $do[0]->nomor_do;
                    $tanggal_do = $do[0]->tanggal;
                    $nomor_faktur = '';
                    if(isset($do[0]->nomor_do)){
                        $nomor_faktur = '';
                        $prefix = 'DO';
                        $str = $do[0]->nomor_do;
                        if(substr($str, 0, strlen($prefix))==$prefix){
                            $str = substr($str, strlen($prefix));
                            $nomor_faktur = 'FKT'.$str;
                        }
                    }
                    echo 'Nomor : '.$nomor_faktur;
                ?>
            </strong>
            <br />
        </h4>

        <div class="row">
            
            <table style="margin: 20px 0px 20px 20px;" class="head">
                <?php
                    $sp = $this->db->get_where('pesanan_master', array('id_pesanan_m' => $id_pesanan))->result();
                    $lembaga = $this->db->get_where('lembaga', array('id' => $sp[0]->id_lembaga))->result();
                    $pelanggan = $this->db->get_where('pelanggan', array('id' => $sp[0]->id_pelanggan))->result();
                    $packing = $this->db->get_where('packing_master', array('id_packing_m' => $id_packing_m))->result();
                    $marketing = $this->db->get_where('marketing', array('id' => $sp[0]->id_mitra))->result();
                    $sumber_dana = $this->db->get_where('sumber_dana', array('id' => $sp[0]->idsumber_dana))->result();
                ?>
                <tr>
                    <td width="50%"><strong>Dari: </strong></td>
                    <td width="50%"><strong>Kepada: </strong></td>
                </tr>

                <tr>
                    <td width="50%" valign="top">
                        CV. Mega Setia Abadi,<br />
                        JL. Cangklek No. 61 RT. 004 RW. 01 Ds. Sukamanah<br />
                        Kec. Cugenang Kab. Cianjur Jawa Barat<br />
                        NPWP 3212356361406000 Kontak 0877 2001 8514 
                    </td>
                    <td width="50%">
                        <?= (isset($lembaga[0]->nama_lembaga) ? $lembaga[0]->nama_lembaga : ''); ?> 
                        <br />
                        <?= (isset($lembaga[0]->alamat) ? $lembaga[0]->alamat : ''); ?>
                        <br>
                        Kontak <?= (isset($pelanggan[0]->kontak) ? $pelanggan[0]->kontak : ''); ?>                        
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td width="50%">
                        Nama Marketing : <?= (isset($marketing[0]->nama_lengkap) ? $marketing[0]->nama_lengkap : ''); ?>
                        <br />
                        Kode Marketing : <?= (isset($marketing[0]->nomor_id) ? $marketing[0]->nomor_id : ''); ?>
                        <br />
                        Jabatan : 
                        <?php
                            $jabatan = $this->db->get_where('jabatan', array('id' => $marketing[0]->jabatan))->result();
                            echo (isset($jabatan[0]->nama_jabatan) ? $jabatan[0]->nama_jabatan : '')
                        ?>
                    </td>
                    <td width="50%">
                        Nama Pelanggan : <?= (isset($pelanggan[0]->nama_pelanggan) ? $pelanggan[0]->nama_pelanggan : ''); ?>
                        <br />
                        Kode Pelanggan :  <?= (isset($pelanggan[0]->kode) ? $pelanggan[0]->kode : ''); ?>
                        <br>
                        Jabatan :  <?= (isset($pelanggan[0]->jabatan) ? $pelanggan[0]->jabatan : ''); ?>                       
                    </td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td width="50%">TANGGAL DO</td>
                                <td>: <?= $this->tanggal->konversi($tanggal_do); ?></td>
                            </tr>
                            <tr>
                                <td width="50%">TANGGAL SP</td>
                                <td>: <?= $this->tanggal->konversi($sp[0]->tanggal_sp); ?></td>
                            </tr>
                            <tr>
                                <td width="50%">NOMOR SP</td>
                                <td>: <?= $sp[0]->nomor_sp; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">JENIS SP</td>
                                <td>: <?= strtoupper($sp[0]->jenis_sp); ?></td>
                            </tr>
                            <tr>
                                <td width="50%">SISTEM TRANSAKSI</td>
                                <td>: <?= strtoupper($sp[0]->sistem_transaksi); ?></td>
                            </tr>
                            <tr>
                                <td width="50%">NOMOR DO</td>
                                <td>: <?= $nomor_do; ?></td>
                            </tr>

                        </table>
                    </td>
                    <td>
                        <table width="100%">
                            <tr>
                                <td width="50%">SISTEM PEMBAYARAN</td>
                                <td>: <?= strtoupper($sp[0]->sistem_pembayaran); ?></td>
                            </tr>
                            <tr>
                                <td width="50%">TANGGAL JATUH TEMPO</td>
                                <td>: <?= (isset($sp[0]->jatuh_tempo) ? $this->tanggal->konversi($sp[0]->jatuh_tempo) : ''); ?></td>
                            </tr>
                            <tr>
                                <td width="50%">TAHUN ANGGARAN</td>
                                <td>: <?= $sp[0]->tahun_anggaran; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">TAHAP ANGGARAN</td>
                                <td>: <?= $sp[0]->tahap_anggaran; ?></td>
                            </tr>
                            <tr>
                                <td width="50%">SUMBER DANA</td>
                                <td>: <?= isset($sumber_dana[0]->sumber_dana) ? $sumber_dana[0]->sumber_dana : ''; ?></td>
                            </tr>

                        </table>

                    </td>
                </tr>

            </table>

            <div class='col-lg-12' style="margin: 20px 0px;">
                <table id="" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr style="font-weight: bold;" class="themed-border themed-background-spring text-light">
                            <td class="text-center" style="width: 2%;">NO</td>
                            <td style="width: 10%;">KODE</td>
                            <td style="width: 25%;">NAMA BARANG</td>
                            <td style="width: 15%;">SPESIFIKASI</td>
                            <td style="width: 5%;">SATUAN</td>
                            <td style="width: 10%;" class="text-center">HARGA SATUAN (Rp.)</td>
                            <td style="width: 5%;" class="text-center">QTY </td>
                            <td style="width: 15%;" class="text-center">JUMLAH (Rp.)</td>
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
                           // $jmlQty = 0;
                            $pdid_barang = $pd->id_barang;
                            $pdbarang = $this->db->get_where('barang', array('id_barang' => $pd->id_barang))->result();
                            $qvendor = $this->db->get_where('vendor', array('id' => $pdbarang[0]->id_vendor))->result();

                        ?>
                            <tr>
                                <td class="text-center"><?= ++$no; ?></td>
                                <td>
                                    <?= isset($pdbarang[0]->kode_barang) ? $pdbarang[0]->kode_barang : ''; ?>
                                </td>
                                <td><?= isset($pdbarang[0]->nama_barang) ? strtoupper($pdbarang[0]->nama_barang) : ''; ?></td>
                                <td><?= $pdbarang[0]->spesifikasi; ?></td>
                                <td><?= $pdbarang[0]->satuan; ?></td>
                                <td class="text-right">
                                    <?php
                                        // $sp = $this->db->get_where('pesanan_master', array('id_pesanan_m' => $id_pesanan))->result();
                                        $sp_detail = $this->db->get_where('pesanan_detail', array('id_pesanan_m' => $id_pesanan, 'id_barang'=>$pdid_barang))->result();
                                        $harga_satuan = (isset($sp_detail[0]->harga_satuan) ? $sp_detail[0]->harga_satuan : 0); 
                                        $total = (isset($sp_detail[0]->total) ? $sp_detail[0]->total : 0); 

                                        $ppn += (isset($sp_detail[0]->ppn) ? $sp_detail[0]->ppn : 0);
                                        $pph22 += (isset($sp_detail[0]->pph22) ? $sp_detail[0]->pph22 : 0);
                                        $pph23 += (isset($sp_detail[0]->pph23) ? $sp_detail[0]->pph23 : 0);
                                        $diskon += (isset($sp_detail[0]->diskon_nominal) ? $sp_detail[0]->diskon_nominal : 0);

                                        echo str_replace(',', '.', number_format($harga_satuan));
                                    ?>
                                </td>
                                <td class="text-center"><?= $pd->qty_terpacking; ?></td>
                                <td class="text-right">
                                    <?php 
                                        // echo str_replace(',', '.', number_format($total)); 
                                        $harga_total = ($pd->qty_terpacking * $harga_satuan);
                                        //$jmlGrandTotal +=$harga_total;
                                        echo str_replace(',', '.', number_format($harga_total)); 
                                        $jml_total += $harga_total;
                                    ?>
                                </td>
                            </tr>
                        <?php
                            //$jmlQty += $pd->qty_terpacking;
                            $i++;
                        }
                        $netto = ($jml_total + $ppn + $pph22 + $pph23);
                        $nettoBayar = $netto - $diskon;
                        ?>
                        <tr style="font-weight: bold;">
                            <td colspan="4" rowspan="9" style="border-left: none;"></td>
                            <td colspan="3" class="text-right">TOTAL</td>
                            <td class="text-right"><?=str_replace(',', '.', number_format($jml_total));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">PPN 11%</td>
                            <td class="text-right"><?=str_replace(',', '.', number_format($ppn));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">PPH 22</td>
                            <td class="text-right"><?=str_replace(',', '.', number_format($pph22));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">PPH 23</td>
                            <td  class="text-right"><?=str_replace(',', '.', number_format($pph23));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">NETTO</td>
                            <td class="text-right"><?=str_replace(',', '.', number_format($netto));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">DISKON</td>
                            <td class="text-right"><?=str_replace(',', '.', number_format($diskon));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">NETTO BAYAR</td>
                            <td class="text-right"><?=str_replace(',', '.', number_format($nettoBayar));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">UANG MUKA</td>
                            <td class="text-right"><?='';//str_replace(',', '.', number_format($sp[0]->uang_muka));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">SISA PEMBAYARAN</td>
                            <td class="text-right"><?='';//str_replace(',', '.', number_format($sp[0]->sisa_bayar));?></td>
                        </tr>
                    </tbody>
                </table>                
            </div> <!-- END col-lg-12 -->
        </div>
        <!-- END row -->

        <div class="row" style="bottom: 100px; left: 30px; width: 100%;">
            <div class='col-lg-12'>
                <table style="margin: 0px 0px 20px 20px;">
                    <tr>
                        <td width="100%">
                            <?php
                                //$tanggal = date('Y-m-d');
                                echo $this->tanggal->konversi($tanggal_do).'<br />';
                                echo 'CV. Mega Setia Abadi';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td height="60"></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>
                            Dani Hermawan, S.Pd <br />
                            Direktur
                            </strong>
                        </td>
                    </tr>
                </table>
            </div>                
        </div>

        <script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
        <script>
        $(document).ready(function () {
            window.print();
        });
        </script>        
    </body>
</html>