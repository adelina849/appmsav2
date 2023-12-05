<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<div class="block-options pull-right" style="margin-right: 15px;">
			<span data-toggle="modal" data-target="#modal-fadein">
				<button type="button" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Tambah Data Baru">
					<i class="fa fa-plus"></i> Tambah
				</button>
			</span>
		</div>
		<h2><i class="hi hi-cog"></i> <strong>DATA MASTER LEMBAGA</strong>
		</h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="table_lembaga" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr class="themed-color themed-background">
							<th class="text-light text-center" style="width: 5%;">NO</th>
							<th class="text-light">KODE</th>
							<th class="text-light" style="width: 20%;">NAMA LEMBAGA</th>
							<th class="text-light">ALAMAT</th>
							<th class="text-light" style="width: 10%;">KLASIFIKASI</th>
							<th class=" text-light text-center no-sort" style="width: 10%;"><i class="fa fa-cog"></i></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Modal Tambah-->
<div class="modal fade" id="modal-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-university"></i> Tambah Lembaga Baru</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_add, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
				<fieldset>

					<div class="form-group">
						<label class="col-md-2 control-label" for="kode">Kode<span class="text-danger">*</span></label>
						<div class="col-md-10">
							<div class="input-group">
								<input type="text" id="kode" name="kode" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="nama_lembaga">Nama Lembaga <span class="text-danger">*</span></label>
						<div class="col-md-10">
							<div class="input-group">
								<input type="text" id="nama_lembaga" name="nama_lembaga" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="alamat">Alamat </label>
						<div class="col-md-10">
							<div class="input-group">
								<input type="text" id="alamat" name="alamat" class="form-control" placeholder="..">
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="provinsi">Provinsi </label>
							<div class="col-md-8">
								<input type="text" id="provinsi" name="provinsi" class="form-control" placeholder="..">
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="kabupaten">Kabupaten </label>
							<div class="col-md-8">
									<input type="text" id="kabupaten" name="kabupaten" class="form-control" placeholder="..">
							</div>
						</div>
					</div>					

					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="kecamatan">Kecamatan </label>
							<div class="col-md-8">
								<input type="text" id="kecamatan" name="kecamatan" class="form-control" placeholder="..">
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="desa">Desa </label>
							<div class="col-md-8">
								<input type="text" id="desa" name="desa" class="form-control" placeholder="..">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label" for="jenjang">Jenjang </label>
						<div class="col-md-6">
							<input type="text" id="jenjang" name="jenjang" class="form-control" placeholder="..">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="status">Status </label>
						<div class="col-md-6">
							<input type="text" id="status" name="status" class="form-control" placeholder="..">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="klasifikasi">Klasifikasi </label>
						<div class="col-md-6">
							<input type="text" id="klasifikasi" name="klasifikasi" class="form-control" placeholder="..">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="nomor_telepon">Nomor Telepon </label>
						<div class="col-md-6">
							<input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control" placeholder="..">
						</div>
					</div>

				</fieldset>
				<div class="form-group form-actions">
					<div class="col-md-12 text-center">
						<button type="reset" class="btn btn-sm btn-default"><i class="fa fa-repeat"></i> Batal</button>
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

