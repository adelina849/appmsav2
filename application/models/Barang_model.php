<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Barang_model extends CI_Model
{
	var $table = 'barang';
	var $column_order = array(null, 'kode_barang', 'nama_barang', 'jenis_barang', 'total_stok', 'id_gudang', 'merk','jenjang'); //set column field
	var $column_order_barang_masuk = array(null, 'tanggal_masuk', 'id_barang', 'total_stok','keterangan'); //set column field
	var $column_search = array('kode_barang', 'nama_barang','merk','jenjang'); //set column field database for datatable searchable 
	var $column_search_barang_masuk = array('tanggal_masuk', 'nama_barang','keterangan'); //set column field database for datatable searchable 
	var $order = array('id_barang' => 'desc');

	function __construct()
	{
		parent::__construct();
	}


	function get_kode_barang($keyword, $registered)
	{
		$not_in = '';

		$koma = explode(',', $registered);
		if (count($koma) > 1) {
			$not_in .= " AND `kode_barang` NOT IN (";
			foreach ($koma as $k) {
				$not_in .= " '" . $k . "', ";
			}
			$not_in = rtrim(trim($not_in), ',');
			$not_in = $not_in . ")";
		}
		if (count($koma) == 1) {
			$not_in .= " AND `kode_barang` != '" . $registered . "' ";
		}

		$sql = "
			SELECT 
                `id_barang`,`kode_barang`, `nama_barang`, `spesifikasi`,  `satuan`
                , `harga_jual`, `harga_beli`
			FROM 
				`barang` 
			WHERE 
				`dihapus` = 'tidak' 
				AND ( 
					`kode_barang` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
					OR `nama_barang` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
				) 
				" . $not_in . " 
		";
		return $this->db->query($sql);		
	}

	function cari_kode($keyword, $registered, $jenis_barang)
	{
		$not_in = '';

		$koma = explode(',', $registered);
		if (count($koma) > 1) {
			$not_in .= " AND `kode_barang` NOT IN (";
			foreach ($koma as $k) {
				$not_in .= " '" . $k . "', ";
			}
			$not_in = rtrim(trim($not_in), ',');
			$not_in = $not_in . ")";
		}
		if (count($koma) == 1) {
			$not_in .= " AND `kode_barang` != '" . $registered . "' ";
		}

		$sql = "
			SELECT 
                `id_barang`,`kode_barang`, `nama_barang`, `spesifikasi`,  `satuan`
                , `harga_jual`, `harga_beli`, `id_vendor`, `total_stok`
			FROM 
				`barang` 
			WHERE 
				`dihapus` = 'tidak' 
                AND `jenis_barang` = '" . $jenis_barang . "' 
				AND ( 
					`kode_barang` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
					OR `nama_barang` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
				) 
				" . $not_in . "ORDER BY total_stok DESC"." 
		";
		return $this->db->query($sql);
	}

	function cari_kode_barangmasuk($keyword, $registered)
	{
		$not_in = '';

		$koma = explode(',', $registered);
		if (count($koma) > 1) {
			$not_in .= " AND `kode_barang` NOT IN (";
			foreach ($koma as $k) {
				$not_in .= " '" . $k . "', ";
			}
			$not_in = rtrim(trim($not_in), ',');
			$not_in = $not_in . ")";
		}
		if (count($koma) == 1) {
			$not_in .= " AND `kode_barang` != '" . $registered . "' ";
		}

		$sql = "
			SELECT 
                `id_barang`,`kode_barang`, `nama_barang`, `spesifikasi`,  `satuan`
                , `harga_jual`, `harga_beli`
			FROM 
				`barang` 
			WHERE 
				`dihapus` = 'tidak' 
				AND ( 
					`kode_barang` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
					OR `nama_barang` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
				) 
				" . $not_in . " 
		";
		return $this->db->query($sql);
	}

	function get_id_bysupplier($kode_barang, $id_vendor)
	{
		return $this->db
			->select('id_barang, nama_barang')
			->where('kode_barang', $kode_barang)
			->where('id_vendor', $id_vendor)
			->where('dihapus', 'tidak')
			->limit(1)
			->get('barang');
	}	
	function get_id($kode_barang)
	{
		return $this->db
			->select('id_barang, nama_barang')
			->where('kode_barang', $kode_barang)
			->where('dihapus', 'tidak')
			->limit(1)
			->get('barang');
	}
	function get_stok($kode)
	{
		return $this->db
			->select('nama_barang, total_stok')
			->where('kode_barang', $kode)
			->limit(1)
			->get('barang');
	}

	function update_stok($id_barang, $qty)
	{
		$sql = "UPDATE barang set total_stok = ((total_stok) - $qty) 
                WHERE id_barang=$id_barang";
		return $this->db->query($sql);
	}

	function tambah_stok($id_barang, $jumlah_beli)
	{
		$sql = "UPDATE barang set total_stok = ((total_stok) + $jumlah_beli) 
                WHERE id_barang=$id_barang";
		return $this->db->query($sql);
	}

	function kurangi_stok($id_barang, $qty)
	{
		$sql = "UPDATE barang set total_stok = ((total_stok) - $qty) 
                WHERE id_barang=$id_barang";
		return $this->db->query($sql);
	}


	function cek_kode($kode)
	{
		return $this->db
			->select('id_barang')
			->where('kode_barang', $kode)
			->where('dihapus', 'tidak')
			->limit(1)
			->get('barang');
	}

	#satu barang bisa banyak kode asal supplier beda
	function cek_supplier_barang($kode_barang, $id_supplier)
	{
		return $this->db
			->select('id_barang')
			->where('kode_barang', $kode_barang)
			->where('id_vendor', $id_supplier)
			->where('dihapus', 'tidak')
			->limit(1)
			->get('barang');
	}



	#SERVER SIDE DATA TABLE
	private function _get_datatables_query($id_gudang = "")
	{
		$this->db->from($this->table);
		if ($id_gudang == "") {
			$this->db->where('dihapus', 'tidak');
		} else {
			$this->db->where('id_gudang', $id_gudang);
			$this->db->where('dihapus', 'tidak');
		}

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
	private function _get_barangmasuk_query()
	{
		$this->db->from('barang_masuk');
		$this->db->where('dihapus', 'tidak');
		$this->db->order_by('id', 'DESC');

		$i = 0;

		foreach ($this->column_search_barang_masuk as $item) {
			if ($_POST['search']['value']) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search_barang_masuk) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order_barang_masuk[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	private function _get_stok_barang_query($data_where)
	{
		$this->db->from($this->table);
		if ($data_where != null) {
			$this->db->where('dihapus', 'tidak');
			$this->db->where($data_where);
		} else {
			$this->db->where('dihapus', 'tidak');
		}

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
	private function _get_barangbarangbygudang_query($id_gudang)
	{
		$this->db->from('barang');
		$this->db->where('dihapus', 'tidak');
		$this->db->where('id_gudang', $id_gudang);

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

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_datatables_barangmasuk()
	{
		$this->_get_barangmasuk_query();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	function get_datatables_stok_barang($data_where)
	{
		$this->_get_stok_barang_query($data_where);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_datatables_by_gudang($id_gudang)
	{
		$this->_get_datatables_query($id_gudang);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}


	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	function count_filtered_stok_barang($data_where)
	{
		$this->_get_stok_barang_query($data_where);
		$query = $this->db->get();
		return $query->num_rows();
	}
	function count_filtered_barangmasuk()
	{
		$this->_get_barangmasuk_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	function count_filtered_by_gudang($id_gudang)
	{
		$this->_get_barangbarangbygudang_query($id_gudang);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		$this->db->where('dihapus', 'tidak');
		return $this->db->count_all_results();
	}
	public function count_all_by_gudang($id_gudang)
	{
		$this->db->from($this->table);
		$this->db->where('dihapus', 'tidak');
		$this->db->where('id_gudang', $id_gudang);
		return $this->db->count_all_results();
	}
	public function count_all_barang_masuk()
	{
		$this->db->from('barang_masuk');
		$this->db->where('dihapus', 'tidak');
		return $this->db->count_all_results();
	}

	public function count_stok_kosong()
	{
		$this->db->from($this->table);
		$this->db->where('total_stok', 0);
		return $this->db->count_all_results();
	}

	public function total_inventory($and)
	{
		$query = "
		SELECT 
			SUM(harga_beli*total_stok) AS total_rupiah
		FROM 
			barang
		WHERE total_stok > 0 
		$and";
		return $this->db->query($query);	
	}

	public function count_ready($wheres)
	{
		$this->db->from($this->table);
		$this->db->where($wheres);
		$this->db->where('total_stok>', 0);
		return $this->db->count_all_results();
	}
	public function count_kosong($wheres)
	{
		$this->db->from($this->table);
		$this->db->where($wheres);
		$this->db->where('total_stok', 0);
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
}

/* End of file Global_model.php */
/* Location: ./application/models/barang_model.php */
/* Please DO NOT modify this information : */
