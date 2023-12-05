<?php if (!defined('BASEPATH')) exit('No Direct Script Allowed');
class Keamanan
{
	private $CI = NULL;
	public $tblUser = 'pengguna';
	public $key		= 'idpengguna';

	function __construct()
	{
		$this->CI = &get_instance();
	}

	function user($idUser, $field)
	{
		$this->CI->db->from($this->tblUser);
		$this->CI->db->where($this->key, $idUser);
		$result = $this->CI->db->get();
		$r = $result->row();
		return $r->$field;
	}

	function table_pengguna($level)
	{
		switch ($level):
			case 'admin':
				$tabel = 'pengguna';
				break;
		endswitch;
		return $tabel;
	}

	function post($input)
	{
		return addslashes(htmlspecialchars($input));
	}

	function post_array($input)
	{
		$temp = "";
		for ($i = 0; $i < count($input); $i++) {
			$temp .= $input[$i];
			$i != count($input) - 1 ? $temp .= ", " : "";
		}
		return $this->post($temp);
	}

	function panjang($input)
	{
		$i = 0;
		while ($i < count($input)) {
			if (strlen($input[$i]) > $input[$i + 1]) {
				return TRUE;
			}
			$i += 2;
		}
	}

	function cari($input)
	{
		return strip_tags($input);
	}

	function url_enkripsi($url)
	{
		return str_replace(" ", "-", $url);
	}

	function url_deskripsi($url)
	{
		return str_replace("-", " ", $url);
	}

	function get($url)
	{
		return str_replace("%20", "-", $url);
	}
}
