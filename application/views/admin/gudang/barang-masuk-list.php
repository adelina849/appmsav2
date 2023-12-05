<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<div class="block-options pull-right" style="margin-right: 15px;">
			<span data-toggle="modal" data-target="#modal-fadein">
				<button type="button" class="btn btn-alt btn-sm btn-primary" data-toggle="tooltip" title="Tambah Stok">
					<i class="fa fa-plus-circle"></i> Tambah Stok
				</button>
			</span>
		</div>
		<h2><i class="hi hi-cog"></i> <strong>Barang Masuk</strong>
		</h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="table_barang_masuk" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr class="themed-color themed-background">
							<th class="text-center text-light" style="width: 5%;">NO</th>
							<th class="text-center text-light" style="width: 10%;">TANGGAL MASUK</th>
							<th class="text-center text-light">NAMA BARANG</th>
							<th class="text-center text-light" style="width: 10%;">Stok Masuk</th>
							<th class="text-center text-light">KETERANGAN</th>
							<th class="text-center text-light no-sort" style="width: 5%;"><i class="fa fa-cog"></i></th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal Tambah-->
<div class="modal fade" id="modal-fadein" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-plus-circle"></i> Tambah Stok</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_add, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
				<fieldset>

					<div class="form-group">
						<label class="col-md-3 control-label" for="tanggal_masuk">TANGGAL MASUK<span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
								<div class="input-date" data-date-format="yyy-mm-dd">
									<input type="text" id="tanggal_masuk" name="tanggal_masuk" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal Masuk" autocomplete="off">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="id_barang">NAMA BARANG <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<input type='hidden' class='form-control' name='id_barang' id='id_barang'>
							<input type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Barang' autocomplete="off">
							<div id="list_barang">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="keterangan">KETERANGAN <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<input type='text' class='form-control' name='keterangan' id='keterangan' placeholder='Keterangan Barang Masuk' autocomplete="off">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="total_stok">STOK MASUK <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="number" id="total_stok" name="total_stok" class="form-control" placeholder=".." required>
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
				<!-- END Form Validation Example Content -->
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
<!-- END Modal Tambah-->

<!--HAPUS  -->
<div id="FormHapus" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> Hapus Data Barang Masuk</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_delete, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_delete')); ?>
				<input type="hidden" name="id" class="id">
				<input type="hidden" name="id_barang" class="id_barang">
				<input type="hidden" name="total_stok" class="total_stok">
				<fieldset>
					<div class="form-group" style="margin:0 20px 0 20px">
						<div class="alert alert-warning alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="gi gi-circle_exclamation_mark"></i> Warning!</h4>
							Semua Data terkait akan dihapus, Apakah anda yakin?
						</div>
					</div>
				</fieldset>
				<div class="form-group form-actions">
					<div class="col-xs-12 text-center">
						<button type="reset" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-sm btn-primary">Hapus</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
<!-- END HAPUS -->

<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script type="text/javascript">
	var table;

	$(document).ready(function() {

		table = $('#table_barang_masuk').DataTable({

			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				url: "<?php echo site_url('admin/gudang/barang_masuk/ajax_list_barang_masuk') ?>",
				type: "POST"
			},
			'language': {
				"search": "",
			},
			//Set column definition initialisation properties.
			"columnDefs": [{
				"targets": [0], //first column / numbering column
				"orderable": false, //set not orderable
			}, ],

		});
		$('body').tooltip({
			selector: '[data-toggle="tooltip"]'
		});

	});

	function form_hapus(id, id_barang, total_stok) {
		$(".id").val(id);
		$(".id_barang").val(id_barang);
		$(".total_stok").val(total_stok);
		$('#FormHapus').modal('show'); // show bootstrap modal when complete loaded
	}

	let timer; // Timer identifier
	const waitTime = 500; // delay processing saat typing kode/nama barang

	//fungsi search untuk mencari kode/nama barang saat menambahkan stok/barang masuk di Modal Tambah Data
	const search = (keyword) => {
		$.ajax({
			url: "<?php echo site_url('admin/gudang/barang_masuk/cari_kode_barangmasuk') ?>",
			type: "POST",
			cache: false,
			data: 'keyword=' + keyword,
			dataType: 'json',
			success: function(json) {
				if (json.status == 1) {
					$("#list_barang").empty();
					$('#list_barang').append(json.datanya);
					$('#list_barang').css({
						"height": "150px",
						"overflow-y": "auto",
						"z-index": "9",
						"position": "absolute"
					})

				}
			}
		});
	};

	//set value kode/nama barang yang dipilih
	$(document).on('click', '#daftar-autocomplete li', function(e) {
		var selected_id = $(this).find('span#selected_id').html();
		var selected_nama = $(this).find('span#selected_nama').html();
		$('#id_barang').val(selected_id);
		$('#pencarian_kode').val(selected_nama);
		$('#list_barang').empty();
	});

	//PENCARIAN KODE
	$(document).on('keyup', '#pencarian_kode', function(e) {
		let KataKunci = e.target.value;
		clearTimeout(timer);

		timer = setTimeout(() => {
			search(KataKunci);
		}, waitTime);
	});
</script>
