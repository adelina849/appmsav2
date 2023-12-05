<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('access');
	}

	public function index()
	{
		$this->form_login();
	}

	public function form_login()
	{
		$data = array(
			'action'	=> 'admin/auth/login',
			'error'		=> FALSE
		);
		$this->load->view('admin/auth', $data);
	}

	public function login()
	{
		$username 	= $this->keamanan->post($this->input->post('username'));
		$password 	= $this->keamanan->post($this->input->post('login-password'));
		$cekAuth 	= $this->access->login($username, $password);

		if ($cekAuth) {

			$idPengguna = $this->session->userdata('idPengguna');
			redirect(site_url('admin/dashboard'));
		} else {
			$this->session->set_flashdata('message_invalid', "
			<div class='alert alert-danger'> <i class='fa fa-exclamation-triangle'></i> Username atau password yang anda masukan tidak sesuai.</div>");
			redirect(site_url('admin/auth'));
		}
	}

	function signout()
	{
		$this->access->signout();
		redirect('admin/auth');
	}
}

/* End of file Auth.php */
