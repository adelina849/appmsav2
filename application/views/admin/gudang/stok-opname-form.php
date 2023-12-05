<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/gudang/stok_opname/daftar'); ?>" class="" data-toggle="tooltip" title="Kembali ke List SO">
				<i class="fa fa-list-alt"></i> List Stok Opname
			</a>
		</div>
		<h2><i class="hi hi-cog"></i> <strong>STOK OPNAME</strong>
		</h2>
	</div>

	<div id="form_so">
		<div class="row">
			<div class='col-lg-12' style="margin-bottom: 5px;">
				<?php $qGudang = $this->db->get_where('gudang', array('id' => $data[0]->id_gudang))->result(); ?>

				<input type="hidden" name="id_gudang" id="id_gudang" value="<?= (isset($qGudang[0]->id) ? $qGudang[0]->id : ''); ?>">
				<input type="hidden" name="id_so" id="id_so" value="<?= (isset($data[0]->id) ? $data[0]->id : ''); ?>">
				<input type="hidden" name="kode_so" id="kode_so" value="<?= (isset($data[0]->kode_so) ? $data[0]->kode_so : ''); ?>">
				<table class="table table-vcenter table-condensed table-bordered table-hover" width="100%">
					<tbody>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>KODE STOK OPNAME</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= ' <i class="fa fa-file-text-o"></i> ' . (isset($data[0]->kode_so) ? $data[0]->kode_so : "-") ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Tanggal Mulai</strong></td>
							<td class="text-left" style="width: 5%;">
								<?= '<i class="fa fa-calendar"></i> ' .  (isset($data[0]->tanggal_mulai) ? $data[0]->tanggal_mulai : "-") ?>
							</td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Lokasi Gudang</strong></td>
							<td class="text-left" style="width: 5%;"> <?= '<i class="fa fa-map-marker"></i> ' . (isset($qGudang[0]->gudang) ? $qGudang[0]->gudang : ''); ?></td>
						</tr>
						<tr>
							<td class="text-left" style="width: 1%;"><strong>Status</strong></td>
							<td class="text-left" style="width: 5%;"><?= '<i class="fa fa-flask"></i> ' .  strtoupper(isset($data[0]->status) ? $data[0]->status : "-"); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- END row -->

		<div class="row">
			<div class='col-lg-12' style="margin-bottom: 5px;">
				<?php echo form_open("", array('class' => 'proses_so', 'id' => 'form-validation')); ?>
				<table id="table_barang" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr class="themed-color themed-background">
							<th class="text-center text-light" style="width: 3%;">NO</th>
							<th class="text-light" style="width: 10%;">KODE</th>
							<th class="text-light">NAMA BARANG</th>
							<th class="text-light">TOTAL STOK</th>
							<th class="text-center no-sort text-light" style="width: 15%;">Selisih</th>
							<th class="text-light">KETERANGAN</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
				<div class="form-group form-actions">
					<div class="col-md-12 text-center" style="margin-top: 15px;">
						<button type="button" id="cetak_form" class="btn btn-sm btn-success hidden-print"><i class="fa fa-print"></i> CETAK FORM</button>
						<button type="button" id="save_as_draft" class="btn btn-sm btn-default hidden-print" data-dismiss="modal"><i class="fa fa-save"></i> SIMPAN SEBAGAI DRAFT</button>
						<button type="button" id="save" class="btn btn-sm btn-info hidden-print"><i class="fa fa-database"></i> SELESAI</button>
					</div>
				</div>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</div>


<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>
<script src="<?php echo base_url('assets/plugins/datatables/js/jquery.dataTables.min.js') ?>"></script>

