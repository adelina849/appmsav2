<?php
foreach ($data as $d) { ?>
	<div class="block full">
		<!-- All Orders Title -->
		<div class="block-title">
			<h2><i class="hi hi-cog"></i> <strong>PROFIL PERUSAHAAN <?= (isset($d->nama_perusahaan) ? $d->nama_perusahaan : '-') ?></strong>
			</h2>

			<div class="block-options pull-right" style="margin-right: 15px;">
				<a href="<?= site_url('admin/master/profil_perusahaan/ubah/' . $d->id . '/profil'); ?>" class="" data-toggle="tooltip" title="Edit">
					<i class="fa fa-list-alt"></i> Edit
				</a>
			</div>
		</div>

		<div class="row">
			<div class='col-lg-12' style="margin-bottom: 5px;">
				<table class="table table-vcenter table-condensed table-bordered table-hover" width="100%">
					<tbody>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Kode Perusahaan</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->kode_perusahaan ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Nama Perusahaan</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->nama_perusahaan ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Alamat</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->alamat ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Website</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->website ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Email</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->email ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Telepon</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->tlp ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Nama Direktur</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->nama_direktur ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Nama Komanditer</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->nama_komanditer ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Nomor Akta Pendirian</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->nomor_akta_pendirian ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Tanggal Akta Pendirian</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->tanggal_akta_pendirian ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Nama Notaris</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->nama_notaris ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Presentase Kepemilikan Direktur</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->presentase_kepemilikan_direktur . ' %' ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Presentase Kepemilikan Komanditer</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->presentase_kepemilikan_komanditer . ' %' ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Nomor Akta Perubahan Terakhir</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->nomor_akta_perubahan_terakhir ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Tanggal Akta Perubahan Terakhir</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->tanggal_akta_perubahan_terakhir ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Nama Direktur Akta Perubahan Terakhir</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->nama_direktur_akta_perubahan_terakhir ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Nama Komanditer Akta Perubahan Terakhir</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->nama_komanditer_akta_perubahan_terakhir ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Nama Notaris Akta Perubahan Terakhir</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->nama_notaris_akta_perubahan_terakhir ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>NPWP</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->npwp ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>NIB</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= $d->nib ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php } ?>
