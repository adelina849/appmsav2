<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stok_opname_model extends CI_Model
{
	var $table = 'stok_opname';
	var $table_detail = 'stok_opname_detail';
	var $column_order = array(null, 'kode_so', 'tanggal_mulai', 'id_gudang', 'status');
	var $column_order_so = array(null, 'kode_barang', 'nama_barang', 'total_stok');
	var $column_search = array('kode_so', 'tanggal_mulai', 'id_gudang', 'status');
	var $column_search_so = array('kode_barang', 'nama_barang');

	var $order = array('id' => 'desc');

	function __construct()
	{
		parent::__construct();
	}

	#SERVER SIDE DATA TABLE
	private function _get_datatables_query($data_where)
	{
		$this->db->from($this->table);
		$this->db->where('dihapus', 'tidak');
		$this->db->where($data_where);

		$i = 0;

		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($data_where)
	{
		$this->_get_datatables_query($data_where);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($data_where)
	{
		$this->_get_datatables_query($data_where);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		$this->db->where('dihapus', 'tidak');
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('id', $id);
		$query = $this->db->get();

		return $query->row();
	}
	#END OF SERVER SIDE DATA TABLE    

	function cari_gudang($keyword)
	{
		$sql = "
			SELECT * FROM gudang
			WHERE 
				dihapus = 'tidak' 
				AND ( 
					gudang LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
				)";

		return $this->db->query($sql);
	}

	function _get_data_so_query($kode_so, $id_gudang)
	{
		$this->db->select('barang.id_barang, barang.kode_barang, barang.nama_barang, barang.total_stok, stok_opname_detail.selisih, stok_opname_detail.keterangan');
		$this->db->from('barang');
		$this->db->join('stok_opname_detail', "barang.id_barang = stok_opname_detail.id_barang AND stok_opname_detail.kode_so = '$kode_so'", 'left');
		$this->db->where("barang.id_gudang = '$id_gudang'");
		$this->db->where("barang.dihapus = 'tidak'");

		$i = 0;

		foreach ($this->column_search_so as $item) {
			if ($_POST['search']['value']) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search_so) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_so[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function cek_draft($kode_so, $id_gudang)
	{
		$this->_get_data_so_query($kode_so, $id_gudang);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_existing($id_so)
	{
		$this->db->from($this->table_detail);
		$this->db->where('id_so', $id_so);
		return $this->db->count_all_results();
	}

	function insert_detail($data_detail)
	{
		return $this->db->insert($this->table_detail, $data_detail);
	}

	function delete_detail($id_barang, $id_so)
	{
		$sql = "DELETE FROM stok_opname_detail WHERE id_barang = $id_barang AND id_so = $id_so ";
		return $this->db->query($sql);
	}
}

/* End of file Pesanan_model.php */
/* Location: ./application/models/pesanan_model.php */
/* Please DO NOT modify this information : */
