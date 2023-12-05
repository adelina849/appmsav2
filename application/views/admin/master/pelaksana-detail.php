<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong>DATA PERUSAHAAN PELAKSANA</strong>
		</h2>

		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/master/pelaksana/daftar'); ?>" class="" data-toggle="tooltip" 
            title="Daftar Perusahaan Pelaksana">
				<i class="fa fa-list-alt"></i> Daftar Perusahaan
			</a>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="block">
				<div class="block-title">
					<h2><i class="fa fa-file-o"></i> <strong>PROFILE <?= strtoupper($data->nama_cv); ?></strong></h2>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h3 class="text-left">
							<strong><?= $data->nama_cv; ?></strong><br><small></small>
						</h3>
						<table class="table table-borderless table-striped table-vcenter">
							<tbody>
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Kode</strong></td>
									<td style="width: 2px;">:</td>
									<td><?=$data->kode; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Nama Direktur</strong></td>
									<td style="width: 2px;">:</td>
									<td><?=$data->direktur; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Nama Komanditer</strong></td>
									<td>:</td>
									<td><?=$data->komanditer; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Alamat</strong></td>
									<td>:</td>
									<td><?=$data->alamat; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Kontak</strong></td>
									<td>:</td>
									<td><?=$data->kontak; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Nomor Akta Pendirian</strong></td>
									<td>:</td>
									<td><?=$data->nomor_akta; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Tanggal Akta Pendirian</strong></td>
									<td>:</td>
									<td><?=($data->tanggal_akta==null) ? '-':$this->tanggal->konversi($data->tanggal_akta); ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Nama Notaris</strong></td>
									<td>:</td>
									<td><?=$data->nama_notaris; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Presentase Kepemilikan Direktur</strong></td>
									<td>:</td>
									<td><?=$data->presentase_direktur; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Presentase Kepemilikan Komanditer</strong></td>
									<td>:</td>
									<td><?=$data->presentase_komanditer; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Nomor Akta Perubahan Terakhir</strong></td>
									<td>:</td>
									<td><?=$data->nomor_perubahan; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Tanggal Akta Perubahan Terakhir</strong></td>
									<td>:</td>
									<td><?=($data->tanggal_perubahan==null) ? '-':$this->tanggal->konversi($data->tanggal_perubahan); ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Nama Direktur Perubahan Terakhir</strong></td>
									<td>:</td>
									<td><?=$data->direktur_perubahan; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Nama Komanditer Perubahan Terakhir</strong></td>
									<td>:</td>
									<td><?=$data->komanditer_perubahan; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Nama Notaris Perubahan Terakhir</strong></td>
									<td>:</td>
									<td><?=$data->notaris; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Nomor Induk Berusaha (NIB)</strong></td>
									<td>:</td>
									<td><?=$data->nib; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Email</strong></td>
									<td>:</td>
									<td><?=$data->email; ?></td>
								</tr>


                            </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
