<html>
    <head>
        <title>Print Surat Pembelian</title>
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
                @page{
                    size: auto;
                    margin: 2cm 0.5cm;
                }

                /* in case @page {margin: 5cm 0 5cm 0;} doesn't work */
                header, footer {
                    display: none !important;
                }
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
                    echo '<br />';
                    echo 'NOMOR : '. $pembelian[0]->nomor_spb;
                ?>
            </strong>
            <br />
        </h1>

        <div class="row">
            
            <?php
                $supplier = $this->db->get_where('vendor', array('id' => $pembelian[0]->id_supplier))->result();
                $marketing = $this->db->get_where('marketing_supplier', array('id' => $pembelian[0]->id_marketing))->result();
            
            ?>
        
            <table style="margin: 20px 0px 20px 20px;">
                <tr>
                    <td width="100%"><strong>Kepada Yth: </strong></td>
                </tr>

                <tr>
                    <td width="100%" valign="top">
                        <p style="margin:0px; padding: 0px">Bapak <?=(isset($marketing[0]->nama_lengkap) ? $marketing[0]->nama_lengkap : '-');?></p>
                        <p style="margin:0px; padding: 0px">Marketing <?=strtoupper(isset($supplier[0]->nama_vendor) ? $supplier[0]->nama_vendor : '-');?></p>                  
                        <p style="margin:0px; padding: 0px"><?=(isset($marketing[0]->alamat) ? $marketing[0]->alamat : '-');?></p>
                        <p style="margin:0px; padding: 0px">
                            Kontak
                            <?=(isset($marketing[0]->nomor_handphone) ? $marketing[0]->nomor_handphone : '-');?>
                        </p>                        
                        <p style="margin:0px; padding: 0px">Di</p> 
                        <p style="margin:0px; padding: 0px">Tempat</p>
                    </td>
                </tr>
                <tr>
                    <td width="100%" valign="top">
                        <p style="margin:20px; padding: 0px"></p>
                        <p style="margin:0px; padding: 0px">Dengan Hormat,</p>
                        <p style="margin:0px; padding: 0px">Melalui Surat Pembelian ini kami memesan barang dengan rincian sebagai berikut:</p>
                    </td>
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
                            <td style="width: 10%;" class="text-center">HARGA</td>
                            <td style="width: 5%;" class="text-center">QTY </td>
                            <td style="width: 15%;" class="text-center">JUMLAH HARGA (Rp.)</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = $jml = $qty = $hargaSatuan = $total = 0;
                        $i = 1;
                        // $detail = $this->db->get_where('pembelian_detail', array('id_pembelian_m' => $pembelian[0]->id_pembelian_m))->result();
                        $detail = $this->db->query("SELECT a.*, 
                                                        b.kode_barang, b.nama_barang, b.spesifikasi,
                                                        b.satuan
                                                    FROM pembelian_detail a, barang b
                                                    WHERE a.id_pembelian_m='".$pembelian[0]->id_pembelian_m."'
                                                    AND a.id_barang=b.id_barang
                                                    ORDER BY b.kode_barang ASC")->result();
                        foreach ($detail as $pd) {
                            //$jml += $pd->harga_pajak;
                            // $pdid_barang = $pd->id_barang;
                            // $pdbarang = $this->db->get_where('barang', array('id_barang' => $pd->id_barang))->result();

                            $jmlHarga = 0;
                            $qty = $pd->jumlah_beli;
                            $hargaSatuan = $pd->harga_satuan;
                            $jmlHarga = ($qty * $hargaSatuan);
                            $total += $jmlHarga;

                        ?>
                            <tr>
                                <td class="text-center"><?= ++$no; ?></td>
                                <td>
                                    <?= $pd->kode_barang; ?>
                                </td>
                                <td><?= strtoupper($pd->nama_barang); ?></td>
                                <td><?= $pd->spesifikasi; ?></td>
                                <td><?= $pd->satuan; ?></td>
                                <td class="text-right"><?= str_replace(',', '.', number_format($pd->harga_satuan)); ?></td>
                                <td class="text-center"><?= $pd->jumlah_beli; ?></td>
                                <td class="text-right"><?= str_replace(',', '.', number_format($jmlHarga)); ?></td>
                            </tr>
                        <?php
                            //$jmlQty += $pd->qty_terpacking;
                            $i++;
                        }
                        ?>
                        <tr style="font-weight: bold;">
                            <td colspan="7" class="text-right">TOTAL</td>
                            <td class="text-right"><?='Rp. '.str_replace(',', '.', number_format($total));?></td>
                        </tr>
                    </tbody>
                </table>                
            </div> <!-- END col-lg-12 -->
            
        </div>
        <!-- END row -->

        <div class="row" style="bottom: 100px; left: 30px; width: 100%;">

            <table style="margin: 20px 0px 20px 20px;">
                <tr>
                    <td width="100%"><strong>Catatan: </strong></td>
                </tr>
                <tr>
                    <td width="100%" valign="top">
                        <p style="margin:0px; padding: 0px">1. Pembayaran akan kami lakukan secara <strong><?=ucwords($pembelian[0]->sistem_pembayaran);?></strong></p>
                        <p style="margin:0px; padding: 0px">2. Kami harap bisa menerima barang paling lambat 7 hari setelah Surat Pembelian Barang ini diterima.</p>
                    </td>
                </tr>
                <tr>
                    <td width="100%" valign="top">
                        <p style="margin:20px; padding: 0px"></p>
                        <p style="margin:0px; padding: 0px">Demikian Surat Pembelian Barang ini kami sampaikan, atas perhatian dan kerjasama saudara kami ucapkan terimakasih.</p>
                    </td>
                </tr>
                <tr>
                    <td width="100%" valign="top">
                        <p style="margin:20px; padding: 0px"></p>
                        <p style="margin:0px; padding: 0px">Cianjur, <?=$this->tanggal->konversi($pembelian[0]->tanggal_spb);?></p>
                        <p style="margin:0px; padding: 0px">CV. Mega Setia Abadi</p>
                    </td>
                </tr>
            </table>

            <table style="margin: 20px 0px 20px 20px;">
                <tr>
                    <td width="100%" valign="top">
                        <p style="margin:20px; padding: 0px"></p>
                        <p style="margin:0px; padding: 0px"><strong>Dani Hermawan, S.Pd</strong></p>
                        <p style="margin:0px; padding: 0px"><strong>Direktur</strong></p>
                    </td>
                </tr>
            </table>
        </div>

        <script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
        <script>
        $(document).ready(function () {
            window.print();
        });
        </script>        
    </body>
</html>