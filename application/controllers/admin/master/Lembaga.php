<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lembaga extends Auth_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->load->model('msa_model', 'msa');
		$this->load->model('lembaga_model', 'lembaga');

	}

	public function index()
	{
		$this->daftar();
	}

	public function ajax_list_lembaga()
	{
		$list = $this->lembaga->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $lembaga) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">' . $no . '</div>';
			$row[] = '<span>' . $lembaga->kode . '</span>';
			$row[] = '<span>' . strtoupper($lembaga->nama_lembaga) . '</span>';
			$row[] = '<span>' . $lembaga->alamat. '</span>';
			// $row[] = '<span>' . $lembaga->jenjang. '</span>';
			// $row[] = '<span>' . $lembaga->status. '</span>';
			$row[] = '<span>' . $lembaga->klasifikasi. '</span>';
			// $row[] = '<span>' . $lembaga->nomor_telepon. '</span>';
			$row[] = '<div class="text-center">
                        <div class="btn-group btn-group-xs">
							<a href="'.site_url('admin/master/lembaga/detail/' . $lembaga->id . '/detail-lembaga').'" data-toggle="tooltip" title="Detail" class="btn btn-xs btn-primary">
								<i class="fa fa-eye"></i>
							</a>
							<a href="javascript:void(0)" data-toggle="tooltip" title="Edit Lembaga" 
								class="btn btn-xs btn-warning" onclick="detail_lembaga(' . "'" . $lembaga->id . "'" . ')">
								<i class="fa fa-pencil"></i>
                            </a>                    
                            <a href="javascript:void(0)" data-toggle="tooltip" title="Hapus" 
                                class="btn btn-xs btn-danger hapus" onclick="form_hapus(' . "'" . $lembaga->id . "'" . ')">
                                <i class="fa fa-trash-o"></i>
                            </a>
						</div>
                    </div>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->lembaga->count_all(),
			"recordsFiltered" => $this->lembaga->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

    public function ajax_get_lembaga()
    {
        $id_lembaga     = $this->input->post('id_lembaga');
        $d = $this->lembaga->get_by_id($id_lembaga);

        echo json_encode(array(
			'kode'		=> $d->kode, 
			'nama_lembaga'=> $d->nama_lembaga,
			'alamat' 	=> $d->alamat,
			'kecamatan'	=> $d->kecamatan,
			'desa'		=> $d->desa,
			'nomor_telepon'=>$d->nomor_telepon,
			'jenjang'	=> $d->jenjang,
			'status'	=> $d->status,
			'klasifikasi'=> $d->klasifikasi,
			'kabupaten'=> $d->kabupaten,
			'provinsi'=> $d->provinsi
        ));
    }


	public function daftar()
	{
		$data = array(
			'action_add' => site_url('admin/master/lembaga/baru'),
			'action_edit' => site_url('admin/master/lembaga/edit'),
			'action_delete' => site_url('admin/master/lembaga/hapus'),
			'data' => $this->msa->get_all('lembaga', 'id'),
			'view' => 'admin/master/lembaga-list'
		);
		$this->load->view('admin/template', $data);
	}

	public function detail($id_lembaga)
	{
		$data_lembaga = $this->msa->getby_id('lembaga', 'id', $id_lembaga)->row();

		$data = array(
			'data' => $data_lembaga,
			'view' => 'admin/master/lembaga-detail'
		);

		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');

		$data = array(
			'kode'    => $this->keamanan->post($this->input->post('kode', TRUE)),
			'nama_lembaga'    => $this->keamanan->post($this->input->post('nama_lembaga', TRUE)),
			'alamat'    => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'jenjang'    => $this->keamanan->post($this->input->post('jenjang', TRUE)),
			'status'    => $this->keamanan->post($this->input->post('status', TRUE)),
			'klasifikasi'    => $this->keamanan->post($this->input->post('klasifikasi', TRUE)),
			'kecamatan'    => $this->keamanan->post($this->input->post('kecamatan', TRUE)),
			'desa'    => $this->keamanan->post($this->input->post('desa', TRUE)),
			'nomor_telepon'    => $this->keamanan->post($this->input->post('nomor_telepon', TRUE)),
			'kabupaten'    => $this->keamanan->post($this->input->post('kabupaten', TRUE)),
			'provinsi'    => $this->keamanan->post($this->input->post('provinsi', TRUE)),
		);

		$this->msa_model->insert('lembaga', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Lembaga berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/lembaga/daftar/inserted-success'));
	}

	public function cek_kode()
	{
		if ($this->input->is_ajax_request()) {
			$kode     = $this->input->post('kode');

			$this->load->model('msa_model');
			$pelanggan = $this->msa_model->cek_existing_code('lembaga', 'kode', $kode)->result();

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
			'kode'    => $this->keamanan->post($this->input->post('kode', TRUE)),
			'nama_lembaga' => $this->keamanan->post($this->input->post('nama_lembaga', TRUE)),
			'alamat' => $this->keamanan->post($this->input->post('alamat', TRUE)),
			'jenjang' => $this->keamanan->post($this->input->post('jenjang', TRUE)),
			'status' => $this->keamanan->post($this->input->post('status', TRUE)),
			'klasifikasi' => $this->keamanan->post($this->input->post('klasifikasi', TRUE)),
			'kecamatan'    => $this->keamanan->post($this->input->post('kecamatan', TRUE)),
			'desa'    => $this->keamanan->post($this->input->post('desa', TRUE)),
			'nomor_telepon'    => $this->keamanan->post($this->input->post('nomor_telepon', TRUE)),
			'kabupaten'    => $this->keamanan->post($this->input->post('kabupaten', TRUE)),
			'provinsi'    => $this->keamanan->post($this->input->post('provinsi', TRUE)),
		);

		$this->msa_model->update('lembaga', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Lembaga berhasil diupdate'));
		}
		redirect(site_url('admin/master/lembaga/daftar/updated-success'));
	}


	function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id_lembaga'));

		// $this->msa_model->delete('lembaga', 'id', $id);

		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('lembaga', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Lembaga berhasil dihapus'));
		}
		redirect(site_url('admin/master/lembaga/daftar/deleted-success'));
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

/* End of file admin/master/Lembaga.php */
