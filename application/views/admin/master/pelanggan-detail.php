<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong>DATA PELANGGAN</strong>
		</h2>

		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/master/pelanggan/daftar'); ?>" class="" data-toggle="tooltip" title="Daftar Pelanggan">
				<i class="fa fa-list-alt"></i> Daftar Pelanggan
			</a>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="block">
				<div class="block-title">
					<h2><i class="fa fa-file-o"></i> <strong>PROFILE <?= strtoupper($pelanggan->nama_pelanggan); ?></strong></h2>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h3 class="text-left">
							<strong><?= $pelanggan->nama_pelanggan; ?></strong><br><small></small>
						</h3>
						<table class="table table-borderless table-striped table-vcenter">
							<tbody>
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Kode</strong></td>
									<td>: <?=$pelanggan->kode; ?></td>
								</tr>

								<tr>
									<td class="text-start" style="width: 30%;"><strong>Lembaga</strong></td>
									<td>
                                        : <?php
                                            $lembaga = $this->db->get_where('lembaga', array('id' => $pelanggan->id_lembaga))->result();

                                            echo (isset($lembaga[0]->nama_lembaga) ? $lembaga[0]->nama_lembaga : ''); 
                                        ?>
                                    </td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Jabatan</strong></td>
									<td>: <?=$pelanggan->jabatan; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Tempat Lahir</strong></td>
									<td>: <?=$pelanggan->tempat_lahir; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Tanggal Lahir</strong></td>
									<td>: <?= ($pelanggan->tanggal_lahir==null) ? '-':$this->tanggal->konversi($pelanggan->tanggal_lahir); ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Jenis Kelamin</strong></td>
									<td>: <?=strtoupper($pelanggan->jenis_kelamin); ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Alamat</strong></td>
									<td>: <?=$pelanggan->alamat; ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Agama</strong></td>
									<td>: <?=strtoupper($pelanggan->agama); ?></td>
								</tr>

                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Status Perkawinan</strong></td>
									<td>: <?=strtoupper($pelanggan->status_perkawinan); ?></td>
								</tr>
                                
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Tanggal Jadi Pelanggan</strong></td>
									<td>: <?=($pelanggan->tanggal_jadi_pelanggan==null) ? '-':$this->tanggal->konversi($pelanggan->tanggal_jadi_pelanggan); ?></td>
								</tr>
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Usia</strong></td>
									<td>: 
										<?php
                                            if($pelanggan->tanggal_lahir!=null){
                                                $uawal  = date_create($pelanggan->tanggal_lahir);
                                                $uakhir = date_create(); //waktu sekarang
                                                $usia  = date_diff($uawal, $uakhir);
                                                echo $usia->y.' Tahun';   
                                            }
                                        ?>											
									</td>
								</tr>
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Email</strong></td>
									<td>: <?=$pelanggan->email; ?></td>
								</tr>
                                <tr>
									<td class="text-start" style="width: 30%;"><strong>Kontak</strong></td>
									<td>: <?=$pelanggan->kontak; ?></td>
								</tr>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
