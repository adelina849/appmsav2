<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="hi hi-cog"></i> <strong>DETAIL BARANG (<?= isset($barang[0]->nama_barang) ? $barang[0]->nama_barang : "-"; ?>)</strong>
		</h2>

		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/master/barang/daftar'); ?>" class="" data-toggle="tooltip" title="Daftar Barang">
				<i class="fa fa-list-alt"></i> Daftar Barang
			</a>
		</div>
	</div>

	<? $vendor = $this->db->get_where('vendor', array('id' => $barang[0]->id_vendor))->result(); ?>
	<? $gudang = $this->db->get_where('gudang', array('id' => $barang[0]->id_gudang))->result(); ?>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<table class="table table-vcenter table-condensed table-bordered table-hover" width="100%">
				<tbody>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Kode Barang</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-file-text-o"></i> ' . (isset($barang[0]->kode_barang) ? $barang[0]->kode_barang : "-") ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Supplier</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-university"></i> ' . (isset($vendor[0]->nama_vendor) ? $vendor[0]->nama_vendor : '-') ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Lokasi Gudang</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-industry"></i> ' . (isset($gudang[0]->gudang) ? $gudang[0]->gudang : '-') ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Nama Barang</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-folder"></i> ' . (isset($barang[0]->nama_barang) ? $barang[0]->nama_barang : "-") ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Merek</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-registered"></i> ' . (isset($barang[0]->nama_barang) ? $barang[0]->merk : "-") ?>
						</td>
					</tr>

					<tr>
						<td class="text-left" style="width: 1%;"><strong>Spesifikasi</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-cube"></i> ' . (isset($barang[0]->spesifikasi) ? $barang[0]->spesifikasi : "-") ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Jenis Barang</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-navicon"></i> ' . strtoupper(isset($barang[0]->jenis_barang) ? $barang[0]->jenis_barang : "-") ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Jenjang</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-navicon"></i> ' . strtoupper(isset($barang[0]->jenjang) ? $barang[0]->jenjang : "-") ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Kategori</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-gear"></i> ' . (isset($barang[0]->kategori) ?  $barang[0]->kategori : "-") ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Sub Kategori</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-gear"></i> ' . (isset($barang[0]->sub_kategori) ? $barang[0]->sub_kategori : "-") ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Satuan</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-i-cursor"></i> ' . (isset($barang[0]->satuan) ? $barang[0]->satuan : "") ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Harga Beli</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-money"></i> Rp. ' . (isset($barang[0]->harga_beli) ?  str_replace(',', '.', number_format($barang[0]->harga_beli)) : "-") ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Harga Jual</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-money"></i> Rp. ' . (isset($barang[0]->harga_jual) ?  str_replace(',', '.', number_format($barang[0]->harga_jual)) : "-") ?>
						</td>
					</tr>
					<tr>
						<td class="text-left" style="width: 1%;"><strong>Stok</strong></td>
						<td class="text-left" style="width: 5%;">
							<?= ' <i class="fa fa-database"></i> ' . (isset($barang[0]->total_stok) ? $barang[0]->total_stok : "-") ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
