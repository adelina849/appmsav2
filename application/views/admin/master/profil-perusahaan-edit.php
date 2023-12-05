<?php
foreach ($data as $d) { ?>
	<div class="block full">
		<!-- All Orders Title -->
		<div class="block-title">
			<h2><i class="hi hi-cog"></i> <strong>UBAH PROFIL PERUSAHAAN <?= (isset($d->nama_perusahaan) ? $d->nama_perusahaan : '-') ?></strong>
			</h2>

			<div class="block-options pull-right" style="margin-right: 15px;">
				<a href="<?= site_url('admin/master/profil_perusahaan/daftar'); ?>" class="" data-toggle="tooltip" title="Kembali">
					<i class="fa fa-list-alt"></i> Kembali
				</a>
			</div>
		</div>

		<div class="row">
			<div class='col-lg-12' style="margin-bottom: 5px;">
				<table class="table table-vcenter table-condensed table-bordered table-hover" width="100%">

					<?php echo form_open($action_edit, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
					<fieldset>
						<tbody>
							<tr>
								<input type="hidden" id="id" value="<?= $d->id ?>" name="id" class="form-control" placeholder=".." required>
								<td class="text-left" style="width: 1%;"><strong>Kode Perusahaan</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="kode_perusahaan" value="<?= $d->kode_perusahaan ?>" name="kode_perusahaan" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Nama Perusahaan</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="nama_perusahaan" value="<?= $d->nama_perusahaan ?>" name="nama_perusahaan" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Alamat</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="alamat" value="<?= $d->alamat ?>" name="alamat" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Website</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="website" value="<?= $d->website ?>" name="website" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Email</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="email" id="email" value="<?= $d->email ?>" name="email" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Telepon</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="tlp" value="<?= $d->tlp ?>" name="tlp" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Nama Direktur</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="nama_direktur" value="<?= $d->nama_direktur ?>" name="nama_direktur" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Nama Komanditer</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="nama_komanditer" value="<?= $d->nama_komanditer ?>" name="nama_komanditer" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Nomor Akta Pendirian</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="nomor_akta_pendirian" value="<?= $d->nomor_akta_pendirian ?>" name="nomor_akta_pendirian" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Tanggal Akta Pendirian</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="tanggal_akta_pendirian" <?= $d->tanggal_akta_pendirian ?> name="tanggal_akta_pendirian" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="..." autocomplete="off">
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Nama Notaris</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="nama_notaris" value="<?= $d->nama_notaris ?>" name="nama_notaris" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Presentase Kepemilikan Direktur</strong></td>
								<td class="text-left" style="width: 5%;">
									<div class="input-group">
										<input type="number" id="presentase_kepemilikan_direktur" name="presentase_kepemilikan_direktur" value="<?= $d->presentase_kepemilikan_direktur ?>" class="form-control" placeholder=".." required>
										<span class="input-group-addon">%</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Presentase Kepemilikan Komanditer</strong></td>
								<td class="text-left" style="width: 5%;">
									<div class="input-group">
										<input type="number" id="presentase_kepemilikan_komanditer" name="presentase_kepemilikan_komanditer" value="<?= $d->presentase_kepemilikan_komanditer ?>" class="form-control" placeholder=".." required>
										<span class="input-group-addon">%</span>
									</div>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Nomor Akta Perubahan Terakhir</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="nomor_akta_perubahan_terakhir" name="nomor_akta_perubahan_terakhir" value="<?= $d->nomor_akta_perubahan_terakhir ?>" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Tanggal Akta Perubahan Terakhir</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="tanggal_akta_perubahan_terakhir" <?= $d->tanggal_akta_perubahan_terakhir ?> name="tanggal_akta_perubahan_terakhir" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="..." autocomplete="off">
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Nama Direktur Akta Perubahan Terakhir</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="nama_direktur_akta_perubahan_terakhir" name="nama_direktur_akta_perubahan_terakhir" value="<?= $d->nama_direktur_akta_perubahan_terakhir ?>" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Nama Komanditer Akta Perubahan Terakhir</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="nama_komanditer_akta_perubahan_terakhir" name="nama_komanditer_akta_perubahan_terakhir" value="<?= $d->nama_komanditer_akta_perubahan_terakhir ?>" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>Nama Notaris Akta Perubahan Terakhir</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="nama_notaris_akta_perubahan_terakhir" name="nama_notaris_akta_perubahan_terakhir" value="<?= $d->nama_notaris_akta_perubahan_terakhir ?>" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>NPWP</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="npwp" name="npwp" value="<?= $d->npwp ?>" class="form-control" placeholder=".." required>
								</td>
							</tr>
							<tr>
								<td class="text-left" style="width: 1%;"><strong>NIB</strong></td>
								<td class="text-left" style="width: 5%;">
									<input type="text" id="nib" name="nib" value="<?= $d->nib ?>" class="form-control" placeholder=".." required>
								</td>
							</tr>
						</tbody>
				</table>

				</fieldset>
				<div class="form-group form-actions">
					<div class="col-md-8 col-md-offset-4 text-right">
						<button type="reset" class="btn btn-sm btn-warning" data-dismiss="modal"><i class="fa fa-repeat"></i> Batal</button>
						<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
					</div>
				</div>

				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
<?php } ?>
