<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Barang extends Auth_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->load->model('msa_model', 'msa');
		$this->load->model('barang_model', 'barang');
	}

	public function index()
	{
		$this->daftar();
	}

	public function daftar()
	{
		$data = array(
			'action_delete'    => site_url('admin/master/barang/hapus'),
			'barang' => $this->msa->get_all('barang', 'id_barang'),
			'view' => 'admin/master/barang-list'
		);
		$this->load->view('admin/template', $data);
	}

	public function detail($id_barang)
	{

		$this->load->model('msa_model');

		$data = array(
			'barang' => $this->msa->getby_id('barang', 'id_barang', $id_barang)->result(),
			'view' => 'admin/master/barang-detail'
		);
		$this->load->view('admin/template', $data);
	}

	public function form_barang()
	{
		$data = array(
			'action_add'       => site_url('admin/master/barang/baru'),
			'kategori' => $this->msa->get_all('kategori', 'id'),
			'sub_kategori' => $this->msa->get_all('kategori_sub', 'id'),
			'satuan' => $this->msa->get_all('satuan', 'id'),
			'vendor' => $this->msa->get_all('vendor', 'id'),
			'gudang' => $this->msa->get_all('gudang', 'id'),
			'view' => 'admin/master/barang-form'
		);
		$this->load->view('admin/template', $data);
	}

	public function baru()
	{
		$this->load->model('msa_model');
		$this->load->model('barang_model');
		$kode_barang = $this->keamanan->post($this->input->post('kode_barang', TRUE));
		$id_vendor = $this->keamanan->post($this->input->post('vendor', TRUE));

		$data = array(
			'id_barang'    => $this->keamanan->post($this->input->post('id_barang', TRUE)),
			'kode_barang'    => $kode_barang,
			'jenis_barang'    => $this->keamanan->post($this->input->post('jenis_barang', TRUE)),
			'id_vendor'    => $id_vendor,
			'id_gudang'    => $this->keamanan->post($this->input->post('gudang', TRUE)),
			'nama_barang'    => $this->keamanan->post($this->input->post('nama_barang', TRUE)),
			'spesifikasi'    => $this->keamanan->post($this->input->post('spesifikasi', TRUE)),
			'jenjang'    => $this->keamanan->post($this->input->post('jenjang', TRUE)),
			'kategori'    => $this->keamanan->post($this->input->post('kategori', TRUE)),
			'sub_kategori'    => $this->keamanan->post($this->input->post('sub_kategori', TRUE)),
			'satuan'    => $this->keamanan->post($this->input->post('satuan', TRUE)),
			'harga_beli'    => str_replace('.', '', $this->keamanan->post($this->input->post('harga_beli', TRUE))),
			'harga_jual'    => str_replace('.', '', $this->keamanan->post($this->input->post('harga_jual', TRUE))),
			'merk'    => $this->keamanan->post($this->input->post('merk', TRUE))
		);

		//$cek_kode_barang = $this->barang_model->cek_kode($kode_barang)->result();
		$cek_kode_barang = $this->barang_model->cek_supplier_barang($kode_barang, $id_vendor)->result();

		if (count($cek_kode_barang) == 0) {
			//kode belum digunakan
			$this->msa_model->insert('barang', $data);
		}
		
		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Barang berhasil ditambahkan'));
		}
		redirect(site_url('admin/master/barang/daftar/inserted-success'));
	}

	public function edit_form($id_barang)
	{
		$data = array(
			'action_edit'      => site_url('admin/master/barang/edit'),
			'kategori' => $this->msa->get_all('kategori', 'id'),
			'sub_kategori' => $this->msa->get_all('kategori_sub', 'id'),
			'satuan' => $this->msa->get_all('satuan', 'id'),
			'vendor' => $this->msa->get_all('vendor', 'id'),
			'gudang' => $this->msa->get_all('gudang', 'id'),
			'barang' => $this->msa->getby_id('barang', 'id_barang', $id_barang)->result(),
			'view' => 'admin/master/barang-edit'
		);
		$this->load->view('admin/template', $data);
	}

	public function edit()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id_barang'));

		$data = array(
			'kode_barang'    => $this->keamanan->post($this->input->post('kode_barang', TRUE)),
			'jenis_barang'    => $this->keamanan->post($this->input->post('jenis_barang', TRUE)),
			'id_vendor'    => $this->keamanan->post($this->input->post('vendor', TRUE)),
			'id_gudang'    => $this->keamanan->post($this->input->post('gudang', TRUE)),
			'nama_barang'    => $this->keamanan->post($this->input->post('nama_barang', TRUE)),
			'spesifikasi'    => $this->keamanan->post($this->input->post('spesifikasi', TRUE)),
			'jenjang'    => $this->keamanan->post($this->input->post('jenjang', TRUE)),
			'kategori'    => $this->keamanan->post($this->input->post('kategori', TRUE)),
			'sub_kategori'    => $this->keamanan->post($this->input->post('sub_kategori', TRUE)),
			'satuan'    => $this->keamanan->post($this->input->post('satuan', TRUE)),
			'harga_beli'    => str_replace('.', '', $this->keamanan->post($this->input->post('harga_beli', TRUE))),
			'harga_jual'    => str_replace('.', '', $this->keamanan->post($this->input->post('harga_jual', TRUE))),
			'merk'    => $this->keamanan->post($this->input->post('merk', TRUE))
		);

		$this->msa_model->update('barang', 'id_barang', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Barang berhasil diupdate'));
		}
		redirect(site_url('admin/master/barang/daftar/updated-success'));
	}

	public function hapus()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id_barang'));

		// $this->msa_model->delete('barang', 'id_barang', $id);

		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('barang', 'id_barang', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Barang berhasil dihapus'));
		}
		redirect(site_url('admin/master/barang/daftar/deleted-success'));
	}

	public function ajax_list_barang()
	{
		$list = $this->barang->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $barang) {
			$vendor = $this->db->get_where('vendor', array('id' => $barang->id_vendor))->result();
			$no++;
			$row = array();
			$row[] = '<div class="text-center">' . $no . '</div>';
			$row[] = '<span>' . $barang->kode_barang . '</span>';
			$row[] = '<span>' . strtoupper($barang->nama_barang) . '</span>';
			$row[] = '<span>' . strtoupper($barang->jenis_barang) . '</span>';
			$row[] = '<span>' . strtoupper($barang->jenjang) . '</span>';
			$row[] = '<span>' . strtoupper($barang->merk) . '</span>';
			$row[] = '<span>' . (isset($vendor[0]->nama_vendor) ? strtoupper($vendor[0]->nama_vendor) : '-') . '</span>';
			$row[] = '<div class="text-center">
                        <div class="btn-group btn-group-xs">
                            <a href="' . site_url('admin/master/barang/detail/' . $barang->id_barang . '/detail-barang') . '" data-toggle="tooltip" title="Detail Barang" 
                                class="btn btn-xs btn-primary">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="' . site_url('admin/master/barang/edit_form/' . $barang->id_barang . '/edit-barang') . '" data-toggle="tooltip" title="Edit Barang" 
                                class="btn btn-xs btn-warning">
                                <i class="fa fa-pencil"></i>
                            </a>
                            <a href="javascript:void(0)" data-toggle="tooltip" title="Hapus" 
                                class="btn btn-xs btn-danger hapus" onclick="form_hapus(' . "'" . $barang->id_barang . "'" . ')">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </div>
                    </div>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->barang->count_all(),
			"recordsFiltered" => $this->barang->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function cek_kode_barang()
	{
		if ($this->input->is_ajax_request()) {
			$id_barang     = $this->input->post('id_barang');

			$this->load->model('barang_model');
			$barang = $this->barang_model->cek_kode($id_barang)->result();

			if (count($barang) == 0) {
				//kode belum digunakan
				$json['status']     = 0;
			} else {
				//kode sudah digunakan
				$json['status']     = 1;
			}
		}
		echo json_encode($json);
	}

	public function cek_supplier_barang()
	{
		if ($this->input->is_ajax_request()) {
			$kode_barang     = $this->input->post('kode_barang');
			$id_supplier     = $this->input->post('id_supplier');

			$this->load->model('barang_model');
			$cek = $this->barang_model->cek_supplier_barang($kode_barang, $id_supplier)->result();

			if (count($cek) == 0) {
				//kode belum digunakan
				$json['status']     = 0;
			} else {
				//kode dan supplier sudah digunakan
				$json['status']     = 1;
			}
		}
		echo json_encode($json);
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

/* End of file admin/master/Barang.php */
