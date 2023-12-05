<!-- All Orders Block -->
<style>
	.table th {
		font-size: 5px;
	}
</style>
<div class="block full">

	<!-- All Orders Title -->
	<div class="block-title">
		<h2 class=""><i class="fa fa-file-o animation-pulse" style="margin-top: -7px"></i> <strong><?= $title; ?></strong></h2>
		<div class="block-options pull-right" style="margin-right: 15px;">
			<a href="<?= site_url('admin/retur_barang/retur_penjualan'); ?>" class="" data-toggle="tooltip" title="Daftar Barang">
				<i class="fa fa-list-alt"></i> Daftar Retur Penjualan
			</a>
		</div>
		<input type="hidden" value="<?= $no_retur ?>" name="no_retur" id="no_retur">
	</div>
	<!-- END All Orders Title -->
	<form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">
		<div class="form-group">
			<div class="col-lg-4 col-xs-6">
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					<div class="input-date" data-date-format="yyy-mm-dd">
						<input type="text" id="tanggal" name="tanggal" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal" autocomplete="off">
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6">
				<label for="marketing"><i class="fa fa-user"></i> Nama Marketing</label>
				<select id="marketing" name="marketing" class="option-line-break" style="width:100%;" placeholder="Nama Marketing">
					<option value="">-- Pilih Marketing --</option>
					<?php
					$marketing = $this->db
						->order_by('nama_lengkap', 'ASC')
						->get_where('marketing', array('dihapus' => 'tidak'))
						->result();
					foreach ($marketing as $marketings) {
					?>
						<option data-description="<?= 'KODE MARKETING: ' . $marketings->nomor_id .
														'<br>NAMA LENGKAP: ' . $marketings->nama_lengkap .
														'<br>KONTAK: ' . $marketings->tlp; ?>" value="<?= $marketings->id; ?>">
							<?= $marketings->nama_lengkap; ?>
						</option>
					<?php
					}
					?>
				</select>
			</div>

			<div class="col-md-6">
				<label for="pelanggan"><i class="fa fa-user"></i> Nama Pelanggan</label>
				<select id="pelanggan" name="pelanggan" class="option-line-break" style="width:100%;" placeholder="Nama Pelanggan">
					<option value="">-- Pilih Pelanggan --</option>
					<?php
					$pelanggan = $this->db
						->order_by('nama_pelanggan', 'ASC')
						->get_where('pelanggan', array('dihapus' => 'tidak'))
						->result();
					foreach ($pelanggan as $pelanggans) {
					?>
						<option data-description="<?= 'KODE pelanggan: ' . $pelanggans->kode ?>" value="<?= $pelanggans->id; ?>">
							<?= $pelanggans->nama_pelanggan ?>
						</option>
					<?php
					}
					?>
				</select>
			</div>
		</div>
	</form>

	<!-- END Horizontal Form Content -->
	<!-- Products Content -->
	<div class='col-sm-7'>
		<form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">
			<div class="form-group">
				<div class="col-sm-4">
					<div class="input-group">
						<span class="input-group-addon text-primary"><i class="gi gi-barcode"></i></span>
						<select id="do" name="do" class="select-select2" style="width:100%;">
							<option value="">-- Input Nomor DO --</option>
							<?php
							$do = $this->db->order_by('id', 'DESC')->get_where('packing_do', array('dihapus' => 'tidak'))->result();
							foreach ($do as $data_do) {
							?>
								<option data-description="" value="<?= $data_do->id; ?>">
									<?= $data_do->nomor_do.' => '.$data_do->id; ?>
								</option>
							<?php
							}
							?>
						</select>
						<div id='hasil_pencarian' style="padding-top: 35px"></div>
					</div>
				</div>
				<div class="col-sm-2">
					<div>
						<button type="reset" data-toggle="tooltip" title="" class="btn btn-sm btn-default add-row">
							<i class="fa fa-plus-circle"></i> Tambah DO
						</button>
					</div>
				</div>
			</div>

		</form>
	</div>
	<div style="width: 1150px; overflow: hidden; overflow-x: auto; ">

	<?php
			$a = $this->db
			->select('pdo.tanggal, pdo.nomor_do, pdo.id_packing_m, pd.id_barang, pd.qty_terpacking, b.id_vendor,b.id_barang, b.kode_barang, b.nama_barang, v.nama_vendor')
			->from('packing_do as pdo')
			->join('packing_detail as pd', 'pd.id_packing_m = pdo.id_packing_m')
			->join('barang as b', 'b.id_barang = pd.id_barang')
			->join('vendor as v', 'v.id = b.id_vendor')
			->where('pdo.id_packing_m', 18)
			->where('pd.qty_so', 0);
			$query = $a->get();
			$x = $query->result();
			var_dump($x);
	
	?>
		<div class="" style="margin-top:15px; width: 2000px;">
			<table class="table table-bordered" id='TabelTransaksi' style="width: auto;">
				<thead>
					<tr class="themed-background-amethyst text-light">
						<td class='text-center' style="width: 2%;">NO</td>
						<td style="width: 5%">NOMOR DO</td>
						<td style="width: 5%">KODE BARANG</td>
						<td style="width: 15%">NAMA BARANG</td>
						<td style="width: 5%">SUPPLIER</td>
						<td style="width: 5%" class='text-center'>QTY TERPACKING</td>
						<td class='text-center' style="width: 3%">JUMLAH RETUR</td>
						<td class='text-center' style="width: 2%"></td>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<br />
		</div>
		<!-- END table responsive -->
	</div>

	<div class="row" style="margin-top: 10px;">
		<div class='col-sm-7'>
		</div>
		<div class="col-sm-5">
			<form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">

				<div class="form-group" style="border-bottom:none; padding-bottom:0px">
					<label class="col-md-6 control-label" for="example-hf-email">
						JUMLAH QOLI
					</label>
					<div class="col-md-6">
						<input type="number" id="jumlahQoli" class="form-control" placeholder='0'>
					</div>
				</div>

				<div class="form-group" style="border-bottom:none; padding-bottom:0px">
					<label class="col-md-6 control-label" for="example-hf-email">
						JUMLAH IKAT
					</label>
					<div class="col-md-6">
						<input type="number" id="jumlahIkat" class="form-control" placeholder='0'>
					</div>
				</div>

				<div class="form-group" style="border-bottom:none;">
					<div class='col-sm-6'>
						<button type='reset' class='btn btn-warning btn-block' id='CetakStruks'>
							<i class='fa fa-refresh'></i> Batal
						</button>
					</div>
					<div class='col-sm-6'>
						<button type='button' class='btn btn-primary btn-block' id='Simpann'>
							<i class='fa fa-floppy-o'></i> Simpan (F10)
						</button>
					</div>
				</div>

			</form>
		</div>
	</div>

