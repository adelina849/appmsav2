<!-- All Orders Block -->
<style>
	.table th {
		font-size: 5px;
	}
</style>
<div class="block full">

	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="gi gi-message_plus animation-pulse"></i> <strong>Edit Master Barang</strong></h2>
		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/master/barang/daftar'); ?>" class="" data-toggle="tooltip" title="Daftar Barang">
				<i class="fa fa-list-alt"></i> Daftar Barang
			</a>
		</div>
	</div>
	<!-- END All Orders Title -->

	<?php echo form_open($action_edit, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
	<fieldset>
		<div class="form-group">
			<input type="hidden" id="id_barang" value="<?= $barang[0]->id_barang ?>" name="id_barang" class="form-control">
			<div class="form-group">
				<label class="col-md-2 control-label" for="kode_barang">Kode Barang <span class="text-danger">*</span></label>
				<div class="col-md-4">
					<input type="text" id="kode_barang" value="<?= $barang[0]->kode_barang ?>" name="kode_barang" class="form-control" placeholder=".." required>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="vendor">Supplier <span class="text-danger">*</span></label>
				<div class="col-md-4">
					<select id="vendor" value="<?= $barang[0]->id_vendor ?>" name="vendor" class="select-select2 select2" style="width:100%;" required>
						<option value="" disabled selected>-- Pilih Supplier --</option>
						<?
						foreach ($vendor as $data) :
							$selected = (($data->id == $barang[0]->id_vendor) ? 'selected' : '');
							echo '<option value="' . $data->id . '" ' . $selected . '>'
								. strtoupper($data->nama_vendor) .
								'</option>';
						endforeach;
						?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label" for="gudang">Lokasi Gudang <span class="text-danger">*</span></label>
				<div class="col-md-4">
					<select id="gudang" value="<?= $barang[0]->id_gudang ?>" name="gudang" class="select-select2 select2" style="width:100%;" required>
						<option value="" disabled selected>-- Pilih Lokasi Gudang --</option>
						<?
						foreach ($gudang as $data) :
							$selected = (($data->id == $barang[0]->id_gudang) ? 'selected' : '');
							echo '<option value="' . $data->id . '" ' . $selected . '>'
								. strtoupper($data->gudang) .
								'</option>';
						endforeach;
						?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label" for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
				<div class="col-md-6">
					<input type="text" id="nama_barang" value="<?= $barang[0]->nama_barang ?>" name="nama_barang" class="form-control" placeholder=".." required>
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-2 control-label" for="merk">Merek </label>
				<div class="col-md-6">
					<input type="text" id="merk" name="merk" value="<?= $barang[0]->nama_barang ?>" class="form-control" placeholder="">
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6">
					<label class="col-md-4 control-label" for="spesifikasi">Spesifikasi <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<div class="input-group">
							<input type="text" id="spesifikasi" value="<?= $barang[0]->spesifikasi ?>" name="spesifikasi" class="form-control" placeholder=".." required>
							<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<label class="col-md-4 control-label" for="satuan">Satuan <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<div class="input-group">
							<select id="satuan" value="<?= $barang[0]->satuan ?>" name="satuan" class="select-select2 select2" style="width:100%;">
								<option value="" disabled selected>-- Pilih Satuan --</option>
								<?
								foreach ($satuan as $data) :
									$selected = (($data->satuan == $barang[0]->satuan) ? 'selected' : '');
									echo '<option value="' . $data->satuan . '" ' . $selected . '>'
										. strtoupper($data->satuan) .
										'</option>';
								endforeach;
								?>
							</select>
							<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<label class="col-md-4 control-label" for="jenis_barang">Jenis Barang <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<div class="input-group">
							<?php $jenis_barang = array('buku', 'non-buku') ?>
							<select id="jenis_barang" value="<?= $barang[0]->jenis_barang ?>" name="jenis_barang" class="select-select2 select2" style="width:100%;">
								<option value="" disabled selected>-- Pilih Jenis Barang --</option>
								<?
								foreach ($jenis_barang as $data) :
									$selected = (($data == $barang[0]->jenis_barang) ? 'selected' : '');
									echo '<option value="' . $data . '" ' . $selected . '>'
										. strtoupper($data) .
										'</option>';
								endforeach;
								?>
							</select>
							<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<label class="col-md-4 control-label" for="jenjang">Jenjang</label>
					<div class="col-md-8">
						<div class="input-group">
							<?php $jenjang = array('ra','tka/paud','mi','sd', 'smp','mts', 'sma','smk','ma') ?>
							<select id="jenjang" name="jenjang" value="<?= $barang[0]->jenjang ?>" class="select-select2 select2" style="width:100%;">
								<option value="" disabled selected>-- Pilih Jenjang --</option>
								<?
								foreach ($jenjang as $data) :
									$selected = (($data == $barang[0]->jenjang) ? 'selected' : '');
									echo '<option value="' . $data . '" ' . $selected . '>'
										. strtoupper($data) .
										'</option>';
								endforeach;
								?>
							</select>
							<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<label class="col-md-4 control-label" for="kategori">Kategori <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<div class="input-group">
							<select id="kategori" value="<?= $barang[0]->kategori ?>" name="kategori" class="select-select2 select2" style="width:100%;">
								<option value="" disabled selected>-- Pilih Kategori --</option>
								<?
								foreach ($kategori as $data) :
									$selected = (($data->kategori ==  str_replace("&amp;", "&", $barang[0]->kategori)) ? 'selected' : '');
									echo '<option value="' . $data->kategori . '" ' . $selected . '>'
										. strtoupper($data->kategori) .
										'</option>';
								endforeach;
								?>
							</select>
							<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<label class="col-md-4 control-label" for="sub_kategori">Sub Kategori <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<div class="input-group">
							<select id="sub_kategori" value="<?= $barang[0]->sub_kategori ?>" name="sub_kategori" class="select-select2 select2" style="width:100%;">
								<option value="" disabled selected>-- Pilih Sub Kategori --</option>
								<?
								foreach ($sub_kategori as $data) :
									$selected = (($data->sub_kategori == $barang[0]->sub_kategori) ? 'selected' : '');
									echo '<option value="' . $data->sub_kategori . '" ' . $selected . '>'
										. strtoupper($data->sub_kategori) .
										'</option>';
								endforeach;
								?>
							</select>
							<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6">
					<label class="col-md-4 control-label" for="harga_beli">Harga Beli <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<div class="input-group">
							<input type="text" id="harga_beli" value="<?= str_replace(',', '.', number_format($barang[0]->harga_beli))  ?>" name="harga_beli" class="form-control" placeholder=".." required>
							<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<label class="col-md-4 control-label" for="harga_jual">Harga Jual <span class="text-danger">*</span></label>
					<div class="col-md-8">
						<div class="input-group">
							<input type="text" id="harga_jual" value="<?= str_replace(',', '.', number_format($barang[0]->harga_jual)) ?>" name="harga_jual" class="form-control" placeholder=".." required>
							<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</fieldset>
	<div class="form-group form-actions">
		<div class="col-md-8 col-md-offset-4 text-right">
			<button type="reset" class="btn btn-sm btn-warning" data-dismiss="modal"><i class="fa fa-repeat"></i> Batal</button>
			<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Simpan</button>
		</div>
	</div>

	<?php echo form_close(); ?>

</div>
<!-- END All Orders Block -->
<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>


<script>
	//konversi nominal
	function to_rupiah(nominal) {
		//hapus titik sebelumnya terlebih dahulu
		nominal = nominal.replace(/\./g, '');
		var rev = parseInt(nominal, 10).toString().split('').reverse().join('');
		var rev2 = '';
		for (var i = 0; i < rev.length; i++) {
			rev2 += rev[i];
			if ((i + 1) % 3 === 0 && i !== (rev.length - 1)) {
				rev2 += '.';
			}
		}
		hasil = rev2.split('').reverse().join('');

		return hasil;
	}
	$(document).on('keyup', '#harga_beli', function(e) {
		let nominal = e.target.value;
		$('#harga_beli').val(to_rupiah(nominal));
	});
	$(document).on('keyup', '#harga_jual', function(e) {
		let nominal = e.target.value;
		$('#harga_jual').val(to_rupiah(nominal));
	});
</script>
