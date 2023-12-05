<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mitra extends Auth_Controller
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
			'action_add' => site_url('admin/master/mitra/baru'),
			'action_edit' => site_url('admin/master/mitra/edit'),
			'action_delete' => site_url('admin/master/mitra/hapus'),
			'data' => $this->msa->get_all('mitra', 'id'),
			'view' => 'admin/master/mitra-list'
		);
		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');

		$data = array(
			'kode'    => $this->keamanan->post($this->input->post('kode', TRUE)),
			'nama_mitra'    => $this->keamanan->post($this->input->post('nama_mitra', TRUE)),
			'tanggal_mulai_kerjasama' => $this->keamanan->post($this->input->post('tanggal_mulai_kerjasama', TRUE)),
			'tempat_lahir' => $this->keamanan->post($this->input->post('tempat_lahir', TRUE)),
			'tanggal_lahir' => $this->keamanan->post($this->input->post('tanggal_lahir', TRUE)),
			'nomor_handphone' => $this->keamanan->post($this->input->post('nomor_handphone', TRUE)),
			'email' => $this->keamanan->post($this->input->post('email', TRUE)),
			'alamat' => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'jenis_kelamin' => $this->keamanan->post($this->input->post('jenis_kelamin', TRUE)),
			'agama' => $this->keamanan->post($this->input->post('agama', TRUE)),
			'status_perkawinan' => $this->keamanan->post($this->input->post('status_perkawinan', TRUE)),
			'usia' => $this->keamanan->post($this->input->post('usia', TRUE)),
			'id_marketing' => $this->keamanan->post($this->input->post('id_marketing', TRUE)),
		);

		$this->msa_model->insert('mitra', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Mitra berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/mitra/daftar/inserted-success'));
	}

	public function cek_kode()
	{
		if ($this->input->is_ajax_request()) {
			$kode     = $this->input->post('kode');

			$this->load->model('msa_model');
			$pelanggan = $this->msa_model->cek_existing_code('mitra', 'kode', $kode)->result();

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


    public function ajax_get_mitra()
    {
        $id_mitra     = $this->input->post('id_mitra');
        $d = $this->msa->get_by_id('id', $id_mitra, 'mitra');

        echo json_encode(array(
			'kode'		=> $d->kode, 
			'nama_mitra'=> $d->nama_mitra,
			'tempat_lahir' 	=> $d->tempat_lahir,
			'tanggal_lahir'	=> $d->tanggal_lahir,
			'jenis_kelamin'		=> $d->jenis_kelamin,
			'alamat'=>$d->alamat,
			'agama'	=> $d->agama,
			'status_perkawinan'	=> $d->status_perkawinan,
			'tanggal_mulai_kerjasama'=> $d->tanggal_mulai_kerjasama,
			'usia'=> $d->usia,
			'nomor_handphone'=> $d->nomor_handphone,
			'email'=> $d->email,
			'id_marketing'=> $d->id_marketing
        ));
    }

	public function detail($id_mitra)
	{
		$data_mitra = $this->msa->getby_id('mitra', 'id', $id_mitra)->row();

		$data = array(
			'data' => $data_mitra,
			'view' => 'admin/master/mitra-detail'
		);

		$this->load->view('admin/template', $data);
	}

	function edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		$data = array(
			'kode' => $this->keamanan->post($this->input->post('kode', TRUE)),
			'nama_mitra' => $this->keamanan->post($this->input->post('nama_mitra', TRUE)),
			'tanggal_mulai_kerjasama' => $this->keamanan->post($this->input->post('tanggal_mulai_kerjasama', TRUE)),
			'tempat_lahir' => $this->keamanan->post($this->input->post('tempat_lahir', TRUE)),
			'tanggal_lahir' => $this->keamanan->post($this->input->post('tanggal_lahir', TRUE)),
			'nomor_handphone' => $this->keamanan->post($this->input->post('nomor_handphone', TRUE)),
			'email' => $this->keamanan->post($this->input->post('email', TRUE)),
			'alamat' => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'jenis_kelamin' => $this->keamanan->post($this->input->post('jenis_kelamin', TRUE)),
			'agama' => $this->keamanan->post($this->input->post('agama', TRUE)),
			'status_perkawinan' => $this->keamanan->post($this->input->post('status_perkawinan', TRUE)),
			'usia' => $this->keamanan->post($this->input->post('usia', TRUE)),
			'id_marketing' => $this->keamanan->post($this->input->post('id_marketing', TRUE)),
		);

		$this->msa_model->update('mitra', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Mitra berhasil diupdate'));
		}
		redirect(site_url('admin/master/mitra/daftar/updated-success'));
	}


	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa_model->delete('mitra', 'id', $id);

		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('mitra', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Mitra berhasil dihapus'));
		}
		redirect(site_url('admin/master/mitra/daftar/deleted-success'));
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

/* End of file admin/master/Mitra.php */