</div>
<!-- END All Orders Block -->
<script src="<?php echo base_url(); ?>assets/proui/js/vendor/jquery.min.js"></script>

<script>
	// ADD ROW (TOMBOL TAMBAH DI CLICK)
	$(document).ready(function() {
		$(".add-row").click(function() {
			var IdDo = $("#do").val();
			listDo();
		});

		// Find and remove selected table rows
		$(".delete-row").click(function() {
			$("table tbody").find('input[name="record"]').each(function() {
				if ($(this).is(":checked")) {
					$(this).parents("tr").remove();
				}
			});
		});
	});



	function listDo() {
		var IdDo = $("#do").val();
		let data = [];

		// if (IdDo != '') {
			$.ajax({
				url: "<?php echo site_url('admin/retur_barang/ajax_detail_do'); ?>",
				type: "POST",
				data: 'id_do=' + IdDo,
				dataType: 'json',
				success: function(response) {
					if (response.status == 1) {
						data = response.data;
					} else {
						$('.modal-dialog').removeClass('modal-lg');
						$('.modal-dialog').addClass('modal-sm');
						$('#ModalHeader').html('Oops !');
						$('#ModalContent').html(response.pesan);
						$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
						$('#ModalGue').modal('show');
					}
				},
				async: false // ajax akan selesai sebelum baris terakhir dieksekusi
			});
			let Baris = "";
			data.forEach((d) => {
				let Nomor = $('#TabelTransaksi tbody tr').length + 1;
				Baris = "<tr>";
				Baris += "<td class='text-center'>";
				Baris += "<span>" + Nomor + "</span>";
				Baris += "<input type='hidden' id='nomor_do' name='nomor_do[]' value='" + d.nomor_do + "'>";
				Baris += "<input type='hidden' id='id_barang' name='id_barang[]' value='" + d.id_barang + "'>";
				Baris += "<input type='hidden' id='kode_barang' name='kode_barang[]' value='" + d.kode_barang + "'>";
				Baris += "</td>";
				Baris += "<td>" + d.nomor_do + "</td>";
				Baris += "<td>" + d.kode_barang + "</td>";
				Baris += "<td>" + d.nama_barang + "</td>";
				Baris += "<td>";
				Baris += "<span>" + d.nama_vendor + "</span>";
				Baris += "<input type='hidden' id='id_lembaga' name='id_lembaga[]' value='" + d.id_vendor + "'>";
				Baris += "</td>";
				Baris += "<td>" + d.qty_terpacking + "</td>";
				Baris += "<td class='text-center'>";
				Baris += "<input type='number' id='jumlah retur' class='form-control' min='0' name='jumlah retur[]' ";
				Baris += "</td>";
				Baris += "<td><a href='#' class='' id='HapusBaris'><i class='fa fa-times btn-xs' style='color:red;'></i></a></td>";
				Baris += "</tr>";
				$("table tbody").append(Baris);
				$('#do option:selected').val('');
			});


			var Indexnya = $(this).parent().parent().parent().parent().index();
			$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').focus();

		// } else {
		// 	$('.modal-dialog').removeClass('modal-lg');
		// 	$('.modal-dialog').addClass('modal-sm');
		// 	$('#ModalHeader').html('Oops !');
		// 	$('#ModalContent').html('Harap pilih nomor DO selain yang ada di daftar DO');
		// 	$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
		// 	$('#ModalGue').modal('show');
		// }
	}

	$(document).ready(function() {
		//select 2 line break option
		function formatResult(result) {
			if (!result.id) return result.text;

			var myElement = $(result.element);

			var markup = '<div class="clearfix">' +
				'<p style="margin-bottom: 0px">' + result.text + '</p>' +
				'<p>' + $(myElement).data('description') + '</p>' +
				'</div>';

			return markup;
		}

		function formatSelection(result) {
			return result.full_name || result.text;
		}

		$(".option-line-break").select2({
			escapeMarkup: function(m) {
				return m;
			},
			closeOnSelect: false,
			templateResult: formatResult,
			templateSelection: formatSelection
		});



		$("#TabelTransaksi tbody").find('input[type=text],textarea,select').filter(':visible:first').focus();
	});


	function check_int(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode;
		return (charCode >= 48 && charCode <= 57 || charCode == 8);
	}


	$(function() {
		$("input.decimal").bind("change keyup input", function() {
			var position = this.selectionStart - 1;
			//remove all but number and .
			var fixed = this.value.replace(/[^0-9\.]/g, "");
			if (fixed.charAt(0) === ".")
				//can't start with .
				fixed = fixed.slice(1);

			var pos = fixed.indexOf(".") + 1;
			if (pos >= 0)
				//avoid more than one .
				fixed = fixed.substr(0, pos) + fixed.slice(pos).replace(".", "");

			if (this.value !== fixed) {
				this.value = fixed;
				this.selectionStart = position;
				this.selectionEnd = position;
			}
		});

		$("input.integer").bind("change keyup input", function() {
			var position = this.selectionStart - 1;
			//remove all but number and .
			var fixed = this.value.replace(/[^0-9]/g, "");

			if (this.value !== fixed) {
				this.value = fixed;
				this.selectionStart = position;
				this.selectionEnd = position;
			}
		});
	});

	//SHORT CUT KEYBOARD
	$(document).on('keydown', 'body', function(e) {
		var charCode = (e.which) ? e.which : event.keyCode;

		if (charCode == 117) //F6
		{
			$('#jumlah_beli').focus();
			return false;
		}

		if (charCode == 118) //F7
		{
			BarisBaru();
			return false;
		}

		if (charCode == 120) //F9
		{
			SimpanTransaksi();
			//CetakStruk();

			setTimeout(function() {
				$('button#SimpanTransaksi').focus();
			}, 500);

			return false;
		}

		if (charCode == 121) //F10
		{
			$('.modal-dialog').removeClass('modal-lg');
			$('.modal-dialog').addClass('modal-sm');
			$('#ModalHeader').html('Konfirmasi');
			$('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
			$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
			$('#ModalGue').modal('show');

			setTimeout(function() {
				$('button#SimpanTransaksi').focus();
			}, 500);

			return false;
		}
	});

	//HAPUS BARIS
	$(document).on('click', '#HapusBaris', function(e) {
		e.preventDefault();
		$(this).parent().parent().remove();

		var Nomor = 1;
		$('#TabelTransaksi tbody tr').each(function() {
			$(this).find('td:nth-child(1)').html(Nomor);
			Nomor++;
		});

		HitungTotalBayar();
	});

	//BUTTON SIMPAN DI CLICK
	$(document).on('click', '#Simpann', function() {
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGue').modal('show');

		setTimeout(function() {
			$('button#SimpanTransaksi').focus();
		}, 500);
	});

	//BUTTON MODAL DI CLICK
	$(document).on('click', 'button#SimpanTransaksi', function() {
		SimpanTransaksi();
	});

	$(document).on('click', 'button#CetakStruk', function() {
		SimpanTransaksi();
	});

	function SimpanTransaksi() {

		var FormData = "marketing=" + $('#marketing').val();
		FormData += "&no_retur=" + $('#no_retur').val();
		FormData += "&tanggal=" + $('#tanggal').val();
		FormData += "&pelanggan=" + $('#pelanggan').val();
		FormData += "&jumlah_qoli=" + $('#jumlahQoli').val();
		FormData += "&jumlah_ikat=" + $('#jumlahIkat').val();
		FormData += "&" + $('#TabelTransaksi tbody input').serialize();

		$.ajax({
			url: "<?php echo site_url('admin/retur_barang/form_retur_penjualan'); ?>",
			type: "POST",
			cache: false,
			data: FormData,
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
					// // window.location.href = "<?php echo site_url('admin/pembelian/form_stok'); ?>";

				} else {
					$('.modal-dialog').removeClass('modal-lg');
					$('.modal-dialog').addClass('modal-sm');
					$('#ModalHeader').html('Oops !');
					$('#ModalContent').html(data.pesan);
					$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
					$('#ModalGue').modal('show');
				}
			}
		});
	}
</script>