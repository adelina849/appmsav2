<?php if (!defined('BASEPATH')) exit('No Direct Script Allowed');

class Auth_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	public $tableLogin = 'login';
	public $tableLoginMhs = 'mahasiswa_akun';
	public $auth = 'auth';


	function auth($username, $password)
	{
		$this->db->where('username', $username);
		$this->db->where('password', $password);

		$this->db->limit(1);

		$query = $this->db->get($this->tableLogin);

		return ($query->num_rows() > 0) ? $query->row() : FALSE;
	}

	function info_pengguna($tabel, $field, $idpengguna)
	{
		$this->db->where($field, $idpengguna);
		$this->db->limit(1);
		$query = $this->db->get($tabel);
		return ($query->num_rows() > 0) ? $query->row() : FALSE;
	}

	function auth_mhs($username, $password)
	{
		$this->db->where('username', $username);
		$this->db->where('password', $password);

		$this->db->limit(1);

		$query = $this->db->get($this->tableLoginMhs);

		return ($query->num_rows() > 0) ? $query->row() : FALSE;
	}
}
