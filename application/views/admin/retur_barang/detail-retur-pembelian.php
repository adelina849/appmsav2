<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<div class="block-options pull-right" style="margin-right: 15px;">
		</div>
		<h2><i class="fa fa-eye"></i> <strong><?= $title; ?></strong></h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<table class="table table-vcenter table-condensed table-bordered table-hover" width="100%">
				<tbody>
					<tr>
						<td class="text-left" style="width: 20%;">Nomor Retur</td>
						<td><?= (isset($retur_master[0]->nomor_retur) ? $retur_master[0]->nomor_retur : '-'); ?></td>
					</tr>
					<tr>
						<td class="text-left" style="width: 20%;">Tanggal Retur</td>
						<td><?= (isset($retur_master[0]->tanggal_retur) ? ($this->tanggal->konversi($retur_master[0]->tanggal_retur)) : '-'); ?></td>
					</tr>
					<tr>
						<td class="text-left" style="width: 20%;">Kode Marketing</td>
						<td><?= (isset($qMarketing[0]->kode) ? $qMarketing[0]->kode : '-'); ?></td>
					</tr>
					<tr>
						<td class="text-left" style="width: 20%;">Nama Marketing</td>
						<td><?= (isset($qMarketing[0]->nama_lengkap) ? $qMarketing[0]->nama_lengkap : '-'); ?></td>
					</tr>
					<tr>
						<td class="text-left" style="width: 20%;">Kode Supplier</td>
						<td><?= (isset($qVendor[0]->kode) ? $qVendor[0]->kode : '-'); ?></td>
					</tr>
					<tr>
						<td class="text-left" style="width: 20%;">Nama Supplier</td>
						<td><?= (isset($qVendor[0]->nama_vendor) ? $qVendor[0]->nama_vendor : '-'); ?></td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="retur" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr class="themed-color themed-background" style="font-weight: bold;">
							<td class="text-center text-light" style="width: 3%;">NO</td>
							<td class="text-light" style="width: 10%;">KODE BARANG</td>
							<td class="text-light" style="width: 35%;">NAMA BARANG</td>
							<td class="text-light" style="width: 10%;">HARGA SATUAN</td>
							<td class="text-light" style="width: 5%;">JUMLAH RETUR</td>
							<td class="text-light" style="width: 10%;">JUMLAH HARGA</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$q = $this->db->get_where('retur_barang_pembelian_detail', array('id_retur_master' => $id_retur_master));
						$no = 0;
						foreach ($q->result() as $d) {
							$id_barang = $d->id_barang;
							$qBarang = $this->db->get_where('barang', array('id_barang' => $id_barang))->result();
							$kode_barang = strtoupper(isset($qBarang[0]->kode_barang) ? $qBarang[0]->kode_barang : '-');
							$nama_barang = strtoupper(isset($qBarang[0]->nama_barang) ? $qBarang[0]->nama_barang : '-');

						?>
							<tr>
								<td><?= ++$no; ?></td>
								<td><?= $kode_barang; ?></td>
								<td><?= $nama_barang; ?></td>
								<td class="text-right"><?= str_replace(',', '.', number_format($d->harga_satuan)); ?></td>
								<td class="text-center"><?= $d->jumlah_retur; ?></td>
								<td class="text-right"><?= str_replace(',', '.', number_format($d->total)); ?></td>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- END row -->
	<!-- END block-->
</div>


<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>