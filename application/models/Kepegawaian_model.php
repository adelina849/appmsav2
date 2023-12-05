<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kepegawaian_model extends CI_Model
{
	var $order = array('id' => 'desc');
	var $column_order = array(null, 'bulan', 'tahun', 'nama_pegawai', 'jabatan', 'gaji_pokok', 'potongan', 'total');
	var $column_order_absen = array(null, 'nama_karyawan', 'id_karyawan', 'jumlah_tidak_hadir');
	var $column_search = array('nama_pegawai', 'jabatan');
	var $column_search_absen = array('nama_karyawan', 'id_karyawan');

	function __construct()
	{
		parent::__construct();
	}

	function get_data_karyawan()
	{
		$this->db->select('pengguna.idpengguna, pengguna.nama_lengkap, pengguna.id_jabatan, jabatan.nama_jabatan, jabatan.gaji_pokok');
		$this->db->from('pengguna');
		$this->db->join('jabatan', "pengguna.id_jabatan = jabatan.id");
		$this->db->where("pengguna.dihapus = 'tidak'");
		$this->db->where("jabatan.dihapus = 'tidak'");

		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query($data_where, $table)
	{
		if ($table == 'penggajian') {
			$this->db->from('penggajian');
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
		} else {
			$this->db->from('absensi');
			$this->db->where($data_where);
			$i = 0;

			foreach ($this->column_search_absen as $item) {
				if ($_POST['search']['value']) {
					if ($i === 0) {
						$this->db->group_start();
						$this->db->like($item, $_POST['search']['value']);
					} else {
						$this->db->or_like($item, $_POST['search']['value']);
					}

					if (count($this->column_search_absen) - 1 == $i)
						$this->db->group_end();
				}
				$i++;
			}

			if (isset($_POST['order'])) // here order processing
			{
				$this->db->order_by($this->column_order_absen[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
			} else if (isset($this->order)) {
				$order = $this->order;
				$this->db->order_by(key($order), $order[key($order)]);
			}
		}
	}

	function get_datatables($data_where, $table)
	{
		$this->_get_datatables_query($data_where, $table);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}


	function count_filtered($data_where, $table)
	{
		$this->_get_datatables_query($data_where, $table);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($table)
	{
		$this->db->from($table);
		return $this->db->count_all_results();
	}

	public function count_existing($bulan, $tahun, $table)
	{
		$this->db->from($table);
		$this->db->where('bulan', $bulan);
		$this->db->where('tahun', $tahun);

		return $this->db->count_all_results();
	}
}

/* End of file Global_model.php */
/* Location: ./application/models/penggajian_model.php */
/* Please DO NOT modify this information : */
