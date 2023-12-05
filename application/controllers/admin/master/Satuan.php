<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Satuan extends Auth_Controller
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
			'action_add' => site_url('admin/master/satuan/baru'),
			'action_edit' => site_url('admin/master/satuan/edit'),
			'action_delete' => site_url('admin/master/satuan/hapus'),
			'data' => $this->msa->get_all('satuan', 'id'),
			'view' => 'admin/master/satuan-barang-list'
		);
		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');

		$data = array(
			'satuan'    => $this->keamanan->post($this->input->post('satuan', TRUE)),
		);

		$this->msa_model->insert('satuan', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Satuan berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/satuan/daftar/inserted-success'));
	}

	function form_edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));
		$satuan = $this->keamanan->post($this->input->post('satuan'));

		echo '
			<input type="hidden" name="id" class="id" value="' . $id . '">

			<div class="form-group">
				<label class="col-md-3 control-label" for="satuan">Nama Satuan <span class="text-danger">*</span></label>
				<div class="col-md-9">
					<div class="input-group">
						<input type="text" id="satuan" value="' . $satuan . '" name="satuan" class="form-control" placeholder=".." required>
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
			'satuan' => $this->keamanan->post($this->input->post('satuan', TRUE)),
		);

		$this->msa_model->update('satuan', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Satuan berhasil diupdate'));
		}
		redirect(site_url('admin/master/satuan/daftar/updated-success'));
	}


	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa_model->delete('satuan', 'id', $id);

		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('satuan', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Satuan berhasil dihapus'));
		}
		redirect(site_url('admin/master/satuan/daftar/deleted-success'));
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

/* End of file admin/master/Satuan.php */
