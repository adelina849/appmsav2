<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Marketing extends Auth_Controller
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
			'action_add'       => site_url('admin/master/marketing/baru'),
			'action_edit'      => site_url('admin/master/marketing/edit'),
			'action_delete'    => site_url('admin/master/marketing/hapus'),
			'marketing' => $this->msa->get_all('marketing', 'id'),
			'view' => 'admin/master/marketing-list'
		);
		$this->load->view('admin/template', $data);
	}

	

	public function detail($id_marketing)
	{
		$data_marketing = $this->msa->getby_id('marketing', 'id', $id_marketing)->row();

		$data = array(
			'data' => $data_marketing,
			'view' => 'admin/master/marketing-detail'
		);

		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');

		$data = array(
			'nomor_id' => $this->keamanan->post($this->input->post('nomor_id')),
			'nama_lengkap' => $this->keamanan->post($this->input->post('nama_lengkap')),
			'wilayah_kerja' => $this->keamanan->post($this->input->post('wilayah')),
			'tlp' => $this->keamanan->post($this->input->post('tlp')),
			'alamat' => $this->keamanan->post($this->input->post('alamat')),
			'tanggal_mulai_bermitra' => $this->keamanan->post($this->input->post('tanggal_mulai_bermitra')),
			'tempat_lahir' => $this->keamanan->post($this->input->post('tempat_lahir')),
			'tanggal_lahir' => $this->keamanan->post($this->input->post('tanggal_lahir')),
			'email' => $this->keamanan->post($this->input->post('email')),
			'jenis_kelamin' => $this->keamanan->post($this->input->post('jenis_kelamin')),
			'agama' => $this->keamanan->post($this->input->post('agama')),
			'status_perkawinan' => $this->keamanan->post($this->input->post('status_perkawinan')),
			'jabatan' => $this->keamanan->post($this->input->post('jabatan'))
		);

		$this->msa_model->insert('marketing', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Marketing berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/marketing/daftar/inserted-success'));
	}
	public function ajax_get_detail()
    {
        $id     = $this->input->post('id');
        $d = $this->msa->get_by_id('id', $id, 'marketing');

        echo json_encode(array(
			'nomor_id'		=> $d->nomor_id, 
			'nama_lengkap'=> $d->nama_lengkap,
			'wilayah_kerja' 	=> $d->wilayah_kerja,
			'tlp'=> $d->tlp,
			'alamat'=>$d->alamat,
			'tanggal_mulai_bermitra'=> $d->tanggal_mulai_bermitra,
			'tempat_lahir'	=> $d->tempat_lahir,
			'tanggal_lahir'	=> $d->tanggal_lahir,
			'email'=> $d->email,
			'jenis_kelamin'		=> $d->jenis_kelamin,
			'agama'	=> $d->agama,
			'status_perkawinan'	=> $d->status_perkawinan,        
			'jabatan'	=> $d->jabatan,       
		));
    }

	public function cek_kode()
	{
		if ($this->input->is_ajax_request()) {
			$kode     = $this->input->post('nomor_id');

			$this->load->model('msa_model');
			$pelanggan = $this->msa_model->cek_existing_code('marketing', 'nomor_id', $kode)->result();

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


	function edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		$data = array(
			'nomor_id' => $this->keamanan->post($this->input->post('nomor_id')),
			'nama_lengkap' => $this->keamanan->post($this->input->post('nama_lengkap')),
			'wilayah_kerja' => $this->keamanan->post($this->input->post('wilayah')),
			'tlp' => $this->keamanan->post($this->input->post('tlp')),
			'alamat' => $this->keamanan->post($this->input->post('alamat')),
			'tanggal_mulai_bermitra' => $this->keamanan->post($this->input->post('tanggal_mulai_bermitra')),
			'tempat_lahir' => $this->keamanan->post($this->input->post('tempat_lahir')),
			'tanggal_lahir' => $this->keamanan->post($this->input->post('tanggal_lahir')),
			'email' => $this->keamanan->post($this->input->post('email')),
			'jenis_kelamin' => $this->keamanan->post($this->input->post('jenis_kelamin')),
			'agama' => $this->keamanan->post($this->input->post('agama')),
			'status_perkawinan' => $this->keamanan->post($this->input->post('status_perkawinan')),
			'jabatan' => $this->keamanan->post($this->input->post('jabatan')),
		);

		$this->msa_model->update('marketing', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Marketing berhasil diupdate'));
		}
		redirect(site_url('admin/master/marketing/daftar/updated-success'));
	}

	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa_model->delete('marketing', 'id', $id);
		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('marketing', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Marketing berhasil dihapus'));
		}
		redirect(site_url('admin/master/marketing/daftar/deleted-success'));
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

/* End of file admin/master/Marketing.php */
