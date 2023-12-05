<html>
    <head>
        <title>Print Surat Penerimaan</title>
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
                    echo 'Nomor Penerimaan: ' .$penerimaan_master[0]->nomor_penerimaan;
                ?>
            </strong>
            <br />
        </h4>

        <div class="row">

            <table style="margin: 20px 0px 20px 20px;" width="100%" class="head">
                <tr>
                    <td width="20%">Nomo Invoice</td>
                    <td>: <?=$penerimaan_master[0]->nomor_invoice;?></td>
                </tr>
                <tr>
                    <td width="20%">Nama Pengirim</td>
                    <td>: <?=$penerimaan_master[0]->pengirim;?></td>
                </tr>
            </table>


            <div class='col-lg-12' style="margin: 20px 0px;">
                <table id="" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr class="themed-background-blackberry text-light" style="font-weight: bold">
                            <td class='text-center' style="width: 2%;">NO</td>
                            <td style="width: 5%">KODE BARANG</td>
                            <td style="width: 15%">NAMA BARANG</td>
                            <td class='text-center' style="width: 10%">SPESIFIKASI</td>
                            <td class='text-center' style="width: 5%">SATUAN</td>
                            <td class='text-center' style="width: 5%">HARGA</td>
                            <td class='text-center' style="width: 5%">Qty</td>
                            <td class='text-center'>JUMLAH</td>
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
                        <tr style="font-weight: bold;">
                            <td colspan="7" rowspan="9" style="border-left: none;"></td>
                            <td colspan="3" class="text-right">TOTAL HARGA BARANG</td>
                            <td colspan="2" class="text-right"><?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->grand_total));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">PPN PEMBELIAN</td>
                            <td colspan="2" class="text-right"><?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->ppn));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">NETTO</td>
                            <td colspan="2" class="text-right"><?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->diskon));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">DISKON PEMBELIAN</td>
                            <td colspan="2" class="text-right"><?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->diskon));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">NETTO BAYAR</td>
                            <td colspan="2" class="text-right"><?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->netto_bayar));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">UANG MUKA</td>
                            <td colspan="2" class="text-right"><?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->uang_muka));?></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="3" class="text-right">SISA PEMBAYARAN</td>
                            <td colspan="2" class="text-right"><?=str_replace(',', '.', 'Rp. '.number_format($penerimaan_master[0]->sisa_bayar));?></td>
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
                                //echo $this->tanggal->konversi($tanggal_do).'<br />';
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