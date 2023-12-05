<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">

		<div class="block-options pull-right" style="margin-right: 15px;">
			<span data-toggle="modal" data-target="#modal-fadein">
				<a href="<?= site_url('admin/master/pengguna/form_pengguna') ?>" type="button" class="btn btn-alt btn-sm btn-primary" data-toggle="tooltip" title="Tambah Karyawan Baru">
					<i class="fa fa-plus-circle"></i> Tambah Karyawan
				</a>
			</span>
		</div>
		<h2><i class="hi hi-cog"></i> <strong>DATA MASTER KARYAWAN</strong>
		</h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="example-datatable" class="table table-vcenter table-condensed table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center" style="width: 5%;">NO</th>
							<th style="width: 10%;">ID AKUN</th>
							<th style="width: 15%;">NIK</th>
							<th style="width: 25%;">NAMA LENGKAP</th>
							<th style="width: 10%;">JABATAN</th>
							<th>ALAMAT</th>
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
								<td><?= strtoupper($d->idpengguna); ?></td>
								<td><?= $d->nik; ?></td>
								<td><?= strtoupper($d->nama_lengkap); ?></td>
								<td>
									<?php
									$jabatan = $this->db->get_where('jabatan', array('id' => $d->id_jabatan))->result();
									echo isset($jabatan[0]->nama_jabatan) ? $jabatan[0]->nama_jabatan : '-';
									?>
								</td>
								<td><?= $d->alamat ?></td>

								<td class="text-center">
									<div class="btn-group btn-group-xs">
										<a href="<?= site_url('admin/master/pengguna/detail/' . $d->idpengguna . '/karyawan') ?>" title="Detail" class="btn btn-xs btn-primary">
											<i class="fa fa-eye"></i>
										</a>
										<a href="<?= site_url('admin/master/pengguna/edit_form/' . $d->idpengguna . '/ubah') ?>" title="Edit" class="btn btn-xs btn-warning edit">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#" data_id="<?= $d->idpengguna; ?>" data_photo="<?= $d->photo ?>" data-toggle="tooltip" title="Hapus Data" class="btn btn-xs btn-danger hapus" onclick="$('#FormHapus').modal('show');">
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

<!--HAPUS  -->
<div id="FormHapus" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> Hapus Pengguna</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_delete, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_delete')); ?>
				<input type="hidden" name="idpengguna" class="id">
				<input type="hidden" name="photo" class="photo">
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
	$(".hapus").on('click', function() {
		id = $(this).attr("data_id");
		$(".id").val(id);
		photo = $(this).attr("data_photo");
		$(".photo").val(photo);
	});
</script>
