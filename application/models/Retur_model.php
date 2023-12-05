<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Retur_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public function get_data_do($nomor_do)
	{
		$this->db->select('pdo.tanggal, pdo.nomor_do, pdo.id_packing_m, pd.id_barang, pd.qty_terpacking, b.id_vendor,b.id_barang, b.kode_barang, b.nama_barang, v.nama_vendor');
		$this->db->from('packing_do as pdo');
		$this->db->join('packing_detail as pd', 'pd.id_packing_m = pdo.id_packing_m');
		$this->db->join('barang as b', 'b.id_barang = pd.id_barang');
		$this->db->join('vendor as v', 'v.id = b.id_vendor');
		$this->db->where('pdo.id_packing_m', $nomor_do);
		$this->db->where('pd.qty_so', 0);

		$query = $this->db->get();
		return $query->result();
	}

}

/* End of file retur_model.php */
/* Location: ./application/models/retur_model.php */
/* Please DO NOT modify this information : */
