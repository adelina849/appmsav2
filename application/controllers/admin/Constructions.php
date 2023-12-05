<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Constructions extends Auth_Controller
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
            'view' => 'constructions'
        );
        $this->load->view('admin/template', $data);
    }
}

/* End of file Construction.php */
