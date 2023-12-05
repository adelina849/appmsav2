<?php if (!defined('BASEPATH')) exit('No Direct Script Allowed');

class Config_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public $tblConfig = 'config';


    function konfigurasi()
    {
        $this->db->limit(1);
        $query = $this->db->get($this->tblConfig);
        return ($query->num_rows() > 0) ? $query->row() : FALSE;
    }

    // function prodi($KodeProdi)
    // {
    //     $sql = 'SELECT * FROM prodi WHERE KodeProdi=?';
    //     return $this->db->query($sql, array($KodeProdi));
    // }

    // function smtr_ganjil_genap()
    // {
    //     $sql = 'SELECT RIGHT(semester, 1) AS ganjil_genap FROM rft_konfigurasi';
    //     return $this->db->query($sql);
    // }
}
