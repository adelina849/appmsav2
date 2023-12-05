<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Barang_masuk extends Auth_Controller
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

		$this->load->model('msa_model');
		$query = $this->msa_model->get_last_code('barang_masuk', 'id')->result();

		$data = array(
			'action_add' => site_url('admin/gudang/barang_masuk/baru'),
			'action_delete' => site_url('admin/gudang/barang_masuk/hapus'),
			'data' => $this->msa->get_all('barang_masuk', 'id'),
			'list_barang' => $this->msa->get_all('barang', 'id_barang'),
			'view' => 'admin/gudang/barang-masuk-list'
		);
		$this->load->view('admin/template', $data);
	}

	public function cari_kode_barangmasuk()
	{
		if ($this->input->is_ajax_request()) {
			$keyword     = $this->input->post('keyword');

			$this->load->model('barang_model');
			$barang = $this->barang_model->cari_kode_barangmasuk($keyword, "");

			if ($barang->num_rows() > 0) {
				$json['status']     = 1;
				$json['datanya']     = "<ul id='daftar-autocomplete'>";
				foreach ($barang->result() as $b) {
					$json['datanya'] .= "
						<li>
							<b>Kode</b> : 
							<span>" . $b->kode_barang . "</span> <br />
							<span id='selected_nama'>" . $b->nama_barang . "</span> <br />
                            <b>Spesifikasi</b> :
                            <span>" . $b->spesifikasi . "</span>
                            <b>Satuan</b> :
                            <span>" . $b->satuan . "</span>
                            <span id='selected_id' style='display:none;'>" . $b->id_barang . "</span>
						</li>
					";
				}
				$json['datanya'] .= "</ul>";
			} else {
				$json['status']     = 0;
			}
		}
		echo json_encode($json);
	}

	public function ajax_list_barang_masuk()
	{
		$list = $this->barang->get_datatables_barangmasuk();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $d) {
			// $barang = $this->db->get_where('barang', array('id_barang' => $d->id_barang));
			// $nama_barang
			// if($barang->num_rows()>0){
			// 	$b = $barang->result();
			// }
			$no++;
			$row = array();
			$row[] = '<div class="text-center">' . $no . '</div>';
			$row[] = '<div class="text-right">' . $this->tanggal->konversi($d->tanggal_masuk) . '</div>';
			$row[] = '<span>' .
						$d->nama_barang.
					'</span>';
			$row[] = '<div class="text-center">' . $d->total_stok . '</div>';
			$row[] = '<span>' .
						$d->keterangan.
					'</span>';
			$row[] = '<div class="text-center">
						<a href="javascript:void(0)" data-toggle="tooltip" title="Hapus" 
							class="btn btn-xs btn-danger hapus" onclick="form_hapus(' . "'" . $d->id . "','" . $d->id_barang . "','" . $d->total_stok . "'" . ')">
							<i class="fa fa-trash-o"></i>
						</a>
		            </div>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->barang->count_all_barang_masuk(),
			"recordsFiltered" => $this->barang->count_filtered_barangmasuk(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function baru()
	{
		$this->load->model('msa_model');
		$this->load->model('barang_model');

		$get_stok_baru = $this->keamanan->post($this->input->post('total_stok', TRUE));
		$id_barang = $this->keamanan->post($this->input->post('id_barang', TRUE));


		$barang = $this->db->get_where('barang', array('id_barang' => $id_barang))->result();

		if ($barang) {
			$data = array(
				'tanggal_masuk'    => $this->keamanan->post($this->input->post('tanggal_masuk', TRUE)),
				'id_barang'    => $id_barang,
				'total_stok'    => $get_stok_baru,
				'nama_barang' => $barang[0]->nama_barang,
				'keterangan'    => $this->keamanan->post($this->input->post('keterangan', TRUE))
			);

			$this->msa_model->insert('barang_masuk', $data);
			$this->barang_model->tambah_stok($id_barang, $get_stok_baru);

			if ($this->db->affected_rows() > 0) {
				$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Stok barang berhasil ditambahkan'));
			}
			redirect(site_url('admin/gudang/barang_masuk/daftar/inserted-success'));
		}
	}


	function hapus()
	{
		$this->load->model('msa_model');
		$this->load->model('barang_model');

		$id = $this->keamanan->post($this->input->post('id'));
		$id_barang = $this->keamanan->post($this->input->post('id_barang'));
		$total_stok = $this->keamanan->post($this->input->post('total_stok'));

		// $this->msa_model->delete('mitra', 'id', $id);

		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('barang_masuk', 'id', $id, $data);

		//kembali mengurangi stok barang
		$this->barang_model->update_stok($id_barang, $total_stok);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Barang Masuk berhasil dihapus'));
		}
		redirect(site_url('admin/gudang/barang_masuk/daftar/deleted-success'));
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

/* End of file admin/gudang/Barang_Masuk.php */
