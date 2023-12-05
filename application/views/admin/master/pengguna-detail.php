<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong>DATA KARYAWAN</strong>
		</h2>

		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/master/pengguna/daftar'); ?>" class="" data-toggle="tooltip" title="Daftar Barang">
				<i class="fa fa-list-alt"></i> Daftar Karyawan
			</a>
		</div>
	</div>

	<? $jabatan = $this->db->get_where('jabatan', array('id' => $pengguna[0]->id_jabatan))->result(); ?>

	<div class="container">
		<div class="row">
			<div class="block">
				<div class="block-title">
					<h2><i class="fa fa-file-o"></i> <strong>PROFILE <?= isset($pengguna[0]->nama_lengkap) ? strtoupper($pengguna[0]->nama_lengkap) : "-"; ?></strong></h2>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="block-section text-center">
							<?php if ($pengguna[0]->photo) { ?>
								<img src="<?= base_url() . 'assets/img/photo_pengguna/' . $pengguna[0]->photo ?>" alt="avatar" class="img-circle" style="width:300px;">
							<?php
							} else {
							?>
								<img src="<?= base_url() . 'assets/img/default-photo.png' ?>" alt="avatar" class="img-circle" style="height: 300px;">
							<?php
							}
							?>
						</div>
					</div>
					<div class="col-md-8">
						<h3 class="text-center">
							<strong><?= isset($pengguna[0]->nama_lengkap) ? strtoupper($pengguna[0]->nama_lengkap) : "-"; ?></strong><br><small></small>
						</h3>
						<table class="table table-borderless table-striped table-vcenter">
							<tbody>
								<tr>
									<td class="text-start" style="width: 40%;"><strong>Jabatan</strong></td>
									<td>: 
										<?php
										echo isset($jabatan[0]->nama_jabatan) ? $jabatan[0]->nama_jabatan : '-'; ?>
									</td>
								</tr>
								<tr>
									<td class="text-start"><strong>Tempat, Tanggal Lahir</strong></td>
									<td>: <?= strtoupper($pengguna[0]->tempat_lahir) . ', ' . strtoupper($pengguna[0]->tanggal_lahir) ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Alamat</strong></td>
									<td>: <?= strtoupper($pengguna[0]->alamat) ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Jenis Kelamin</strong></td>
									<td>: <?= strtoupper($pengguna[0]->jenis_kelamin) ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Agama</strong></td>
									<td>: <?= strtoupper($pengguna[0]->agama) ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Status Perkawinan</strong></td>
									<td>: <?= strtoupper($pengguna[0]->status_perkawinan) ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Tanggal Mulai Kerja</strong></td>
									<td>: <?= strtoupper($pengguna[0]->tanggal_mulai_kerja) ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Lama Bekerja</strong></td>
									<td>: <?= strtoupper($masa_kerja->y . ' Tahun, ' . $masa_kerja->m . ' Bulan, ' . $masa_kerja->d . ' Hari') ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Nomor Handphone</strong></td>
									<td>: <?= $pengguna[0]->nomor_hp ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Email</strong></td>
									<td>: <?= $pengguna[0]->email ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Usia</strong></td>
									<td>: 
									<?php
                                            if($pengguna[0]->tanggal_lahir!=null){
                                                $uawal  = date_create($pengguna[0]->tanggal_lahir);
                                                $uakhir = date_create(); //waktu sekarang
                                                $usia  = date_diff($uawal, $uakhir);
                                                echo $usia->y.' Tahun';   
                                            }
                                        ?>											
									</td>
								</tr>
								<tr>
									<td class="text-start"><strong>Pendidikan Terakhir</strong></td>
									<td>: <?= strtoupper($pengguna[0]->pendidikan_terakhir) ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Nomor NPWP</strong></td>
									<td>: <?= $pengguna[0]->npwp_karyawan ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Status BPJS Ketenagakerjaan</strong></td>
									<td>: <?= strtoupper($pengguna[0]->status_bpjs_tk) ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Nomor BPJS Ketenagakerjaan</strong></td>
									<td>: <?= $pengguna[0]->nomor_bpjs_tk ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Status BPJS Kesehatan</strong></td>
									<td>: <?= strtoupper($pengguna[0]->status_bpjs_kesehatan) ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Nomor BPJS Kesehatan</strong></td>
									<td>: <?= $pengguna[0]->nomor_bpjs_kesehatan ?></td>
								</tr>
								<tr>
									<td class="text-start"><strong>Status Karyawan</strong></td>
									<td>: <?= strtoupper($pengguna[0]->status_karyawan) ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
