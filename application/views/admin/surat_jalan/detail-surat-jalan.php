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
                        <td class="text-left" style="width: 20%;"><i class="fa fa-file-text-o"></i> Nomor Surat Jalan</td>
                        <td><?=(isset($surat_jalan[0]->nomor) ? $surat_jalan[0]->nomor : '-');?></td>
                    </tr>
                    <tr>
                        <td class="text-left" style="width: 20%;"><i class="fa fa-calendar"></i> Tanggal Surat Jalan</td>
                        <td><?=(isset($surat_jalan[0]->nomor) ? ($this->tanggal->konversi($surat_jalan[0]->tanggal)): '-');?></td>
                    </tr>
                    <tr>
                        <td class="text-left" style="width: 20%;"><i class="fa fa-user"></i> Exspedisi</td>
                        <td><?=(isset($surat_jalan[0]->nomor) ? (strtoupper($surat_jalan[0]->exspedisi)) : '-');?></td>
                    </tr>

                </tbody>
            </table>        
        </div>
    </div>

    <div class="row">
        <div class='col-lg-12' style="margin-bottom: 5px;">
        <form action="#" method="post" class="form-horizontal form-bordered" onsubmit="return false;">
            <input type="hidden" name="id_surat_jalan" id="id_surat_jalan" value="<?=$id_surat_jalan;?>">
            <div class="form-group">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-addon text-primary"><i class="gi gi-barcode"></i></span>
                        <select id="pilih_do" name="pilih_do" class="select-select2" style="width:100%;">
                            <option value="">-- Input Nomor DO --</option>
                            <?php
                                $do = $this->db->order_by('tanggal','ASC')->get_where('packing_do', array('dihapus' => 'tidak'))->result();
                                foreach ($do as $data_do) {
                                ?>
                                    <option data-description="" value="<?= $data_do->id; ?>">
                                        <?= $data_do->nomor_do; ?>
                                    </option>
                                <?php
                                }
                            ?>
                        </select>                    
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
            <input type="hidden" name="new_do" id="new_do">
            <div class="table-responsive">
                <table id="do" class="display table table-vcenter table-condensed table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                        <tr class="themed-color themed-background" style="font-weight: bold;">
                            <td class="text-center text-light" style="width: 3%;">NO</td>
                            <td class="text-light" style="width: 10%;">NOMOR DO</td>
                            <td class="text-light" style="width: 35%;">NAMA LEMBAGA</td>
                            <td class="text-light text-center" style="width: 10%;">JML QOLI</td>
                            <td class="text-light text-center" style="width: 10%;">JML IKAT</td>
                            <td class="text-light text-center" style="width: 10%;">LHFBD</td>
                            <td class="text-center no-sort text-light" style="width: 10%;"><i class="fa fa-cog"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $q = $this->db->get_where('surat_jalan_detail', array('surat_jalan_id' => $id_surat_jalan));
                            $no = 0;
                            foreach($q->result() as $d)
                            {
                                $id_lembaga = $d->id_lembaga;
                                $qLembaga = $this->db->get_where('lembaga', array('id' => $id_lembaga))->result();
                                $nama_lembaga = strtoupper(isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-');

                                $qDo = $this->db->get_where('packing_do', array('nomor_do' => $d->nomor_do))->result();
                                $qoli = (isset($qDo[0]->jumlah_qoli) ? $qDo[0]->jumlah_qoli : '-');
                                $ikat = (isset($qDo[0]->jumlah_ikat) ? $qDo[0]->jumlah_ikat : '-');
                            ?>
                                <tr>
                                    <td><?=++$no;?></td>
                                    <td><?=$d->nomor_do;?></td>
                                    <td><?=$nama_lembaga;?></td>
                                    <td class="text-center"><?=$qoli;?></td>
                                    <td class="text-center"><?=$ikat;?></td>
                                    <td class="text-center"><?='0 Hari';?></td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-xs">
                                            <a href="#"
                                                data_id="<?= $d->id; ?>" data_id_surat_jalan="<?= $id_surat_jalan; ?>" data-toggle="tooltip" title="Hapus DO Pada Surat Jalan" class="btn btn-alt btn-default btn-xs hapus" onclick="$('#FormHapus').modal('show');">
                                                <i class="fa fa-trash-o"></i> Hapus DO
                                            </a>
                                        </div>                                           
                                    </td>
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


<!--HAPUS  -->
<div id="FormHapus" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h2 class="modal-title text-center"><i class="gi gi-bin"></i> HAPUS NOMOR DO</h2>
			</div>
			<!-- END Modal Header -->

			<!-- Modal Body -->
			<div class="modal-body">
				<?php echo form_open($action_delete, array('class' => 'form-horizontal form-bordered"', 'id' => 'form_delete')); ?>
				<input type="hidden" name="id_detail" class="id_detail">
				<input type="hidden" name="id_suratjln" class="id_suratjln">
				<fieldset>
					<div class="form-group" style="margin:0 20px 0 20px">
						<div class="alert alert-warning alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="gi gi-circle_exclamation_mark"></i> Warning!</h4>
							Nomor DO akan dihapus pada data surat jalan, Apakah anda yakin?
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
<script>
    // ADD ROW (TOMBOL TAMBAH DI CLICK)
    $(document).ready(function() {
        $(".add-row").click(function() {
            var IdDo = $("#pilih_do").val();
            if(IdDo !=''){
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
                
            }
            else{
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

        if (IdDo =='') 
        {
            $('.modal-dialog').removeClass('modal-lg');
            $('.modal-dialog').addClass('modal-sm');
            $('#ModalHeader').html('Oops !');
            $('#ModalContent').html('Harap pilih Nomor DO terlebih dahulu!');
            $('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
            $('#ModalGue').modal('show');
        }
        else{
            //var IdDo = $("#pilih_do").val();
            var id_surat_jalan = $("#id_surat_jalan").val();
            
            var FormData = "nomor_do=" + encodeURI($('#new_do').val());
            FormData += "&id_do=" + IdDo;
            FormData += "&id_surat_jalan=" + id_surat_jalan;
            FormData += "&" + $('#do tbody input').serialize();
            $.ajax({
                url: "<?php echo site_url('admin/surat_jalan/detail/'.$id_surat_jalan.'/update-do-successfully'); ?>",
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

                        window.location.href="<?php echo site_url('admin/surat_jalan/detail/'.$id_surat_jalan.'/update-do-successfully'); ?>";

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