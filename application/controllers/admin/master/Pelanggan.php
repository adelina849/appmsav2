<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pelanggan extends Auth_Controller
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
			'action_add' => site_url('admin/master/pelanggan/baru'),
			'action_edit' => site_url('admin/master/pelanggan/edit'),
			'action_delete' => site_url('admin/master/pelanggan/hapus'),
			'data' => $this->msa->get_all('pelanggan', 'id'),
			'jabatan' => $this->msa->get_all('jabatan', 'id'),
			'view' => 'admin/master/pelanggan-list'
		);
		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');

		$data = array(
			'kode'    => $this->keamanan->post($this->input->post('kode', TRUE)),
			'nama_pelanggan'    => $this->keamanan->post($this->input->post('nama_pelanggan', TRUE)),
			'jabatan'    => $this->keamanan->post($this->input->post('jabatan', TRUE)),
			'kontak'    => $this->keamanan->post($this->input->post('kontak', TRUE)),
			'tempat_lahir' => $this->keamanan->post($this->input->post('tempat_lahir', TRUE)),
			'tanggal_lahir' => $this->keamanan->post($this->input->post('tanggal_lahir', TRUE)),
			'jenis_kelamin' => $this->keamanan->post($this->input->post('jenis_kelamin', TRUE)),
			'alamat' => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'agama' => $this->keamanan->post($this->input->post('agama', TRUE)),
			'status_perkawinan' => $this->keamanan->post($this->input->post('status_perkawinan', TRUE)),
			'tanggal_jadi_pelanggan' => $this->keamanan->post($this->input->post('tanggal_jadi_pelanggan', TRUE)),
			'usia' => $this->keamanan->post($this->input->post('usia', TRUE)),
			'email' => $this->keamanan->post($this->input->post('email', TRUE)),
			'id_lembaga' => $this->keamanan->post($this->input->post('lembaga', TRUE)),
		);

		$this->msa_model->insert('pelanggan', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Pelanggan berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/pelanggan/daftar/inserted-success'));
	}

	public function cek_kode()
	{
		if ($this->input->is_ajax_request()) {
			$kode     = $this->input->post('kode');

			$this->load->model('msa_model');
			$pelanggan = $this->msa_model->cek_existing_code('pelanggan', 'kode', $kode)->result();

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

    public function ajax_get_pelanggan()
    {
        $id_pelanggan     = $this->input->post('id_pelanggan');
        $d = $this->msa->get_by_id('id', $id_pelanggan, 'pelanggan');
        echo json_encode(array(
			'kode'		=> $d->kode, 
			'nama_pelanggan'=> $d->nama_pelanggan,
			'jabatan'=> $d->jabatan,
			'kontak'=> $d->kontak,
			'tempat_lahir' 	=> $d->tempat_lahir,
			'tanggal_lahir'	=> $d->tanggal_lahir,
			'jenis_kelamin'		=> $d->jenis_kelamin,
			'alamat'=>$d->alamat,
			'agama'	=> $d->agama,
			'status_perkawinan'	=> $d->status_perkawinan,
			'tanggal_jadi_pelanggan'=> $d->tanggal_jadi_pelanggan,
			'usia'=> $d->usia,
			'email'=> $d->email,
			'id_lembaga'=> $d->id_lembaga
        ));
    }


	public function detail($id_pelanggan)
	{
		$data_pelanggan = $this->msa->getby_id('pelanggan', 'id', $id_pelanggan)->row();

		$data = array(
			'pelanggan' => $data_pelanggan,
			'view' => 'admin/master/pelanggan-detail'
		);

		$this->load->view('admin/template', $data);
	}


	function edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		$data = array(
			'kode'    => $this->keamanan->post($this->input->post('kode', TRUE)),
			'nama_pelanggan'    => $this->input->post('nama_pelanggan', TRUE),
			'jabatan'    => $this->keamanan->post($this->input->post('jabatan', TRUE)),
			'kontak'    => $this->keamanan->post($this->input->post('kontak', TRUE)),
			'tempat_lahir' => $this->keamanan->post($this->input->post('tempat_lahir', TRUE)),
			'tanggal_lahir' => $this->keamanan->post($this->input->post('tanggal_lahir', TRUE)),
			'jenis_kelamin' => $this->keamanan->post($this->input->post('jenis_kelamin', TRUE)),
			'alamat' => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'agama' => $this->keamanan->post($this->input->post('agama', TRUE)),
			'status_perkawinan' => $this->keamanan->post($this->input->post('status_perkawinan', TRUE)),
			'tanggal_jadi_pelanggan' => $this->keamanan->post($this->input->post('tanggal_jadi_pelanggan', TRUE)),
			'usia' => $this->keamanan->post($this->input->post('usia', TRUE)),
			'email' => $this->keamanan->post($this->input->post('email', TRUE)),
			'id_lembaga' => $this->keamanan->post($this->input->post('lembaga', TRUE)),
		);

		$this->msa_model->update('pelanggan', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Pelanggan berhasil diupdate'));
		}
		redirect(site_url('admin/master/pelanggan/daftar/updated-success'));
	}


	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa_model->delete('pelanggan', 'id', $id);

		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('pelanggan', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Pelanggan berhasil dihapus'));
		}
		redirect(site_url('admin/master/pelanggan/daftar/deleted-success'));
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

/* End of file admin/master/Pelanggan.php */
