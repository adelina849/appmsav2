<!-- Quick Stats -->
<div class="row text-center">
	<div class="col-sm-6 col-lg-3">
		<a href="#" class="widget widget-hover-effect2" data-toggle="modal" data-target="#modal-fadein">
			<div class="widget-extra themed-background-dark">
				<h4 class="widget-content-light"><strong>Tambah</strong> Barang</h4>
			</div>
			<div class="widget-extra-full"><span class="h2 text-success animation-expandOpen"><i class="fa fa-plus"></i></span></div>
		</a>
	</div>
	<div class="col-sm-6 col-lg-3">
		<a href="javascript:void(0)" class="widget widget-hover-effect2">
			<div class="widget-extra themed-background-danger">
				<h4 class="widget-content-light"><strong>Kurang</strong> Laku</h4>
			</div>
			<div class="widget-extra-full"><span class="h2 text-danger animation-expandOpen">155</span></div>
		</a>
	</div>
	<div class="col-sm-6 col-lg-3">
		<a href="javascript:void(0)" class="widget widget-hover-effect2">
			<div class="widget-extra themed-background-success">
				<h4 class="widget-content-light"><strong>Paling</strong> Laku</h4>
			</div>
			<div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">2</span></div>
		</a>
	</div>
	<div class="col-sm-6 col-lg-3">
		<a href="javascript:void(0)" class="widget widget-hover-effect2">
			<div class="widget-extra themed-background-info">
				<h4 class="widget-content-light"><strong>Semua</strong> Barang</h4>
			</div>
			<div class="widget-extra-full"><span class="h2 themed-color-dark animation-expandOpen">2747</span></div>
		</a>
	</div>
</div>
<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<div class="block-options pull-right" style="margin-right: 15px;">
			<span data-toggle="modal" data-target="#modal-fadein">
				<button type="button" class="btn btn-alt btn-sm btn-primary" data-toggle="tooltip" title="Tambah Data Baru">
					<i class="fa fa-plus-circle"></i> Tambah Data
				</button>
			</span>
		</div>
		<h2><i class="hi hi-cog"></i> <strong>DATA MASTER BARANG</strong>
		</h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="example-datatable" class="table table-vcenter table-condensed table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center" style="width: 5%;">NO</th>
							<th style="width: 5%;">KODE</th>
							<th>NAMA BARANG</th>
							<th style="width: 10%;">SATUAN</th>
							<th style="width: 10%;">HARGA JUAL</th>
							<th class="text-center no-sort" style="width: 10%;"><i class="fa fa-cog"></i></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($barang as $data) {
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?= $data->kode; ?></td>
								<td><?= strtoupper($data->nama_barang); ?></td>
								<td><?= $data->satuan; ?></td>
								<td><?= str_replace(',', '.', number_format($data->harga_jual));; ?></td>
								<td class="text-center">
									<div class="btn-group btn-group-xs">
										<a href="#" data_id_ruangan="<?= $data->id; ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-default edit" onclick="$('#FormEdit').modal('show');">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#" data_id_ruangan="<?= $data->id; ?>" data-toggle="tooltip" title="Hapus" class="btn btn-xs btn-default hapus" onclick="$('#FormHapus').modal('show');">
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
	<!-- END row -->
	<!-- END block-->
</div>

<!-- Modal Tambah-->
<div class="modal fade" id="modal-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-plus-circle"></i> Tambah Data</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_add, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
				<fieldset>

				</fieldset>
				<div class="form-group form-actions">
					<div class="col-md-12 text-center">
						<button type="reset" class="btn btn-sm btn-default" data-dismiss="modal"><i class="fa fa-repeat"></i> Batal</button>
						<button type="submit" class="btn btn-sm btn-info"><i class="fa fa-save"></i> Simpan</button>
					</div>
				</div>
				<?php echo form_close(); ?>
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
				<h2 class="modal-title"><i class="fa fa-pencil"></i> Edit Data</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_edit, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
				<fieldset>
					<input type="hidden" name="id" class="id">

				</fieldset>
				<div class="form-group form-actions">
					<div class="col-md-12 text-center">
						<button type="reset" class="btn btn-sm btn-default" data-dismiss="modal"><i class="fa fa-repeat"></i> Batal</button>
						<button type="submit" class="btn btn-sm btn-info"><i class="fa fa-save"></i> Simpan</button>
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
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> Hapus Data</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_delete, array('class' => 'form-horizontal form-bordered"', 'id' => '')); ?>
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
		id = $(this).attr("data_id_ruangan");
		id_gedung = $(this).attr("data_id_gedung");
		//gedung = $(this).attr("data_gedung");
		ruangan = $(this).attr("data_ruangan");

		$(".id").val(id);
		$(".id_gedung").val(id_gedung).trigger("chosen:updated");
		//$(".gedung").val(gedung);
		//val(str_array[i]).trigger("chosen:updated")
		$(".ruangan").val(ruangan);
	});

	$(".hapus").on('click', function() {
		id = $(this).attr("data_id_ruangan");
		$(".id").val(id);
	});
</script>
