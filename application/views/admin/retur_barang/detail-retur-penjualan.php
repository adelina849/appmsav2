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
						<td class="text-left" style="width: 20%;">Nomor DO</td>
						<td>
							<?php
							$id_do = (isset($retur_master[0]->id_do) ? $retur_master[0]->id_do : '0'); 

							$do = $this->db->get_where('packing_do', array('id' => $id_do))->result();
							echo (isset($do[0]->nomor_do) ? $do[0]->nomor_do : '-');
							?>
						</td>
					</tr>

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
						<td><?= (isset($qMarketing[0]->nomor_id) ? $qMarketing[0]->nomor_id : '-'); ?></td>
					</tr>
					<tr>
						<td class="text-left" style="width: 20%;">Nama Marketing</td>
						<td><?= (isset($qMarketing[0]->nama_lengkap) ? $qMarketing[0]->nama_lengkap : '-'); ?></td>
					</tr>
					<tr>
						<td class="text-left" style="width: 20%;">Kode Lembaga</td>
						<td><?= (isset($qLembaga[0]->kode) ? $qLembaga[0]->kode : '-'); ?></td>
					</tr>
					<tr>
						<td class="text-left" style="width: 20%;">Nama Lembaga</td>
						<td><?= (isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-'); ?></td>
					</tr>
					<tr>
						<td class="text-left" style="width: 20%;">Kode Pelanggan</td>
						<td><?= (isset($qPelanggan[0]->kode) ? $qPelanggan[0]->kode : '-'); ?></td>
					</tr>
					<tr>
						<td class="text-left" style="width: 20%;">Nama Pelanggan</td>
						<td><?= (isset($qPelanggan[0]->nama_pelanggan) ? $qPelanggan[0]->nama_pelanggan : '-'); ?></td>
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
							<td class="text-light" style="width: 5%;">KODE BARANG</td>
							<td class="text-light" style="width: 35%;">NAMA BARANG</td>
							<td class="text-light" style="width: 35%;">NAMA SUPPLIER</td>
							<td class="text-light" style="width: 5%;">JUMLAH RETUR</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$q = $this->db->get_where('retur_barang_penjualan_detail', array('id_retur_master' => $id_retur_master));
						$no = 0;
						foreach ($q->result() as $d) {
							$id_barang = $d->id_barang;
							$qBarang = $this->db->get_where('barang', array('id_barang' => $id_barang))->result();
							$qVendor = $this->db->get_where('vendor', array('id' => $qBarang[0]->id_vendor))->result();
							$nama_vendor = strtoupper(isset($qVendor[0]->nama_vendor) ? $qVendor[0]->nama_vendor : '-');
							$kode_barang = strtoupper(isset($qBarang[0]->kode_barang) ? $qBarang[0]->kode_barang : '-');
							$nama_barang = strtoupper(isset($qBarang[0]->nama_barang) ? $qBarang[0]->nama_barang : '-');

						?>
							<tr>
								<td><?= ++$no; ?></td>
								<td><?= $kode_barang; ?></td>
								<td><?= $nama_barang; ?></td>
								<td><?= $nama_vendor; ?></td>
								<td class='text-center'><?= $d->jumlah_retur; ?></td>
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
<script>
	// ADD ROW (TOMBOL TAMBAH DI CLICK)
	$(document).ready(function() {
		$(".add-row").click(function() {
			var IdDo = $("#pilih_do").val();
			if (IdDo != '') {
				$("#new_do").val(IdDo);
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Konfirmasi');
				$('#ModalContent').html("Anda akan menambahkan Nomor DO baru, Apakah anda yakin?");
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='UpdateSuratJalan'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
				$('#ModalGue').modal('show');

				setTimeout(function() {
					$('button#UpdateSuratJalan').focus();
				}, 500);

			} else {
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html('Harap pilih nomor DO');
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
				$('#ModalGue').modal('show');
			}
		});
	});

	//BUTTON MODAL DI CLICK
	$(document).on('click', 'button#UpdateSuratJalan', function() {
		//CetakStruk();
		UpdateSuratJalan();
	});

	function UpdateSuratJalan() {
		//cek kalo dipilih diinput nama pelanggan
		var IdDo = $("#new_do").val();

		if (IdDo == '') {
			$('.modal-dialog').removeClass('modal-lg');
			$('.modal-dialog').addClass('modal-sm');
			$('#ModalHeader').html('Oops !');
			$('#ModalContent').html('Harap pilih Nomor DO terlebih dahulu!');
			$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
			$('#ModalGue').modal('show');
		} else {
			//var IdDo = $("#pilih_do").val();
			var id_surat_jalan = $("#id_surat_jalan").val();

			var FormData = "nomor_do=" + encodeURI($('#new_do').val());
			FormData += "&id_do=" + IdDo;
			FormData += "&id_surat_jalan=" + id_surat_jalan;
			FormData += "&" + $('#retur tbody input').serialize();
			$.ajax({
				url: "<?php echo site_url('admin/surat_jalan/detail/' . $id_surat_jalan . '/update-do-successfully'); ?>",
				type: "POST",
				cache: false,
				data: FormData,
				dataType: 'json',
				success: function(data) {
					if (data.status == 1) {
						$('.modal-dialog').removeClass('modal-lg');
						$('.modal-dialog').addClass('modal-sm');
						$('#ModalHeader').html('Sukses !');
						$('#ModalContent').html(data.pesan);
						$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
						$('#ModalGue').modal('show');

						window.location.href = "<?php echo site_url('admin/surat_jalan/detail/' . $id_surat_jalan . '/update-do-successfully'); ?>";

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
	}

	$(".hapus").on('click', function() {
		id = $(this).attr("data_id");
		id_surat_jalan = $(this).attr("data_id_surat_jalan");
		$(".id_detail").val(id);
		$(".id_suratjln").val(id_surat_jalan);
	});
</script>