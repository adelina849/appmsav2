<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Standing_order_model extends CI_Model
{
	var $column_order_b = array(null, 'kode_barang', 'nama_barang', 'jenis_barang', 'qty_so');
	var $column_search_b = array('kode_barang', 'nama_barang', 'jenis_barang', 'qty_so');
	var $column_order_v = array(null, 'nama_vendor', 'kode');
	var $column_search_v = array('nama_vendor', 'kode');
	var $column_order_p = array(null, 'nama_pelanggan', 'kode');
	var $column_search_p = array('p.nama_pelanggan', 'p.kode');
	var $order = array('packing_detail.id_packing_d' => 'desc');

	function __construct()
	{
		parent::__construct();
	}

	#SERVER SIDE DATA TABLE
	private function _get_datatables_query($table, $filter)
	{
		if ($filter == 'barang') {
			$this->db->select('barang.*, packing_detail.id_packing_d as id_so, SUM(packing_detail.qty_terpacking) as total_terpacking');
			$this->db->from('packing_detail');
			$this->db->join('barang', 'packing_detail.id_barang = barang.id_barang');
			$this->db->group_by('packing_detail.id_barang');
			//$this->db->having('total_terpacking > 0');			
			$this->db->order_by('packing_detail.id_packing_d', 'DESC');

			$i = 0;

			foreach ($this->column_search_b as $item) {
				if ($_POST['search']['value']) {
					if ($i === 0) {
						$this->db->group_start();
						$this->db->like($item, $_POST['search']['value']);
					} else {
						$this->db->or_like($item, $_POST['search']['value']);
					}

					if (count($this->column_search_b) - 1 == $i)
						$this->db->group_end();
				}
				$i++;
			}

			if (isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($this->column_order_b[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} else if (isset($this->order)) {
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		} else if ($filter == 'supplier') {
			$this->db->select('*, packing_detail.id_packing_d as id_so , SUM(qty_so) as total_qty_so');
			$this->db->from('packing_detail');
			$this->db->join('barang', 'packing_detail.id_barang = barang.id_barang');
			$this->db->join('vendor', 'vendor.id = barang.id_vendor');
			$this->db->where('qty_so >', 0);
			$this->db->group_by('vendor.id');

			$i = 0;

			foreach ($this->column_search_v as $item) {
				if ($_POST['search']['value']) {
					if ($i === 0) {
						$this->db->group_start();
						$this->db->like($item, $_POST['search']['value']);
					} else {
						$this->db->or_like($item, $_POST['search']['value']);
					}

					if (count($this->column_search_v) - 1 == $i)
						$this->db->group_end();
				}
				$i++;
			}

			if (isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($this->column_order_v[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} else if (isset($this->order)) {
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		} else if ($filter == 'pelanggan') {
			$this->db->select('pd.id_packing_d as id_so ,pcm.id_packing_m, pcm.id_pesanan_m, pd.id_barang, SUM(pd.qty_so) as total_qty_so, pm.id_pesanan_m, v.id, pm.id_pelanggan ,b.*, p.*');
			$this->db->from('packing_detail as pd');
			$this->db->join('packing_master as pcm', 'pcm.id_packing_m = pd.id_packing_m');
			$this->db->join('pesanan_master as pm', 'pcm.id_pesanan_m = pm.id_pesanan_m');
			$this->db->join('barang as b', 'pd.id_barang = b.id_barang');
			$this->db->join('pelanggan as p', 'pm.id_pelanggan = p.id');
			$this->db->join('vendor as v', 'b.id_vendor = v.id');
			$this->db->where('qty_so >', 0);
			$this->db->group_by('pm.id_pelanggan');
			$this->db->order_by('pd.id_packing_d', 'DESC');

			$i = 0;

			foreach ($this->column_search_p as $item) {
				if ($_POST['search']['value']) {
					if ($i === 0) {
						$this->db->group_start();
						$this->db->like($item, $_POST['search']['value']);
					} else {
						$this->db->or_like($item, $_POST['search']['value']);
					}

					if (count($this->column_search_p) - 1 == $i)
						$this->db->group_end();
				}
				$i++;
			}
		}
	}

	function get_datatables($table, $filter)
	{
		$this->_get_datatables_query($table, $filter);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_so_barang($id_barang)
	{

		// $this->db->select('*,packing_detail.id_packing_d as id_so , SUM(qty_so) as total_qty_so');
		// $this->db->from('packing_detail');
		// $this->db->join('barang', 'packing_detail.id_barang = barang.id_barang');
		// $this->db->where('qty_so >', 0);
		// $this->db->where('packing_detail.id_barang ', $id_barang);
		// $this->db->group_by('packing_detail.id_barang');

		$this->db->select('barang.*, packing_detail.id_packing_d as id_so, SUM(packing_detail.qty_so) as total_qty_so');
		$this->db->from('packing_detail');
		$this->db->join('(SELECT id_barang, MAX(id_packing_m) AS latest_packing_m FROM packing_detail WHERE qty_so > 0 && id_barang = ' . $id_barang . ' GROUP BY id_barang, id_pesanan_m) AS latest_packing', 'packing_detail.id_barang = latest_packing.id_barang AND packing_detail.id_packing_m = latest_packing.latest_packing_m');
		$this->db->join('barang', 'packing_detail.id_barang = barang.id_barang');
		$this->db->group_by('packing_detail.id_barang');
		$this->db->order_by('packing_detail.id_packing_d', 'DESC');

		$query = $this->db->get();
		return $query->result();
	}

	function get_so_vendor($id_vendor)
	{
		// $this->db->select('*,packing_detail.id_packing_d as id_so , SUM(qty_so) as total_qty_so');
		// $this->db->from('packing_detail');
		// $this->db->join('barang', 'packing_detail.id_barang = barang.id_barang');
		// $this->db->where('qty_so >', 0);
		// $this->db->group_by('packing_detail.id_barang');

		$this->db->select('barang.*, packing_detail.id_packing_d as id_so, SUM(packing_detail.qty_so) as total_qty_so');
		$this->db->from('packing_detail');
		$this->db->join('(SELECT id_barang, MAX(id_packing_m) AS latest_packing_m FROM packing_detail GROUP BY id_barang, id_pesanan_m) AS latest_packing', 'packing_detail.id_barang = latest_packing.id_barang AND packing_detail.id_packing_m = latest_packing.latest_packing_m');
		$this->db->join('barang', 'packing_detail.id_barang = barang.id_barang');
		$this->db->where('barang.id_vendor ', $id_vendor);
		$this->db->where('packing_detail.qty_so >', 0);
		$this->db->group_by('packing_detail.id_barang');
		$this->db->order_by('packing_detail.id_packing_d', 'DESC');

		$query = $this->db->get();
		return $query->result();
	}
	function get_so_pelanggan($id_pelanggan)
	{
		// $this->db->select('*,packing_detail.id_packing_d as id_so , SUM(qty_so) as total_qty_so');
		// $this->db->from('packing_detail');
		// $this->db->join('pesanan_master', 'packing_detail.id_pesanan_m = pesanan_master.id_pesanan_m');
		// $this->db->join('barang', 'packing_detail.id_barang = barang.id_barang');
		// $this->db->where('qty_so >', 0);
		// $this->db->where('pesanan_master.id_pelanggan ', $id_pelanggan);
		// $this->db->group_by('packing_detail.id_barang');

		$this->db->select('barang.*, packing_detail.id_packing_d as id_so, SUM(packing_detail.qty_so) as total_qty_so');
		$this->db->from('packing_detail');
		$this->db->join('(SELECT id_barang, MAX(id_packing_m) AS latest_packing_m FROM packing_detail GROUP BY id_barang, id_pesanan_m) AS latest_packing', 'packing_detail.id_barang = latest_packing.id_barang AND packing_detail.id_packing_m = latest_packing.latest_packing_m');
		$this->db->join('barang', 'packing_detail.id_barang = barang.id_barang');
		$this->db->join('pesanan_master', 'packing_detail.id_pesanan_m = pesanan_master.id_pesanan_m');
		$this->db->where('pesanan_master.id_pelanggan ', $id_pelanggan);
		$this->db->where('packing_detail.qty_so >', 0);
		$this->db->group_by('packing_detail.id_barang');
		$this->db->order_by('packing_detail.id_packing_d', 'DESC');


		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($table, $filter)
	{
		$this->_get_datatables_query($table, $filter);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($table)
	{
		$this->db->from($table);
		return $this->db->count_all_results();
	}

	function update_nomor($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('counter_number', $data);
	}
}

/* End of file Standing_order_model.php */
/* Location: ./application/models/Standing_order_model.php */
/* Please DO NOT modify this information : */
