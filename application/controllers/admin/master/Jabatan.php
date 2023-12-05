<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Jabatan extends Auth_Controller
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
			'action_add' => site_url('admin/master/jabatan/baru'),
			'action_edit' => site_url('admin/master/jabatan/edit'),
			'action_delete' => site_url('admin/master/jabatan/hapus'),
			'data' => $this->msa->get_all('jabatan', 'id'),
			'view' => 'admin/master/jabatan-list'
		);
		$this->load->view('admin/template', $data);
	}

	function baru()
	{

		$data = array(
			'nama_jabatan'    => $this->keamanan->post($this->input->post('nama_jabatan', TRUE)),
		);

		$this->msa->insert('jabatan', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Jabatan berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/jabatan/daftar/inserted-success'));
	}

	function form_edit()
	{
		$id = $this->keamanan->post($this->input->post('id'));
		$jabatan = $this->keamanan->post($this->input->post('nama_jabatan'));

		echo '
			<input type="hidden" name="id" class="id" value="' . $id . '">

			<div class="form-group">
				<label class="col-md-3 control-label" for="nama_jabatan">Nama Jabatan <span class="text-danger">*</span></label>
				<div class="col-md-9">
					<div class="input-group">
						<input type="text" id="nama_jabatan" value="' . $jabatan . '" name="nama_jabatan" class="form-control" placeholder=".." required>
						<span class="input-group-addon"><i class="fa fa-pencil-square-o"></i></span>
					</div>
				</div>
			</div>';
	}


	function edit()
	{

		$id = $this->keamanan->post($this->input->post('id'));

		$data = array(
			'nama_jabatan'    => $this->keamanan->post($this->input->post('nama_jabatan', TRUE)),
		);

		$this->msa->update('jabatan', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Jabatan berhasil diupdate'));
		}
		redirect(site_url('admin/master/jabatan/daftar/updated-success'));
	}


	function hapus()
	{

		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa->delete('jabatan', 'id', $id);

		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa->update('jabatan', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Jabatan berhasil dihapus'));
		}
		redirect(site_url('admin/master/jabatan/daftar/deleted-success'));
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

/* End of file admin/master/Jabatan.php */
