<!-- Quick Stats -->
<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">

<div class="row text-center">
	<div class="container">
		<?php if ($existing_penggajian == 0) { ?>
			<div class="alert alert-warning">
				<i class="fa fa-fw fa-warning-circle"></i> Penggajian Bulan Ini belum dilakukan
			</div>
			<a href="<?= site_url('admin/kepegawaian/penggajian/baru'); ?>" class="widget widget-hover-effect2" data-toggle="tooltip" title="Generate Penggajian">
				<div class="widget-extra themed-background-dark text-center">

					<h4 class="widget-content-light"><strong>GENERATE PENGGAJIAN SEKARANG</strong></h4>
				</div>
				<div class="widget-extra-full text-center bg-info"><span class="h2 text-success animation-expandOpen "><i class="fa fa-plus-circle animation-pulse text-center"></i></span></div>
			</a>
		<?php } ?>
	</div>
</div>

<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong><?= $title; ?></strong>
		</h2>
	</div>
	<div class="row">
		<div class='col-sm-12' style="margin-bottom: 5px;">
			<div class="btn-group btn-group-lg">
				<?php echo form_open('admin/kepegawaian/penggajian/daftar', array('class' => '"', 'id' => 'filter_state', 'target' => '_blank')); ?>
				<input type="hidden" name="judul" value="<?= $title; ?>">
				<input type="hidden" name="penggajian_bulan_ini" id="penggajian_bulan_ini" value="<?= $penggajian_bulan_ini; ?>">
				<input type="hidden" name="penggajian_tahun_ini" id="penggajian_tahun_ini" value="<?= $penggajian_tahun_ini; ?>">
				<input type="hidden" name="bulan" id="bulan" value="<?= $bulan_filter; ?>">
				<input type="hidden" name="tahun" id="tahun" value="<?= $tahun_filter; ?>">

				<a href="#" data_id_barang="<?= 1; ?>" data-toggle="tooltip" title="Filter Penggajian" class="btn btn-alt btn-sm btn-warning" onclick="$('#modal-filter').modal('show');">
					<i class="fa fa-search"></i> Lihat Penggajian Lainnya
				</a>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="table_penggajian" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr class="themed-color themed-background" style="font-weight: bold;">
							<td class="text-center text-light" style="width: 3%;">NO</td>
							<td class="text-light" style="width: 10%;">NAMA PEGAWAI</td>
							<td class="text-light" style="width: 10%;">JABATAN</td>
							<td class="text-light" style="width: 10%;">GAJI POKOK</td>
							<td class="text-light" style="width: 10%;">POTONGAN</td>
							<td class="text-light" style="width: 10%;">TOTAL</td>
							<td class="text-center no-sort text-light" style="width: 5%;"><i class="fa fa-cog"></i></td>
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
				<h2 class="modal-title text-center text-primary"><i class="fa fa-search"></i> Filter Penggajian</h2>
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
									<input type="text" id="pilih_bulan" name="pilih_bulan" class="form-control input-datepicker datepicker-years" data-date-format="m" placeholder="Pilih Tahun" autocomplete="off" required>
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
									<input type="text" id="pilih_tahun" name="pilih_tahun" class="form-control input-datepicker datepicker-years" data-date-format="yyyy" placeholder="Pilih Tahun" autocomplete="off" required>
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

<!--Cetak slip  -->
<div id="FormCetak" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title text-center text-primary"><i class="fa fa-file-pdf-o"></i> Cetak Slip Gaji</h2>
			</div>

			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_cetak, array('class' => 'form-horizontal form-bordered"', 'id' => 'form', 'target' => '_blank')); ?>
				<input type="hidden" name="id_penggajian" class="id_penggajian">
				<fieldset>
					<div class="form-group" style="margin:0 20px 0 20px">
						<div class="alert alert-info alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="fa fa-info-circle"></i> Info!</h4>
							Anda akan mencetak slip gaji <span id="nama_karyawan"></span> dalam format file PDF
						</div>
					</div>
				</fieldset>
				<div class="form-group form-actions">
					<div class="col-xs-12 text-center">
						<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-sm btn-primary">Lanjutkan</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
<!-- END cetak sp -->

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script type="text/javascript">
	var table;


	$(document).on('keyup', '#potongan', function(e) {
		var edit_id = $(this).data('id');
		var edit_bulan = $(this).data('bulan');
		var edit_tahun = $(this).data('tahun');
		var gapok = $(this).data('gapok');
		var potongan = e.target.value;

		//convert to rupiah
		//hapus titik sebelumnya terlebih dahulu
		potongan = potongan.replace(/\./g, '');
		var nom = parseInt(potongan, 10).toString().split('').reverse().join('');
		var nom2 = '';

		for (var i = 0; i < nom.length; i++) {
			nom2 += nom[i];
			if ((i + 1) % 3 === 0 && i !== (nom.length - 1)) {
				nom2 += '.';
			}
		}
		var hasil_nom = nom2.split('').reverse().join('');
		$("#potongan[data-id='" + edit_id + "']").val(hasil_nom);

		$.ajax({
			url: "<?php echo site_url('admin/kepegawaian/penggajian/update_potongan') ?>",
			data: {
				id: edit_id,
				bulan: edit_bulan,
				tahun: tahun,
				potongan: potongan,
				gapok: gapok
			},
			type: "POST",
			success: function(response) {
				//convert to rupiah
				//hapus titik sebelumnya terlebih dahulu
				response = response.replace(/\./g, '');
				var nom = parseInt(response, 10).toString().split('').reverse().join('');
				var nom2 = '';

				for (var i = 0; i < nom.length; i++) {
					nom2 += nom[i];
					if ((i + 1) % 3 === 0 && i !== (nom.length - 1)) {
						nom2 += '.';
					}
				}
				var hasil_pot = nom2.split('').reverse().join('');

				$("#total[data-id='" + edit_id + "']").text('Rp. ' + hasil_pot);
			}
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


		var penggajian_bulan_ini = $("#penggajian_bulan_ini").val();
		var penggajian_tahun_ini = $("#penggajian_tahun_ini").val();
		var bulan = $("#bulan").val();
		var tahun = $("#tahun").val();

		table = $('#table_penggajian').DataTable({
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				url: "<?php echo site_url('admin/kepegawaian/penggajian/ajax_list_penggajian') ?>",
				data: {
					penggajian_bulanini: penggajian_bulan_ini,
					penggajian_tahunini: penggajian_tahun_ini,
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

	function form_cetak(id_penggajian) {
		$(".id_penggajian").val(id_penggajian);
		$('#FormCetak').modal('show'); // show bootstrap modal when complete loaded
	}
</script>