<!-- Modal edit-->
<div class="modal fade" id="FormEdit" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header text-center">
				<h2 class="modal-title"><i class="fa fa-pencil"></i> Edit Lembaga</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_edit, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_edit')); ?>
				<fieldset>

					<input type="hidden" name="id" class="id">
					<div class="form-group">
						<label class="col-md-2 control-label" for="kode">Kode<span class="text-danger">*</span></label>
						<div class="col-md-10">
							<div class="input-group">
								<input type="text" id="kode" name="kode" class="form-control" placeholder="..">
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="nama_lembaga">Nama Lembaga <span class="text-danger">*</span></label>
						<div class="col-md-10">
							<div class="input-group">
								<input type="text" id="nama_lembaga" name="nama_lembaga" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="alamat">Alamat </label>
						<div class="col-md-10">
								<input type="text" id="alamat" name="alamat" class="form-control" placeholder="..">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="provinsi">Provinsi </label>
							<div class="col-md-8">
								<input type="text" id="provinsi" name="provinsi" class="form-control" placeholder="..">
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="kabupaten">Kabupaten </label>
							<div class="col-md-8">
									<input type="text" id="kabupaten" name="kabupaten" class="form-control" placeholder="..">
							</div>
						</div>
					</div>					
					

					<div class="form-group">
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="kecamatan">Kecamatan </label>
							<div class="col-md-8">
								<input type="text" id="kecamatan" name="kecamatan" class="form-control" placeholder="..">
							</div>
						</div>
						<div class="col-md-6">
							<label class="col-md-4 control-label" for="desa">Desa </label>
							<div class="col-md-8">
								<input type="text" id="desa" name="desa" class="form-control" placeholder="..">
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label" for="jenjang">Jenjang </label>
						<div class="col-md-6">
							<input type="text" id="jenjang" name="jenjang" class="form-control" placeholder="..">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label" for="status">Status</label>
						<div class="col-md-6">
							<input type="text" id="status" name="status" class="form-control" placeholder="..">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label" for="klasifikasi">Klasifikasi </label>
						<div class="col-md-6">
							<input type="text" id="klasifikasi" name="klasifikasi" class="form-control" placeholder="..">
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-2 control-label" for="nomor_telepon">Nomor Telepon</label>
						<div class="col-md-6">
							<input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control" placeholder="..">
						</div>
					</div>

				</fieldset>
				<div class="form-group form-actions">
					<div class="col-xs-12 text-center">
						<button type="reset" class="btn btn-sm btn-default" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-sm btn-primary">Simpan</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
			<!-- END Modal Body -->
		</div>
	</div>
</div>
<!-- END Modal edit-->

<!--HAPUS  -->
<div id="FormHapus" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> Hapus Lembaga</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_delete, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_delete')); ?>
				<input type="hidden" name="id_lembaga" class="id_lembaga">
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
<script>

	var table;

	$(document).ready(function() {

		//datatables
		table = $('#table_lembaga').DataTable({

			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('admin/master/lembaga/ajax_list_lembaga') ?>",
				"type": "POST"
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

	$(".hapus").on('click', function() {
		id = $(this).attr("data_id");
		$(".id").val(id);
	});

    function detail_lembaga(id_lembaga) {
        save_method = 'update';
        //$('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('admin/master/lembaga/ajax_get_lembaga') ?>",
            type: "POST",
            data: 'id_lembaga=' + id_lembaga,
            dataType: "json",
            success: function(data) {

                $('[name="id"]').val(id_lembaga);
                $('[name="kode"]').val(data.kode);
                $('[name="nama_lembaga"]').val(data.nama_lembaga);
                $('[name="alamat"]').val(data.alamat);
                $('[name="kecamatan"]').val(data.kecamatan);
                $('[name="desa"]').val(data.desa);
                $('[name="nomor_telepon"]').val(data.nomor_telepon);
                $('[name="jenjang"]').val(data.jenjang);
                $('[name="status"]').val(data.status);
                $('[name="klasifikasi"]').val(data.klasifikasi);
                $('[name="provinsi"]').val(data.provinsi);
                $('[name="kabupaten"]').val(data.kabupaten);
                //$(".tahun").val(data.tahun).trigger("chosen:updated");
                $('#FormEdit').modal('show'); 

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

	function form_hapus(id_lembaga) {
		$(".id_lembaga").val(id_lembaga);
		$('#FormHapus').modal('show'); 
	}


	//cek existing kode lembaga
	$(document).on('blur', '#kode', function(e) {
		let kode = e.target.value;
		$.ajax({
			url: "<?php echo site_url('admin/master/lembaga/cek_kode') ?>",
			type: "POST",
			cache: false,
			data: 'kode=' + kode,
			dataType: 'json',
			success: function(json) {
				if (json.status == 1) {
					$("#kode").val("");
					$('#ModalHeader').html('Oops !');
					$('#ModalContent').html('Maaf, Kode Lembaga sudah terdaftar');
					$('#ModalContent').css({
						"color": "red",
					});
					$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
					$('#ModalGue').modal('show');

				}
			}
		});
	});
		$("#modal-fadein").on("hidden.bs.modal", function(){
			//$(".modal-body").html();
			$('#modal-fadein').empty();
		});
	//$('form').trigger('reset');


</script>
