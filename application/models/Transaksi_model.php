<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class transaksi_model extends CI_Model
{
	public $master_pesanan = 'pesanan_master';
	public $detail_pesanan = 'pesanan_detail';
	public $id = 'id';
	public $order = 'ASC';

	function __construct()
	{
		parent::__construct();
	}

	//**************** TRANSAKSI ***********************
	function last_nokwitansi($id)
	{
		$sql = "SELECT
					last_number AS maxs
					FROM pesanan_counter_number where id=$id limit 0, 1";
		return $this->db->query($sql)->row();
	}

	function update_nomor_spb($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('pesanan_counter_number', $data);
	}
	
	function update_nomor_sp($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('pesanan_counter_number', $data);
	}

	function insert_master($data_master)
	{
		return $this->db->insert($this->master_pesanan, $data_master);
	}

	function insert_detail($data_detail)
	{
		return $this->db->insert($this->detail_pesanan, $data_detail);
	}

	function get_nomor_sp($nomor_sp)
	{
		return $this->db
			->select('id_pesanan_m')
			->where('nomor_sp', $nomor_sp)
			->limit(1)
			->get('pesanan_master');
	}

	function get_nomor_sj($nomor_sj)
	{
		return $this->db
			->select('id')
			->where('nomor', $nomor_sj)
			->limit(1)
			->get('surat_jalan_master');
	}

	function get_nomor_spb($nomor_spb)
	{
		return $this->db
			->select('id_pembelian_m')
			->where('nomor_spb', $nomor_spb)
			->limit(1)
			->get('pembelian_master');
	}

	function get_nomor_penerimaan($nomor)
	{
		return $this->db
			->select('id_penerimaan_m')
			->where('nomor_penerimaan', $nomor)
			->limit(1)
			->get('penerimaan_master');
	}

	function get_detail($id_master)
	{
		$sql = "SELECT 
					penjualan_detail.*,
					COUNT(penjualan_detail.id_barang) AS total_item,
					barang.nama_barang 
					FROM penjualan_detail, barang
					WHERE barang.id_barang=penjualan_detail.id_barang
					AND penjualan_detail.id_penjualan_m=$id_master";
		return $this->db->query($sql);
	}
	function delete($table, $field, $id)
	{
		$this->db->where($field, $id);
		$this->db->delete($table);
	}

	function get_nomor_retur($nomor_retur, $table)
	{
		return $this->db
			->select('id')
			->where('nomor_retur', $nomor_retur)
			->limit(1)
			->get($table);
	}

}

/* End of file Admin_model.php */
/* Location: ./application/models/transaksi_model.php */
/* Please DO NOT modify this information : */
