<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gudang extends Auth_Controller
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

		$this->load->model('msa_model');

		//untuk generate kode gudang
		$query = $this->msa_model->get_last_code('gudang', 'id')->result();
		$max_id = (isset($query[0]->kode) ? $query[0]->kode : 0);
		$angka = (int) substr($max_id, 1, 3);
		$angka++;
		$huruf = "G";
		$kode_baru = $huruf . sprintf("%03s", $angka);
		// selesai generate kode gudang

		$data = array(
			'action_add' => site_url('admin/master/gudang/baru'),
			'action_edit' => site_url('admin/master/gudang/edit'),
			'action_delete' => site_url('admin/master/gudang/hapus'),
			'data' => $this->msa->get_all('gudang', 'id'),
			'generate_kode' => $kode_baru,
			'view' => 'admin/master/gudang-lokasi-list'
		);
		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');

		$data = array(
			'kode'    => $this->keamanan->post($this->input->post('kode', TRUE)),
			'gudang'    => $this->keamanan->post($this->input->post('gudang', TRUE)),
		);

		$this->msa_model->insert('gudang', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Gudang berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/gudang/daftar/inserted-success'));
	}

	function form_edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));
		$gudang = $this->keamanan->post($this->input->post('gudang'));

		echo '
			<input type="hidden" name="id" class="id" value="' . $id . '">

			<div class="form-group">
				<label class="col-md-3 control-label" for="nama">Nama Gudang <span class="text-danger">*</span></label>
				<div class="col-md-9">
					<div class="input-group">
						<input type="text" id="gudang" value="' . $gudang . '" name="gudang" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>';
	}


	function edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		$data = array(
			'gudang' => $this->keamanan->post($this->input->post('gudang', TRUE)),
		);

		$this->msa_model->update('gudang', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Gudang berhasil diupdate'));
		}
		redirect(site_url('admin/master/gudang/daftar/updated-success'));
	}


	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa_model->delete('gudang', 'id', $id);

		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('gudang', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Gudang berhasil dihapus'));
		}
		redirect(site_url('admin/master/gudang/daftar/deleted-success'));
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

/* End of file admin/master/Gudang.php */
