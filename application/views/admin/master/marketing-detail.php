<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong>DATA MARKETING</strong>
		</h2>

		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/master/marketing/daftar'); ?>" class="" data-toggle="tooltip" title="Daftar Marketing">
				<i class="fa fa-list-alt"></i> Daftar Marketing
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
                        <div class="table-responsive">
						<table class="table table-borderless table-striped table-vcenter">
							<tbody>
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Nomor ID</strong></td>
                                    <td>:</td>
									<td><?=$data->nomor_id; ?></td>
								</tr>

								<tr>
									<td class="text-start" style="width: 30%;"><strong>Jabatan</strong></td>
									<td>:</td>
									<td>
									<?php
										//$data->wilayah_kerja;
										$j = $this->db->get_where('jabatan', array('id' => $data->jabatan))->result();
										echo (isset($j[0]->nama_jabatan) ? strtoupper($j[0]->nama_jabatan) : ''); 							
									?>
									</td>
								</tr>

								<tr>
									<td class="text-start" style="width: 30%;"><strong>Wilayah Kerja</strong></td>
									<td>:</td>
									<td>
									<?php
										//$data->wilayah_kerja;
										$w = $this->db->get_where('wilayah_kerja', array('id' => $data->wilayah_kerja))->result();
										echo (isset($w[0]->nama) ? ($w[0]->kode.' '.$w[0]->nama.' '.strtoupper($w[0]->provinsi)) : ''); 							
									?>
									</td>
								</tr>

								<tr>
									<td class="text-start" style="width: 30%;"><strong>Alamat</strong></td>
									<td>:</td>
									<td><?=$data->alamat; ?></td>
								</tr>

								<tr>
									<td class="text-start" style="width: 30%;"><strong>Telepon</strong></td>
									<td>:</td>
									<td><?=$data->tlp; ?></td>
								</tr>

								<tr>
									<td class="text-start" style="width: 30%;"><strong>Email</strong></td>
									<td>:</td>
									<td><?=$data->email; ?></td>
								</tr>

								<tr>
									<td class="text-start" style="width: 30%;"><strong>Tempat Lahir</strong></td>
									<td>:</td>
									<td><?=$data->tempat_lahir; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Tanggal Lahir</strong></td>
									<td>:</td>
									<td><?= ($data->tanggal_lahir==null) ? '-':$this->tanggal->konversi($data->tanggal_lahir); ?></td>
								</tr>    

								<tr>
									<td class="text-start" style="width: 30%;"><strong>Jenis Kelamin</strong></td>
									<td>:</td>
									<td><?=$data->jenis_kelamin; ?></td>
								</tr>

								<tr>
									<td class="text-start" style="width: 30%;"><strong>Agama</strong></td>
									<td>:</td>
									<td><?=$data->agama; ?></td>
								</tr>

								<tr>
									<td class="text-start" style="width: 30%;"><strong>Status Perkawinan</strong></td>
									<td>:</td>
									<td><?=$data->status_perkawinan; ?></td>
								</tr>
                                
								<tr>
									<td class="text-start" style="width: 30%;"><strong>Tanggal Mulai Bermitra</strong></td>
									<td>:</td>
									<td>
                                        <?php
                                            echo ($data->tanggal_lahir==null) ? '-':$this->tanggal->konversi($data->tanggal_mulai_bermitra);
                                            echo '(';
                                            $data_marketing = $this->msa->getby_id('marketing', 'id', $data->id)->result();
                                            $awal  = date_create($data_marketing[0]->tanggal_mulai_bermitra);
                                            $akhir = date_create(); //waktu sekarang
                                            $masa_kerja  = date_diff($awal, $akhir);
                                            echo strtoupper($masa_kerja->y . ' Tahun, ' . $masa_kerja->m . ' Bulan, ' . $masa_kerja->d . ' Hari');
                                            echo ')';
                                        ?>
                                    </td>
								</tr>

								<tr>
									<td class="text-start" style="width: 30%;"><strong>Usia</strong></td>
									<td>:</td>
									<td>
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

							</tbody>
						</table>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>

</div>
