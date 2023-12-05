<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Auth_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('access');
        $this->load->model('msa_model', 'msa');
        $this->load->model('pesanan_model', 'pesanan');
        $this->load->model('barang_model', 'barang');
    }

    public function index(){
        $this->daftar();
    }

    function daftar(){
        date_default_timezone_set('Asia/Jakarta');

        $tglHariIni = date('Y-m-d');
        $th = date('Y');
        $bln = date('m');
        $hr = date('d');
        $tanggal = $sp_bulan_ini = $tAwal = $tAkhir = $id_lembaga = $id_pelanggan = '';

        $title = 'DAFTAR DELIVERY ORDER (DO)';
        if ($this->input->post('filter', TRUE)) {
            $tAwal = $this->input->post('awal', TRUE);
            $tAkhir = $this->input->post('akhir', TRUE);
            $id_lembaga = $this->input->post('lembaga', TRUE);
            $id_pelanggan = $this->input->post('pelanggan', TRUE);
            $tanggal = $this->tanggal->konversi($tAwal) . ' - ' . $this->tanggal->konversi($tAkhir);
            $title = 'DAFTAR DELIVERY ORDER (DO) ' . $tanggal;

            $id_lembaga = $this->input->post('id_lembaga');
            $id_pelanggan = $this->input->post('id_pelanggan');
            if ((!empty($id_lembaga) && !empty($id_pelanggan))) {
                $data_wheres = "AND c.id_lembaga='".$id_lembaga."' 
                                AND c.id_pelanggan='".$id_pelanggan."' 
                                AND date(a.tanggal)>='".$tAwal."' 
                                AND date(a.tanggal)<='".$tAkhir."'";
            } else if (!empty($id_lembaga)) {
                $data_wheres = "AND c.id_lembaga='".$id_lembaga."' 
                            AND date(a.tanggal)>='".$tAwal."' 
                            AND date(a.tanggal)<='".$tAkhir."'";
            } else if (!empty($id_pelanggan)) {
                $data_wheres = "AND c.id_pelanggan='".$id_pelanggan."' 
                            AND date(a.tanggal)>='".$tAwal."' 
                            AND date(a.tanggal)<='".$tAkhir."'";
            } else {
                $data_wheres = "AND date(a.tanggal)>='".$tAwal."' 
                                AND date(a.tanggal)<='".$tAkhir."'";
            }

        } else {
            $tanggal = $hr . ' ' . $this->tanggal->bulan($bln) . ' ' . $th;
            $sp_bulan_ini = $bln;
            $title = 'DAFTAR DELIVERY ORDER (DO) '.$this->tanggal->bulan($bln) . ' ' . $th;
            $data_wheres = "AND month(a.tanggal) = '".$sp_bulan_ini."'";

        }

		// $count_sp = $this->pesanan->count_sp($and, $jenis_sp)->row();
		//$count_do_all = $this->pesanan->count_do_all()->row();
		
        $data = array(
            'title'         => $title,
            'sp_bulan_ini'  => $sp_bulan_ini,
            'tAwal'    => $tAwal,
            'tAkhir'    => $tAkhir,
            'id_lembaga'    => $id_lembaga,
            'id_pelanggan'    => $id_pelanggan,
            'tanggal'       => $tanggal,
			//'count_do_all'	=>$count_do_all->jumlah_do,
			'data_wheres'	=>$data_wheres,
            'action_filter' => site_url('admin/order/daftar'),
            'action_cetak' => site_url('admin/cetak/surat_pesanan'),
            'view' => 'admin/order/daftar'
        );
        $this->load->view('admin/template', $data);
    }
    //
	public function all_dovalidate(){
        $sp_bulan_ini = $this->input->post('sp_bulanini');
        $tAwal = $this->input->post('tAwal');
        $tAkhir = $this->input->post('tAkhir');

        if (!empty($sp_bulan_ini)) {
            #tampilkan bulan aktif kalo tidak ada filter
            $data_wheres = "AND month(a.tanggal) = '".$sp_bulan_ini."'";
        } else {
            $id_lembaga = $this->input->post('id_lembaga');
            $id_pelanggan = $this->input->post('id_pelanggan');
            if ((!empty($id_lembaga) && !empty($id_pelanggan))) {
                $data_wheres = "AND c.id_lembaga='".$id_lembaga."' 
                                AND c.id_pelanggan='".$id_pelanggan."' 
                                AND date(a.tanggal)>='".$tAwal."' 
                                AND date(a.tanggal)<='".$tAkhir."'";
            } else if (!empty($id_lembaga)) {
                $data_wheres = "AND c.id_lembaga='".$id_lembaga."' 
                            AND date(a.tanggal)>='".$tAwal."' 
                            AND date(a.tanggal)<='".$tAkhir."'";
            } else if (!empty($id_pelanggan)) {
                $data_wheres = "AND c.id_pelanggan='".$id_pelanggan."' 
                            AND date(a.tanggal)>='".$tAwal."' 
                            AND date(a.tanggal)<='".$tAkhir."'";
            } else {
                $data_wheres = "AND date(a.tanggal)>='".$tAwal."' 
                                AND date(a.tanggal)<='".$tAkhir."'";
            }
        }

		$s = "SELECT 
                    a.nomor_do,
                    b.id_packing_m, b.nomor_packing, b.tanggal_packing,
                    c.id_pesanan_m, c.nomor_sp, c.id_lembaga, c.id_pelanggan, c.id_mitra, c.grand_total, c.sisa_bayar, c.sistem_pembayaran
                FROM packing_do AS a
                INNER JOIN packing_master AS b
                ON a.id_packing_m=b.id_packing_m
                INNER JOIN pesanan_master AS c
                ON b.id_pesanan_m = c.id_pesanan_m
                $data_wheres
                ORDER BY a.nomor_do DESC";
		$q = $this->db->query($s);
		$no = 1;
		$result = array();
		$result['total'] = $q->num_rows();
		$row = array();	
		foreach($q->result() as $data) {	
            $qPelanggan = $this->db->get_where('pelanggan', array('id' => $data->id_pelanggan))->result();
            $qLembaga = $this->db->get_where('lembaga', array('id' => $data->id_lembaga))->result();
            
            //HITUNG NILAI FAKTUR DO
            $QpackingDetail = $this->db->get_where('packing_detail', array('id_packing_m' => $data->id_packing_m, 'qty_terpacking >' => 0))->result();
            $nilai_do = 0;
            foreach ($QpackingDetail as $pd) {
                $harga_total = 0;
               // $jmlQty = 0;
                $pdid_barang = $pd->id_barang;
                //$pdbarang = $this->db->get_where('barang', array('id_barang' => $pd->id_barang))->result();
                $sp_detail = $this->db->get_where('pesanan_detail', array('id_pesanan_m' => $data->id_pesanan_m, 'id_barang'=>$pdid_barang))->result();
                $harga_satuan = (isset($sp_detail[0]->harga_satuan) ? $sp_detail[0]->harga_satuan : 0); 
                $harga_total = ($pd->qty_terpacking * $harga_satuan);
                $nilai_do += $harga_total;
            }

            $row[] = array(
                'no'=> '<div class="text-center">'.$no.'</div>',
                'nomor_do'=>'<span>' . $data->nomor_do . '</span>',
                'nomor_sp'=>'<span>' . $data->nomor_sp . '</span>',
                'pelanggan'=>'<span>' . strtoupper(isset($qPelanggan[0]->nama_pelanggan) ? $qPelanggan[0]->nama_pelanggan : '-') . '</span>',
                'lembaga'=>'<span>' . strtoupper(isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-') . '</span>',
                'status'=>'<span>' . strtoupper(isset($qLembaga[0]->satus) ? $qLembaga[0]->satus : '-') . '</span>',
                'pembayaran'=>'<span>' . strtoupper($data->sistem_pembayaran) . '</span>',
                'jenjang'=>'<span>' . strtoupper(isset($qLembaga[0]->jenjang) ? $qLembaga[0]->jenjang : '-') . '</span>',
                'nilai_do'=>'<div class="text-right">' . str_replace(',', '.', number_format($nilai_do)) . '</div>',
                'nilai_sp'=>'<div class="text-right">' . str_replace(',', '.', number_format($data->grand_total)) . '</div>',
                'aksi'=>'<div class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="' . site_url('admin/order/delivery/' . $data->id_pesanan_m . '/list') . '" data-toggle="tooltip" title="Detail Order" 
                                    class="btn btn-alt btn-success btn-xs">
                                    <i class="fa fa-search"></i> Detail
                                </a>
                            </div>        
                        </div>' 
            );
			$no++;
		}
		
		$result = array('aaData'=>$row);
		echo json_encode($result);
		
	}

    public function delivery($id_pesanan_m)
    {
        if (empty($id_pesanan_m)) {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Surat Pesanan Tidak Dapat Ditemukan'));
            redirect('admin/packing');
        } else {
            $title = 'DELIVERY ORDER LIST';
            $jumlah_do = $this->pesanan->count_do($id_pesanan_m);
            $data = array(
                'title'         => $title,
                'jumlah_do'         => $jumlah_do->total_do,
                'id_pesanan'         => $id_pesanan_m,
                'action_packing' => site_url('admin/packing/simpan'),
                'action_cetak' => site_url('admin/cetak/surat_pesanan'),
                'action_validasi' => site_url('admin/order/validasi'),
                'view' => 'admin/order/delivery-order-list'
            );
            $this->load->view('admin/template', $data);
        }
    }

    public function ajax_get_do()
    {
        $id_packing_do     = $this->input->post('id_packing_do');
        $d = $this->msa->get_by_id('id', $id_packing_do, 'packing_do');

        $tanggal=$nomor_do=$jumlah_qoli=$jumlah_ikat=$kepala_gudang=$pengirim = '';
        if($id_packing_do > 0){
            $tanggal    = $d->tanggal;
            $nomor_do   = $d->nomor_do;
            $jumlah_qoli= $d->jumlah_qoli;
            $jumlah_ikat= $d->jumlah_ikat;
            $kepala_gudang=$d->kepala_gudang;
            $pengirim = $d->pengirim;
        }
        echo json_encode(array(
			'tanggal'		=> $tanggal, 
			'nomor_do'      => $nomor_do,
			'jumlah_qoli'	=> $jumlah_qoli,
			'jumlah_ikat'	=> $jumlah_ikat,
			'kepala_gudan'  =>$kepala_gudang,
			'pengirim'	    => $pengirim
        ));
    }

    function validasi()
    {
		date_default_timezone_set('Asia/Jakarta');

        if ($this->input->server('HTTP_REFERER')) {
            $idpengguna            = $this->session->userdata('idPengguna');
            
            $id_packing_do = $this->input->post('id_packing_do');
            $id_pesanan = $this->input->post('id_pesanan');
            $id_packing_m = $this->input->post('id_packing_m');    

            $qoli = $this->input->post('qoli');
            $ikat = $this->input->post('ikat');        

            if (empty($id_packing_m)) {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'DO tidak dapat divalidasi!'));
                redirect('admin/order/delivery/' . $id_pesanan . '/list');
            }
            else {
                
                #nomor urut do
                $tanggal_do     = $this->input->post('tanggal_do');
                $t = explode("-", $tanggal_do);
                $format = ($t[0] . $t[1] . $t[2]); //tahun-bulan-tanggal

                $qNumber = $this->db->query("SELECT
                            last_number_do AS maxs
                            FROM counter_number WHERE id='1' limit 0, 1")->row();
                $last_no    = $qNumber->maxs;
                $no_urut    = (($last_no == 0) ? 1 : $last_no += 1);
                $nomor_do     = 'DO' . $format . sprintf("%05s", $no_urut);
    
                #data validasi
                $data_validasi = array(
                    'tanggal'  => $tanggal_do,
                    'nomor_do'  => $nomor_do,
                    'id_packing_m'  => $id_packing_m,
                    'jumlah_qoli'      => $qoli,
                    'jumlah_ikat' => $ikat,
                    'kepala_gudang'   => $idpengguna,
                    'pengirim'   => ''
                );
                if($id_packing_do==0){
                    #kalo id_do 0 insert data
                    $this->db->insert('packing_do', $data_validasi);
                }else{
                    $this->msa->update('packing_do', 'id', $id_packing_do, $data_validasi);
                }

                #return last id packing_do
                //$lastid_packing_do = $this->db->insert_id();

                if ($this->db->affected_rows() > 0) {
                    #update NOMOR URUT 
                    $newNumber = array('last_number_do' => $no_urut);
                    $this->db->where('id', 1);
                    $this->db->update('counter_number', $newNumber);
            
                    $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'DO Berhasil Divalidasi'));
                } else {

                    $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'DO Tidak Berhasil Divalidasi'));
                }
            }
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Opps. terjadi kesalahan pada pengisian data, silahkan ulangi validasi !'));
        }
        redirect('admin/packing/form_packing/' . $id_pesanan . '/barang');
    }

    public function print_do($id_packing_do, $id_pesanan, $id_packing_m){
        $data = array(
            'id_packing_do' => $id_packing_do,
            'id_pesanan' => $id_pesanan,
            'id_packing_m' => $id_packing_m,
            'title'         => 'DELIVERY ORDER (DO)'
        );

        $this->load->view('admin/print/print-delivery-order', $data);
    }

    public function print_packing($id_pesanan, $id_packing_m){
        $data = array(
            'id_pesanan' => $id_pesanan,
            'id_packing_m' => $id_packing_m,
            'title'         => 'FORM PACKING BARANG'
        );

        #KALO PERNAH DI CETAK update cetak = 1
        $flag = array('cetak' => 1);
        $this->db->where('id_packing_m', $id_packing_m);
        $this->db->update('packing_master', $flag);

        $this->load->view('admin/print/print-packing-barang', $data);
    }

    public function print_faktur($id_packing_do, $id_pesanan, $id_packing_m){
        $data = array(
            'id_packing_do' => $id_packing_do,
            'id_pesanan' => $id_pesanan,
            'id_packing_m' => $id_packing_m,
            'title'         => 'FAKTUR PENJUALAN'
        );

        $this->load->view('admin/print/print-faktur', $data);
    }    

    public function messageAlert($type, $title)
    {
        $messageAlert = "const Toast = Swal.mixin({
        	toast: true,
        	position: 'center',
            showConfirmButton: true,
        	timer: 6000,
            timerProgressBar: true
        });
        Toast.fire({
        	type: '" . $type . "',
        	title: '" . $title . "',
        });";
        return $messageAlert;
    }

}

/* End of file admin/Order.php */
