<!-- Quick Stats -->
<div class="row text-center">
	<div class="container">
		<div class="alert alert-info">
			<i class="fa fa-fw fa-info-circle"></i> Pilih Bulan & Tahun Terlebih Dahulu
		</div>
		<div class="col-lg-12">
			<!-- Edit Contact Block -->
			<div class="block">
				<!-- Edit Contact Title -->
				<div class="block-title">
					<h2><i class="fa fa-print"></i> Cetak Laporan Gaji</h2>
				</div>
				<!-- END Edit Contact Title -->

				<!-- Edit Contact Content -->
				<?php echo form_open($action_print, array('class' => 'form-horizontal form-bordered', 'id' => 'filter_form')); ?>
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
					<div class="text-center">
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> CETAK LAPORAN</button>
					</div>
				</div>
				<?php echo form_close(); ?>
				<!-- END Edit Contact Content -->
			</div>
			<!-- END Edit Contact Block -->
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script>
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

	})
</script>
