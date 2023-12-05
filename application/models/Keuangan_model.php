<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Keuangan_model extends CI_Model
{
	var $table = 'hutang';
	var $column_order_hutang = array(null, 'kode', 'tanggal', 'id_vendor', 'nominal', 'status'); //set column field
	var $column_order_piutang = array(null, 'nomor_sp', 'tanggal_sp', 'jatuh_tempo', 'id_lembaga', 'id_pelanggan', 'id_mitra', 'id_pelaksana', 'nominal', 'status'); //set column field
	var $column_search_hutang = array('kode', 'tanggal', 'nama_vendor', 'nominal', 'status'); //set column field database for datatable searchable 
	var $column_search_piutang = array('nomor_sp', 'tanggal_sp', 'jatuh_tempo', 'id_lembaga', 'id_pelanggan', 'id_mitra', 'id_pelaksana', 'nominal', 'status'); //set column field database for datatable searchable 
	var $order = array('id' => 'desc');

	function __construct()
	{
		parent::__construct();
	}

	#SERVER SIDE DATA TABLE
	private function _get_datatables_query($table)
	{
		$this->db->from($table);
		$this->db->where('dihapus', 'tidak');

		$i = 0;
		if ($table == "hutang") {
			foreach ($this->column_search_hutang as $item) {
				if ($_POST['search']['value']) {
					if ($i === 0) {
						$this->db->group_start();
						$this->db->like($item, $_POST['search']['value']);
					} else {
						$this->db->or_like($item, $_POST['search']['value']);
					}

					if (count($this->column_search_hutang) - 1 == $i)
						$this->db->group_end();
				}
				$i++;
			}
			if (isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($this->column_order_hutang[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} else if (isset($this->order)) {
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		} else {
			foreach ($this->column_order_piutang as $item) {
				if ($_POST['search']['value']) {
					if ($i === 0) {
						$this->db->group_start();
						$this->db->like($item, $_POST['search']['value']);
					} else {
						$this->db->or_like($item, $_POST['search']['value']);
					}

					if (count($this->column_order_piutang) - 1 == $i)
						$this->db->group_end();
				}
				$i++;
			}
			if (isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($this->column_order_piutang[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} else if (isset($this->order)) {
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
	}

	function get_datatables($table)
	{
		$this->_get_datatables_query($table);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($table)
	{
		$this->_get_datatables_query($table);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($table)
	{
		$this->db->from($table);
		$this->db->where('dihapus', 'tidak');
		return $this->db->count_all_results();
	}
	#END OF SERVER SIDE DATA TABLE    
}

/* End of file Global_model.php */
/* Location: ./application/models/barang_model.php */
/* Please DO NOT modify this information : */
