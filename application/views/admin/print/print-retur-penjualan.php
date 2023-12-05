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
                ?>
            </strong>
            <br />
        </h4>

        <div class="row">
            <table style="margin: 20px 0px 20px 20px;" width="100%" class="head">
                <tr>
                    <td class="text-left" style="width: 20%;">Nomor DO</td>
                    <td>
                        <?php
                        $id_do = (isset($retur_master[0]->id_do) ? $retur_master[0]->id_do : '0'); 

                        $do = $this->db->get_where('packing_do', array('id' => $id_do))->result();
                        echo (isset($do[0]->nomor_do) ? $do[0]->nomor_do : '-');
                        ?>
                    </td>
                </tr>

                <tr>
                    <td class="text-left" style="width: 20%;">Nomor Retur</td>
                    <td><?= (isset($retur_master[0]->nomor_retur) ? $retur_master[0]->nomor_retur : '-'); ?></td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 20%;">Tanggal Retur</td>
                    <td><?= (isset($retur_master[0]->tanggal_retur) ? ($this->tanggal->konversi($retur_master[0]->tanggal_retur)) : '-'); ?></td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 20%;">Kode Marketing</td>
                    <td><?= (isset($qMarketing[0]->nomor_id) ? $qMarketing[0]->nomor_id : '-'); ?></td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 20%;">Nama Marketing</td>
                    <td><?= (isset($qMarketing[0]->nama_lengkap) ? $qMarketing[0]->nama_lengkap : '-'); ?></td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 20%;">Kode Lembaga</td>
                    <td><?= (isset($qLembaga[0]->kode) ? $qLembaga[0]->kode : '-'); ?></td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 20%;">Nama Lembaga</td>
                    <td><?= (isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-'); ?></td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 20%;">Kode Pelanggan</td>
                    <td><?= (isset($qPelanggan[0]->kode) ? $qPelanggan[0]->kode : '-'); ?></td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 20%;">Nama Pelanggan</td>
                    <td><?= (isset($qPelanggan[0]->nama_pelanggan) ? $qPelanggan[0]->nama_pelanggan : '-'); ?></td>
                </tr>

            </table>

            
            <div class='col-lg-12' style="margin-bottom: 5px;">
                <table id="" class="table table-vcenter table-condensed table-bordered">
                    <thead>
                        <tr style="font-weight: bold;" class="themed-border themed-background-spring text-light">
                            <td class="text-center text-light" style="width: 3%;">NO</td>
							<td class="text-light" style="width: 5%;">KODE BARANG</td>
							<td class="text-light" style="width: 35%;">NAMA BARANG</td>
							<td class="text-light" style="width: 35%;">NAMA SUPPLIER</td>
							<td class="text-light" style="width: 5%;">JUMLAH RETUR</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
						$q = $this->db->get_where('retur_barang_penjualan_detail', array('id_retur_master' => $id_retur_master));
						$no = 0;
						foreach ($q->result() as $d) {
							$id_barang = $d->id_barang;
							$qBarang = $this->db->get_where('barang', array('id_barang' => $id_barang))->result();
							$qVendor = $this->db->get_where('vendor', array('id' => $qBarang[0]->id_vendor))->result();
							$nama_vendor = strtoupper(isset($qVendor[0]->nama_vendor) ? $qVendor[0]->nama_vendor : '-');
							$kode_barang = strtoupper(isset($qBarang[0]->kode_barang) ? $qBarang[0]->kode_barang : '-');
							$nama_barang = strtoupper(isset($qBarang[0]->nama_barang) ? $qBarang[0]->nama_barang : '-');

						?>
							<tr>
								<td><?= ++$no; ?></td>
								<td><?= $kode_barang; ?></td>
								<td><?= $nama_barang; ?></td>
								<td><?= $nama_vendor; ?></td>
								<td class='text-center'><?= $d->jumlah_retur; ?></td>
							</tr>
						<?php
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