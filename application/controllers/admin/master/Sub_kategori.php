<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sub_kategori extends Auth_Controller
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
			'action_add' => site_url('admin/master/sub_kategori/baru'),
			'action_edit' => site_url('admin/master/sub_kategori/edit'),
			'action_delete' => site_url('admin/master/sub_kategori/hapus'),
			'data' => $this->msa->get_all('kategori_sub', 'id'),
			'view' => 'admin/master/subkategori-barang-list'
		);
		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');

		$data = array(
			'sub_kategori'    => $this->keamanan->post($this->input->post('sub_kategori', TRUE)),
		);

		$this->msa_model->insert('kategori_sub', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Sub Kategori berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/sub_kategori/daftar/inserted-success'));
	}

	function form_edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));
		$sub_kategori = $this->keamanan->post($this->input->post('sub_kategori'));

		echo '
			<input type="hidden" name="id" class="id" value="' . $id . '">

			<div class="form-group">
				<label class="col-md-3 control-label" for="nama">Nama Sub Kategori <span class="text-danger">*</span></label>
				<div class="col-md-9">
					<div class="input-group">
						<input type="text" id="sub_kategori" value="' . $sub_kategori . '" name="sub_kategori" class="form-control" placeholder=".." required>
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
			'sub_kategori' => $this->keamanan->post($this->input->post('sub_kategori', TRUE)),
		);

		$this->msa_model->update('kategori_sub', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Sub Kategori berhasil diupdate'));
		}
		redirect(site_url('admin/master/sub_kategori/daftar/updated-success'));
	}

	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa_model->delete('kategori_sub', 'id', $id);
		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('kategori_sub', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Sub Kategori berhasil dihapus'));
		}
		redirect(site_url('admin/master/sub_kategori/daftar/deleted-success'));
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

/* End of file admin/master/Sub_Kategori.php */
