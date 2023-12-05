<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pengguna extends Auth_Controller
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
			'action_add' => site_url('admin/master/pengguna/baru'),
			'action_edit' => site_url('admin/master/pengguna/edit'),
			'action_delete' => site_url('admin/master/pengguna/hapus'),
			'data' => $this->msa->get_all('pengguna', 'idpengguna'),
			'jabatan' => $this->msa->get_all('jabatan', 'id'),
			'view' => 'admin/master/pengguna-list'
		);
		$this->load->view('admin/template', $data);
	}

	public function detail($id_pengguna)
	{
		$data_karyawan = $this->msa->getby_id('pengguna', 'idpengguna', $id_pengguna)->result();
		$awal  = date_create($data_karyawan[0]->tanggal_mulai_kerja);
		$akhir = date_create(); // waktu sekarang
		$diff  = date_diff($awal, $akhir);

		$data = array(
			'pengguna' => $data_karyawan,
			'masa_kerja' => $diff,
			'view' => 'admin/master/pengguna-detail'
		);

		$this->load->view('admin/template', $data);
	}

	public function form_pengguna()
	{

		$query = $this->msa->get_last_code('pengguna', 'idpengguna')->result();
		$max_id = (isset($query[0]->idpengguna) ? $query[0]->idpengguna : 0);
		$angka = (int) substr($max_id, 1, 5);
		$angka++;
		$huruf = "A";
		$kode_baru = $huruf . sprintf("%05s", $angka);

		$data = array(
			'generate_kode' => $kode_baru,
			'action_add'       => site_url('admin/master/pengguna/baru'),
			'jabatan' => $this->msa->get_all('jabatan', 'id'),
			'view' => 'admin/master/pengguna-form'
		);
		$this->load->view('admin/template', $data);
	}

	function baru()
	{

		$id_pengguna = $this->keamanan->post($this->input->post('idpengguna', TRUE));

		$data = array(
			'idpengguna'    => $id_pengguna,
			'nik'    => $this->keamanan->post($this->input->post('nik', TRUE)),
			'nama_lengkap'    => $this->keamanan->post($this->input->post('nama_lengkap', TRUE)),
			'tempat_lahir'    => $this->keamanan->post($this->input->post('tempat_lahir', TRUE)),
			'tanggal_lahir'    => $this->keamanan->post($this->input->post('tanggal_lahir', TRUE)),
			'alamat'    => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'jenis_kelamin'    => $this->keamanan->post($this->input->post('jenis_kelamin', TRUE)),
			'agama'    => $this->keamanan->post($this->input->post('agama', TRUE)),
			'tanggal_mulai_kerja'    => $this->keamanan->post($this->input->post('tanggal_mulai_kerja', TRUE)),
			'id_jabatan'    => $this->keamanan->post($this->input->post('id_jabatan', TRUE)),
			'status_perkawinan'    => $this->keamanan->post($this->input->post('status_perkawinan', TRUE)),
			'status_karyawan'    => $this->keamanan->post($this->input->post('status_karyawan', TRUE)),
			'email'    => $this->keamanan->post($this->input->post('email', TRUE)),
			'nomor_hp'    => $this->keamanan->post($this->input->post('nomor_hp', TRUE)),
			'usia'    => $this->keamanan->post($this->input->post('usia', TRUE)),
			'pendidikan_terakhir'    => $this->keamanan->post($this->input->post('pendidikan_terakhir', TRUE)),
			'npwp_karyawan'    => $this->keamanan->post($this->input->post('npwp_karyawan', TRUE)),
			'status_bpjs_tk'    => $this->keamanan->post($this->input->post('status_bpjs_tk', TRUE)),
			'nomor_bpjs_tk'    => $this->keamanan->post($this->input->post('nomor_bpjs_tk', TRUE)),
			'status_bpjs_kesehatan'    => $this->keamanan->post($this->input->post('status_bpjs_kesehatan', TRUE)),
			'nomor_bpjs_kesehatan'    => $this->keamanan->post($this->input->post('nomor_bpjs_kesehatan', TRUE)),
		);

		$akun = array(
			'idpengguna' => $id_pengguna,
			'username' => $id_pengguna,
			'password' => md5($id_pengguna),
			'level' => 'admin',
		);

		$config['upload_path']          = 'assets/img/photo_pengguna/';
		$config['allowed_types']        = 'gif|jpg|jpeg|png';
		$config['file_name']            = 'karyawan_' . $id_pengguna;
		$config['overwrite']            = true;


		$this->load->library('upload', $config);

		if ($this->upload->do_upload('photo', FALSE)) {
			$uploaded_data = $this->upload->data();
			$photo = array(
				'photo' => $uploaded_data['file_name']
			);

			$full_data = $data + $photo;
		} else {
			$full_data = $data;
		}

		$this->msa->insert('pengguna', $full_data);
		$this->msa->insert('login', $akun);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Pengguna berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/pengguna/daftar'));
	}

	public function edit_form($id_pengguna)
	{
		$data = array(
			'action_edit' => site_url('admin/master/pengguna/edit'),
			'karyawan' => $this->msa->getby_id('pengguna', 'idpengguna', $id_pengguna)->result(),
			'jabatan' => $this->msa->get_all('jabatan', 'id'),
			'view' => 'admin/master/pengguna-edit'
		);
		$this->load->view('admin/template', $data);
	}

	function edit()
	{

		$id_pengguna = $this->keamanan->post($this->input->post('idpengguna', TRUE));

		$data = array(
			'idpengguna'    => $id_pengguna,
			'nik'    => $this->keamanan->post($this->input->post('nik', TRUE)),
			'nama_lengkap'    => $this->keamanan->post($this->input->post('nama_lengkap', TRUE)),
			'tempat_lahir'    => $this->keamanan->post($this->input->post('tempat_lahir', TRUE)),
			'tanggal_lahir'    => $this->keamanan->post($this->input->post('tanggal_lahir', TRUE)),
			'alamat'    => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'jenis_kelamin'    => $this->keamanan->post($this->input->post('jenis_kelamin', TRUE)),
			'agama'    => $this->keamanan->post($this->input->post('agama', TRUE)),
			'tanggal_mulai_kerja'    => $this->keamanan->post($this->input->post('tanggal_mulai_kerja', TRUE)),
			'id_jabatan'    => $this->keamanan->post($this->input->post('id_jabatan', TRUE)),
			'status_perkawinan'    => $this->keamanan->post($this->input->post('status_perkawinan', TRUE)),
			'status_karyawan'    => $this->keamanan->post($this->input->post('status_karyawan', TRUE)),
			'email'    => $this->keamanan->post($this->input->post('email', TRUE)),
			'nomor_hp'    => $this->keamanan->post($this->input->post('nomor_hp', TRUE)),
			'usia'    => $this->keamanan->post($this->input->post('usia', TRUE)),
			'pendidikan_terakhir'    => $this->keamanan->post($this->input->post('pendidikan_terakhir', TRUE)),
			'npwp_karyawan'    => $this->keamanan->post($this->input->post('npwp_karyawan', TRUE)),
			'status_bpjs_tk'    => $this->keamanan->post($this->input->post('status_bpjs_tk', TRUE)),
			'nomor_bpjs_tk'    => $this->keamanan->post($this->input->post('nomor_bpjs_tk', TRUE)),
			'status_bpjs_kesehatan'    => $this->keamanan->post($this->input->post('status_bpjs_kesehatan', TRUE)),
			'nomor_bpjs_kesehatan'    => $this->keamanan->post($this->input->post('nomor_bpjs_kesehatan', TRUE)),
		);

		$akun = array(
			'idpengguna' => $id_pengguna,
			'username' => $id_pengguna,
			'password' => md5($id_pengguna),
			'level' => 'admin',
		);

		$config['upload_path']          = 'assets/img/photo_pengguna/';
		$config['allowed_types']        = 'gif|jpg|jpeg|png';
		$config['file_name']            = 'karyawan_' . $id_pengguna;
		$config['overwrite']            = true;


		$this->load->library('upload', $config);

		if ($this->upload->do_upload('photo', FALSE)) {
			$uploaded_data = $this->upload->data();
			$photo = array(
				'photo' => $uploaded_data['file_name']
			);

			$full_data = $data + $photo;
		} else {
			$full_data = $data;
		}

		$this->msa->update('pengguna', 'idpengguna', $id_pengguna, $full_data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Pengguna berhasil diupdate'));
		}
		redirect(site_url('admin/master/pengguna/daftar/updated-success'));
	}


	function hapus()
	{

		$id = $this->keamanan->post($this->input->post('idpengguna'));

		//untuk menghapus file photo
		// unlink(FCPATH . "/assets/img/photo_pengguna/" . $this->input->post('photo'));

		// $this->msa->delete('pengguna', 'idpengguna', $id);

		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa->update('pengguna', 'idpengguna', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Pengguna berhasil dihapus'));
		}
		redirect(site_url('admin/master/pengguna/daftar/deleted-success'));
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

/* End of file admin/master/Pengguna.php */
