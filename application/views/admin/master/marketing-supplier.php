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
		<h2><i class="hi hi-cog"></i> <strong>DATA MASTER MARKETING SUPPLIER</strong>
		</h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="example-datatable" class="table table-vcenter table-condensed table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center" style="width: 5%;">NO</th>
							<th class="text-center" style="width: 10%;">NO ID</th>
							<th style="width: 25%;">NAMA LENGKAP</th>
							<th style="width: 25%;">SUPPLIER</th>
							<th style="width: 10%;">TELP</th>
							<th style="width: 10%;">EMAIL</th>
							<th class="text-center no-sort" style="width: 10%;"><i class="fa fa-cog"></i></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$v = $this->db->get_where('vendor', array('dihapus' => 'tidak'))->result();
						$i = 1;
						foreach ($marketing as $data) {
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<td><?= $data->kode; ?></td>
								<td><?= strtoupper($data->nama_lengkap); ?></td>
								<td>
									<?php
									$supplier = $this->db->get_where('vendor', array('id' => $data->id_vendor))->result();
									echo (isset($supplier[0]->nama_vendor) ? $supplier[0]->nama_vendor : ''); 							
									?>
								</td>
								<td><?= $data->nomor_handphone; ?></td>
								<td><?= $data->email; ?></td>
								<td class="text-center">
									<div class="btn-group btn-group-xs">
										<a href="<?= site_url('admin/master/marketing_supplier/detail/' . $data->id . '/detail-mitra') ?>" data-toggle="tooltip" title="Detail" class="btn btn-xs btn-primary">
											<i class="fa fa-eye"></i>
										</a>
                                        <a href="#" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-warning edit" onclick="detail(<?=$data->id;?>);">
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
<div class="modal fade" id="modal-fadein" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-user-plus"></i> Tambah Marketing Supplier</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_add, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
				<fieldset>

					<div class="form-group">
                        <label class="col-md-4 control-label" for="kode">Kode <span class="text-danger">*</span></label>
                        <div class="col-md-4">
							<input type="text" id="kode" name="kode" class="form-control" placeholder="diisi kode marketing supplier" required>
                        </div>
                    </div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="id_vendor">Supplier</label>
						<div class="col-md-6">
							<select id="id_vendor" name="id_vendor" class="form-control select-chosen" style="width:100%;">
								<option value="" selected disabled>-- Pilih Supplier --</option>								
								<?php
                                foreach ($v as $vendor) {
                                ?>
                                    <option value="<?= $vendor->id; ?>">
                                        <?= $vendor->kode.' '.$vendor->nama_vendor; ?>
                                    </option>
                                <?php
                                }
                                ?>								
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
						<div class="col-md-6">
							<input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder=".." required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="tempat_lahir">Tempat Lahir </label>
						<div class="col-md-6">
							<input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="..">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="tanggal_lahir">Tanggal Lahir </label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
								<div class="input-date" data-date-format="yyy-mm-dd">
									<input type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Lahir" autocomplete="off">
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="tanggal_mulai_kerjasama">Tanggal Mulai Kerjasama </label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
								<div class="input-date" data-date-format="yyy-mm-dd">
									<input type="text" id="tanggal_mulai_kerjasama" name="tanggal_mulai_kerjasama" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Mulai Kerjasama" autocomplete="off">
								</div>
							</div>
						</div>
					</div>
					

					<div class="form-group">
						<label class="col-md-4 control-label" for="nomor_handphone">Nomor Handphone</label>
						<div class="col-md-6">
							<input type="text" id="nomor_handphone" name="nomor_handphone" class="form-control" placeholder="..">
						</div>
					</div>		

					<div class="form-group">
						<label class="col-md-4 control-label" for="email">Email </label>
						<div class="col-md-6">
							<input type="email" id="email" name="email" class="form-control" placeholder="..">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="alamat">Alamat</label>
						<div class="col-md-8">
							<input type="text" id="alamat" name="alamat" class="form-control" placeholder="..">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="jenis_kelamin">Jenis Kelamin</label>
							<div class="col-md-8">
								<select id="jenis_kelamin" name="jenis_kelamin" class="form-control select-chosen" style="width:100%;">
									<option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
									<option value="perempuan">Perempuan</option>
									<option value="laki - laki">Laki - Laki</option>
								</select>
							</div>
						</div>

						<div class="col-md-6">
							<label class="col-md-4 control-label" for="agama">Agama</label>
							<div class="col-md-8">
								<select id="agama" name="agama" class="form-control select-chosen" style="width:100%;">
									<option value="" selected disabled>-- Pilih Agama --</option>
									<option value="Islam">Islam</option>
									<option value="Protestan">Protestan</option>
									<option value="Katolik">Katolik</option>
									<option value="Hindu">Hindu</option>
									<option value="Buddha">Buddha</option>
									<option value="Khonghucu">Khonghucu</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="status_perkawinan">Perkawinan</label>
							<div class="col-md-8">
								<select id="status_perkawinan" name="status_perkawinan" class="form-control select-chosen" style="width:100%;">
									<option value="" selected disabled>-- Status Perkawinan --</option>
									<option value="kawin">Kawin</option>
									<option value="belum kawin">Belum Kawin</option>
								</select>
							</div>
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
				<h2 class="modal-title"><i class="fa fa-pencil"></i> Edit Marketing Supplier</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php 
				echo form_open($action_edit, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_edit')); 
				$jk = array('perempuan', 'laki - laki');
				$list_agama = array('Islam', 'Protestan', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu');
				$list_status_kawin = array('kawin', 'belum kawin');						
				?>
				<fieldset>

					<input type="hidden" name="id" class="id">
					<div class="form-group">
						<label class="col-md-4 control-label" for="kode">Kode<span class="text-danger">*</span></label>
						<div class="col-md-4">
							<input type="text" id="kode" name="kode" class="form-control" placeholder="diisi kode marketing supplier">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="id_vendor">Supplier</label>
						<div class="col-md-6">
							<select id="id_vendor" name="id_vendor" class="id_vendor form-control select-chosen" style="width:100%;">
								<option value="" selected disabled>-- Pilih Supplier --</option>								
								<?php
                                foreach ($v as $vendor) {
                                ?>
                                    <option value="<?= $vendor->id; ?>">
                                        <?= $vendor->kode.' '.$vendor->nama_vendor; ?>
                                    </option>
                                <?php
                                }
                                ?>								
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
						<div class="col-md-6">
							<input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder=".." required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="tempat_lahir">Tempat Lahir </label>
						<div class="col-md-6">
							<input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder="..">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="tanggal_lahir">Tanggal Lahir </label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
								<div class="input-date" data-date-format="yyy-mm-dd">
									<input type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Lahir" autocomplete="off">
								</div>
							</div>
						</div>
					</div>					

					<div class="form-group">
						<label class="col-md-4 control-label" for="tanggal_mulai_kerjasama">Tanggal Mulai Kerjasama </label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
								<div class="input-date" data-date-format="yyy-mm-dd">
									<input type="text" id="tanggal_mulai_kerjasama" name="tanggal_mulai_kerjasama" 
									class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Mulai Bermitra" autocomplete="off">
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nomor_handphone">Nomor Handphone </label>
						<div class="col-md-6">
							<input type="text" id="nomor_handphone" name="nomor_handphone" class="form-control" placeholder="..">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="email">Email </label>
						<div class="col-md-6">
							<input type="email" id="email" name="email" class="form-control" placeholder="..">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="alamat">Alamat </label>
						<div class="col-md-8">
							<input type="text" id="alamat" name="alamat" class="form-control" placeholder="..">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="jenis_kelamin">Jenis Kelamin</label>
							<div class="col-md-8">
								<select id="jenis_kelamin" name="jenis_kelamin" class="select-chosen form-control jenis_kelamin" style="width:100%;">
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
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="agama">Agama</label>
							<div class="col-md-8">
								<select id="agama" name="agama" class="form-control select-chosen agama" style="width:100%;">
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
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="status_perkawinan">Status Perkawinan</label>
							<div class="col-md-8">
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
							</div>
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

	function detail(id) {
        save_method = 'update';
        //$('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('admin/master/marketing_supplier/ajax_get_detail') ?>",
            type: "POST",
            data: 'id=' + id,
            dataType: "json",
            success: function(data) {

                $('[name="id"]').val(id);
                $('[name="kode"]').val(data.kode);
                $('[name="nama_lengkap"]').val(data.nama_lengkap);
                $('[name="alamat"]').val(data.alamat);
                $('[name="tanggal_mulai_kerjasama"]').val(data.tanggal_mulai_kerjasama);
                $('[name="tempat_lahir"]').val(data.tempat_lahir);
                $('[name="tanggal_lahir"]').val(data.tanggal_lahir);
                $('[name="nomor_handphone"]').val(data.nomor_handphone);
                $('[name="email"]').val(data.email);
				$(".jenis_kelamin").val(data.jenis_kelamin).trigger("chosen:updated");
				$(".agama").val(data.agama).trigger("chosen:updated");
				$(".status_perkawinan").val(data.status_perkawinan).trigger("chosen:updated");
				$(".id_vendor").val(data.id_vendor).trigger("chosen:updated");
								
                $('#FormEdit').modal('show'); 

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

	//cek existing kode marketing
	$(document).on('blur', '#nomor_id', function(e) {
		let nomor_id = e.target.value;
		$.ajax({
			url: "<?php echo site_url('admin/master/marketing_supplier/cek_kode') ?>",
			type: "POST",
			cache: false,
			data: 'nomor_id=' + nomor_id,
			dataType: 'json',
			success: function(json) {
				if (json.status == 1) {
					$("#nomor_id").val("");
					$('#ModalHeader').html('Oops !');
					$('#ModalContent').html('Maaf, Nomor ID Marketing sudah tedaftar');
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
