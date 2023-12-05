<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends Auth_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->load->model('msa_model', 'msa');
	}

	public function index()
	{
		$this->daftar();
	}

	public function daftar()
	{
		$data = array(
			'action_add'       => site_url('admin/master/vendor/baru'),
			'action_edit'      => site_url('admin/master/vendor/edit'),
			'action_delete'    => site_url('admin/master/vendor/hapus'),
			'vendor' => $this->msa->get_all('vendor', 'id'),
			'vendor_klasifikasi' => $this->msa->get_all('vendor_klasifikasi', 'id'),
			'view' => 'admin/master/vendor-list'
		);
		$this->load->view('admin/template', $data);
	}

	public function detail($id_vendor)
	{
		$data_vendor = $this->msa->getby_id('vendor', 'id', $id_vendor)->row();

		$data = array(
			'data' => $data_vendor,
			'view' => 'admin/master/vendor-detail'
		);

		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');

		$data = array(
			'kode'    => $this->keamanan->post($this->input->post('kode', TRUE)),
			'nama_vendor'    => $this->keamanan->post($this->input->post('nama_vendor', TRUE)),
			'klasifikasi'    => $this->keamanan->post($this->input->post('klasifikasi', TRUE)),
			'kontak'    => $this->keamanan->post($this->input->post('kontak', TRUE)),
			'email'    => $this->keamanan->post($this->input->post('email', TRUE)),
			'tlp'    => $this->keamanan->post($this->input->post('tlp', TRUE)),
			'alamat'    => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'nama_bank' => $this->keamanan->post($this->input->post('nama_bank', TRUE)),
			'norek' => $this->keamanan->post($this->input->post('norek', TRUE)),
		);

		$this->msa_model->insert('vendor', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Vendor berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/vendor/daftar/inserted-success'));
	}

	public function cek_kode()
	{
		if ($this->input->is_ajax_request()) {
			$kode     = $this->input->post('kode');

			$this->load->model('msa_model');
			$pelanggan = $this->msa_model->cek_existing_code('vendor', 'kode', $kode)->result();

			if (count($pelanggan) == 0) {
				//kode belum digunakan
				$json['status']     = 0;
			} else {
				//kode sudah digunakan
				$json['status']     = 1;
			}
		}
		echo json_encode($json);
	}

	function form_edit()
	{
		$this->load->model('msa_model');

		$list_klasifikasi = $this->msa->get_all('vendor_klasifikasi', 'id');

		$id = $this->keamanan->post($this->input->post('id'));
		$kode = $this->keamanan->post($this->input->post('kode', TRUE));
		$nama_vendor = $this->keamanan->post($this->input->post('nama_vendor', TRUE));
		$klasifikasi = $this->keamanan->post($this->input->post('klasifikasi', TRUE));
		$kontak = $this->keamanan->post($this->input->post('kontak', TRUE));
		$email = $this->keamanan->post($this->input->post('email', TRUE));
		$tlp = $this->keamanan->post($this->input->post('tlp', TRUE));
		$alamat = $this->keamanan->post($this->input->post('alamat', TRUE));
		$nama_bank = $this->keamanan->post($this->input->post('nama_bank', TRUE));
		$norek = $this->keamanan->post($this->input->post('norek', TRUE));

		echo '
			<input type="hidden" name="id" class="id" value="' . $id . '">

				<div class="form-group">
						<label class="col-md-3 control-label" for="kode">Kode<span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="kode" name="kode" value="' . $kode . '" class="form-control" placeholder=".." readonly required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="nama_vendor">Nama Supplier <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="nama_vendor" name="nama_vendor" value="' . $nama_vendor . '" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="klasifikasi">Klasifikasi <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<select id="example-select" name="klasifikasi" value="' . $klasifikasi . '" class="form-control" size="1">
							<option value="" selected disabled>Pilih Klasifikasi</option>
							';
		foreach ($list_klasifikasi as $data) :
			$selected = (($data->id == $klasifikasi) ? 'selected' : '');
			echo '<option value="' . $data->id . '" ' . $selected . '>'
				. strtoupper($data->klasifikasi) .
				'</option>';
		endforeach;
		echo '</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="kontak">Kontak <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="kontak" name="kontak" value="' . $kontak . '" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="email">Email <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="email" name="email" value="' . $email . '" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="tlp">Telepon <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="tlp" name="tlp" value="' . $tlp . '" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="alamat">Alamat <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="alamat" name="alamat" value="' . $alamat . '" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="nama_bank">Nama Bank <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="nama_bank" name="nama_bank" value="' . $nama_bank . '" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label" for="norek">Nomor Rekening <span class="text-danger">*</span></label>
						<div class="col-md-9">
							<div class="input-group">
								<input type="text" id="norek" name="norek" value="' . $norek . '" class="form-control" placeholder=".." required>
								<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
							</div>
						</div>
					</div>
			';
	}

	function edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		$data = array(
			'kode' => $this->keamanan->post($this->input->post('kode', TRUE)),
			'nama_vendor' => $this->keamanan->post($this->input->post('nama_vendor', TRUE)),
			'klasifikasi' => $this->keamanan->post($this->input->post('klasifikasi', TRUE)),
			'kontak' => $this->keamanan->post($this->input->post('kontak', TRUE)),
			'email' => $this->keamanan->post($this->input->post('email', TRUE)),
			'tlp' => $this->keamanan->post($this->input->post('tlp', TRUE)),
			'alamat' => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'nama_bank' => $this->keamanan->post($this->input->post('nama_bank', TRUE)),
			'norek' => $this->keamanan->post($this->input->post('norek', TRUE)),
		);

		$this->msa_model->update('vendor', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Vendor berhasil diupdate'));
		}
		redirect(site_url('admin/master/vendor/daftar/updated-success'));
	}

	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa_model->delete('vendor', 'id', $id);
		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('vendor', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Vendor berhasil dihapus'));
		}
		redirect(site_url('admin/master/vendor/daftar/deleted-success'));
	} // end hapus

	function messageAlert($type, $title)
	{
		$messageAlert = "const Toast = Swal.mixin({
	    	toast: true,
	    	position: 'bottom-end',
	        showConfirmButton: true,
	    	timer: 6000,
	    });
	    Toast.fire({
	    	type: '" . $type . "',
	    	title: '" . $title . "',
	    });";
		return $messageAlert;
	}
}

/* End of file admin/master/Vendor.php */
