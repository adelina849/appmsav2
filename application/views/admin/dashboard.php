<!-- eCommerce Orders Header -->
<div class="content-header">
    <ul class="nav-horizontal text-center">
        <li>
            <?= anchor('akademik/constructions', '<i class="fa fa-creative-commons"></i>Hutang Usaha'); ?>
        </li>
        <li>
            <?= anchor('akademik/constructions', '<i class="fa fa-money"></i>Piutang Usaha'); ?>
        </li>
        <li>
            <?= anchor('akademik/constructions', '<i class="gi gi-money"></i>Pembayaran'); ?>
        </li>
        <li>
            <?= anchor('akademik/constructions', '<i class="gi gi-stats"></i>Cash Flow'); ?>
        </li>
        <li>
            <?= anchor('akademik/constructions', '<i class="gi gi-edit"></i>Rekap Fee'); ?>
        </li>
        <li>
            <?= anchor('akademik/constructions', '<i class="gi gi-package"></i>Rekap Cash Flow'); ?>
        </li>

    </ul>
</div>
<!-- END  Header -->

<div class="row">
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect4">
            <div class="widget-simple">
                <div class="widget-icon pull-right animation-fadeIn themed-background-amethyst">
                    <i class="hi hi-file animation-pulseSlow"></i>
                </div>
                <h4 class="widget-content themed-color-amethyst animation-pulse">
                    <span class="h2"><strong>235</strong></span>
                    <small>Pemesanan</small>
                </h4>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect4">
            <div class="widget-simple">
                <div class="widget-icon pull-right animation-fadeIn themed-background-spring">
                    <i class="gi gi-parents"></i>
                </div>
                <h4 class=" widget-content themed-color-spring animation-stretchLeft">
                    <span class="h2"><strong>217</strong></span>
                    <small>Pengiriman</small>
                </h4>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect4">
            <div class="widget-simple">
                <div class="widget-icon pull-right animation-fadeIn themed-background-fire">
                    <i class="hi hi-new_window"></i>
                </div>
                <h4 class="widget-content themed-color-fire animation-stretchLeft">
                    <span class="h2"><strong>11</strong></span>
                    <small>Retur</small>
                </h4>
            </div>
        </a>
    </div>
    <div class="col-sm-6 col-lg-3">
        <a href="javascript:void(0)" class="widget widget-hover-effect4">
            <div class="widget-simple">
                <div class="widget-icon pull-right animation-fadeIn themed-background">
                    <i class="gi gi-check"></i>
                </div>
                <h4 class="widget-content themed-color animation-stretchLeft">
                    <span class="h2"><strong>2341</strong></span>
                    <small>Transaksi</small>
                </h4>
            </div>
        </a>
    </div>
</div>

<!-- Classic and Bars Chart -->
<div class="row">
    <div class="col-sm-6">
        <!-- Classic Chart Block -->
        <div class="block full">
            <!-- Classic Chart Title -->
            <div class="block-title">
                <h2><strong>Grapik Penjualan</strong> </h2>
            </div>
            <!-- END Classic Chart Title -->

            <!-- Classic Chart Content -->
            <!-- Flot Charts (initialized in js/pages/compCharts.js), for more examples you can check out http://www.flotcharts.org/ -->
            <div id="chart-classic" class="chart"></div>
            <!-- END Classic Chart Content -->
        </div>
        <!-- END Classic Chart Block -->
    </div>
    <div class="col-sm-6">
        <!-- Bars Chart Block -->
        <div class="block full">
            <!-- Bars Chart Title -->
            <div class="block-title">
                <h2><strong>Jumlah Penjualan</strong></h2>
            </div>
            <!-- END Bars Chart Title -->

            <!-- Bars Chart Content -->
            <!-- Flot Charts (initialized in js/pages/compCharts.js), for more examples you can check out http://www.flotcharts.org/ -->
            <div id="chart-bars" class="chart"></div>
            <!-- END Bars Chart Content -->
        </div>
        <!-- END Bars Chart Block -->
    </div>
</div>
<!-- END Classic and Bars Chart -->

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/proui/js/pages/compCharts.js"></script>
<script>
    $(function() {
        CompCharts.init();
    });
</script>