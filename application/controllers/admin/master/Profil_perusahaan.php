<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profil_perusahaan extends Auth_Controller
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
			'data' => $this->msa->get_all('profil_perusahaan', 'id'),
			'view' => 'admin/master/profil-perusahaan-list'
		);
		$this->load->view('admin/template', $data);
	}
	public function ubah($id)
	{
		$data = array(
			'action_edit' => site_url('admin/master/profil_perusahaan/edit'),
			'data' => $this->msa->getby_id('profil_perusahaan', 'id', $id)->result(),
			'view' => 'admin/master/profil-perusahaan-edit'
		);
		$this->load->view('admin/template', $data);
	}

	function edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		$data = array(
			'kode_perusahaan'    => $this->keamanan->post($this->input->post('kode_perusahaan', TRUE)),
			'nama_perusahaan'    => $this->keamanan->post($this->input->post('nama_perusahaan', TRUE)),
			'alamat'    => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'website'    => $this->keamanan->post($this->input->post('website', TRUE)),
			'email'    => $this->keamanan->post($this->input->post('email', TRUE)),
			'tlp'    => $this->keamanan->post($this->input->post('tlp', TRUE)),
			'nama_direktur'    => $this->keamanan->post($this->input->post('nama_direktur', TRUE)),
			'nama_komanditer'    => $this->keamanan->post($this->input->post('nama_komanditer', TRUE)),
			'nomor_akta_pendirian'    => $this->keamanan->post($this->input->post('nomor_akta_pendirian', TRUE)),
			'tanggal_akta_pendirian'    => $this->keamanan->post($this->input->post('tanggal_akta_pendirian', TRUE)),
			'nama_notaris'    => $this->keamanan->post($this->input->post('nama_notaris', TRUE)),
			'presentase_kepemilikan_direktur'    => $this->keamanan->post($this->input->post('presentase_kepemilikan_direktur', TRUE)),
			'presentase_kepemilikan_komanditer'    => $this->keamanan->post($this->input->post('presentase_kepemilikan_komanditer', TRUE)),
			'nomor_akta_perubahan_terakhir'    => $this->keamanan->post($this->input->post('nomor_akta_perubahan_terakhir', TRUE)),
			'tanggal_akta_perubahan_terakhir'    => $this->keamanan->post($this->input->post('tanggal_akta_perubahan_terakhir', TRUE)),
			'nama_direktur_akta_perubahan_terakhir'    => $this->keamanan->post($this->input->post('nama_direktur_akta_perubahan_terakhir', TRUE)),
			'nama_komanditer_akta_perubahan_terakhir'    => $this->keamanan->post($this->input->post('nama_komanditer_akta_perubahan_terakhir', TRUE)),
			'nama_notaris_akta_perubahan_terakhir'    => $this->keamanan->post($this->input->post('nama_notaris_akta_perubahan_terakhir', TRUE)),
			'npwp'    => $this->keamanan->post($this->input->post('npwp', TRUE)),
			'nib'    => $this->keamanan->post($this->input->post('nib', TRUE)),
		);

		$this->msa_model->update('profil_perusahaan', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Profil Perusahaan berhasil diupdate'));
		}
		redirect(site_url('admin/master/profil_perusahaan/daftar/updated-success'));
	}

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

/* End of file admin/master/Profil_Perusahaan.php */
