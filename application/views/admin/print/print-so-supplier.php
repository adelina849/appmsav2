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
                    margin: 0mm;
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
                    $q = $this->db->get_where('vendor', array('id' => $id_vendor))->result();

                ?>
            </strong>
            <br />
        </h4>

        <div class="row">
            <table style="margin: 20px 0px 20px 20px;" width="100%" class="head">
                <tr>
                    <td width="20%">KODE SUPPLIER</td>
                    <td>: <?=strtoupper(isset($q[0]->kode) ? $q[0]->kode : '-');?></td>
                </tr>
                <tr>
                    <td width="20%">NAMA SUPPLIER</td>
                    <td>: <?=strtoupper(isset($q[0]->nama_vendor) ? $q[0]->nama_vendor : '-');?></td>
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
                            <td style="width: 10%;" class="text-center">QTY </td>
                            <td style="width: 10%;" class="text-center">KETERANGAN </td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        // $q = $this->db->query("SELECT 
                        //         a.id_barang, a.qty_so, 
                        //         SUM(a.qty_so) AS total_so_barang,
                        //         vendor.id,
                        //         barang.kode_barang AS kode_barang,
                        //         barang.nama_barang AS nama_barang,
                        //         barang.spesifikasi AS spesifikasi,
                        //         barang.satuan AS satuan
                        //         FROM (select distinct id_barang, qty_so from packing_detail) a, barang, vendor
                        //         WHERE a.id_barang=barang.id_barang
                        //         AND barang.id_vendor=vendor.id
                        //         AND vendor.id='".$id_vendor."'
                        //         AND a.qty_so > 0
                        //         GROUP BY a.id_barang");        
                        $q = $this->db->query("SELECT c.id_vendor, c.kode_barang, c.nama_barang, c.spesifikasi, c.satuan, 
                                                a.id_barang, SUM(a.qty_terpacking) AS jml_terpacking,
                                                (
                                                    (
                                                        SELECT SUM(b.jumlah_beli) FROM pesanan_detail b 
                                                        WHERE a.id_barang=b.id_barang
                                                    ) - SUM(a.qty_terpacking)		
                                                ) AS qty_so
                                                FROM packing_detail a, barang c
                                                WHERE a.id_barang=c.id_barang
                                                AND c.id_vendor='".$id_vendor."'
                                                GROUP BY a.id_barang HAVING qty_so > 0");        


                        $no = 0;
                        $result = array();
                        $result['total'] = $q->num_rows();
                        $row = array();
                        
                        foreach($q->result() as $pd) {
                        ?>
                            <tr>
                                <td class="text-center"><?= ++$no; ?></td>
                                <td>
                                    <?= $pd->kode_barang; ?>
                                </td>
                                <td>
                                    <?= $pd->nama_barang; ?>
                                </td>
                                <td>
                                    <?= $pd->spesifikasi; ?>
                                </td>
                                <td>
                                    <?= $pd->satuan; ?>
                                </td>
                                <td class="text-center"><?= $pd->qty_so; ?></td>
                                <td></td>
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