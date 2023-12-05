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
                .head tr{
                    border: solid 1px #red;
                    line-height: 20px;
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
        <h1 class="text-center">
            <strong>
                <?php
                    echo $title;
                ?>
            </strong>
            <br />
        </h1>

        <div class="row">
            
            <table style="margin: 20px 0px 20px 20px;" width="100%" class="head">
                <tr>
                    <td width="20%">Nomor Surat Jalan</td>
                    <td>: <?=(isset($surat_jalan[0]->nomor) ? $surat_jalan[0]->nomor : '-');?></td>
                </tr>
                <tr>
                    <td width="20%">Tanggal Surat Jalan</td>
                    <td>: <?=(isset($surat_jalan[0]->nomor) ? ($this->tanggal->konversi($surat_jalan[0]->tanggal)): '-');?></td>
                </tr>
                <tr>
                    <td width="20%">Exspedisi</td>
                    <td>: <?=(isset($surat_jalan[0]->nomor) ? (strtoupper($surat_jalan[0]->exspedisi)) : '-');?></td>
                </tr>
            </table>

            <div class='col-lg-12' style="margin: 20px 0px;">
                <table id="" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr style="font-weight: bold;" class="themed-border themed-background-spring text-light">
                            <td class="text-center text-light" style="width: 3%;">NO</td>
                            <td class="text-light" style="width: 10%;">NOMOR DO</td>
                            <td class="text-light" style="width: 35%;">NAMA LEMBAGA</td>
                            <td class="text-light text-center" style="width: 10%;">JML QOLI</td>
                            <td class="text-light text-center" style="width: 10%;">JML IKAT</td>
                            <td class="text-light text-center" style="width: 15%;">KETERANGAN</td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            $q = $this->db->get_where('surat_jalan_detail', array('surat_jalan_id' => $id_surat_jalan));
                            $no = 0;
                            foreach($q->result() as $d)
                            {
                                $id_lembaga = $d->id_lembaga;
                                $qLembaga = $this->db->get_where('lembaga', array('id' => $id_lembaga))->result();
                                $nama_lembaga = strtoupper(isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-');

                                $qDo = $this->db->get_where('packing_do', array('nomor_do' => $d->nomor_do))->result();
                                $qoli = (isset($qDo[0]->jumlah_qoli) ? $qDo[0]->jumlah_qoli : '-');
                                $ikat = (isset($qDo[0]->jumlah_ikat) ? $qDo[0]->jumlah_ikat : '-');
                            ?>
                                <tr>
                                    <td><?=++$no;?></td>
                                    <td><?=$d->nomor_do;?></td>
                                    <td><?=$nama_lembaga;?></td>
                                    <td class="text-center"><?=$qoli;?></td>
                                    <td class="text-center"><?=$ikat;?></td>
                                    <td class="text-center"><?='';?></td>
                                </tr>
                            <?php
                            }
                        ?>                    

                    </tbody>
                </table>                
            </div> <!-- END col-lg-12 -->
        </div>
        <!-- END row -->

        <div class="row" style="bottom: 100px; left: 30px; position: fixed; width: 100%;">
            <div class='col-lg-12'>
                <table width="100%" class="">
                    <tr>
                        <td width="70%"><?='Kepala Gudang';?></td>
                        <td width="50%"><?='Diterima Oleh';?></td>
                    </tr>
                    <tr>
                        <td height="60"></td>
                        <td height="60"></td>
                    </tr>
                    <tr>
                        <td><strong>..................</strong></td>
                        <td><strong>..................</strong></td>
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