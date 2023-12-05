<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">

		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/gudang/stok_opname/daftar'); ?>" class="" data-toggle="tooltip" title="Kembali ke List SO">
				<i class="fa fa-list-alt"></i> List Stok Opname
			</a>
		</div>
		<h2><i class="hi hi-cog"></i> <strong>HASIL STOK OPNAME - <?= (isset($so[0]->tanggal_mulai) ? $so[0]->tanggal_mulai : "-") ?></strong>
		</h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<?php $qGudang = $this->db->get_where('gudang', array('id' => $so[0]->id_gudang))->result(); ?>

			<input type="hidden" name="id_gudang" id="id_gudang" value="<?= (isset($qGudang[0]->id) ? $qGudang[0]->id : ''); ?>">
			<input type="hidden" name="id_so" id="id_so" value="<?= (isset($so[0]->id) ? $so[0]->id : ''); ?>">
			<table class="table table-vcenter table-condensed table-bordered table-hover" width="100%">
				<tbody>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>KODE STOK OPNAME</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-file-text-o"></i> ' . (isset($so[0]->kode_so) ? $so[0]->kode_so : "-") ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Tanggal Mulai</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= '<i class="fa fa-calendar"></i> ' .  (isset($so[0]->tanggal_mulai) ? $so[0]->tanggal_mulai : "-") ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Tanggal Selesai</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= '<i class="fa fa-calendar"></i> ' .  (isset($so[0]->tanggal_selesai) ? $so[0]->tanggal_selesai : "-") ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Lokasi Gudang</strong></td>
						<td class="text-left" style="width: 5%;"> <?= '<i class="fa fa-map-marker"></i> ' . (isset($qGudang[0]->gudang) ? $qGudang[0]->gudang : '-'); ?></td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Status</strong></td>
						<td class="text-left" style="width: 5%;"><?= '<i class="fa fa-flask"></i> ' .  strtoupper(isset($so[0]->status) ? $so[0]->status : "-"); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<!-- END row -->

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<table id="table_barang" class="table table-vcenter table-condensed table-bordered table-hover">
				<thead>
					<tr class="themed-color themed-background">
						<th class="text-center text-light" style="width: 3%;">NO</th>
						<th class="text-light">KODE BARANG</th>
						<th class="text-light">NAMA BARANG</th>
						<th class="text-light">TOTAL STOK</th>
						<th class="text-light">SELISIH</th>
						<th class="text-light">KETERANGAN</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					if (count($data) == 0) {
					?>
						<tr>
							<td colspan="7" class="text-center">TIDAK ADA SELISIH BARANG</td>
						</tr>
						<?
					} else {
						foreach ($data as $d) {
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>
								<? $barang = $this->db->get_where('barang', array('id_barang' => $d->id_barang))->result(); ?>
								<td><?= strtoupper(isset($barang[0]->kode_barang) ? $barang[0]->kode_barang : "-"); ?></td>
								<td><?= strtoupper(isset($barang[0]->nama_barang) ? $barang[0]->nama_barang : "-"); ?></td>
								<td><?= strtoupper($d->total_stok); ?></td>
								<td><?= strtoupper($d->selisih); ?></td>
								<td><?= strtoupper($d->keterangan); ?></td>
							</tr>
					<?php
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
