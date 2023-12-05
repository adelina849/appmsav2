<?php if (!defined('BASEPATH')) exit('No Direct Script Allowed');

class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
}

class Auth_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (!$this->access->is_login()) {
			redirect('admin/auth');
		}
	}
	function is_login()
	{
		return $this->access->is_login();
	}
}
