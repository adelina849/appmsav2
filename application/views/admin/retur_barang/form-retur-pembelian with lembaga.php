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
			<a href="<?= site_url('admin/retur_barang/retur_pembelian'); ?>" class="" data-toggle="tooltip" title="Daftar Barang">
				<i class="fa fa-list-alt"></i> Daftar Retur Pembelian
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
					<option value="">-- Pilih Marketing Supplier --</option>
					<?php
					$marketing = $this->db
						->order_by('nama_lengkap', 'ASC')
						->get_where('marketing_supplier', array('dihapus' => 'tidak'))
						->result();
					foreach ($marketing as $marketings) {
						$supplier = $this->db->get_where('vendor', array('id' => $marketings->id_vendor))->result();
					?>
						<option data-description="<?= 'KODE MARKETING: ' . $marketings->kode .
														'<br>KODE SUPPLIER: ' . $supplier[0]->kode .
														'<br>NAMA SUPPLIER: ' . $supplier[0]->nama_vendor .
														'<br>KONTAK: ' . $supplier[0]->kontak; ?>" value="<?= $marketings->id; ?>">
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
	<div style="width: 1150px; overflow: hidden; overflow-x: auto; ">
		<div class="" style="margin-top:15px; width: 2000px;">
			<table class="table table-bordered" id='TabelTransaksi' style="width: auto;">
				<thead>
					<tr class="themed-background-amethyst text-light">
						<td class='text-center' style="width: 2%;">NO</td>
						<td style="width: 5%">NOMOR NOTA PEMBELIAN</td>
						<td style="width: 5%">NAMA LEMBAGA</td>
						<td style="width: 5%">KODE BARANG</td>
						<td style="width: 15%">NAMA BARANG</td>
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
			<div class="col-md-5">
				<button type='button' class='btn btn-primary btn-block' id='BarisBaru'>
					<i class='fa fa-plus-circle'></i> Tambah Barang
				</button>
			</div>
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


		for (B = 1; B <= 1; B++) {
			BarisBaru();
		}
		$('#BarisBaru').click(function() {
			BarisBaru();
		});

		$("#TabelTransaksi tbody").find('input[type=text],textarea,select').filter(':visible:first').focus();
	});

	function BarisBaru() {
		var Nomor = $('#TabelTransaksi tbody tr').length + 1;
		var Baris = "<tr>";
		Baris += "<td>" + Nomor + "</td>";
		Baris += "<td>";
		Baris += "<input type='text' class='form-control text-center' id='nomor_nota' name='nomor_nota[]'>";
		Baris += "</td>";
		Baris += "<td>";
		Baris += "<input type='text' class='form-control' name='nama_lembaga[]' id='pencarian_lembaga' placeholder='Ketik Kode / Nama Lembaga' autocomplete='off'>";
		Baris += "<input type='hidden' id='id_lembaga' name='id_lembaga[]'>";
		Baris += "<div id='hasil_pencarian_lembaga'></div>";
		Baris += "</td>";
		Baris += "<td>";
		Baris += "<input type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Barang' autocomplete='off'>";
		Baris += "<input type='hidden' id='id_barang' name='id_barang[]'>";
		Baris += "<div id='hasil_pencarian'></div>";
		Baris += "</td>";
		Baris += "<td>";
		Baris += "<input type='hidden' name='nama_barang[]'>";
		Baris += "<span></span>";
		Baris += "</td>";

		Baris += "<td><input type='text' class='form-control text-center' id='jumlah_retur' name='jumlah_retur[]' onkeypress='return check_int(event)'></td>";

		Baris += "<td><a href='#' class='' id='HapusBaris'><i class='fa fa-times btn-xs' style='color:red;'></i></a></td>";

		Baris += "</tr>";

		$('#TabelTransaksi tbody').append(Baris);

		$('#TabelTransaksi tbody tr').each(function() {
			// $(this).find('td:nth-child(2) input').focus(); //fokus ke pencarian field nomor nota
		});
	}

	//PENCARIAN KODE BARANG

	$(document).on('keyup', '#pencarian_kode', function(e) {
		if ($(this).val() !== '') {
			var charCode = e.which || e.keyCode;
			if (charCode == 40) {
				if ($('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(4)').find('div#hasil_pencarian li.autocomplete_active').length > 0) {
					var Selanjutnya = $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(4)').find('div#hasil_pencarian li.autocomplete_active').next();
					$('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(4)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');

					Selanjutnya.addClass('autocomplete_active');
				} else {
					$('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(4)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
				}
			} else if (charCode == 38) {
				if ($('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(4)').find('div#hasil_pencarian li.autocomplete_active').length > 0) {
					var Sebelumnya = $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(4)').find('div#hasil_pencarian li.autocomplete_active').prev();
					$('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(4)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');

					Sebelumnya.addClass('autocomplete_active');
				} else {
					$('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(4)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
				}
			} else if (charCode == 13) {
				var Field = $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(4)');
				var Idnya = Field.find('div#hasil_pencarian li.autocomplete_active span#idnya').html();
				var Kodenya = Field.find('div#hasil_pencarian li.autocomplete_active span#kodenya').html();
				var Barangnya = Field.find('div#hasil_pencarian li.autocomplete_active span#barangnya').html();

				Field.find('div#hasil_pencarian').hide();
				Field.find('input#pencarian_kode').val(Kodenya);
				Field.find('input#id_barang').val(Idnya);

				$('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(5)').html(Barangnya);


				$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').focus();
			} else {
				AutoCompleteBarang($(this).width(), $(this).val(), $(this).parent().parent().index());
			}
		} else {
			$('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(2)').find('div#hasil_pencarian').hide();
		}
	});

	// Pencarian Kode Lembaga
	$(document).on('keyup', '#pencarian_lembaga', function(e) {
		if ($(this).val() !== '') {
			var charCode = e.which || e.keyCode;
			if (charCode == 40) {
				if ($('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(3)').find('div#hasil_pencarian_lembaga li.autocomplete_active').length > 0) {
					var Selanjutnya = $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(3)').find('div#hasil_pencarian_lembaga li.autocomplete_active').next();
					$('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(3)').find('div#hasil_pencarian_lembaga li.autocomplete_active').removeClass('autocomplete_active');

					Selanjutnya.addClass('autocomplete_active');
				} else {
					$('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(3)').find('div#hasil_pencarian_lembaga li:first').addClass('autocomplete_active');
				}
			} else if (charCode == 38) {
				if ($('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(3)').find('div#hasil_pencarian_lembaga li.autocomplete_active').length > 0) {
					var Sebelumnya = $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(3)').find('div#hasil_pencarian_lembaga li.autocomplete_active').prev();
					$('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(3)').find('div#hasil_pencarian_lembaga li.autocomplete_active').removeClass('autocomplete_active');

					Sebelumnya.addClass('autocomplete_active');
				} else {
					$('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(3)').find('div#hasil_pencarian_lembaga li:first').addClass('autocomplete_active');
				}
			} else if (charCode == 13) {
				var Field = $('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(3)');
				var Idnya = Field.find('div#hasil_pencarian_lembaga li.autocomplete_active span#idnya').html();
				var Lembaganya = Field.find('div#hasil_pencarian_lembaga li.autocomplete_active span#lembaganya').html();

				Field.find('div#hasil_pencarian_lembaga').hide();
				Field.find('input#pencarian_lembaga').val(Lembaganya);
				Field.find('input#id_lembaga').val(Idnya);

				$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4) input').focus();
			} else {
				AutoCompleteLembaga($(this).width(), $(this).val(), $(this).parent().parent().index());
			}
		} else {
			$('#TabelTransaksi tbody tr:eq(' + $(this).parent().parent().index() + ') td:nth-child(2)').find('div#hasil_pencarian').hide();
		}
	});

	//AUTO COMPLITE
	function AutoCompleteBarang(Lebar, KataKunci, Indexnya) {
		$('div#hasil_pencarian').hide();
		var Lebar = Lebar + 25;
		var Registered = '';
		$('#TabelTransaksi tbody tr').each(function() {
			if (Indexnya !== $(this).index()) {
				if ($(this).find('td:nth-child(4) input').val() !== '') {
					Registered += $(this).find('td:nth-child(4) input').val() + ',';
				}
			}
		});

		if (Registered !== '') {
			Registered = Registered.replace(/,\s*$/, "");
		}

		$.ajax({
			url: "<?= ('cari_barang'); ?>",
			type: "POST",
			cache: false,
			data: 'keyword=' + KataKunci + '&registered=' + Registered,
			dataType: 'json',
			success: function(json) {
				if (json.status == 1) {
					$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4)').find('div#hasil_pencarian').css({
						'width': Lebar + 'px'
					});
					$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4)').find('div#hasil_pencarian').show('fast');
					$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4)').find('div#hasil_pencarian').html(json.datanya);
				}
				if (json.status == 0) {
					$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(5)').html('');
				}
			}
		});
	}
	//AUTO COMPLITE
	function AutoCompleteLembaga(Lebar, KataKunci, Indexnya) {
		$('div#hasil_pencarian_lembaga').hide();
		var Lebar = Lebar + 25;
		var Registered = '';
		$('#TabelTransaksi tbody tr').each(function() {
			if (Indexnya !== $(this).index()) {
				if ($(this).find('td:nth-child(3) input').val() !== '') {
					Registered += $(this).find('td:nth-child(3) input').val() + ',';
				}
			}
		});

		if (Registered !== '') {
			Registered = Registered.replace(/,\s*$/, "");
		}

		$.ajax({
			url: "<?= ('cari_lembaga'); ?>",
			type: "POST",
			cache: false,
			data: 'keyword=' + KataKunci + '&registered=' + Registered,
			dataType: 'json',
			success: function(json) {
				if (json.status == 1) {
					$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(3)').find('div#hasil_pencarian_lembaga').css({
						'width': Lebar + 'px'
					});
					$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(3)').find('div#hasil_pencarian_lembaga').show('fast');
					$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(3)').find('div#hasil_pencarian_lembaga').html(json.datanya);
				}
				if (json.status == 0) {
					$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(5)').html('');
				}
			}
		});
	}


	//DAFTAR AUTO COMPLITE
	$(document).on('click', '#daftar-autocomplete li', function() {
		$(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());

		var Indexnya = $(this).parent().parent().parent().parent().index();
		var IdBarang = $(this).find('span#idnya').html();
		var NamaBarang = $(this).find('span#barangnya').html();
		var Harganya = $(this).find('span#harganya').html();
		var Speknya = $(this).find('span#speknya').html();
		var Satuannya = $(this).find('span#satuannya').html();

		$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4)').find('div#hasil_pencarian').hide();
		$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4) input#id_barang').val(IdBarang);
		$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(5) input').val(NamaBarang);
		$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(5) span').html(NamaBarang);

		$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(6) input').focus();

	});

	//DAFTAR AUTO COMPLITE
	$(document).on('click', '#daftar-autocomplete-lembaga li', function() {
		$(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());

		var Indexnya = $(this).parent().parent().parent().parent().index();
		var IdLembaga = $(this).find('span#idnya').html();
		var NamaLembaga = $(this).find('span#lembaganya').html();
		var Harganya = $(this).find('span#harganya').html();
		var Speknya = $(this).find('span#speknya').html();
		var Satuannya = $(this).find('span#satuannya').html();

		$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(3)').find('div#hasil_pencarian_lembaga').hide();
		$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(3) input#id_lembaga').val(IdLembaga);
		$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(3) input#pencarian_lembaga').val(NamaLembaga);
		$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(3) span').html(NamaLembaga);


		$('#TabelTransaksi tbody tr:eq(' + Indexnya + ') td:nth-child(4) input').focus();

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
		var no_urut = $("#nomor_nota").val();

		var FormData = "marketing=" + $('#marketing').val();
		FormData += "&no_retur=" + $('#no_retur').val();
		FormData += "&tanggal=" + $('#tanggal').val();
		FormData += "&pelanggan=" + $('#pelanggan').val();
		FormData += "&jumlah_qoli=" + $('#jumlahQoli').val();
		FormData += "&jumlah_ikat=" + $('#jumlahIkat').val();
		FormData += "&" + $('#TabelTransaksi tbody input').serialize();

		$.ajax({
			url: "<?php echo site_url('admin/retur_barang/form_retur_pembelian'); ?>",
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