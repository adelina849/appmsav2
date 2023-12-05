<link href="<?php echo base_url('assets/plugins/datatables/css/jquery.dataTables.min.css') ?>" rel="stylesheet">
<div class="block full">
	<!-- All Orders Title -->
	<div class="block-title">
		<div class="block-options pull-right" style="margin-right: 15px;">
			<span data-toggle="modal" data-target="#modal-fadein">
				<button type="button" class="btn btn-alt btn-sm btn-primary" data-toggle="tooltip" title="Tambah Stok">
					<i class="fa fa-plus-circle"></i> Tambah Hutang
				</button>
			</span>
		</div>
		<h2><i class="hi hi-cog"></i> <strong>Hutang Perusahaan</strong>
		</h2>
	</div>

	<div class="row">
		<div class='col-lg-12' style="margin-bottom: 5px;">
			<div class="table-responsive">
				<table id="table_hutang" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
					<thead>
						<tr class="themed-color themed-background">
							<th class="text-center text-light" style="width: 5%;">NO</th>
							<th class="text-center text-light" style="width: 10%;">Kode Hutang</th>
							<th class="text-center text-light" style="width: 10%;">Tanggal</th>
							<th class="text-center text-light" style="width: 10%;">Nama Vendor</th>
							<th class="text-center text-light" style="width: 10%;">Nominal</th>
							<th class="text-center text-light" style="width: 10%;">Keterangan</th>
							<th class="text-center text-light" style="width: 10%;">Status</th>
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
				<h2 class="modal-title"><i class="fa fa-plus-circle"></i> Masukan Hutang Perusahaan</h2>
			</div>
			<!-- END Modal Header -->
			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_add, array('class' => 'form-horizontal form-bordered', 'id' => 'form-validation')); ?>
				<fieldset>

					<div class="form-group">
						<label class="col-md-3 control-label" for="kode">Kode Hutang<span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="kode" value="<?= $generate_kode ?>" name="kode" class="form-control" placeholder=".." readonly required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="tanggal">Tanggal<span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon text-info"><i class="fa fa-calendar"></i></span>
								<div class="input-date" data-date-format="yyy-mm-dd">
									<input type="text" id="tanggal" name="tanggal" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="Tanggal" autocomplete="off" required>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="vendor">Supplier <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<select id="vendor" name="id_vendor" class="select-select2 select2" style="width:100%;" required>
									<option value="" selected disabled>-- Pilih Supplier --</option>
									<?
									foreach ($vendor as $v) { ?>
										<option value="<?= $v->id ?>"><?= $v->nama_vendor ?></option>
									<? } ?>
								</select>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="nominal">Nominal<span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<span class="input-group-addon text-info">Rp</span>
								<input type="text" id="nominal" name="nominal" class="form-control" placeholder=".." autocomplete="off" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="keterangan">Keterangan <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="keterangan" name="keterangan" class="form-control" placeholder=".." autocomplete="off" required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
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
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> Hapus Data Hutang</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_delete, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_delete')); ?>
				<input type="hidden" name="id" class="id">
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

		table = $('#table_hutang').DataTable({

			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				url: "<?php echo site_url('admin/keuangan/hutang/ajax_list_hutang') ?>",
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

	function form_hapus(id) {
		$(".id").val(id);
		$('#FormHapus').modal('show'); // show bootstrap modal when complete loaded
	}

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
		var hasil = rev2.split('').reverse().join('');

		$('#nominal').val(hasil);
	}
	$(document).on('keyup', '#nominal', function(e) {
		let nominal = e.target.value;
		to_rupiah(nominal);
	});
</script>
