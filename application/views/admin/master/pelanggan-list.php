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
		<h2><i class="hi hi-cog"></i> <strong>DATA MASTER PELANGGAN</strong>
		</h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="example-datatable" class="table table-vcenter table-condensed table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center" style="width: 5%;">NO</th>
							<th>KODE</th>
							<th style="width: 25%;">NAMA PELANGGAN</th>
							<th style="width: 20%;">LEMBAGA</th>
							<th>JABATAN</th>
							<th class="text-center no-sort" style="width: 10%;"><i class="fa fa-cog"></i></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($data as $d) {
							$lembaga = $this->db->get_where('lembaga', array('id' => $d->id_lembaga))->result();
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?= strtoupper($d->kode); ?></td>
								<td><?= strtoupper($d->nama_pelanggan); ?></td>
								<td><?= (isset($lembaga[0]->nama_lembaga) ? $lembaga[0]->nama_lembaga : ''); ?></td>
								<td><?= $d->jabatan; ?></td>
								<td class="text-center">
									<div class="btn-group btn-group-xs">
										<a href="<?= site_url('admin/master/pelanggan/detail/' . $d->id . '/detail-pelanggan') ?>" data-toggle="tooltip" title="Detail" class="btn btn-xs btn-primary">
											<i class="fa fa-eye"></i>
										</a>
										<a href="#" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-warning edit" onclick="detail_pelanggan(<?=$d->id;?>);">
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
				<h2 class="modal-title"><i class="fa fa-user-secret"></i> Tambah Pelanggan Baru</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_add, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
				<fieldset>
					<div class="form-group">
						<label class="col-md-2 control-label" for="kode">Kode<span class="text-danger">*</span></label>
						<div class="col-md-10">
							<div class="input-group">
								<input type="text" id="kode" name="kode" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="nama_pelanggan">Nama Pelanggan <span class="text-danger">*</span></label>
						<div class="col-md-10">
							<div class="input-group">
								<input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label" for="nama_pelanggan">Lembaga <span class="text-danger">*</span></label>
						<div class="col-md-10">
							<select id="lembaga" name="lembaga" class="option-line-break chosen" style="width:100%;" placeholder="Nama Lembaga">
                                <option value="">-- Pilih Lembaga --</option>
                                <?php
                                $l = $this->db->get_where('lembaga', array('dihapus' => 'tidak'))->result();
                                foreach ($l as $lembagas) {
                                ?>
                                    <option data-description="<?= 'Kode: ' . $lembagas->kode .
                                                                    '<br>Alamat: ' . $lembagas->alamat .
                                                                    '<br>Jenjang: ' . $lembagas->jenjang .
                                                                    '<br>Status: ' . $lembagas->status .
                                                                    '<br>Klasifikasi: ' . $lembagas->klasifikasi; ?>" value="<?= $lembagas->id; ?>">
                                        <?= $lembagas->nama_lembaga; ?>
                                    </option>
                                <?php
                                }
                                ?>
                            </select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="tempat_lahir">Tempat Lahir </label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="..">
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="tanggal_lahir">Tanggal Lahir </label>
							<div class="col-md-8">
								<div class="input-group">
									<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
									<div class="input-date" data-date-format="yyy-mm-dd">
										<input type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Lahir" autocomplete="off">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="alamat">Alamat </label>
						<div class="col-md-10">
							<div class="input-group">
								<input type="text" id="alamat" name="alamat" class="form-control" placeholder="..">
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="jenis_kelamin">Jenis Kelamin</label>
							<div class="col-md-8">
								<div class="input-group">
									<select id="jenis_kelamin" name="jenis_kelamin" class="select-select2 select2" style="width:100%;">
										<option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
										<option value="perempuan">Perempuan</option>
										<option value="laki - laki">Laki - Laki</option>
									</select>
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="agama">Agama</label>
							<div class="col-md-8">
								<div class="input-group">
									<select id="agama" name="agama" class="select-select2 select2" style="width:100%;">
										<option value="" selected disabled>-- Pilih Agama --</option>
										<option value="Islam">Islam</option>
										<option value="Protestan">Protestan</option>
										<option value="Katolik">Katolik</option>
										<option value="Hindu">Hindu</option>
										<option value="Buddha">Buddha</option>
										<option value="Khonghucu">Khonghucu</option>
									</select>
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="status_perkawinan">Status Perkawinan</label>
							<div class="col-md-8">
								<div class="input-group">
									<select id="status_perkawinan" name="status_perkawinan" class="select-select2 select2" style="width:100%;">
										<option value="" selected disabled>-- Pilih Status Perkawinan --</option>
										<option value="kawin">Kawin</option>
										<option value="belum kawin">Belum Kawin</option>
									</select>
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="usia">Usia</label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="number" id="usia" name="usia" class="form-control" placeholder="..">
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="tanggal_jadi_pelanggan">Tanggal Jadi Pelanggan </label>
							<div class="col-md-8">
								<div class="input-group">
									<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
									<div class="input-date" data-date-format="yyy-mm-dd">
										<input type="text" id="tanggal_jadi_pelanggan" name="tanggal_jadi_pelanggan" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Mulai Jadi Pelanggan" autocomplete="off">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="jabatan">Jabatan </label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" id="jabatan" name="jabatan" class="form-control" placeholder="..">
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="kontak">Kontak </label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" id="kontak" name="kontak" class="form-control" placeholder="..">
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="email">Email </label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="email" id="email" name="email" class="form-control" placeholder="..">
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
					</div>

				</fieldset>
				<div class="form-group form-actions">
					<div class="col-md-12 text-center">
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
<div class="modal fade" id="FormEdit" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-pencil"></i> Edit Pelanggan</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php 
					$jk = array('perempuan', 'laki - laki');
					$list_agama = array('Islam', 'Protestan', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu');
					$list_status_kawin = array('kawin', 'belum kawin');
					echo form_open($action_edit, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_edit')); 
				?>
				<fieldset>
					<input type="hidden" name="id" class="id">
					<div class="form-group">
						<label class="col-md-2 control-label" for="kode">Kode<span class="text-danger">*</span></label>
						<div class="col-md-10">
							<div class="input-group">
								<input type="text" id="kode" name="kode" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="nama_pelanggan">Nama Pelanggan <span class="text-danger">*</span></label>
						<div class="col-md-10">
							<div class="input-group">
								<input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label" for="nama_pelanggan">Lembaga</label>
						<div class="col-md-10">
							<select id="lembaga" name="lembaga" class="lembaga select-chosen form-control" style="width:100%;" required>
								<?php
                                foreach ($l as $lembagas) {
                                ?>
                                    <option value="<?= $lembagas->id; ?>">
                                        <?= $lembagas->nama_lembaga.' (Kode: '.$lembagas->kode.')'; ?>
                                    </option>
                                <?php
                                }
                                ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="tempat_lahir">Tempat Lahir</label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="..">
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="tanggal_lahir">Tanggal Lahir </label>
							<div class="col-md-8">
								<div class="input-group">
									<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
									<div class="input-date" data-date-format="yyy-mm-dd">
										<input type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Lahir" autocomplete="off">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="alamat">Alamat </label>
						<div class="col-md-10">
							<div class="input-group">
								<input type="text" id="alamat" name="alamat" class="form-control" placeholder="..">
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="jenis_kelamin">Jenis Kelamin</label>
							<div class="col-md-8">
								<div class="input-group">
									<select id="jenis_kelamin" name="jenis_kelamin" class="form-control select-chosen" style="width:100%;">
										<option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
										<?php
										foreach ($jk as $data) :
										$selected = (($data == $jenis_kelamin) ? 'selected' : '');
										echo '<option value="' . $data . '" ' . $selected . '>'
											. strtoupper($data) .
											'</option>';
										endforeach;
										?>
									</select>
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="agama">Agama</label>
							<div class="col-md-8">
								<div class="input-group">
									<select id="agama" name="agama" class="select-chosen agama form-control" style="width:100%;">
										<option value="" disabled selected>-- Pilih Agama --</option>
										<?php
										foreach ($list_agama as $data) :
											$selected = (($data == $agama) ? 'selected' : '');
											echo '<option value="' . $data . '" ' . $selected . '>'
												. strtoupper($data) .
												'</option>';
										endforeach;
										?>
									</select>
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="status_perkawinan">Status Perkawinan</label>
							<div class="col-md-8">
								<div class="input-group">
									<select id="status_perkawinan" name="status_perkawinan" class="form-control select-chosen status_perkawinan" style="width:100%;">
										<option value="" disabled selected>-- Pilih Status Perkawinan --</option>
										<?php
										foreach ($list_status_kawin as $data) :
										$selected = (($data == $status_perkawinan) ? 'selected' : '');
										echo '<option value="' . $data . '" ' . $selected . '>'
											. strtoupper($data) .
											'</option>';
										endforeach;
										?>
									</select>
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="usia">Usia</label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="number" id="usia" name="usia" class="form-control" placeholder="..">
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="tanggal_jadi_pelanggan">Tanggal Jadi Pelanggan </label>
							<div class="col-md-8">
								<div class="input-group">
									<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
									<div class="input-date" data-date-format="yyy-mm-dd">
										<input type="text" id="tanggal_jadi_pelanggan" name="tanggal_jadi_pelanggan" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal" autocomplete="off">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="jabatan">Jabatan </label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" id="jabatan" name="jabatan" class="form-control" placeholder="..">
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="kontak">Kontak </label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="text" id="kontak" name="kontak" class="form-control" placeholder="..">
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="email">Email </label>
							<div class="col-md-8">
								<div class="input-group">
									<input type="email" id="email" name="email" class="form-control" placeholder="..">
									<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
								</div>
							</div>
						</div>
					</div>

				</fieldset>
				<div class="form-group form-actions">
					<div class="col-md-12 text-center">
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
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> Hapus Pelanggan</h2>
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
					<div class="col-md-12 text-center">
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

	function detail_pelanggan(id_pelanggan) {
        save_method = 'update';
        //$('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('admin/master/pelanggan/ajax_get_pelanggan') ?>",
            type: "POST",
            data: 'id_pelanggan=' + id_pelanggan,
            dataType: "json",
            success: function(data) {
                $('[name="id"]').val(id_pelanggan);
                $('[name="kode"]').val(data.kode);
                $('[name="nama_pelanggan"]').val(data.nama_pelanggan);
                $('[name="jabatan"]').val(data.jabatan);
                $('[name="kontak"]').val(data.kontak);
                $('[name="tempat_lahir"]').val(data.tempat_lahir);
                $('[name="tanggal_lahir"]').val(data.tanggal_lahir);
				$(".jenis_kelamin").val(data.jenis_kelamin).trigger("chosen:updated");
                $('[name="alamat"]').val(data.alamat);
				$(".agama").val(data.agama).trigger("chosen:updated");
                $('[name="tanggal_jadi_pelanggan"]').val(data.tanggal_jadi_pelanggan);
				$('[name="usia"]').val(data.usia);
                $('[name="email"]').val(data.email);
				$(".status_perkawinan").val(data.status_perkawinan).trigger("chosen:updated");
				$(".lembaga").val(data.id_lembaga).trigger("chosen:updated");
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

	//cek existing kode pelanggan
	$(document).on('blur', '#kode', function(e) {
		let kode = e.target.value;
		$.ajax({
			url: "<?php echo site_url('admin/master/pelanggan/cek_kode') ?>",
			type: "POST",
			cache: false,
			data: 'kode=' + kode,
			dataType: 'json',
			success: function(json) {
				if (json.status == 1) {
					$("#kode").val("");
					$('#ModalHeader').html('Oops !');
					$('#ModalContent').html('Maaf, Kode Pelanggan sudah tedaftar');
					$('#ModalContent').css({
						"color": "red",
					});
					$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
					$('#ModalGue').modal('show');

				}
			}
		});
	})

    $(document).ready(function() {
        $('body').tooltip({
            selector: '[data-toggle="tooltip"]'
        });
        //select 2 line break option
        function formatResult(result) {
            if (!result.id) return result.text;

            var myElement = $(result.element);

            var markup = '<div class="clearfix">' +
                '<p style="margin-bottom: 0px">' + result.text + '</p>' +
                '<p>' + $(myElement).data('description') + '</p>' +
                '</div>';

            return markup;
        }

        function formatSelection(result) {
            return result.full_name || result.text;
        }

        $(".option-line-break").select2({
            escapeMarkup: function(m) {
                return m;
            },
            closeOnSelect: false,
            templateResult: formatResult,
            templateSelection: formatSelection
        });

    });


</script>
