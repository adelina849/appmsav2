<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Auth_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('access');
    }

    public function index()
    {
        $idPengguna = $this->session->userdata('idPengguna');

        $data = array(
            'view' => 'admin/dashboard'
        );
        $this->load->view('admin/template', $data);
    }
}

/* End of file admin/Dashboard.php */
