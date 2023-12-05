<?php if (!defined('BASEPATH')) exit('No Direct Script Allowed');
class Access
{
	function __construct()
	{
		$this->CI = &get_instance();
		$auth = $this->CI->config->item('auth');

		$this->CI->load->helper('cookie');
		$this->CI->load->model('auth_model');

		$this->auth_model = &$this->CI->auth_model;
	}

	public $user;

	function login($username, $pass)
	{
		$password = md5($pass);

		$result = $this->auth_model->auth($username, $password);

		if ($result) {
			if (($username === $result->username) && ($password === $result->password)) {
				$infouser = array(
					'id' => $result->id,
					'idPengguna' => $result->idpengguna,
					'level'	=> $result->level
				);
				$this->CI->session->set_userdata($infouser);
				return TRUE;
			}
		}
		return FALSE;
	}

	function is_login()
	{
		#yang login bukan user admin
		if ($this->CI->session->userdata('level') != 'admin') {
			redirect('admin/auth');
		}
		return (($this->CI->session->userdata('idPengguna')) ? TRUE : FALSE);
	}

	function signout()
	{
		$this->CI->session->unset_userdata('idPengguna');
		$this->CI->session->unset_userdata('level');
		$this->CI->session->unset_userdata('id');
	}
}
