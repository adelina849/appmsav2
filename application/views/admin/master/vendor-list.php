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
		<h2><i class="hi hi-cog"></i> <strong>DATA MASTER SUPPLIER</strong>
		</h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="example-datatable" class="table table-vcenter table-condensed table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center" style="width: 5%;">NO</th>
							<th class="text-center" style="width: 5%;">KODE</th>
							<th>NAMA SUPPLIER</th>
							<th class="text-center" style="width: 15%;">KLASIFIKASI</th>
							<th style="width: 15%;">TELP</th>

							<th class="text-center no-sort" style="width: 10%;"><i class="fa fa-cog"></i></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($vendor as $data) {
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?= $data->kode; ?></td>
								<td><?= strtoupper($data->nama_vendor); ?></td>
								<td>
									<?php
									$klasifikasi = $this->db->get_where('vendor_klasifikasi', array('id' => $data->klasifikasi))->result();
									echo isset($klasifikasi[0]->klasifikasi) ? $klasifikasi[0]->klasifikasi : '-';
									?>
								</td>
								<td><?= $data->tlp; ?></td>

								<td class="text-center">
									<div class="btn-group btn-group-xs">
										<a href="<?= site_url('admin/master/vendor/detail/' . $data->id . '/detail-supplier') ?>" data-toggle="tooltip" title="Detail" class="btn btn-xs btn-primary">
											<i class="fa fa-eye"></i>
										</a>

										<a href="#" data_id="<?= $data->id; ?>" data_kode='<?= $data->kode ?>' data_nama_vendor='<?= strtoupper($data->nama_vendor) ?>' data_klasifikasi='<?= $data->klasifikasi ?>' data_kontak='<?= $data->kontak ?>' data_tlp='<?= $data->tlp ?>' data_email='<?= $data->email ?>' data_alamat="<?= $data->alamat ?>" data_nama_bank="<?= $data->nama_bank ?>" data_norek="<?= $data->norek ?>" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-warning edit" onclick="$('#FormEdit').modal('show');">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#" data_id="<?= $data->id; ?>" data-toggle="tooltip" title="Hapus" class="btn btn-xs btn-danger hapus" onclick="$('#FormHapus').modal('show');">
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
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-plus-circle"></i> Tambah Supplier Baru</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_add, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
				<fieldset>
					<div class="form-group">
						<label class="col-md-3 control-label" for="kode">Kode<span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="kode" name="kode" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="nama_vendor">Nama Supplier <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="nama_vendor" name="nama_vendor" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="klasifikasi">Klasifikasi <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<select id="example-select" name="klasifikasi" class="form-control" size="1">
								<option value="" selected disabled>Pilih Klasifikasi</option>
								<? foreach ($vendor_klasifikasi as $data) { ?>
									<option value="<?= $data->id ?>"><?= $data->klasifikasi ?></option>
								<? } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="kontak">Kontak <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="kontak" name="kontak" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="email">Email <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="email" name="email" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="tlp">Telepon <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="tlp" name="tlp" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="alamat">Alamat <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="alamat" name="alamat" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="nama_bank">Nama Bank <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="nama_bank" name="nama_bank" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="norek">Nomor Rekening <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="norek" name="norek" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
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
				<?php echo form_open($action_edit, array('class' => 'form-horizontal form-bordered', 'id' => '')); ?>
				<fieldset>
					<div class='formEdit'></div>
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
		id = $(this).attr("data_id");
		kode = $(this).attr("data_kode");
		nama_vendor = $(this).attr("data_nama_vendor");
		klasifikasi = $(this).attr("data_klasifikasi");
		kontak = $(this).attr("data_kontak");
		email = $(this).attr("data_email");
		tlp = $(this).attr("data_tlp");
		alamat = $(this).attr("data_alamat");
		nama_bank = $(this).attr("data_nama_bank");
		norek = $(this).attr("data_norek");

		$.ajax({
			url: "<?php echo base_url() . 'admin/master/vendor/form_edit'; ?>",
			type: "POST",
			data: "id=" + id + "&kode=" + kode + "&nama_vendor=" + nama_vendor + "&klasifikasi=" + klasifikasi + "&kontak=" + kontak + "&email=" + email + "&tlp=" + tlp + "&alamat=" + alamat + "&nama_bank=" + nama_bank + "&norek=" + norek,
			success: function(formEdit) {
				$(".formEdit").html(formEdit).show();
			}
		});
	});



	//cek existing kode vendor
	$(document).on('blur', '#kode', function(e) {
		let kode = e.target.value;
		$.ajax({
			url: "<?php echo site_url('admin/master/vendor/cek_kode') ?>",
			type: "POST",
			cache: false,
			data: 'kode=' + kode,
			dataType: 'json',
			success: function(json) {
				if (json.status == 1) {
					$("#kode").val("");
					$('#ModalHeader').html('Oops !');
					$('#ModalContent').html('Maaf, Kode Supplier sudah tedaftar');
					$('#ModalContent').css({
						"color": "red",
					});
					$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
					$('#ModalGue').modal('show');

				}
			}
		});
	})

	$(".hapus").on('click', function() {
		id = $(this).attr("data_id");
		$(".id").val(id);
	});
</script>
