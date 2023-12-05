<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stok_barang extends Auth_Controller
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
		$filtered = $id_gudang = $status_stok = $and = $supplier = '';
		$title = '';
		$where = null;

		$where = array(
			'dihapus' => 'tidak',
		);				


		// filter stok barang list
		if ($this->input->post('filter', TRUE)) {
			$id_gudang = $this->input->post('gudang', TRUE);
			$status_stok = $this->input->post('status_stok', TRUE);
			$supplier = $this->input->post('vendor', TRUE);

			$title = '- FILTER STOK BARANG ' . $filtered;
			if(!empty($supplier) && !empty($id_gudang)){
				$and = "AND id_gudang = '".$id_gudang."' AND id_vendor='".$supplier."'";

				$where = array(
					'dihapus' => 'tidak',
					'id_vendor' => $supplier,
					'id_gudang' => $id_gudang,
				);				

			}
			else if(!empty($supplier)){
				$and = "AND id_vendor='".$supplier."'";

				$where = array(
					'dihapus' => 'tidak',
					'id_vendor' => $supplier,
				);				

			}
			else if(!empty($id_gudang)){
				$and = "AND id_gudang = '".$id_gudang."'";

				$where = array(
					'dihapus' => 'tidak',
					'id_gudang' => $id_gudang,
				);				
			}
			else{
				$where = array(
					'dihapus' => 'tidak',
				);					
			}
		}

		$ready = $this->barang->count_ready($where);
		$kosong = $this->barang->count_kosong($where);
		// 'count_all' => $this->barang->count_all(),

		$q = $this->barang->total_inventory($and)->row();

		$data = array(
			'title'         => $title,
			'id_gudang'    => $id_gudang,
			'status_stok'    => $status_stok,
			'supplier'    => $supplier,
			'action_filter' => site_url('admin/gudang/stok_barang/daftar'),
			'barang' => $this->msa->get_all('barang', 'id_barang'),
			// 'count_stok_kosong' => $this->barang->count_stok_kosong(),
			'count_all' => $this->barang->count_all(),
			'ready'=>$ready,
			'kosong'=>$kosong,
			'total_inventory' => str_replace(',', '.', number_format($q->total_rupiah)),
			'list_gudang' => $this->msa->get_all('gudang', 'id'),
			'view' => 'admin/gudang/stok-barang-list'
		);
		$this->load->view('admin/template', $data);
	}

	public function ajax_list_barang()
	{

		$id_gudang = $this->input->post('id_gudang');
		$status_stok = $this->input->post('status_stok');
		$supplier = $this->input->post('supplier');

		// if ($status_stok == "kosong") {
		// 	$status = "==";
		// } else {
		// 	$status = ">";
		// }

		if(!empty($id_gudang) && !empty($status_stok) && !empty($supplier)){
			if($status_stok=='tersedia'){
				$data_wheres = array(
					'id_vendor' => $supplier,
					'id_gudang' => $id_gudang,
					'total_stok>' => 0,
				);	
			}else{
				$data_wheres = array(
					'id_vendor' => $supplier,
				);					
			}
		}
		else if(!empty($id_gudang) && !empty($status_stok))
		{
			if($status_stok=='tersedia'){
				$data_wheres = array(
					'id_gudang' => $id_gudang,
					'total_stok>' => 0,
				);	
			}else{
				$data_wheres = array(
					'id_gudang' => $id_gudang,
					'total_stok' => 0,
				);					
			}
		}
		else if(!empty($supplier) && !empty($id_gudang)){
			if($status_stok=='tersedia'){
				$data_wheres = array(
					'id_vendor' => $supplier,
					'id_gudang' => $id_gudang,
					'total_stok>' => 0,
				);	
			}else{
				$data_wheres = array(
					'id_gudang' => $id_gudang,
					'id_vendor' => $supplier,
				);					
			}
		}		
		else if(!empty($supplier) && !empty($status_stok)){
			if($status_stok=='tersedia'){
				$data_wheres = array(
					'id_vendor' => $supplier,
					'total_stok>' => 0,
				);	
			}else{
				$data_wheres = array(
					'total_stok' => 0,
				);					
			}
		}		
		else if(!empty($supplier)){
			if($status_stok=='tersedia'){
				$data_wheres = array(
					'id_vendor' => $supplier,
					'total_stok>' => 0,
				);	
			}else{
				$data_wheres = array(
					'id_vendor' => $supplier,
				);					
			}
		}
		else if(!empty($id_gudang)){
			$data_wheres = array(
				'id_gudang' => $id_gudang,
			);
		}
		else if(!empty($status_stok)){
			if($status_stok=='tersedia'){
				$data_wheres = array(
					'total_stok>' => 0,
				);	
			}else{
				$data_wheres = array(
					'total_stok' => 0,
				);					
			}			
		}
		else{
			$data_wheres = null;
		}

		$list = $this->barang->get_datatables_stok_barang($data_wheres);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $barang) {
			$gudang = $this->db->get_where('gudang', array('id' => $barang->id_gudang))->result();
			$vendor = $this->db->get_where('vendor', array('id' => $barang->id_vendor))->result();

			$jmlHarga = 0;
			$hpp = $barang->harga_beli;
			$jmlHarga = $hpp * $barang->total_stok;

			$no++;
			$row = array();
			$row[] = '<div class="text-center">' . $no . '</div>';
			$row[] = '<span>' . $barang->kode_barang . '</span>';
			$row[] = '<span>' . strtoupper($barang->nama_barang) . '</span>';
			$row[] = '<span>' . (isset($vendor[0]->nama_vendor) ? strtoupper($vendor[0]->nama_vendor) : '-') . '</span>';
			if (isset($gudang[0]->gudang)) $row[] = '<span>' . strtoupper($gudang[0]->gudang) . '</span>';
			else  $row[] = '<span>-</span>';
			$row[] = '<div class="text-right">' . str_replace(',', '.', number_format($barang->harga_beli)). '</div>';
			$row[] = '<div class="text-center">' . strtoupper($barang->total_stok) . '</div>';
			$row[] = '<div class="text-right">' . str_replace(',', '.', number_format($jmlHarga)). '</div>';

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->barang->count_all(),
			"recordsFiltered" => $this->barang->count_filtered_stok_barang($data_wheres),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
}

/* End of file admin/gudang/Stok_Barang.php */
