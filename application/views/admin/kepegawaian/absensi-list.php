<!-- Quick Stats -->
<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">

<?php if ($existing_absensi == 0) {
	redirect('admin/kepegawaian/absensi/baru');
} ?>

<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong><?= $title; ?></strong>
		</h2>
	</div>
	<div class="row">
		<div class='col-sm-12' style="margin-bottom: 5px;">
			<div class="btn-group btn-group-lg">
				<?php echo form_open('admin/kepegawaian/absensi/daftar', array('class' => '"', 'id' => 'filter_state', 'target' => '_blank')); ?>
				<input type="hidden" name="judul" value="<?= $title; ?>">
				<input type="hidden" name="absensi_bulan_ini" id="absensi_bulan_ini" value="<?= $absensi_bulan_ini; ?>">
				<input type="hidden" name="absensi_tahun_ini" id="absensi_tahun_ini" value="<?= $absensi_tahun_ini; ?>">
				<input type="hidden" name="bulan" id="bulan" value="<?= $bulan_filter; ?>">
				<input type="hidden" name="tahun" id="tahun" value="<?= $tahun_filter; ?>">

				<a href="#" data_id_barang="<?= 1; ?>" data-toggle="tooltip" title="Filter Absensi" class="btn btn-alt btn-sm btn-warning" onclick="$('#modal-filter').modal('show');">
					<i class="fa fa-search"></i> Lihat Absensi Lainnya
				</a>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="table_absensi" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr class="themed-color themed-background" style="font-weight: bold;">
							<td class="text-center text-light" style="width: 3%;">NO</td>
							<td class="text-light" style="width: 10%;">ID PEGAWAI</td>
							<td class="text-light" style="width: 10%;">NAMA PEGAWAI</td>
							<td class="text-light" style="width: 10%;">JUMLAH TIDAK HADIR</td>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal Filter-->
<div class="modal fade" id="modal-filter" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title text-center text-primary"><i class="fa fa-search"></i> Filter Absensi</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_filter, array('class' => 'form-horizontal form-bordered', 'id' => 'filter_form')); ?>
				<input type="hidden" name="filter" value="filter">
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label" for="pilih_bulan">Pilih Bulan <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
								<div class="input-date" data-date-format="m">
									<input type="text" id="pilih_bulan" name="pilih_bulan" class="form-control input-datepicker datepicker-years" data-date-format="m" placeholder="Pilih Tahun" autocomplete="off">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="pilih_tahun">Pilih Tahun <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
								<div class="input-date" data-date-format="yyyy">
									<input type="text" id="pilih_tahun" name="pilih_tahun" class="form-control input-datepicker datepicker-years" data-date-format="yyyy" placeholder="Pilih Tahun" autocomplete="off">
								</div>
							</div>
						</div>
					</div>
				</fieldset>
				<div class="form-group form-actions">
					<div class="col-md-8 col-md-offset-4 text-right">
						<button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Batal</button>
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Tampilkan</button>
					</div>
				</div>
				<?php echo form_close(); ?>
				<!-- END Form Validation Example Content -->
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
<!-- END Modal Filter-->

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script type="text/javascript">
	var table;
	$(document).on('blur', '#total_tidak_hadir', function(e) {
		var edit_id = $(this).data('id');
		var edit_bulan = $(this).data('bulan');
		var edit_tahun = $(this).data('tahun');
		var new_absen = e.target.value;
		$.ajax({
			url: "<?php echo site_url('admin/kepegawaian/absensi/update_absen') ?>",
			data: {
				id: edit_id,
				bulan: edit_bulan,
				tahun: tahun,
				newAbsen: new_absen
			},
			type: "POST",
		})
	});
	$(document).ready(function() {

		$("#pilih_bulan").datepicker({
			format: "m",
			viewMode: "months",
			minViewMode: "months",
			maxViewMode: "months",
			autoclose: true //to close picker once year is selected
		});
		$("#pilih_tahun").datepicker({
			format: "yyyy",
			viewMode: "years",
			minViewMode: "years",
			autoclose: true //to close picker once year is selected
		});


		var absensi_bulan_ini = $("#absensi_bulan_ini").val();
		var absensi_tahun_ini = $("#absensi_tahun_ini").val();
		var bulan = $("#bulan").val();
		var tahun = $("#tahun").val();

		table = $('#table_absensi').DataTable({
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				url: "<?php echo site_url('admin/kepegawaian/absensi/ajax_list_absensi') ?>",
				data: {
					absensi_bulanini: absensi_bulan_ini,
					absensi_tahunini: absensi_tahun_ini,
					bulan: bulan,
					tahun: tahun,
				},
				type: "POST",
			},
			'language': {
				"search": "",
			},
			//Set column definition initialisation properties.
			"columnDefs": [{
				"targets": [0], //first column / numbering column
				"orderable": false, //set not orderable
			}, ],

		});
		$('body').tooltip({
			selector: '[data-toggle="tooltip"]'
		});
	});
</script>
