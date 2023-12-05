<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class pelaksana extends Auth_Controller
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
			'action_add' => site_url('admin/master/pelaksana/baru'),
			'action_edit' => site_url('admin/master/pelaksana/edit'),
			'action_delete' => site_url('admin/master/pelaksana/hapus'),
			'data' => $this->msa->get_all('pelaksana', 'id'),
			'view' => 'admin/master/pelaksana-list'
		);
		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');
		
		$data = array(
			'nama_cv'    => $this->keamanan->post($this->input->post('pelaksana', TRUE)),
			'kode'    => $this->keamanan->post($this->input->post('kode', TRUE)),
			'kontak'    => $this->keamanan->post($this->input->post('kontak', TRUE)),
			'alamat'    => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'direktur'    => $this->keamanan->post($this->input->post('direktur', TRUE)),
			'komanditer'    => $this->keamanan->post($this->input->post('komanditer', TRUE)),
			'nomor_akta'    => $this->keamanan->post($this->input->post('nomor_akta', TRUE)),
			'tanggal_akta'    => $this->keamanan->post($this->input->post('tanggal_akta', TRUE)),
			'nama_notaris'    => $this->keamanan->post($this->input->post('nama_notaris', TRUE)),
			'presentase_direktur'    => $this->keamanan->post($this->input->post('presentase_direktur', TRUE)),
			'presentase_komanditer'    => $this->keamanan->post($this->input->post('presentase_komanditer', TRUE)),
			'nomor_perubahan'    => $this->keamanan->post($this->input->post('nomor_perubahan', TRUE)),
			'tanggal_perubahan'    => $this->keamanan->post($this->input->post('tanggal_perubahan', TRUE)),
			'direktur_perubahan'    => $this->keamanan->post($this->input->post('direktur_perubahan', TRUE)),
			'komanditer_perubahan'    => $this->keamanan->post($this->input->post('komanditer_perubahan', TRUE)),
			'notaris'    => $this->keamanan->post($this->input->post('notaris', TRUE)),
			'nib'    => $this->keamanan->post($this->input->post('nib', TRUE)),
			'email'    => $this->keamanan->post($this->input->post('email', TRUE)),
		);

		$this->msa_model->insert('pelaksana', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data pelaksana berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/pelaksana/daftar/inserted-success'));
	}


    public function ajax_get_pelaksana()
    {
        $id_pelaksana     = $this->input->post('id_pelaksana');
        $d = $this->msa->get_by_id('id', $id_pelaksana, 'pelaksana');

        echo json_encode(array(
			'kode'		=> $d->kode, 
			'nama_cv'=> $d->nama_cv,
			'kontak'=> $d->kontak,
			'alamat' 	=> $d->alamat,
			'direktur'	=> $d->direktur,
			'komanditer'		=> $d->komanditer,
			'nomor_akta'=>$d->nomor_akta,
			'tanggal_akta'	=> $d->tanggal_akta,
			'nama_notaris'	=> $d->nama_notaris,
			'presentase_direktur'=> $d->presentase_direktur,
			'presentase_komanditer'=> $d->presentase_komanditer,
			'nomor_perubahan'=> $d->nomor_perubahan,
			'tanggal_perubahan'=> $d->tanggal_perubahan,
			'direktur_perubahan'=> $d->direktur_perubahan,
			'komanditer_perubahan'=> $d->komanditer_perubahan,
			'notaris'=> $d->notaris,
			'nib'=> $d->nib,
			'email'=> $d->email
        ));
    }
	function edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		$data = array(
			'nama_cv'    => $this->keamanan->post($this->input->post('pelaksana', TRUE)),
			'kode'    => $this->keamanan->post($this->input->post('kode', TRUE)),
			'kontak'    => $this->keamanan->post($this->input->post('kontak', TRUE)),
			'alamat'    => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'direktur'    => $this->keamanan->post($this->input->post('direktur', TRUE)),
			'komanditer'    => $this->keamanan->post($this->input->post('komanditer', TRUE)),
			'nomor_akta'    => $this->keamanan->post($this->input->post('nomor_akta', TRUE)),
			'tanggal_akta'    => $this->keamanan->post($this->input->post('tanggal_akta', TRUE)),
			'nama_notaris'    => $this->keamanan->post($this->input->post('nama_notaris', TRUE)),
			'presentase_direktur'    => $this->keamanan->post($this->input->post('presentase_direktur', TRUE)),
			'presentase_komanditer'    => $this->keamanan->post($this->input->post('presentase_komanditer', TRUE)),
			'nomor_perubahan'    => $this->keamanan->post($this->input->post('nomor_perubahan', TRUE)),
			'tanggal_perubahan'    => $this->keamanan->post($this->input->post('tanggal_perubahan', TRUE)),
			'direktur_perubahan'    => $this->keamanan->post($this->input->post('direktur_perubahan', TRUE)),
			'komanditer_perubahan'    => $this->keamanan->post($this->input->post('komanditer_perubahan', TRUE)),
			'notaris'    => $this->keamanan->post($this->input->post('notaris', TRUE)),
			'nib'    => $this->keamanan->post($this->input->post('nib', TRUE)),
			'email'    => $this->keamanan->post($this->input->post('email', TRUE)),
		);


		$this->msa_model->update('pelaksana', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data pelaksana berhasil diupdate'));
		}
		redirect(site_url('admin/master/pelaksana/daftar/updated-success'));
	}


	public function detail($id_pelaksana)
	{
		$data_pelaksana = $this->msa->getby_id('pelaksana', 'id', $id_pelaksana)->row();

		$data = array(
			'data' => $data_pelaksana,
			'view' => 'admin/master/pelaksana-detail'
		);

		$this->load->view('admin/template', $data);
	}


	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa_model->delete('pelaksana', 'id', $id);

		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('pelaksana', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data pelaksana berhasil dihapus'));
		}
		redirect(site_url('admin/master/pelaksana/daftar/deleted-success'));
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

/* End of file admin/master/Pelaksana.php */
