<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Wilayah extends Auth_Controller
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
			'action_add' => site_url('admin/master/wilayah/baru'),
			'action_edit' => site_url('admin/master/wilayah/edit'),
			'action_delete' => site_url('admin/master/wilayah/hapus'),
			'data' => $this->msa->get_all('wilayah_kerja', 'id'),
			'view' => 'admin/master/wilayah-kerja'
		);
		$this->load->view('admin/template', $data);
	}


	// public function exist_kode()
    // {
    //     $kode = $this->keamanan->post($this->input->post('npm', TRUE));
    //     $npm_awal = $this->keamanan->post($this->input->post('npm_awal', TRUE));
    //     $pesan = '';
    //     $available = 1;

    //     if (!empty($npm)) {
    //         if ($npm_awal != $npm) {
    //             $npm_count = $this->db->get_where('mahasiswa', array('npm' => $npm))->num_rows();
    //             if ($npm_count > 0) {
    //                 $pesan .= "<span class='status-not-available'> <i class='fa fa-times-circle-o'></i> NPM sudah digunakan. masukan NPM baru</span>";
    //                 $available = 0;
    //             } else {
    //                 $pesan .=  "<span class='status-available'> <i class='fa fa-check-circle-o'></i> NPM dapat digunakan.</span>";
    //                 $available = 1;
    //             }
    //         } else {
    //             $pesan .=  "<span class='status-available'> <i class='fa fa-check-circle-o'></i> NPM dapat digunakan.</span>";
    //             $available = 1;
    //         }
    //         echo json_encode(array(
    //             'pesan' => $pesan,
    //             'available' => $available
    //         ));
    //     }
    // }

	function baru()
	{
		//$this->load->model('msa_model');
		$kode = $this->keamanan->post($this->input->post('kode', TRUE));
		$exist_kode= $this->msa->get_by_id('kode', $kode, 'wilayah_kerja');

        if ($this->input->server('HTTP_REFERER')) {
            #cek kode sudah digunakan ?
            if ($exist_kode->kode != "") {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Tidak dapat menambahkan data, kode ' . $kode . ' Sudah Digunakan ! Silahkan buat kode baru'));
            } else {
				$data = array(
					'kode'    => $kode,
					'nama'    => $this->keamanan->post($this->input->post('nama', TRUE)),
					'provinsi'    => $this->keamanan->post($this->input->post('provinsi', TRUE))
				);
				$this->msa->insert('wilayah_kerja', $data);

				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data berhasil ditambahkan'));
				}				
			}				
		}
		else{
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Tidak berhasil menambahkan wilayah baru'));
		}

		redirect(site_url('admin/master/wilayah/daftar'));
	}



    public function ajax_get_wilayah()
    {
        $id     = $this->input->post('id');
        $d = $this->msa->get_by_id('id', $id, 'wilayah_kerja');

        echo json_encode(array(
			'kode'		=> $d->kode, 
			'nama'=> $d->nama,
			'provinsi'=> $d->provinsi
        ));
    }

	function edit()
	{
		$id = $this->keamanan->post($this->input->post('id'));
		$kode = $this->keamanan->post($this->input->post('kode', TRUE));
		$kode_lama = $this->keamanan->post($this->input->post('kode_lama', TRUE));
		//$exist_kode= $this->msa->get_by_id('kode', $kode, 'wilayah_kerja');

        if ($this->input->server('HTTP_REFERER')) {

			if($kode_lama != $kode){
				$kode_count = $this->db->get_where('wilayah_kerja', array('kode' => $kode))->num_rows();
				if ($kode_count > 0) {
					$this->session->set_flashdata('messageAlert', $this->messageAlert('error', ' Tidak dapat merubah data, kode ' . $kode . ' Sudah Digunakan ! Silahkan buat kode baru'));										
				}else{
					$data = array(
						'kode'    => $kode,
						'nama'    => $this->keamanan->post($this->input->post('nama', TRUE)),
						'provinsi'    => $this->keamanan->post($this->input->post('provinsi', TRUE))
					);
			
					$this->msa->update('wilayah_kerja', 'id', $id, $data);
			
					if ($this->db->affected_rows() > 0) {
						$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data berhasil diupdate'));
					}									
				}
			}else{
				$data = array(
					'kode'    => $kode,
					'nama'    => $this->keamanan->post($this->input->post('nama', TRUE)),
					'provinsi'    => $this->keamanan->post($this->input->post('provinsi', TRUE))
				);
		
				$this->msa->update('wilayah_kerja', 'id', $id, $data);
		
				if ($this->db->affected_rows() > 0) {
					$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data berhasil diupdate'));
				}									
			}
		}else{
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Tidak berhasil merubah wilayah'));
		}

		redirect(site_url('admin/master/wilayah/daftar/updated-success'));
	}


	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id'));
		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('wilayah_kerja', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data berhasil dihapus'));
		}
		redirect(site_url('admin/master/wilayah/daftar/deleted-success'));
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
