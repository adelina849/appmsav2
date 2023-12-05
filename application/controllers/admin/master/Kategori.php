<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kategori extends Auth_Controller
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
			'action_add' => site_url('admin/master/kategori/baru'),
			'action_edit' => site_url('admin/master/kategori/edit'),
			'action_delete' => site_url('admin/master/kategori/hapus'),
			'data' => $this->msa->get_all('kategori', 'id'),
			'view' => 'admin/master/kategori-barang-list'
		);
		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');

		$data = array(
			'kategori'    => $this->keamanan->post($this->input->post('kategori', TRUE)),
		);

		$this->msa_model->insert('kategori', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Kategori berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/kategori/daftar/inserted-success'));
	}

	function form_edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));
		$kategori = $this->keamanan->post($this->input->post('kategori'));

		echo '
			<input type="hidden" name="id" class="id" value="' . $id . '">

			<div class="form-group">
				<label class="col-md-3 control-label" for="nama">Nama Kategori <span class="text-danger">*</span></label>
				<div class="col-md-9">
					<div class="input-group">
						<input type="text" id="kategori" value="' . $kategori . '" name="kategori" class="form-control" placeholder=".." required>
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
			'kategori' => $this->keamanan->post($this->input->post('kategori', TRUE)),
		);

		$this->msa_model->update('kategori', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Kategori berhasil diupdate'));
		}
		redirect(site_url('admin/master/kategori/daftar/updated-success'));
	}

	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa_model->delete('kategori', 'id', $id);

		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('kategori', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Kategori berhasil dihapus'));
		}
		redirect(site_url('admin/master/kategori/daftar/deleted-success'));
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

/* End of file admin/master/Kategori.php */
