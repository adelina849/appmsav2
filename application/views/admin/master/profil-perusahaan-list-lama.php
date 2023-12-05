<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong>PROFIL PERUSAHAAN</strong>
		</h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="example-datatable" class="table table-vcenter table-condensed table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center" style="width: 5%;">NO</th>
							<th>NAMA PERUSAHAAN</th>
							<th>ALAMAT</th>
							<th>WEBSITE</th>
							<th>EMAIL</th>
							<th>TLP</th>
							<th>NPWP</th>
							<th class="text-center no-sort" style="width: 10%;"><i class="fa fa-cog"></i></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($data as $d) {
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?= strtoupper($d->nama_perusahaan); ?></td>
								<td><?= $d->alamat; ?></td>
								<td><?= $d->website; ?></td>
								<td><?= $d->email; ?></td>
								<td><?= $d->tlp; ?></td>
								<td><?= $d->npwp; ?></td>
								<td class="text-center">
									<div class="btn-group btn-group-xs">
										<a href="#" data_id="<?= $d->id; ?>" data_nama_perusahaan='<?= strtoupper($d->nama_perusahaan); ?>' data_alamat='<?= $d->alamat ?>' data_website='<?= $d->website ?>' data_email='<?= $d->email ?>' data_website='<?= strtoupper($d->website); ?>' data_tlp='<?= $d->tlp ?>' data_npwp='<?= strtoupper($d->npwp); ?>' data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default edit" onclick="$('#FormEdit').modal('show');">
											<i class="fa fa-pencil"></i>
										</a>
									</div>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal edit-->
<div class="modal fade" id="FormEdit" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-pencil"></i> Edit Profil Perusahaan</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_edit, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_edit')); ?>
				<fieldset>
					<div class='formEdit'></div>
				</fieldset>
				<div class="form-group form-actions">
					<div class="col-xs-12 text-right">
						<button type="reset" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-sm btn-primary">Simpan</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
<!-- END Modal edit-->

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script>
	$(".edit").on('click', function() {
		id = $(this).attr("data_id");
		nama_perusahaan = $(this).attr("data_nama_perusahaan");
		alamat = $(this).attr("data_alamat");
		website = $(this).attr("data_website");
		email = $(this).attr("data_email");
		tlp = $(this).attr("data_tlp");
		npwp = $(this).attr("data_npwp");

		$.ajax({
			url: "<?php echo base_url() . 'admin/master/profil_perusahaan/form_edit'; ?>",
			type: "POST",
			data: "id=" + id + "&nama_perusahaan=" + nama_perusahaan + "&alamat=" + alamat + "&website=" + website + "&email=" + email + "&tlp=" + tlp + "&npwp=" + npwp,
			success: function(formEdit) {
				$(".formEdit").html(formEdit).show();
			}
		});
	});
</script>
