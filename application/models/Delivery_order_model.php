<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Delivery_order_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}


	function get_do($keyword, $registered)
	{
		$sql = "SELECT * 
			FROM 
                `packing_do`
			WHERE 
				`dihapus` = 'tidak' 
				AND ( 
					`nomor_do`='".$keyword."' 
				)";
		return $this->db->query($sql);
	}

	#cari kode barang dengan harga reseller (paket)
	function cari_kode_hargareseller($keyword, $registered)
	{
		$not_in = '';

		$koma = explode(',', $registered);
		if(count($koma) > 1)
		{
			$not_in .= " AND `kode_barang` NOT IN (";
			foreach($koma as $k)
			{
				$not_in .= " '".$k."', ";
			}
			$not_in = rtrim(trim($not_in), ',');
			$not_in = $not_in.")";
		}
		if(count($koma) == 1)
		{
			$not_in .= " AND `kode_barang` != '".$registered."' ";
		}
		
		$sql = "
			SELECT 
				`kode_barang`, `nama_barang`, `harga_jual` 
			FROM 
				`barang` 
			WHERE 
				`dihapus` = 'tidak' 
				AND ( 
					`kode_barang` LIKE '%".$this->db->escape_like_str($keyword)."%' 
					OR `nama_barang` LIKE '%".$this->db->escape_like_str($keyword)."%' 
				) 
				".$not_in." 
		";

		return $this->db->query($sql);
	}

}

/* End of file Delivery_order_model.php */
/* Location: ./application/models/Delivery_order_model.php */
/* Please DO NOT modify this information : */
