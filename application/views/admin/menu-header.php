<header class="navbar navbar-default">
    <!-- Left Header Navigation -->
    <ul class="nav navbar-nav-custom">
        <!-- Main Sidebar Toggle Button -->
        <li>
            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                <i class="fa fa-bars fa-fw"></i>
            </a>
        </li>
        <!-- END Main Sidebar Toggle Button -->

        <!-- Template Options -->
        <!-- Change Options functionality can be found in js/app.js - templateOptions() -->
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <i class="gi gi-settings"></i>
            </a>
            <ul class="dropdown-menu dropdown-custom dropdown-options">
                <li class="dropdown-header text-center">Header Style</li>
                <li>
                    <div class="btn-group btn-group-justified btn-group-sm">
                        <a href="javascript:void(0)" class="btn btn-primary" id="options-header-default">Light</a>
                        <a href="javascript:void(0)" class="btn btn-primary" id="options-header-inverse">Dark</a>
                    </div>
                </li>
                <li class="dropdown-header text-center">Page Style</li>
                <li>
                    <div class="btn-group btn-group-justified btn-group-sm">
                        <a href="javascript:void(0)" class="btn btn-primary" id="options-main-style">Default</a>
                        <a href="javascript:void(0)" class="btn btn-primary" id="options-main-style-alt">Alternative</a>
                    </div>
                </li>
            </ul>
        </li>
        <!-- END Template Options -->
    </ul>
    <!-- END Left Header Navigation -->

    <!-- Search Form -->
    <form action="page_ready_search_results.html" method="post" class="navbar-form-custom">
        <div class="form-group">
            <input type="text" id="top-search" name="top-search" class="form-control" placeholder="Search..">
        </div>
    </form>
    <!-- END Search Form -->

    <!-- Right Header Navigation -->
    <ul class="nav navbar-nav-custom pull-right">
        <!-- User Dropdown -->
        <li>
            <!-- If you do not want the main sidebar to open when the alternative sidebar is closed, just remove the second parameter: App.sidebar('toggle-sidebar-alt'); -->
            <a href="javascript:void(0)" class="text-info">
                <?php
                if (function_exists('date_default_timezone_set'))
                    date_default_timezone_set('Asia/Jakarta');
                ?>
                <i class="fa fa-calendar animation-pulse"></i>
                <strong><span id="clock">&nbsp;</span></strong>
            </a>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo base_url(); ?>assets/img/avatar.jpg" alt="avatar"> <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                <li class="dropdown-header text-center">Account</li>
                <li>
                    <a href="#">
                        <i class="fa fa-user fa-fw pull-right"></i>
                        Profile
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <?php echo anchor(
                        'admin/auth/signout',
                        '<i class="fa fa-ban fa-fw pull-right"></i> Sign out',
                        array(
                            'class' => '',
                            'onclick' => 'return confirm(\'Apakah anda yakin keluar ?\');'
                        )
                    ); ?>
                </li>
            </ul>
        </li>
        <!-- END User Dropdown -->
    </ul>
    <!-- END Right Header Navigation -->
</header>