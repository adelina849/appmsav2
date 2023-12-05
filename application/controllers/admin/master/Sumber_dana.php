<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sumber_dana extends Auth_Controller
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
			'action_add' => site_url('admin/master/sumber_dana/baru'),
			'action_edit' => site_url('admin/master/sumber_dana/edit'),
			'action_delete' => site_url('admin/master/sumber_dana/hapus'),
			'data' => $this->msa->get_all('sumber_dana', 'id'),
			'view' => 'admin/master/sumber-dana'
		);
		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');

		$data = array(
			'sumber_dana'    => $this->keamanan->post($this->input->post('sumber_dana', TRUE)),
			'keterangan'    => $this->keamanan->post($this->input->post('keterangan', TRUE))
		);

		$this->msa_model->insert('sumber_dana', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/sumber_dana/daftar/inserted-success'));
	}



    public function ajax_get_sumberdana()
    {
        $id     = $this->input->post('id');
        $d = $this->msa->get_by_id('id', $id, 'sumber_dana');

        echo json_encode(array(
			'sumber_dana'		=> $d->sumber_dana, 
			'keterangan'=> $d->keterangan
        ));
    }

	
	function edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

        $data = array(
			'sumber_dana'    => $this->keamanan->post($this->input->post('sumber_dana', TRUE)),
			'keterangan'    => $this->keamanan->post($this->input->post('keterangan', TRUE))
		);

		$this->msa_model->update('sumber_dana', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data berhasil diupdate'));
		}
		redirect(site_url('admin/master/sumber_dana/daftar/updated-success'));
	}


	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa_model->delete('mitra', 'id', $id);

		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('sumber_dana', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data berhasil dihapus'));
		}
		redirect(site_url('admin/master/sumber_dana/daftar/deleted-success'));
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

/* End of file admin/master/Sumber_dana.php */
