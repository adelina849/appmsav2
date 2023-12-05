<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">

		<div class="block-options pull-right" style="margin-right: 15px;">
			<span data-toggle="modal" data-target="#modal-fadein">
				<button type="button" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Tambah Data Baru">
					<i class="fa fa-plus"></i> Tambah
				</button>
			</span>
		</div>
		<h2><i class="hi hi-cog"></i> <strong>DATA MASTER SUPPLIER KLASIFIKASI</strong>
		</h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="example-datatable" class="table table-vcenter table-condensed table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center" style="width: 5%;">NO</th>
							<th>KLASIFIKASI</th>
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
								<td><?= strtoupper($d->klasifikasi); ?></td>
								<td class="text-center">
									<div class="btn-group btn-group-xs">
										<a href="#" data_id="<?= $d->id; ?>" data_klasifikasi='<?= strtoupper($d->klasifikasi); ?>' data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default edit" onclick="$('#FormEdit').modal('show');">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#" data_id="<?= $d->id; ?>" data-toggle="tooltip" title="Hapus Klasifikasi" class="btn btn-xs btn-danger hapus" onclick="$('#FormHapus').modal('show');">
											<i class="fa fa-trash-o"></i>
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

<!-- Modal Tambah-->
<div class="modal fade" id="modal-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-plus-circle"></i> Tambah Supplier Klasifikasi Baru</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_add, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
				<fieldset>

					<div class="form-group">
						<label class="col-md-3 control-label" for="klasifikasi">Nama Klasifikasi <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="klasifikasi" name="klasifikasi" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>

				</fieldset>
				<div class="form-group form-actions">
					<div class="col-md-8 col-md-offset-4 text-right">
						<button type="reset" class="btn btn-sm btn-warning" data-dismiss="modal"><i class="fa fa-repeat"></i> Batal</button>
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
					</div>
				</div>
				<?php echo form_close(); ?>
				<!-- END Form Validation Example Content -->
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
<!-- END Modal Tambah-->

<!-- Modal edit-->
<div class="modal fade" id="FormEdit" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-pencil"></i> Edit Klasifikasi</h2>
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

<!--HAPUS  -->
<div id="FormHapus" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> Hapus Klasifikasi</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_delete, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_delete')); ?>
				<input type="hidden" name="id" class="id">
				<fieldset>
					<div class="form-group" style="margin:0 20px 0 20px">
						<div class="alert alert-warning alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="gi gi-circle_exclamation_mark"></i> Warning!</h4>
							Semua Data terkait akan dihapus, Apakah anda yakin?
						</div>
					</div>
				</fieldset>
				<div class="form-group form-actions">
					<div class="col-xs-12 text-center">
						<button type="reset" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-sm btn-primary">Hapus</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
<!-- END HAPUS -->

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script>
	$(".edit").on('click', function() {
		id = $(this).attr("data_id");
		klasifikasi = $(this).attr("data_klasifikasi");

		//$(".id_barang").val(id_barang); //harus ada minimal id

		$.ajax({
			url: "<?php echo base_url() . 'admin/master/vendor_klasifikasi/form_edit'; ?>",
			type: "POST",
			data: "id=" + id + "&klasifikasi=" + klasifikasi,
			success: function(formEdit) {
				$(".formEdit").html(formEdit).show();
			}
		});
	});
	$(".hapus").on('click', function() {
		id = $(this).attr("data_id");
		$(".id").val(id);
	});
</script>
