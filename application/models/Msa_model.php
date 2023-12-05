<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Msa_model extends CI_Model
{
	public $desc = 'DESC';
	public $order = 'DESC';

	function __construct()
	{
		parent::__construct();
	}

	public function random_id($table, $key)
	{
		$str = random_string('alnum', 8); //alnumeric
		$no = 0;
		do {
			$slug[] = $no < 1 ? $str : random_string('alnum', 8);
			$newslug = $slug[($no)];
			$no++;
		} while (count($this->db->get_where($table, array($key => $newslug))->result()) > 0);
		return $newslug;
	}

	public function slug($table, $key, $str)
	{
		$str = word_limiter($str, 5, '');
		$str = url_title($str, '-', TRUE);
		$no = 0;
		do {
			$slug[] = $no < 1 ? $str : $str . '_' . $no;
			$newslug = $slug[($no)];
			$no++;
		} while (count($this->db->get_where($table, array($key => $newslug))->result()) > 0);

		return $newslug;
	}

	// get all	

	function get_all($table, $field)
	{
		return $this->db
			->order_by($field, $this->desc)
			->where('dihapus', 'tidak')
			->get($table)->result();
	}

	function getby_id($table, $field, $key)
	{
		return $this->db
			->where($field, $key)
			->limit(1)
			->get($table);
	}

	function getById($table, $field, $key)
	{
		$this->db->where($field, $key);

		$query = $this->db->get($table);

		return ($query->num_rows() > 0) ? $query->row() : FALSE;
	}

	function get_by_id($field, $id, $table)
	{
		$this->db->where($field, $id);
		return $this->db->get($table)->row();
	}

	function terbaru($table, $field)
	{
		return $this->db
			->order_by($field, 'DESC')
			->limit(5)
			->get($table)
			->result();
	}
	function max_id($table, $field)
	{
		return $this->db
			->where('id', 1)
			->order_by($field, 'ASC')
			->limit(1)
			->get($table);
	}
	function get_last_code($table, $field)
	{
		return $this->db
			->order_by($field, 'DESC')
			->limit(1)
			->get($table);
	}

	function cek_existing_code($table, $field, $kode)
	{
		return $this->db
			->select($field)
			->where($field, $kode)
			->where('dihapus', 'tidak')
			->limit(1)
			->get($table);
	}

	function insert($table, $data)
	{
		$this->db->insert($table, $data);
	}

	function update($tabel, $field, $id, $data)
	{
		$this->db->where($field, $id);
		$this->db->update($tabel, $data);
	}
	// delete data
	function delete($table, $field, $id)
	{
		$this->db->where($field, $id);
		$this->db->delete($table);
	}
	public function _count($table)
	{
		return $this->db
				->from($table)
				->count_all_results();
	}	

	public function __count($table, $field, $key)
	{
		return $this->db
		->from($table)
		->where($field, $key)
		->count_all_results();
	}	

}

/* End of file Global_model.php */
/* Location: ./application/models/msa_model.php */
/* Please DO NOT modify this information : */
