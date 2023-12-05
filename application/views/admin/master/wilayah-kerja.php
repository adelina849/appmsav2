<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<div class="block-options pull-right" style="margin-right: 15px;">
			<span data-toggle="modal" data-target="#modal-fadein">
				<button type="button" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Tambah Data Baru">
					<i class="fa fa-plus-circle"></i> Tambah
				</button>
			</span>
		</div>
		<h2><i class="hi hi-cog"></i> <strong>DATA MASTER WILAYAH</strong>
		</h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="example-datatable" class="table table-vcenter table-condensed table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center" style="width: 5%;">NO</th>
							<th style="width: 15%;">KODE</th>
							<th>KABUPATEN</th>
							<th>PROVINSI</th>
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
								<td><?= $d->kode; ?></td>
								<td><?= $d->nama; ?></td>
								<td><?= $d->provinsi; ?></td>
								<td class="text-center">
									<div class="btn-group btn-group-xs">
										<a href="#" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-warning edit" onclick="detail_dana(<?=$d->id;?>);">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#" data_id="<?= $d->id; ?>" data-toggle="tooltip" title="Hapus Data" class="btn btn-xs btn-danger hapus" onclick="$('#FormHapus').modal('show');">
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
<div class="modal fade" id="modal-fadein" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-map-marker"></i> Wilayah Kerja</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_add, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
				<fieldset>

					<div class="form-group">
                        <label class="col-md-4 control-label" for="kode">Kode Wilayah<span class="text-danger">*</span></label>
                        <div class="col-md-4">
							<input type="text" name="kode" class="form-control" placeholder="" required>
                        </div>
                    </div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nama">Nama Kabupaten</label>
						<div class="col-md-6">
							<input type="text" id="nama" name="nama" class="form-control" required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="provinsi">Nama Provinsi</label>
						<div class="col-md-6">
							<input type="text" id="provinsi" name="provinsi" class="form-control" required>
						</div>
					</div>

				</fieldset>
				<div class="form-group form-actions">
					<div class="col-md-12 text-center">
						<button type="reset" class="btn btn-sm btn-default" data-dismiss="modal"><i class="fa fa-repeat"></i> Batal</button>
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
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-pencil"></i> Edit Wilayah Kerja</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php 
				echo form_open($action_edit, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_edit')); 
				?>
				<fieldset>

					<input type="hidden" name="id" class="id">
					<input type="hidden" name="kode_lama" class="kode">

					<div class="form-group">
                        <label class="col-md-4 control-label" for="kode">Kode Wilayah<span class="text-danger">*</span></label>
                        <div class="col-md-4">
							<input type="text" name="kode" class="form-control" placeholder="" required>
                        </div>
                    </div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nama">Nama Kabupaten</label>
						<div class="col-md-6">
							<input type="text" id="nama" name="nama" class="form-control" required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="provinsi">Nama Provinsi</label>
						<div class="col-md-6">
							<input type="text" id="provinsi" name="provinsi" class="form-control" required>
						</div>
					</div>
					
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
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> Hapus</h2>
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

	function detail_dana(id) {
        save_method = 'update';
        //$('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('admin/master/wilayah/ajax_get_wilayah') ?>",
            type: "POST",
            data: 'id=' + id,
            dataType: "json",
            success: function(data) {

                $('[name="id"]').val(id);
                $('[name="kode"]').val(data.kode);
                $('[name="kode_lama"]').val(data.kode);
                $('[name="nama"]').val(data.nama);
                $('[name="provinsi"]').val(data.provinsi);
								
                $('#FormEdit').modal('show'); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

	$(".hapus").on('click', function() {
		id = $(this).attr("data_id");
		$(".id").val(id);
	});
</script>
