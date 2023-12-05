<html>
    <head>
        <title>Print Form Packing Barang</title>
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
                    line-height: 20px;
                }
                table tr .detail{
                    border: solid 1px #ccc;
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

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/gaya.css">
        <!-- Modernizr (browser feature detection library) -->
        <script src="<?php echo base_url(); ?>assets/proui/js/vendor/modernizr.min.js"></script>

    </head>
    <body class="section-to-print">
        <h1 class="text-center">
            <strong><?=$title;?></strong>
        </h1>

        <div class="row">            
            <table style="margin: 20px 20px 20px 20px;" width="100%">
                <?php
                    $sp = $this->db->get_where('pesanan_master', array('id_pesanan_m' => $id_pesanan))->result();
                    $lembaga = $this->db->get_where('lembaga', array('id' => $sp[0]->id_lembaga))->result();
                    $pelanggan = $this->db->get_where('pelanggan', array('id' => $sp[0]->id_pelanggan))->result();
                    $packing = $this->db->get_where('packing_master', array('id_packing_m' => $id_packing_m))->result();
                    $mitra = $this->db->get_where('mitra', array('id' => $sp[0]->id_mitra))->result();
                ?>
                <tr>
                    <td width="15%">NOMOR PACKING</td>
                    <td width="30%">: <?= isset($packing[0]->nomor_packing) ? $packing[0]->nomor_packing : ''; ?></td>
                    <td width="15%">NAMA LEMBAGA</td>
                    <td width="40%">: <?= (isset($lembaga[0]->nama_lembaga) ? $lembaga[0]->nama_lembaga : ''); ?> </td>
                </tr>

                <tr>
                    <td width="15%">TANGGAL PACKING</td>
                    <td width="30%">: <?= isset($packing[0]->tanggal_packing) ? $packing[0]->tanggal_packing : ''; ?></td>
                    <td width="15%">KODE LEMBAGA</td>
                    <td width="40%">: <?= (isset($lembaga[0]->kode) ? $lembaga[0]->kode : ''); ?> </td>
                </tr>

                <tr>
                    <td width="15%">TANGGAL SP</td>
                    <td width="30%">: <?= $this->tanggal->konversi($sp[0]->tanggal_sp); ?></td>
                    <td width="15%">KLASIFIKASI</td>
                    <td width="40%">: <?= (isset($lembaga[0]->klasifikasi) ? strtoupper($lembaga[0]->klasifikasi) : ''); ?></td>
                </tr>

                <tr>
                    <td width="15%">NOMOR SP</td>
                    <td width="30%">: <?= $sp[0]->nomor_sp; ?></td>
                    <td width="15%">NAMA PELANGGAN</td>
                    <td width="40%">: <?= (isset($pelanggan[0]->nama_pelanggan) ? $pelanggan[0]->nama_pelanggan : ''); ?></td>
                </tr>

                <tr>
                    <td width="15%">ID MARKETING</td>
                    <td width="30%">: <?= (isset($mitra[0]->kode) ? $mitra[0]->kode : ''); ?></td>
                    <td width="17%">JABATAN PELANGGAN</td>
                    <td width="40%">: <?= (isset($pelanggan[0]->jabatan) ? $pelanggan[0]->jabatan : ''); ?></td>
                </tr>

                <tr>
                    <td width="15%">NAMA MARKETING</td>
                    <td width="30%">: <?= (isset($mitra[0]->nama_mitra) ? $mitra[0]->nama_mitra : ''); ?></td>
                    <td width="15%">KODE PELANGGAN</td>
                    <td width="40%">: <?= (isset($pelanggan[0]->kode) ? $pelanggan[0]->kode : ''); ?></td>
                </tr>

            </table>

            <div class='col-lg-12' style="margin-bottom: 5px;">
                <table id="" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr style="font-weight: bold;" class="themed-border themed-background-spring text-light">
                            <td class="text-center" style="width: 2%;">NO</td>
                            <td style="width: 10%;">NAMA SUPPLIER</td>
                            <td style="width: 15%;">SPESIFIKASI</td>
                            <td style="width: 10%;">KODE BARANG</td>
                            <td style="width: 30%;">NAMA BARANG</td>
                            <td style="width: 10%;" class="text-center">JUMLAH PACKING</td>
                            <td style="width: 10%;" class="text-center">CEKING</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = $jmlQty = 0;
                        $i = 1;
                        $QpackingDetail = $this->db->get_where('packing_detail', array('id_packing_m' => $id_packing_m, 'qty_terpacking >' => 0))->result();
                        foreach ($QpackingDetail as $pd) {
                            $pdid_barang = $pd->id_barang;
                            $pdbarang = $this->db->get_where('barang', array('id_barang' => $pd->id_barang))->result();
                            $qvendor = $this->db->get_where('vendor', array('id' => $pdbarang[0]->id_vendor))->result();
                        ?>
                            <tr>
                                <td class="text-center"><?= ++$no; ?></td>
                                <td><?= isset($qvendor[0]->nama_vendor) ? $qvendor[0]->nama_vendor : ''; ?></td>
                                <td><?= $pdbarang[0]->spesifikasi; ?></td>
                                <td>
                                    <?= isset($pdbarang[0]->kode_barang) ? $pdbarang[0]->kode_barang : ''; ?>
                                </td>
                                <td><?= isset($pdbarang[0]->nama_barang) ? strtoupper($pdbarang[0]->nama_barang) : ''; ?></td>
                                <td class="text-center"><?= $pd->qty_terpacking; ?></td>
                                <td></td>
                            </tr>
                        <?php
                            $jmlQty += $pd->qty_terpacking;
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>                
            </div> <!-- END col-lg-12 -->
        </div>
        <!-- END row -->

        <div class="row" style="bottom: 100px;">
            <div class='col-lg-12'>
                <table style="margin: 50px 0px 0px 0px;" class="table table-vcenter table-condensed table-bordered">
                    <tr>
                        <td width="40%"><strong>PETUGAS PACKING</strong></td>
                        <td width="20%" class="text-center detail"><strong>JUMLAH QOLI</strong></td>
                        <td width="20%" class="text-center detail"><strong>JUMLAH IKAT</strong></td>
                        <td width="20%" class="text-center detail"><strong>TANGGAL</strong></td>
                    </tr>
                    <tr>
                        <td height="100"></td>
                        <td height="100" rowspan="2" class="detail"></td>
                        <td height="100" rowspan="2" class="detail"></td>
                        <td height="100" rowspan="2" class="detail"></td>
                    </tr>
                    <tr>
                        <td>Nama Jelas, Tandatangan</td>
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