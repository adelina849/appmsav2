<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <title>CV. Mega Setia Abadi</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/ico.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/proui/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/proui/css/plugins.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/proui/css/main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/proui/css/themes.css">
    <script src="<?php echo base_url(); ?>assets/proui/js/vendor/modernizr.min.js"></script>
    <style>

    </style>
</head>

<body>

    <img src="<?php echo base_url(); ?>assets/img/background.jpeg" alt="Login Full Background" class="full-bg animation-pulseSlow">
    <!-- END Login Full Background -->

    <!-- Login Container -->
    <div id="login-container" class="animation-fadeIn">
        <!-- Login Title -->
        <div class="login-title text-center">
            <h1>
                <i class="fa fa-power-off animation-pulse"></i> <strong><?php echo 'CV. Mega Setia Abadi'; ?></strong><br><small> <strong>Login</strong> Pengguna<strong></strong></small>
            </h1>
        </div>
        <!-- END Login Title -->

        <!-- Login Block -->
        <div class="block push-bit">
            <!-- Login Form -->
            <?php echo form_open($action, array('class' => 'form-horizontal form-bordered form-control-borderless', 'id' => 'form-login')); ?>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <?php echo $this->session->flashdata('message_invalid'); ?>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" id="username" name="username" class="form-control input-lg" placeholder="Username">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                        <input type="password" id="login-password" name="login-password" class="form-control input-lg" placeholder="Password">
                    </div>
                </div>
            </div>
            <div class="form-group form-actions">
                <div class="col-xs-4">
                    <label class="switch switch-primary" data-toggle="tooltip" title="Batal">
                        <button type="reset" class="btn btn-sm btn-default"><i class="fa fa-refresh"></i> Batal</button>
                    </label>
                </div>
                <div class="col-xs-8 text-right">
                    <button type="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Masuk halaman pengguna"><i class="fa fa-unlock"></i> Masuk</button>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 text-center">
                    <a href="javascript:void(0)"><small>@copy 2022</small></a>
                </div>
            </div>
            <?php echo form_close(); ?>
            <!-- END Login Form -->

        </div>
        <!-- END Login Block -->
    </div>
    <!-- END Login Container -->

    <script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/proui/js/vendor/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/proui/js/plugins.js"></script>
    <script src="<?php echo base_url(); ?>assets/proui/js/app.js"></script>

    <!-- Load and execute javascript code used only in this page -->
    <script src="<?php echo base_url(); ?>assets/proui/js/pages/login.js"></script>
    <script>
        $(function() {
            Login.init();
        });
    </script>
</body>

</html>