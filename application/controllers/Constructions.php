<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Constructions extends Auth_Mahasiswa_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('access');
    }

    public function index()
    {

        $idPengguna = $this->session->userdata('idPengguna');
        $idMahasiswa = $this->session->userdata('idMahasiswa');

        $data = array(
            'view' => 'constructions'
        );

        $this->load->view('mahasiswa/template', $data);
    }
}

/* End of file Construction.php */
