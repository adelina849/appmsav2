<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vendor_klasifikasi extends Auth_Controller
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
			'action_add' => site_url('admin/master/vendor_klasifikasi/baru'),
			'action_edit' => site_url('admin/master/vendor_klasifikasi/edit'),
			'action_delete' => site_url('admin/master/vendor_klasifikasi/hapus'),
			'data' => $this->msa->get_all('vendor_klasifikasi', 'id'),
			'view' => 'admin/master/vendor-klasifikasi-list'
		);
		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');

		$data = array(
			'klasifikasi'    => $this->keamanan->post($this->input->post('klasifikasi', TRUE)),
		);

		$this->msa_model->insert('vendor_klasifikasi', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Vendor Klasifikasi berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/vendor_klasifikasi/daftar/inserted-success'));
	}

	function form_edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));
		$klasifikasi = $this->keamanan->post($this->input->post('klasifikasi'));

		echo '
			<input type="hidden" name="id" class="id" value="' . $id . '">

			<div class="form-group">
				<label class="col-md-3 control-label" for="klasifikasi">Supplier Klasifikasi <span class="text-danger">*</span></label>
				<div class="col-md-9">
					<div class="input-group">
						<input type="text" id="klasifikasi" value="' . $klasifikasi . '" name="klasifikasi" class="form-control" placeholder=".." required>
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
			'klasifikasi' => $this->keamanan->post($this->input->post('klasifikasi', TRUE)),
		);

		$this->msa_model->update('vendor_klasifikasi', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Vendor Klasifikasi berhasil diupdate'));
		}
		redirect(site_url('admin/master/vendor_klasifikasi/daftar/updated-success'));
	}

	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa_model->delete('vendor_klasifikasi', 'id', $id);
		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('vendor_klasifikasi', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Vendor Klasifikasi berhasil dihapus'));
		}
		redirect(site_url('admin/master/vendor_klasifikasi/daftar/deleted-success'));
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

/* End of file admin/master/Vendor_Klasifikasi.php */
