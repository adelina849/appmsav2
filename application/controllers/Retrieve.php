<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Retrieve extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->load->model('msa_model', 'msa');
	}

	public function index()
	{
		echo 'Access Not Allowed.';
	}

    function pelanggan(){
        $data = $this->msa->get_all('pelanggan', 'id');
        $response = array();
        $posts = array();
        foreach ($data as $d) {
            $posts[] = array(
                "id"    => $d->id,	
                "kode"   =>$d->kode,	
                "nama_pelanggan" => $d->nama_pelanggan,	
                "tempat_lahir" => $d->tempat_lahir,	
                "tanggal_lahir" => $d->tanggal_lahir,	
                "jenis_kelamin" => $d->jenis_kelamin,	
                "alamat" => $d->alamat,	
                "agama" => $d->agama,	
                "status_perkawinan" => $d->status_perkawinan,	
                "tanggal_jadi_pelanggan" => $d->tanggal_jadi_pelanggan,	
                "usia" => $d->usia,	
                "email" => $d->jabatan,	
                "jabatan" => $d->id,	
                "kontak" => $d->kontak,	
                "id_lembaga" => $d->id_lembaga,	
                "dihapus" => $d->dihapus	                    
            );
        } 
        $response['posts'] = $posts;
        echo json_encode($response,TRUE);
        // $a =  json_encode($response,TRUE);
        // print_r(json_decode($a));

        //If the json is correct, you can then write the file and load the view        
        // $fp = fopen('./pelanggan.json', 'w');
        // fwrite($fp, json_encode($response));
    
        // if ( ! write_file('./pelanggan.json', $arr))
        // {
        //     echo 'Unable to write the file';
        // }
        // else
        // {
        //     echo 'file written';
        // }

    }

    function lembaga(){
        $data = $this->msa->get_all('lembaga', 'id');
        $response = array();
        $posts = array();
        foreach ($data as $d) {
            $posts[] = array(
                "id"    => $d->id,		
                "kode"    => $d->kode,	
                "nama_lembaga"    => $d->nama_lembaga,	
                "alamat"    => $d->alamat,		
                "jenjang"    => $d->jenjang,		
                "status"    => $d->status,		
                "klasifikasi"    => $d->klasifikasi,		
                "kabupaten"    => $d->kabupaten,		
                "provinsi"    => $d->provinsi,		
                "kecamatan"    => $d->kecamatan,		
                "desa"    => $d->desa,		
                "nomor_telepon"    => $d->nomor_telepon,		
                "dihapus"    => $d->dihapus,	
            );
        } 
            $response['posts'] = $posts;
            echo json_encode($response,TRUE);
    }

    function supplier(){
        $data = $this->msa->get_all('vendor', 'id');
        $response = array();
        $posts = array();
        foreach ($data as $d) {
            $posts[] = array(
                "id"    => $d->id,		
                "kode"    => $d->kode,		
                "nama_vendor"    => $d->nama_vendor,		
                "klasifikasi"    => $d->klasifikasi,		
                "kontak"    => $d->kontak,	
                "email"    => $d->email,		
                "tlp"    => $d->tlp,		
                "alamat"    => $d->alamat,		
                "nama_bank"    => $d->nama_bank,		
                "norek"    => $d->norek,		
                "dihapus"    => $d->dihapus,		
            );
        } 
        $response['posts'] = $posts;
        echo json_encode($response,TRUE);
    }

    #TRANSAKSI PEMBELIAN DIAMBIL DARI PENERIMAAN BARANG
    function pembelian(){
        $q = $this->db->query("SELECT *
                                FROM penerimaan_master AS a
                                WHERE dihapus='tidak'
                                ORDER BY a.tanggal DESC");
        $data = $q->result();
        $response = array();
        $posts = array();
        foreach ($data as $d) {
            $posts[] = array(
                "id_penerimaan_m"    => $d->id_penerimaan_m,	
                "id_pembelian_m"    => $d->id_pembelian_m,	
                "nomor_penerimaan"    => $d->nomor_penerimaan,
                "tanggal"    => $d->tanggal,	
                "grand_total"    => $d->grand_total,	
                "ppn"    => $d->ppn,	
                "netto"    => $d->netto,	
                "diskon"    => $d->diskon,	
                "netto_bayar"    => $d->netto_bayar,	
                "uang_muka"    => $d->uang_muka,	
                "sisa_bayar"    => $d->sisa_bayar,	
                "id_user"    => $d->id_user,	
                "tanggal_input"    => $d->tanggal_input,	
                "nomor_invoice"    => $d->nomor_invoice,	
                "pengirim"    => $d->pengirim,	
                "dihapus"    => $d->dihapus,	                    
            );
        } 
        $response['posts'] = $posts;
        echo json_encode($response,TRUE);
    }


}

/* End of file Retrieve.php */
