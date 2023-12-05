<!-- All Orders Block -->
<style>
	.table th {
		font-size: 5px;
	}
</style>
<div class="block full">

	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="gi gi-message_plus animation-pulse"></i> <strong>Input Karyawan Baru</strong></h2>
		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/master/pengguna/daftar'); ?>" class="" data-toggle="tooltip" title="Daftar Karyawan">
				<i class="fa fa-list-alt"></i> Daftar Karyawan
			</a>
		</div>
	</div>
	<!-- END All Orders Title -->
	<?php echo form_open($action_add, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation', 'enctype' => 'multipart/form-data')); ?>
	<fieldset>
		<div class="form-group">
			<label class="col-md-2 control-label text-left" for="idpengguna">ID Pengguna<span class="text-danger">*</span></label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" id="idpengguna" value="<?= $generate_kode ?>" name="idpengguna" class="form-control" placeholder=".." readonly required>
					<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="nik">NIK <span class="text-danger">*</span></label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" id="nik" name="nik" class="form-control" placeholder=".." required>
					<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" placeholder=".." required>
					<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
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
			<label class="col-md-2 control-label" for="alamat">Alamat <span class="text-danger">*</span></label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" id="alamat" name="alamat" class="form-control" placeholder=".." required>
					<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="jenis_kelamin">Jenis Kelamin<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<select id="jenis_kelamin" name="jenis_kelamin" class="select-select2 select2" style="width:100%;" required>
							<option value="" selected disabled>-- Pilih Jenis Kelamin --</option>
							<option value="perempuan">Perempuan</option>
							<option value="laki - laki">Laki - Laki</option>
						</select>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="agama">Agama<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<select id="agama" name="agama" class="select-select2 select2" style="width:100%;" required>
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
				<label class="col-md-4 control-label" for="tanggal_mulai_kerja">Tanggal Mulai Kerja <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
						<div class="input-date" data-date-format="yyy-mm-dd">
							<input type="text" id="tanggal_mulai_kerja" name="tanggal_mulai_kerja" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Mulai Kerja" autocomplete="off">
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="id_jabatan">Jabatan <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<select id="id_jabatan" name="id_jabatan" class="select-select2 select2" style="width:100%;" required>
							<option value="" selected disabled>-- Pilih Jabatan --</option>
							<?
							foreach ($jabatan as $j) { ?>
								<option value="<?= $j->id ?>"><?= $j->nama_jabatan ?></option>
							<? } ?>
						</select>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="status_perkawinan">Status Perkawinan<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<select id="status_perkawinan" name="status_perkawinan" class="select-select2 select2" style="width:100%;" required>
							<option value="" selected disabled>-- Pilih Status Perkawinan --</option>
							<option value="kawin">Kawin</option>
							<option value="belum kawin">Belum Kawin</option>
						</select>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="status_karyawan">Status Karyawan <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<select id="status_karyawan" name="status_karyawan" class="select-select2 select2" style="width:100%;" required>
							<option value="" selected disabled>-- Pilih Status Karyawan --</option>
							<option value="tetap">Tetap</option>
							<option value="tidak tetap">Tidak Tetap</option>
						</select>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="email">Email <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="email" id="email" name="email" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="nomor_hp">No Telepon <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" id="nomor_hp" name="nomor_hp" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="usia">Usia<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="number" id="usia" name="usia" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="pendidikan_terakhir">Pendidikan Terakhir <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<select id="pendidikan_terakhir" name="pendidikan_terakhir" class="select-select2 select2" style="width:100%;" required>
							<option value="" selected disabled>-- Pilih Pendidikan Terakhir --</option>
							<option value="Tidak / Belum Sekolah">Tidak / Belum Sekolah</option>
							<option value="BELUM TAMAT SD/SEDERAJAT">BELUM TAMAT SD/SEDERAJAT</option>
							<option value="TAMAT SD / SEDERAJAT">TAMAT SD / SEDERAJAT</option>
							<option value="BELUM TAMAT SLTP/SEDERAJAT">BELUM TAMAT SLTP/SEDERAJAT</option>
							<option value="TAMAT SLTP/SEDERAJAT">TAMAT SLTP/SEDERAJAT</option>
							<option value="BELUM TAMAT SLTA/SEDERAJAT">BELUM TAMAT SLTA/SEDERAJAT</option>
							<option value="TAMAT SLTA/SEDERAJAT">TAMAT SLTA/SEDERAJAT</option>
							<option value="AKADEMI/ DIPLOMA III/S. MUDA">AKADEMI/ DIPLOMA III/S. MUDA</option>
							<option value="	DIPLOMA I / II"> DIPLOMA I / II</option>
							<option value="DIPLOMA IV/ STRATA I">DIPLOMA IV/ STRATA I</option>
							<option value="STRATA II">STRATA II</option>
							<option value="STRATA III">STRATA III</option>
						</select>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="npwp_karyawan">NPWP Karyawan<span class="text-danger">*</span></label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" id="npwp_karyawan" name="npwp_karyawan" class="form-control" placeholder=".." required>
					<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="status_bpjs_tk">Status BPJS Ketenagakerjaan<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" id="status_bpjs_tk" name="status_bpjs_tk" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="nomor_bpjs_tk">Nomor BPJS Ketenagakerjaan<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" id="nomor_bpjs_tk" name="nomor_bpjs_tk" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="status_bpjs_kesehatan">Status BPJS Kesehatan<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" id="status_bpjs_kesehatan" name="status_bpjs_kesehatan" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="nomor_bpjs_kesehatan">Nomor BPJS Kesehatan<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" id="nomor_bpjs_kesehatan" name="nomor_bpjs_kesehatan" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="photo">Photo Karyawan</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="file" id="photo" name="photo" class="form-control" accept="image/png, image/jpeg, image/jpg, image/gif">
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

</div>
<!-- END All Orders Block -->
<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
