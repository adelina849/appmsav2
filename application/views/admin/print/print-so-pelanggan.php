<html>
    <head>
        <title>Print SO</title>
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
                    $qPelanggan = $this->db->get_where('pelanggan', array('id' => $id_pelanggan))->result();
                    $qLembaga = $this->db->get_where('lembaga', array('id' => $id_lembaga))->result();

                ?>
            </strong>
            <br />
        </h4>

        <div class="row">
            <table style="margin: 20px 0px 20px 20px;" width="100%" class="head">
                <tr>
                    <td width="20%">KODE PELANGGAN</td>
                    <td>: <?=strtoupper(isset($qPelanggan[0]->kode) ? $qPelanggan[0]->kode : '-');?></td>
                </tr>
                <tr>
                    <td width="20%">NAMA PELANGGAN</td>
                    <td>: <?=strtoupper(isset($qPelanggan[0]->nama_pelanggan) ? $qPelanggan[0]->nama_pelanggan : '-');?></td>
                </tr>
                <tr>
                    <td width="20%">NAMA LEMBAGA</td>
                    <td>: <?=strtoupper(isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-');?></td>
                </tr>
                <tr>
                    <td width="20%">ALAMAT LEMBAGA</td>
                    <td>: <?=isset($qLembaga[0]->alamat) ? $qLembaga[0]->alamat : '-';?></td>
                </tr>
            </table>

            
            <div class='col-lg-12' style="margin-bottom: 5px;">
                <table id="" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr style="font-weight: bold;" class="themed-border themed-background-spring text-light">
                            <td class="text-center" style="width: 2%;">NO</td>
                            <td style="width: 5%;">KODE</td>
                            <td style="width: 30%;">NAMA BARANG</td>
                            <td style="width: 15%;">SPESIFIKASI</td>
                            <td style="width: 10%;" class="text-center">SATUAN</td>
                            <td style="width: 10%;" class="text-center">QTY SP</td>
                            <td style="width: 10%;" class="text-center">TERPACKING</td>
                            <td style="width: 10%;" class="text-center">SO</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        #ambil dulu daftar pakingan terakhir
                        $qp = $this->db->query("SELECT MAX(id_packing_m) as max FROM packing_detail WHERE id_pesanan_m='".$id_pesanan_m."'")->row();
                        $idpacking = $qp->max;

                        // $s = "SELECT 
                        //         a.id_barang, SUM(a.qty_so) AS total_so,
                        //         b.id_packing_m, b.nomor_packing, b.tanggal_packing,
                        //         c.id_pesanan_m, c.id_lembaga, c.id_pelanggan
                        //         FROM packing_detail AS a
                        //         INNER JOIN packing_master AS b
                        //         ON a.id_packing_m=b.id_packing_m
                        //         INNER JOIN pesanan_master AS c
                        //         ON b.id_pesanan_m = c.id_pesanan_m
                        //         AND c.id_pelanggan='".$id_pelanggan."'
                        //         AND a.id_packing_m='".$idpacking."'
                        //         AND a.qty_so > 0
                        //         GROUP BY a.id_barang
                        //         ORDER BY a.id_packing_d DESC";
                        $s = "SELECT a.*, 
                        (select SUM(jumlah_beli) from pesanan_detail where id_pesanan_m=b.id_pesanan_m and id_barang=a.id_barang) AS QTY_SP,
                        (select SUM(qty_terpacking) from packing_detail where id_pesanan_m=b.id_pesanan_m and id_barang=a.id_barang) AS TERPACKING
                        FROM 
                        packing_detail a, 
                        pesanan_master b,
                        pesanan_detail c
                        WHERE b.id_pelanggan='".$id_pelanggan."'
                        AND a.id_pesanan_m = b.id_pesanan_m
                        GROUP BY a.id_barang
                        ORDER BY a.id_packing_d DESC";

                        $q = $this->db->query($s);
                        $no = 0;
                        $result = array();
                        $result['total'] = $q->num_rows();
                        $row = array();
                        
                        foreach($q->result() as $pd) {
                            $SO = 0;
                            $pdid_barang = $pd->id_barang;
                            $pdbarang = $this->db->get_where('barang', array('id_barang' => $pd->id_barang))->result();
                            //$qvendor = $this->db->get_where('vendor', array('id' => $pdbarang[0]->id_vendor))->result();

                        ?>
                            <tr>
                                <td class="text-center"><?= ++$no; ?></td>
                                <td>
                                    <?= isset($pdbarang[0]->kode_barang) ? $pdbarang[0]->kode_barang : ''; ?>
                                </td>
                                <td><?= isset($pdbarang[0]->nama_barang) ? strtoupper($pdbarang[0]->nama_barang) : ''; ?></td>
                                <td><?= $pdbarang[0]->spesifikasi; ?></td>
                                <td><?= $pdbarang[0]->satuan; ?></td>
                                <td class="text-center"><?= $pd->QTY_SP; ?></td>
                                <td class="text-center"><?= $pd->TERPACKING; ?></td>
                                <td class="text-center">
                                    <?php
                                        $SO = ($pd->QTY_SP - $pd->TERPACKING);
                                        echo $SO;
                                    ?>
                                </td>
                            </tr>
                        <?php
                            //$jmlQty += $pd->qty_terpacking;
                        }
                        ?>
                    </tbody>
                </table>                
            </div> <!-- END col-lg-12 -->
        </div>
        <!-- END row -->

        <script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
        <script>
        $(document).ready(function () {
            window.print();
        });
        </script>        
    </body>
</html>