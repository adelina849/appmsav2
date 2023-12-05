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
		<h2><i class="hi hi-cog"></i> <strong>DATA MASTER PERUSAHAAN PELAKSANA</strong>
		</h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="example-datatable" class="table table-vcenter table-condensed table-bordered table-hover">
					<thead>
						<tr>
							<th class="text-center" style="width: 5%;">NO</th>
							<th>NAMA PELAKSANA</th>
							<th>NAMA DIREKTUR</th>
							<th>KONTAK</th>
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
								<td><?= strtoupper($d->nama_cv); ?></td>
								<td><?= strtoupper($d->direktur); ?></td>
								<td><?= strtoupper($d->kontak); ?></td>
								<td class="text-center">
									<div class="btn-group btn-group-xs">
										<a href="<?= site_url('admin/master/pelaksana/detail/' . $d->id . '/detail-perusahaan-pelaksana') ?>" data-toggle="tooltip" title="Detail" class="btn btn-xs btn-primary">
											<i class="fa fa-eye"></i>
										</a>										
										<a href="#" data-toggle="tooltip" title="Edit" class="btn btn-xs btn-warning edit" onclick="detail_pelaksana(<?=$d->id;?>);">
											<i class="fa fa-pencil"></i>
										</a>
										<a href="#" data_id="<?= $d->id; ?>" data-toggle="tooltip" title="Hapus Pelaksana" class="btn btn-xs btn-danger hapus" onclick="$('#FormHapus').modal('show');">
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
				<h2 class="modal-title"><i class="fa fa-plus-circle"></i> Tambah Perusahaan Pelaksana</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_add, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
				<fieldset>

					<div class="form-group">
						<label class="col-md-4 control-label" for="kode">Kode <span class="text-danger">*</span></label>
						<div class="col-md-6">
							<input type="text" id="kode" name="kode" class="form-control" placeholder=".." required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="pelaksana">Nama Perusahaan <span class="text-danger">*</span></label>
						<div class="col-md-6">
							<input type="text" id="pelaksana" name="pelaksana" class="form-control" placeholder=".." required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="kontak">Kontak</label>
						<div class="col-md-6">
							<input type="text" id="kontak" name="kontak" class="form-control">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label" for="direktur">Direktur</label>
						<div class="col-md-6">
							<input type="text" id="direktur" name="direktur" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="alamat">Alamat </label>
						<div class="col-md-6">
							<input type="text" id="alamat" name="alamat" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="komanditer">Komanditer </label>
						<div class="col-md-6">
							<input type="text" id="komanditer" name="komanditer" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nomor_akta">Nomor Akta</label>
						<div class="col-md-6">
							<input type="text" id="nomor_akta" name="nomor_akta" class="form-control" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="tanggal_akta">Tanggal Akta </label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
								<div class="input-date" data-date-format="yyy-mm-dd">
									<input type="text" id="tanggal_akta" name="tanggal_akta" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" autocomplete="off">
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nama_notaris">Nama Notaris </label>
						<div class="col-md-6">
							<input type="text" id="nama_notaris" name="nama_notaris" class="form-control" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="presentase_direktur">Presentase Direktur</label>
						<div class="col-md-6">
							<input type="text" id="presentase_direktur" name="presentase_direktur" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="presentase_komanditer">Presentase Komanditer</label>
						<div class="col-md-6">
							<input type="text" id="presentase_komanditer" name="presentase_komanditer" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nomor_perubahan">Nomor Perubahan</label>
						<div class="col-md-6">
							<input type="text" id="nomor_perubahan" name="nomor_perubahan" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="tanggal_perubahan">Tanggal Perubahan </label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
								<div class="input-date" data-date-format="yyy-mm-dd">
									<input type="text" id="tanggal_perubahan" name="tanggal_perubahan" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" autocomplete="off">
								</div>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label" for="direktur_perubahan">Direktur Perubahan</label>
						<div class="col-md-6">
							<input type="text" id="direktur_perubahan" name="direktur_perubahan" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="komanditer_perubahan">Komanditer Perubahan</label>
						<div class="col-md-6">
							<input type="text" id="komanditer_perubahan" name="komanditer_perubahan" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="notaris">Nama Notaris Perubahan</label>
						<div class="col-md-6">
							<input type="text" id="notaris" name="notaris" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nib">Nomor Induk Berusaha(NIB) </label>
						<div class="col-md-6">
							<input type="text" id="nib" name="nib" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="email">Email</label>
						<div class="col-md-6">
							<input type="email" id="email" name="email" class="form-control">
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
<div class="modal fade" id="FormEdit" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-pencil"></i> Edit Pelaksana</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_edit, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_edit')); ?>
				<fieldset>

					<input type="hidden" name="id" class="id">

					<div class="form-group">
						<label class="col-md-4 control-label" for="kode">Kode <span class="text-danger">*</span></label>
						<div class="col-md-6">
							<input type="text" id="kode" name="kode" class="form-control" placeholder=".." required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="pelaksana">Nama Perusahaan <span class="text-danger">*</span></label>
						<div class="col-md-6">
							<input type="text" id="pelaksana" name="pelaksana" class="form-control" placeholder=".." required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="kontak">Kontak</label>
						<div class="col-md-6">
							<input type="text" id="kontak" name="kontak" class="form-control">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label" for="direktur">Direktur</label>
						<div class="col-md-6">
							<input type="text" id="direktur" name="direktur" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="alamat">Alamat </label>
						<div class="col-md-6">
							<input type="text" id="alamat" name="alamat" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="komanditer">Komanditer </label>
						<div class="col-md-6">
							<input type="text" id="komanditer" name="komanditer" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nomor_akta">Nomor Akta</label>
						<div class="col-md-6">
							<input type="text" id="nomor_akta" name="nomor_akta" class="form-control" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="tanggal_akta">Tanggal Akta </label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
								<div class="input-date" data-date-format="yyy-mm-dd">
									<input type="text" id="tanggal_akta" name="tanggal_akta" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" autocomplete="off">
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nama_notaris">Nama Notaris </label>
						<div class="col-md-6">
							<input type="text" id="nama_notaris" name="nama_notaris" class="form-control" >
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="presentase_direktur">Presentase Direktur</label>
						<div class="col-md-6">
							<input type="text" id="presentase_direktur" name="presentase_direktur" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="presentase_komanditer">Presentase Komanditer</label>
						<div class="col-md-6">
							<input type="text" id="presentase_komanditer" name="presentase_komanditer" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nomor_perubahan">Nomor Perubahan</label>
						<div class="col-md-6">
							<input type="text" id="nomor_perubahan" name="nomor_perubahan" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="tanggal_perubahan">Tanggal Perubahan </label>
						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
								<div class="input-date" data-date-format="yyy-mm-dd">
									<input type="text" id="tanggal_perubahan" name="tanggal_perubahan" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" autocomplete="off">
								</div>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label" for="direktur_perubahan">Direktur Perubahan</label>
						<div class="col-md-6">
							<input type="text" id="direktur_perubahan" name="direktur_perubahan" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="komanditer_perubahan">Komanditer Perubahan</label>
						<div class="col-md-6">
							<input type="text" id="komanditer_perubahan" name="komanditer_perubahan" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="notaris">Nama Notaris Perubahan</label>
						<div class="col-md-6">
							<input type="text" id="notaris" name="notaris" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="nib">Nomor Induk Berusaha(NIB) </label>
						<div class="col-md-6">
							<input type="text" id="nib" name="nib" class="form-control">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="email">Email</label>
						<div class="col-md-6">
							<input type="email" id="email" name="email" class="form-control">
						</div>
					</div>




				</fieldset>
				<div class="form-group form-actions">
					<div class="col-xs-12 text-center">
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
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> Hapus Pelaksana</h2>
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
	


	function detail_pelaksana(id_pelaksana) {
        save_method = 'update';
        //$('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('admin/master/pelaksana/ajax_get_pelaksana') ?>",
            type: "POST",
            data: 'id_pelaksana=' + id_pelaksana,
            dataType: "json",
            success: function(data) {						
                $('[name="id"]').val(id_pelaksana);
                $('[name="kode"]').val(data.kode);
                $('[name="pelaksana"]').val(data.nama_cv);
                $('[name="alamat"]').val(data.alamat);
                $('[name="kontak"]').val(data.kontak);
                $('[name="direktur"]').val(data.direktur);
                $('[name="komanditer"]').val(data.komanditer);
                $('[name="nomor_akta"]').val(data.nomor_akta);
                $('[name="tanggal_akta"]').val(data.tanggal_akta);
                $('[name="nama_notaris"]').val(data.nama_notaris);              
                $('[name="presentase_direktur"]').val(data.presentase_direktur);
                $('[name="presentase_komanditer"]').val(data.presentase_komanditer);
                $('[name="tanggal_perubahan"]').val(data.tanggal_perubahan);
                $('[name="direktur_perubahan"]').val(data.direktur_perubahan);
                $('[name="komanditer_perubahan"]').val(data.komanditer_perubahan);
                $('[name="notaris"]').val(data.notaris);
                $('[name="nib"]').val(data.nib);
                $('[name="email"]').val(data.email);

				//$(".jenis_kelamin").val(data.jenis_kelamin).trigger("chosen:updated");
								
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
