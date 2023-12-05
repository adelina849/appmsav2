<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Marketing_supplier extends Auth_Controller
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
			'action_add'       => site_url('admin/master/marketing_supplier/baru'),
			'action_edit'      => site_url('admin/master/marketing_supplier/edit'),
			'action_delete'    => site_url('admin/master/marketing_supplier/hapus'),
			'marketing' => $this->msa->get_all('marketing_supplier', 'id'),
			'view' => 'admin/master/marketing-supplier'
		);
		$this->load->view('admin/template', $data);
	}


	public function detail($id_marketing)
	{
		$data_marketing = $this->msa->getby_id('marketing_supplier', 'id', $id_marketing)->row();

		$data = array(
			'data' => $data_marketing,
			'view' => 'admin/master/marketing-supplier-detail'
		);

		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');

		$data = array(
			'kode'    => $this->keamanan->post($this->input->post('kode', TRUE)),
			'nama_lengkap'    => $this->keamanan->post($this->input->post('nama_lengkap', TRUE)),
			'tanggal_mulai_kerjasama' => $this->keamanan->post($this->input->post('tanggal_mulai_kerjasama', TRUE)),
			'tempat_lahir' => $this->keamanan->post($this->input->post('tempat_lahir', TRUE)),
			'tanggal_lahir' => $this->keamanan->post($this->input->post('tanggal_lahir', TRUE)),
			'nomor_handphone' => $this->keamanan->post($this->input->post('nomor_handphone', TRUE)),
			'email' => $this->keamanan->post($this->input->post('email', TRUE)),
			'alamat' => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'jenis_kelamin' => $this->keamanan->post($this->input->post('jenis_kelamin', TRUE)),
			'agama' => $this->keamanan->post($this->input->post('agama', TRUE)),
			'status_perkawinan' => $this->keamanan->post($this->input->post('status_perkawinan', TRUE)),
			'id_vendor' => $this->keamanan->post($this->input->post('id_vendor', TRUE))					
		);

		$this->msa_model->insert('marketing_supplier', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Marketing berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/marketing_supplier/daftar/inserted-success'));
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

    public function ajax_get_detail()
    {
        $id     = $this->input->post('id');
        $d = $this->msa->get_by_id('id', $id, 'marketing_supplier');

        echo json_encode(array(
			'kode'		=> $d->kode, 
			'nama_lengkap'=> $d->nama_lengkap,
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
			'id_vendor' => $d->id_vendor
        ));
    }

	function edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		$data = array(
			'kode'    => $this->keamanan->post($this->input->post('kode', TRUE)),
			'nama_lengkap'    => $this->keamanan->post($this->input->post('nama_lengkap', TRUE)),
			'tanggal_mulai_kerjasama' => $this->keamanan->post($this->input->post('tanggal_mulai_kerjasama', TRUE)),
			'tempat_lahir' => $this->keamanan->post($this->input->post('tempat_lahir', TRUE)),
			'tanggal_lahir' => $this->keamanan->post($this->input->post('tanggal_lahir', TRUE)),
			'nomor_handphone' => $this->keamanan->post($this->input->post('nomor_handphone', TRUE)),
			'email' => $this->keamanan->post($this->input->post('email', TRUE)),
			'alamat' => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'jenis_kelamin' => $this->keamanan->post($this->input->post('jenis_kelamin', TRUE)),
			'agama' => $this->keamanan->post($this->input->post('agama', TRUE)),
			'status_perkawinan' => $this->keamanan->post($this->input->post('status_perkawinan', TRUE)),
			'id_vendor' => $this->keamanan->post($this->input->post('id_vendor', TRUE))					
		);

		$this->msa_model->update('marketing_supplier', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Marketing berhasil diupdate'));
		}
		redirect(site_url('admin/master/marketing_supplier/daftar/updated-success'));
	}

	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa_model->delete('marketing', 'id', $id);
		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('marketing_supplier', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Marketing berhasil dihapus'));
		}
		redirect(site_url('admin/master/marketing_supplier/daftar/deleted-success'));
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

/* End of file admin/master/Marketing_supplier.php */
