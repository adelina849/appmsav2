<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pesanan_model extends CI_Model
{
	var $table = 'pesanan_master';
	var $column_order = array(null, 'nomor_sp', 'tanggal_sp', 'grand_total', 'jenis_sp', 'sistem_transaksi', 'id_lembaga', 'id_pelanggan');
	var $column_search = array('nomor_sp', 'tanggal_sp', 'grand_total', 'jenis_sp', 'sistem_transaksi', 'id_lembaga', 'id_pelanggan');
	var $order = array('id_pesanan_m' => 'desc');

	function __construct()
	{
		parent::__construct();
	}

	#SERVER SIDE DATA TABLE
	private function _get_datatables_query($data_where)
	{
		//$data_where = array('date(tanggal_sp)>=' => '2022-12-01', 'date(tanggal_sp)<=' => '2022-12-30');
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
		$this->db->where('id_pesanan_m', $id);
		$query = $this->db->get();

		return $query->row();
	}
	#END OF SERVER SIDE DATA TABLE    
	function last_number_sp($id)
	{
		$sql = "SELECT
					last_number AS maxs
					FROM pesanan_counter_number where id=$id limit 0, 1";
		return $this->db->query($sql)->row();
	}
	function update_number_sp($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('counter_kwintansi', $data);
	}

	function cari_lembaga($keyword)
	{
		$sql = "
			SELECT * FROM lembaga
			WHERE 
				dihapus = 'tidak' 
				AND ( 
					nama_lembaga LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
				)";

		return $this->db->query($sql);
	}
	function cari_pelanggan($keyword)
	{
		$sql = "
			SELECT * FROM pelanggan
			WHERE 
				dihapus = 'tidak' 
				AND ( 
					nama_pelanggan LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
				)";

		return $this->db->query($sql);
	}
	#hitung sp yang sudah di packing atau di DO
	function count_do($id_pesanan_m)
	{
		$query = "SELECT 
            COUNT(id_pesanan_m) AS total_do
            FROM packing_master
            WHERE
            id_pesanan_m ='" . $id_pesanan_m . "'" . "
            AND dihapus='tidak'";
		return $this->db->query($query)->row();
	}

	function count_qty_terpacking($id_pesanan_m, $id_barang)
	{
		$query = "
		SELECT 
			SUM(qty_terpacking) AS total_qty_terpacking
		FROM 
			packing_detail
		WHERE id_pesanan_m='" . $id_pesanan_m . "'" . "	
		AND id_barang='" . $id_barang . "'";
		return $this->db->query($query);
	}
	// function count_do($table, $field, $key)
	// {
	//     $query = "SELECT 
	//         COUNT($field) AS total
	//         FROM $table
	//         WHERE
	//             $field = $key
	//         AND dihapus='tidak'";
	//     return $this->db->query($query)->row();
	// }
	function nota_penjualan_count($WHERE)
	{
		$query = "
		SELECT 
			SUM(penjualan_detail.jumlah_beli) AS total_produk_terjual,
			SUM(penjualan_detail.total) AS total_penjualan,
			SUM(penjualan_detail.jumlah_beli*barang.harga_beli) AS total_harga_modal,
			(SUM(penjualan_detail.total) - SUM(penjualan_detail.jumlah_beli*barang.harga_beli)) AS laba_kotor 
		FROM 
			penjualan_master, penjualan_detail, barang
		$WHERE	
		AND penjualan_master.id_penjualan_m=penjualan_detail.id_penjualan_m
		AND barang.id_barang=penjualan_detail.id_barang";
		return $this->db->query($query);
	}

	public function nominal_pesanan($and, $jenis_sp)
	{
		$query = "
		SELECT 
			SUM(grand_total) AS total_rupiah
		FROM 
			pesanan_master
		WHERE dihapus = 'tidak'
		AND jenis_sp='".$jenis_sp."' 
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

	public function count_sp($and, $jenis_sp)
	{
		$query = "
		SELECT 
			count(id_pesanan_m) AS jumlah
		FROM 
			pesanan_master
		WHERE dihapus = 'tidak' 
		AND jenis_sp='".$jenis_sp."' 
		$and";
		return $this->db->query($query);	
	}
	public function count_sp_all($jenis_sp)
	{
		$query = "
		SELECT 
			count(id_pesanan_m) AS jumlah_all
		FROM 
			pesanan_master
		WHERE dihapus = 'tidak' 
		AND jenis_sp='".$jenis_sp."'";
		return $this->db->query($query);	
	}

	#COUNT DO

	public function count_do_all()
	{
		$query = "
		SELECT 
			count(id) AS jumlah_do
		FROM 
			packing_do
		WHERE dihapus = 'tidak'";
		return $this->db->query($query);	
	}

}

/* End of file Pesanan_model.php */
/* Location: ./application/models/pesanan_model.php */
/* Please DO NOT modify this information : */
