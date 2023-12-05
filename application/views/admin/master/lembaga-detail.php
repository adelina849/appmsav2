<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong>DATA LEMBAGA</strong>
		</h2>

		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/master/lembaga/daftar'); ?>" class="" data-toggle="tooltip" title="Daftar Lembaga">
				<i class="fa fa-list-alt"></i> Daftar Lembaga
			</a>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="block">
				<div class="block-title">
					<h2><i class="fa fa-file-o"></i> <strong>PROFILE <?= strtoupper($data->nama_lembaga); ?></strong></h2>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h3 class="text-left">
							<strong><?= $data->nama_lembaga; ?></strong><br><small></small>
						</h3>
						<table class="table table-borderless table-striped table-vcenter">
							<tbody>
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Kode</strong></td>
									<td style="width: 1px">:</td>
									<td><?=$data->kode; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Nomor Telepon</strong></td>
									<td style="width: 2px">:</td>
                                    <td><?=$data->nomor_telepon; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Jenjang</strong></td>
									<td style="width: 2px">:</td>
                                    <td><?=$data->jenjang; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Status</strong></td>
									<td style="width: 2px">:</td>
                                    <td><?=$data->status; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Klasifikasi</strong></td>
									<td style="width: 2px">:</td>
                                    <td><?=$data->klasifikasi; ?></td>
								</tr>
                                
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Alamat</strong></td>
									<td style="width: 2px">:</td>
                                    <td><?=$data->alamat; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Provinsi</strong></td>
									<td style="width: 2px">:</td>
                                    <td><?=$data->provinsi; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Kabupaten</strong></td>
									<td style="width: 2px">:</td>
                                    <td><?=$data->kabupaten; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Kecamatan</strong></td>
									<td style="width: 2px">:</td>
                                    <td><?=$data->kecamatan; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Desa</strong></td>
									<td style="width: 2px">:</td>
                                    <td><?=$data->desa; ?></td>
								</tr>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
