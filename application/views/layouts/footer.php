    <!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
    <a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>

    <script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/proui/js/vendor/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/proui/js/plugins.js"></script>
    <script src="<?php echo base_url(); ?>assets/proui/js/app.js"></script>
    <script src="<?php echo base_url(); ?>assets/js_cus/dates_comp.js"></script>

    <!-- Load and execute javascript code used only in this page -->
    <script src="<?php echo base_url(); ?>assets/proui/js/pages/tablesDatatables.js"></script>
    <script>
        $(function() {
            TablesDatatables.init();
        });
    </script>

    <!-- Load and execute javascript code used only in this page -->
    <script src="<?php echo base_url(); ?>assets/proui/js/pages/formsValidation.js"></script>

    <script>
        $(function() {
            FormsValidation.init();
        });
    </script>

    <!-- Scroll to top link, initialized in js/app.js - scrollToTop() -->
    <a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>

    <?php $this->load->view('admin/user-setting'); ?>

    <script src="<?php echo base_url(); ?>assets/proui/js/pages/index.js"></script>

    <script src="<?php echo base_url(); ?>assets/proui/js/pages/widgetsStats.js"></script>
    <script>
        $(function() {
            WidgetsStats.init();
        });
    </script>

    <script>
        $(function() {
            Index.init();
        });
    </script>

    <script>
        $(window).load(function() {
            $(".overlay").fadeOut("100");
        });
    </script>

    <script src="<?php echo base_url(); ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script>
        <?= $this->session->flashdata('messageAlert'); ?>
    </script>

    <script type="text/javascript">
        var d = new Date();
        var hours = d.getHours();
        var minutes = d.getMinutes();
        var seconds = d.getSeconds();
        var hari = d.getDay();
        var namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        hariIni = namaHari[hari];
        var tanggal = ("0" + d.getDate()).slice(-2);
        var month = new Array();
        month[0] = "Januari";
        month[1] = "Februari";
        month[2] = "Maret";
        month[3] = "April";
        month[4] = "Mei";
        month[5] = "Juni";
        month[6] = "Juli";
        month[7] = "Agustus";
        month[8] = "September";
        month[9] = "Oktober";
        month[10] = "Nopember";
        month[11] = "Desember";
        var bulan = month[d.getMonth()];
        var tahun = d.getFullYear();
        var date = Date.now(),
            second = 1000;

        function pad(num) {
            return ('0' + num).slice(-2);
        }

        function updateClock() {
            var clockEl = document.getElementById('clock'),
                dateObj;
            date += second;
            dateObj = new Date(date);
            clockEl.innerHTML = '' + hariIni + '.  ' + tanggal + ' ' + bulan + ' ' + tahun + '. ' + pad(dateObj.getHours()) + ':' + pad(dateObj.getMinutes()) + ':' + pad(dateObj.getSeconds());
        }

        // function updateClock() {
        //     var clockEl = document.getElementById('jam'),
        //         dateObj;
        //     date += second;
        //     dateObj = new Date(date);
        //     clockEl.innerHTML = '' + pad(dateObj.getHours()) + ':' + pad(dateObj.getMinutes()) + ':' + pad(dateObj.getSeconds());
        // }
        setInterval(updateClock, second);
    </script>
    <div class="modal" id="ModalGue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class='fa fa-times-circle'></i></button>
                    <h4 class="modal-title" id="ModalHeader"></h4>
                </div>
                <div class="modal-body" id="ModalContent"></div>
                <div class="modal-footer" id="ModalFooter"></div>
            </div>
        </div>
    </div>

    <script>
        $('#ModalGue').on('hide.bs.modal', function() {
            setTimeout(function() {
                $('#ModalHeader, #ModalContent, #ModalFooter').html('');
            }, 500);
        });
    </script>