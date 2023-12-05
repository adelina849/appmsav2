<!-- All Orders Block -->
<style>
	.table th {
		font-size: 5px;
	}
</style>
<div class="block full">

	<!-- All Orders Title -->
	<div class="block-title">
		<h2><i class="gi gi-message_plus animation-pulse"></i> <strong>Input Master Barang</strong></h2>
		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/master/barang/daftar'); ?>" class="" data-toggle="tooltip" title="Daftar Barang">
				<i class="fa fa-list-alt"></i> Daftar Barang
			</a>
		</div>
	</div>
	<!-- END All Orders Title -->
	<?php echo form_open($action_add, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
	<fieldset>
		<div class="form-group">
			<label class="col-md-2 control-label" for="kode_barang">Kode Barang <span class="text-danger">*</span></label>
			<div class="col-md-4">
				<input type="text" id="kode_barang" name="kode_barang" class="form-control" placeholder=".." required>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="vendor">Supplier <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<select id="vendor" name="vendor" class="select-select2 select2" style="width:100%;" required>
						<option value="" selected disabled>-- Pilih Supplier Barang --</option>
						<?
						foreach ($vendor as $v) { ?>
							<option value="<?= $v->id ?>"><?= $v->nama_vendor ?></option>
						<? } ?>
					</select>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="gudang">Lokasi Gudang <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<select id="gudang" name="gudang" class="select-select2 select2" style="width:100%;" required>
						<option value="" selected disabled>-- Pilih Lokasi Gudang --</option>
						<?php
                            $gudang = $this->db->order_by('id','DESC')->get_where('gudang', array('dihapus' => 'tidak'))->result();

						foreach ($gudang as $g) { ?>
							<option value="<?= $g->id ?>"><?= $g->kode.' '.strtoupper($g->gudang); ?></option>
						<? } ?>
					</select>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
			<div class="col-md-6">
				<input type="text" id="nama_barang" name="nama_barang" class="form-control" placeholder=".." required>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="merk">Merek </label>
			<div class="col-md-6">
				<input type="text" id="merk" name="merk" class="form-control" placeholder="">
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="spesifikasi">Spesifikasi <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" id="spesifikasi" name="spesifikasi" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="satuan">Satuan <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<select id="satuan" name="satuan" class="select-select2 select2" style="width:100%;" required>
							<option value="" selected disabled>-- Pilih Satuan Barang --</option>
							<?
							foreach ($satuan as $k) { ?>
								<option value="<?= $k->satuan ?>"><?= $k->satuan ?></option>
							<? } ?>
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
						<select id="jenis_barang" name="jenis_barang" class="select-select2 select2" style="width:100%;" required>
							<option value="" selected disabled>-- Pilih Jenis Barang --</option>
							<option value="buku">Buku</option>
							<option value="non-buku">Non Buku</option>
						</select>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="jenjang">Jenjang</label>
				<div class="col-md-8">
					<div class="input-group">
						<select id="jenjang" name="jenjang" class="select-select2 select2" style="width:100%;">
							<option value="" selected disabled>-- Pilih Jenjang --</option>
							<option value="ra">RA</option>
							<option value="tka/paud">TKA/PAUD</option>
							<option value="mi">MI</option>
							<option value="sd">SD</option>
							<option value="smp">SMP</option>
							<option value="mts">MTS</option>
							<option value="sma">SMA</option>
							<option value="smk">SMK</option>
							<option value="ma">MA</option>
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
						<select id="kategori" name="kategori" class="select-select2 select2" style="width:100%;" required>
							<option value="" selected disabled>-- Pilih Kategori Barang --</option>
							<?
							foreach ($kategori as $k) { ?>
								<option value="<?= $k->kategori ?>"><?= $k->kategori ?></option>
							<? } ?>
						</select>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="sub_kategori">Sub Kategori <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<select id="sub_kategori" name="sub_kategori" class="select-select2 select2" style="width:100%;" required>
							<option value="" selected disabled>-- Pilih Sub Kategori Barang --</option>
							<?
							foreach ($sub_kategori as $k) { ?>
								<option value="<?= $k->sub_kategori ?>"><?= $k->sub_kategori ?></option>
							<? } ?>
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
						<input type="text" id="harga_beli" name="harga_beli" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label class="col-md-4 control-label" for="harga_jual">Harga Jual <span class="text-danger">*</span></label>
				<div class="col-md-8">
					<div class="input-group">
						<input type="text" id="harga_jual" name="harga_jual" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
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


    $(document).ready(function(){
		$("#vendor").on('change', function () 
        {
            let id_supplier = $(this).find(":selected").val();  
			let kode_barang = $('#kode_barang').val();

			if(kode_barang==''){
				$("#kode_barang").val("");
				$('#vendor').val('');
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html('Silahkan isi kode barang terlebih dahulu');
				$('#ModalContent').css({
					"color": "red",
				});
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
				$('#ModalGue').modal('show');				
			}else{

				$.ajax({
					url: "<?php echo site_url('admin/master/barang/cek_supplier_barang') ?>",
					type: "POST",
					cache: false,
					data: 'kode_barang=' + kode_barang + '&id_supplier=' + id_supplier,
					dataType: 'json',
					success: function(json) {
						if (json.status == 1) {
							$("#kode_barang").val("");
							$('#vendor').val('').trigger('change');
							$('.modal-dialog').removeClass('modal-lg');
							$('.modal-dialog').addClass('modal-sm');
							$('#ModalHeader').html('Oops !');
							$('#ModalContent').html('Maaf, Kode Barang untuk supplier yang dipilih sudah digunakan.  Hanya boleh terdapat Kode barang yang sama dengan supplier yang berbeda!');
							$('#ModalContent').css({
								"color": "red",
							});
							$('#ModalFooter').html("<button type='button' id='resetSupplier' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
							$('#ModalGue').modal('show');

						}
					}
				})
			}
		})		
	});


	//cek existing kode barang
	// $(document).on('blur', '#kode_barang', function(e) {
	// 	let id_barang = e.target.value;
	// 	$.ajax({
	// 		url: "<?php echo site_url('admin/master/barang/cek_kode_barang') ?>",
	// 		type: "POST",
	// 		cache: false,
	// 		data: 'id_barang=' + id_barang,
	// 		dataType: 'json',
	// 		success: function(json) {
	// 			if (json.status == 1) {
	// 				$("#kode_barang").val("");
	// 				$('.modal-dialog').removeClass('modal-lg');
	// 				$('.modal-dialog').addClass('modal-sm');
	// 				$('#ModalHeader').html('Oops !');
	// 				$('#ModalContent').html('Maaf, Kode Barang sudah digunakan');
	// 				$('#ModalContent').css({
	// 					"color": "red",
	// 				});
	// 				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
	// 				$('#ModalGue').modal('show');

	// 			}
	// 		}
	// 	});
	// })
</script>
