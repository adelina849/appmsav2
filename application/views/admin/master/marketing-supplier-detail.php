<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong>DATA MARKETING SUPPLIER</strong>
		</h2>

		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/master/marketing_supplier/daftar'); ?>" class="" data-toggle="tooltip" title="Daftar Marketing Supplier">
				<i class="fa fa-list-alt"></i> Daftar Marketing Supplier
			</a>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="block">
				<div class="block-title">
					<h2><i class="fa fa-file-o"></i> <strong>PROFILE <?= strtoupper($data->nama_lengkap); ?></strong></h2>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h3 class="text-left">
							<strong><?= $data->nama_lengkap; ?></strong><br><small></small>
						</h3>
						<table class="table table-borderless table-striped table-vcenter">
							<tbody>
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Kode Marketing</strong></td>
									<td>: <?=$data->kode; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Supplier</strong></td>
									<td>: 
									<?php
										$supplier = $this->db->get_where('vendor', array('id' => $data->id_vendor))->result();
										echo (isset($supplier[0]->nama_vendor) ? $supplier[0]->nama_vendor : ''); 							
									?>
									</td>
								</tr>

								<tr>
									<td class="text-start" style="width: 30%;"><strong>Nomor Telepon</strong></td>
									<td>: <?=$data->nomor_handphone; ?></td>
								</tr>
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Email</strong></td>
									<td>: <?=$data->email; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Tempat Lahir</strong></td>
									<td>: <?=$data->tempat_lahir; ?></td>
								</tr>
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Tanggal Lahir</strong></td>
									<td>: <?= ($data->tanggal_lahir==null) ? '-':$this->tanggal->konversi($data->tanggal_lahir); ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Alamat</strong></td>
									<td>: <?=$data->alamat; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Jenis Kelamin</strong></td>
									<td>: <?=strtoupper($data->jenis_kelamin); ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Agama</strong></td>
									<td>: <?=strtoupper($data->agama); ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Status Perkawinan</strong></td>
									<td>: <?=strtoupper($data->status_perkawinan); ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Usia</strong></td>
									<td>: 
                                        <?php
                                            if($data->tanggal_lahir!=null){
                                                $uawal  = date_create($data->tanggal_lahir);
                                                $uakhir = date_create(); //waktu sekarang
                                                $usia  = date_diff($uawal, $uakhir);
                                                echo $usia->y.' Tahun';   
                                            }
                                        ?>
                                    </td>
								</tr>
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Tanggal Mulai Kerjasama</strong></td>
									<td>: 
                                        <?php
                                            if($data->tanggal_mulai_kerjasama!=null){
                                                $data_mitra = $this->msa->getby_id('marketing_supplier', 'id', $data->id)->result();
                                                $awal  = date_create($data_mitra[0]->tanggal_mulai_kerjasama);
                                                $akhir = date_create(); //waktu sekarang
                                                $masa_kerja  = date_diff($awal, $akhir);
                                                echo $this->tanggal->konversi($data->tanggal_mulai_kerjasama); 
                                                echo ' (';
                                                echo strtoupper($masa_kerja->y . ' Tahun, ' . $masa_kerja->m . ' Bulan, ' . $masa_kerja->d . ' Hari');
                                                echo ')';
    
                                            }
                                        ?>
                                    </td>
								</tr>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
