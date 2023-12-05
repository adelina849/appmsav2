<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong>DATA SUPPLIER</strong>
		</h2>

		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/master/vendor/daftar'); ?>" class="" data-toggle="tooltip" title="Daftar Supplier">
				<i class="fa fa-list-alt"></i> Daftar Supplier
			</a>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="block">
				<div class="block-title">
					<h2><i class="fa fa-file-o"></i> <strong>PROFILE <?= strtoupper($data->nama_vendor); ?></strong></h2>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h3 class="text-left">
							<strong><?= $data->nama_vendor; ?></strong><br><small></small>
						</h3>
						<table class="table table-borderless table-striped table-vcenter">
							<tbody>
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Kode</strong></td>
									<td style="width: 2px;">:</td>
									<td><?=$data->kode; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Klasifikasi</strong></td>
									<td style="width: 2px;">:</td>
									<td>
                                    <?php
                                            $k = $this->db->get_where('vendor_klasifikasi', array('id' => $data->klasifikasi))->result();
                                            echo (isset($k[0]->klasifikasi) ? $k[0]->klasifikasi : ''); 
                                        ?>                                    
                                    </td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Kontak</strong></td>
									<td style="width: 2px;">:</td>
									<td><?=$data->kontak; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Email</strong></td>
									<td style="width: 2px;">:</td>
									<td><?=$data->email; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Telp</strong></td>
									<td style="width: 2px;">:</td>
									<td><?=$data->tlp; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Alamat</strong></td>
									<td style="width: 2px;">:</td>
									<td><?=$data->alamat; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Nama Bank</strong></td>
									<td style="width: 2px;">:</td>
									<td><?=$data->nama_bank; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>norek</strong></td>
									<td style="width: 2px;">:</td>
									<td><?=$data->norek; ?></td>
								</tr>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
