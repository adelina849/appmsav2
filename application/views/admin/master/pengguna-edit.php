<!-- All Orders Block -->
<style>
	.table th {
		font-size: 5px;
	}
</style>
<div class="block full">

	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="gi gi-message_plus animation-pulse"></i> <strong>Edit Data Karyawan</strong></h2>
		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/master/pengguna/daftar'); ?>" class="" data-toggle="tooltip" title="Daftar Barang">
				<i class="fa fa-list-alt"></i> Daftar Karyawan
			</a>
		</div>
	</div>
	<!-- END All Orders Title -->

	<?php echo form_open($action_edit, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation', 'enctype' => 'multipart/form-data')); ?>
	<fieldset>
		<div class="form-group">
			<input type="hidden" id="idpengguna" value="<?= $karyawan[0]->idpengguna ?>" name="idpengguna" class="form-control" placeholder=".." required>
			<div class="form-group">
				<label class="col-md-2 control-label" for="id_pengguna">ID Pengguna <span class="text-danger">*</span></label>
				<div class="col-md-10">
					<input type="text" id="id_pengguna" value="<?= $karyawan[0]->idpengguna ?>" name="kode_barang" class="form-control" placeholder=".." required readonly>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="nik">NIK <span class="text-danger">*</span></label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" id="nik" value="<?= $karyawan[0]->nik ?>" name="nik" class="form-control" placeholder=".." required>
					<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="nama_lengkap">Nama Lengkap <span class="text-danger">*</span></label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" id="nama_lengkap" value="<?= $karyawan[0]->nama_lengkap ?>" name="nama_lengkap" class="form-control" placeholder=".." required>
					<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="tempat_lahir">Tempat Lahir <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" id="tempat_lahir" value="<?= $karyawan[0]->tempat_lahir ?>" name="tempat_lahir" class="form-control" placeholder=".." required>
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
							<input type="text" id="tanggal_lahir" value="<?= $karyawan[0]->tanggal_lahir ?>" name="tanggal_lahir" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Lahir" autocomplete="off">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label" for="alamat">Alamat <span class="text-danger">*</span></label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" id="alamat" name="alamat" value="<?= $karyawan[0]->alamat ?>" class="form-control" placeholder=".." required>
					<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="jenis_kelamin">Jenis Kelamin<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<?php $jenis_kelamin = array('perempuan', 'laki - laki') ?>
						<select id="jenis_kelamin" value="<?= $karyawan[0]->jenis_kelamin ?>" name="jenis_kelamin" class="select-select2 select2" style="width:100%;">
							<option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
							<?
							foreach ($jenis_kelamin as $data) :
								$selected = (($data == $karyawan[0]->jenis_kelamin) ? 'selected' : '');
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
				<label class="col-md-4 control-label" for="agama">Agama<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<?php $agama = array('Islam', 'Protestan', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu') ?>
						<select id="agama" value="<?= $karyawan[0]->agama ?>" name="agama" class="select-select2 select2" style="width:100%;">
							<option value="" disabled selected>-- Pilih Agama --</option>
							<?
							foreach ($agama as $data) :
								$selected = (($data == $karyawan[0]->agama) ? 'selected' : '');
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
				<label class="col-md-4 control-label" for="tanggal_mulai_kerja">Tanggal Mulai Kerja <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
						<div class="input-date" data-date-format="yyy-mm-dd">
							<input type="text" id="tanggal_mulai_kerja" value="<?= $karyawan[0]->tanggal_mulai_kerja ?>" name="tanggal_mulai_kerja" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Mulai Kerja" autocomplete="off">
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="id_jabatan">Jabatan <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<select id="id_jabatan" value="<?= $karyawan[0]->id_jabatan ?>" name="id_jabatan" class="select-select2 select2" style="width:100%;">
							<option value="" disabled selected>-- Pilih Jabatan --</option>
							<?
							foreach ($jabatan as $data) :
								$selected = (($data->id == $karyawan[0]->id_jabatan) ? 'selected' : '');
								echo '<option value="' . $data->id . '" ' . $selected . '>'
									. strtoupper($data->nama_jabatan) .
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
				<label class="col-md-4 control-label" for="status_perkawinan">Status Perkawinan<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<?php $status_perkawinan = array('kawin', 'belum kawin') ?>
						<select id="status_perkawinan" value="<?= $karyawan[0]->status_perkawinan ?>" name="status_perkawinan" class="select-select2 select2" style="width:100%;">
							<option value="" disabled selected>-- Pilih Status Perkawinan --</option>
							<?
							foreach ($status_perkawinan as $data) :
								$selected = (($data == $karyawan[0]->status_perkawinan) ? 'selected' : '');
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
				<label class="col-md-4 control-label" for="status_karyawan">Status Karyawan <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<?php $status_karyawan = array('tetap', 'tidak tetap') ?>
						<select id="status_karyawan" value="<?= $karyawan[0]->status_karyawan ?>" name="status_karyawan" class="select-select2 select2" style="width:100%;">
							<option value="" disabled selected>-- Pilih Status Karyawan --</option>
							<?
							foreach ($status_karyawan as $data) :
								$selected = (($data == $karyawan[0]->status_karyawan) ? 'selected' : '');
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
				<label class="col-md-4 control-label" for="email">Email <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="email" id="email" value="<?= $karyawan[0]->email ?>" name="email" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="nomor_hp">No Telepon <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" id="nomor_hp" value="<?= $karyawan[0]->nomor_hp ?>" name="nomor_hp" class="form-control" placeholder=".." required>
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
						<input type="number" id="usia" value="<?= $karyawan[0]->usia ?>" name="usia" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="pendidikan_terakhir">Pendidikan Terakhir <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<?php $pendidikan_terakhir = array(
							'Tidak / Belum Sekolah',
							'BELUM TAMAT SD/SEDERAJAT',
							'TAMAT SD / SEDERAJAT',
							'BELUM TAMAT SLTP/SEDERAJAT',
							'TAMAT SLTP/SEDERAJAT',
							'BELUM TAMAT SLTA/SEDERAJAT',
							'TAMAT SLTA/SEDERAJAT',
							'AKADEMI/ DIPLOMA III/S. MUDA',
							'DIPLOMA I / II',
							'DIPLOMA IV/ STRATA I',
							'STRATA II',
							'STRATA III'
						) ?>
						<select id="pendidikan_terakhir" value="<?= $karyawan[0]->pendidikan_terakhir ?>" name="pendidikan_terakhir" class="select-select2 select2" style="width:100%;">
							<option value="" disabled selected>-- Pilih Pendidikan Terakhir --</option>
							<?
							foreach ($pendidikan_terakhir as $data) :
								$selected = (($data == $karyawan[0]->pendidikan_terakhir) ? 'selected' : '');
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
			<label class="col-md-2 control-label" for="npwp_karyawan">NPWP Karyawan<span class="text-danger">*</span></label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" id="npwp_karyawan" value="<?= $karyawan[0]->npwp_karyawan ?>" name="npwp_karyawan" class="form-control" placeholder=".." required>
					<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="status_bpjs_tk">Status BPJS Ketenagakerjaan<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" id="status_bpjs_tk" value="<?= $karyawan[0]->status_bpjs_tk ?>" name="status_bpjs_tk" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="nomor_bpjs_tk">Nomor BPJS Ketenagakerjaan<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" id="nomor_bpjs_tk" value="<?= $karyawan[0]->nomor_bpjs_tk ?>" name="nomor_bpjs_tk" class="form-control" placeholder=".." required>
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
						<input type="text" id="status_bpjs_kesehatan" value=" <?= $karyawan[0]->status_bpjs_kesehatan ?>" name="status_bpjs_kesehatan" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="nomor_bpjs_kesehatan">Nomor BPJS Kesehatan<span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" id="nomor_bpjs_kesehatan" value="<?= $karyawan[0]->nomor_bpjs_kesehatan ?>" name="nomor_bpjs_kesehatan" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="photo">Photo Karyawan</label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="file" id="photo" value="<?= $karyawan[0]->photo ?>" name="photo" class="form-control" accept="image/png, image/jpeg, image/jpg, image/gif">
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<?php if ($karyawan[0]->photo) {
				echo '<div class="col-md-6 text-start"><img src="' . base_url() . 'assets/img/photo_pengguna/' . $karyawan[0]->photo . '" alt="Photo" width="200px"></div>';
			} else {
				echo '
				<div class="col-md-6 label label-danger">
					<p><b>[Photo Tidak Tersedia]</b></p>
				</div>';
			}
			?>
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