<script type="text/javascript">
	var table;
	var tSettings;

	$(document).ready(function() {

		var id_gudang = $("#id_gudang").val();
		var kode_so = $("#kode_so").val();
		//datatables
		table = $('#table_barang').DataTable({
			aLengthMenu: [
				[25, 50, 100, 200, -1],
				[25, 50, 100, 200, "All"]
			],
			iDisplayLength: 25,
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('admin/gudang/stok_opname/ajax_list_barang') ?>",
				"type": "POST",
				"data": {
					id_gudang: id_gudang,
					kode_so: kode_so
				},
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
		tSettings = table.settings();
	});

	let value_array = [];
	let row_checked = [];
	let result = [];

	function addState() {
		value_array.forEach(element => {
			result.push({
				id_barang: parseInt(element),
				selisih: parseInt($('#selisih_' + element).val()),
				keterangan: $('#keterangan_' + element).val(),
			})
		});
	};

	$(document).on('click', 'button#save', function() {
		addState();
		selesai_so("done");
	});

	$(document).on('click', 'button#save_as_draft', function() {
		addState();
		if (row_checked.length != 0) {
			selesai_so("draft");
		}
	});

	$(document).on('click', '#cetak_form', function() {
		//memunculkan semua data di table sebelum print
		// tSettings[0]._iDisplayLength = tSettings[0].fnRecordsTotal();
		// table.draw();
		setTimeout(function() {
			window.print();
		}, 1000);
	});

	$(document).on('change', '.proses_so input:checkbox', function(e) {
		let $this = $(this),
			value = $this.val();

		if ($this.prop('checked')) {
			value_array.push(value);
			row_checked.push(value);
			$('#selisih_' + value).removeAttr("readonly");
			$('#keterangan_' + value).removeAttr("readonly");
		} else {
			row_checked.splice(value_array.indexOf(value), 1);
			$('#selisih_' + value).attr("readonly", true);
			$('#keterangan_' + value).attr("readonly", true);
			$('#selisih_' + value).val(0);
			$('#keterangan_' + value).val("");
		}
	});

	function selesai_so(status) {
		var id_so = $("#id_so").val();
		var kode_so = $("#kode_so").val();

		let isNotValidated = result.filter(r => r.selisih === 0);
		let isValidated = result.filter(r => r.selisih !== 0);

		//untuk melakukan reset ketika submit namun value nya masih 0
		isNotValidated.forEach(e => {
			$('#selisih_' + e.id_barang).attr("readonly", true);
			$('#keterangan_' + e.id_barang).attr("readonly", true);
			$('#edit_' + e.id_barang).removeAttr('checked');
		});

		var hasil = JSON.stringify(isValidated);
		var invalid = JSON.stringify(isNotValidated);

		if (isValidated.length !== 0) {
			$.ajax({
				url: "<?php echo site_url('admin/gudang/stok_opname/simpan_hasil_so'); ?>",
				type: "POST",
				cache: false,
				data: {
					status: status,
					idSo: id_so,
					kodeSo: kode_so,
					hasil: hasil,
					hasilInvalid: invalid
				},
				dataType: 'json',
				success: function(data) {
					if (data.status == 1) {
						//alert(data.pesan);
						$('.modal-dialog').removeClass('modal-lg');
						$('.modal-dialog').addClass('modal-sm');
						$('#ModalHeader').html('Sukses !');
						$('#ModalContent').html(data.pesan);
						$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
						$('#ModalGue').modal('show');
						window.location.href = "<?php echo site_url('admin/gudang/stok_opname/daftar'); ?>";

					} else {
						$('.modal-dialog').removeClass('modal-lg');
						$('.modal-dialog').addClass('modal-sm');
						$('#ModalHeader').html('Oops !');
						$('#ModalContent').html(data.pesan);
						$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
						$('#ModalGue').modal('show');
					}
				},
				error: function(response) {
					alert("TERJADI KESALAHAN SISTEM" + response);
				}
			});
		}
		if (isValidated.length === 0 && status === "done") {
			$.ajax({
				url: "<?php echo site_url('admin/gudang/stok_opname/selesai_so'); ?>",
				type: "POST",
				cache: false,
				data: {
					idSo: id_so,
					hasilInvalid: invalid
				},
				success: function(data) {
					$('.modal-dialog').removeClass('modal-lg');
					$('.modal-dialog').addClass('modal-sm');
					$('#ModalHeader').html('Sukses !');
					$('#ModalContent').html(data.pesan);
					$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
					$('#ModalGue').modal('show');
					window.location.href = "<?php echo site_url('admin/gudang/stok_opname/daftar'); ?>";
				},
				error: function(response) {
					alert("TERJADI KESALAHAN SISTEM" + response);
				}
			});
		}

		//make sure semua array kembali kosong untuk submit berikutnya
		result = [];
		isValidated = [];
		isNotValidated = [];
		hasil = [];
		value_array = [];
	}
</script>
