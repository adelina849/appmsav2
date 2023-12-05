<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Packing extends Auth_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('access');
        $this->load->model('msa_model', 'msa');
        $this->load->model('pesanan_model', 'pesanan');
        $this->load->model('barang_model', 'barang');
    }

    public function index()
    {
        $this->surat_pesanan();
    }

    public function surat_pesanan()
    {
        date_default_timezone_set('Asia/Jakarta');

        $tglHariIni = date('Y-m-d');
        $th = date('Y');
        $bln = date('m');
        $hr = date('d');
        $tanggal = $sp_bulan_ini = $tAwal = $tAkhir = $id_lembaga = $id_pelanggan = '';

        $title = 'DAFTAR SURAT PESANAN SIAP PACKING';
        if ($this->input->post('filter', TRUE)) {
            $tAwal = $this->input->post('awal', TRUE);
            $tAkhir = $this->input->post('akhir', TRUE);
            $id_lembaga = $this->input->post('lembaga', TRUE);
            $id_pelanggan = $this->input->post('pelanggan', TRUE);
            $tanggal = $this->tanggal->konversi($tAwal) . ' - ' . $this->tanggal->konversi($tAkhir);
            $title = 'SURAT PESANAN SIAP PACKING ' . $tanggal;
        } else {
            $tanggal = $hr . ' ' . $this->tanggal->bulan($bln) . ' ' . $th;
            $sp_bulan_ini = $bln;
            //$data_where = array('date(tanggal_sp)=' => $tglHariIni);
            //$title = 'DAFTAR SURAT PESANAN SIAP PACKING ' . strtoupper($this->tanggal->bulan($bln)) . ' ' . $th;
            $title = 'DAFTAR SURAT PESANAN SIAP PACKING ';
        }

        $data = array(
            'title'         => $title,
            'sp_bulan_ini'  => $sp_bulan_ini,
            'tAwal'    => $tAwal,
            'tAkhir'    => $tAkhir,
            'id_lembaga'    => $id_lembaga,
            'id_pelanggan'    => $id_pelanggan,
            'tanggal'       => $tanggal,
            'action_filter' => site_url('admin/packing/surat_pesanan'),
            'action_cetak' => site_url('admin/cetak/surat_pesanan'),
            'view' => 'admin/packing/daftar-surat-pesanan'
        );
        $this->load->view('admin/template', $data);
    }

	public function all_unpacking(){
        $sp_bulan_ini = $this->input->post('sp_bulanini');
        $tAwal = $this->input->post('tAwal');
        $tAkhir = $this->input->post('tAkhir');
        
        //$sp_bulan_ini = $_POST['sp_bulanini'];
        if (!empty($sp_bulan_ini)) {
            #tampilkan bulan aktif kalo tidak ada filter
            //$data_wheres = "AND month(sp1.tanggal_sp)=$sp_bulan_ini";
            $data_wheres = "";
        } else {
            $id_lembaga = $this->input->post('id_lembaga');
            $id_pelanggan = $this->input->post('id_pelanggan');
            if ((!empty($id_lembaga) && !empty($id_pelanggan))) {
                $data_wheres = "AND sp1.id_lembaga='".$id_lembaga."' 
                                AND sp1.id_pelanggan='".$id_pelanggan."' 
                                AND date(sp1.tanggal_sp)>='".$tAwal."' 
                                AND date(sp1.tanggal_sp)<='".$tAkhir."'";
            } else if (!empty($id_lembaga)) {
                $data_wheres = "AND sp1.id_lembaga='".$id_lembaga."' 
                                AND date(sp1.tanggal_sp)>='".$tAwal."' 
                                AND date(sp1.tanggal_sp)<='".$tAkhir."'";
            } else if (!empty($id_pelanggan)) {
                $data_wheres = "AND sp1.id_pelanggan='".$id_pelanggan."' 
                                AND date(sp1.tanggal_sp)>='".$tAwal."' 
                                AND date(sp1.tanggal_sp)<='".$tAkhir."'";
            } else {
                $data_wheres = "AND date(sp1.tanggal_sp)>='".$tAwal."' 
                                AND date(sp1.tanggal_sp)<='".$tAkhir."'";
            }
        }

		$s = "SELECT 
                sp1.*,
                SUM(sp2.jumlah_beli) AS total_qty_sp
                FROM pesanan_master AS sp1
                INNER JOIN pesanan_detail AS sp2
                ON sp1.id_pesanan_m=sp2.id_pesanan_m
                $data_wheres
                AND sp1.dihapus='tidak'
                GROUP by sp1.id_pesanan_m
                ORDER BY sp1.id_pesanan_m DESC";
		$q = $this->db->query($s);
		$no = 1;
		$result = array();
		$result['total'] = $q->num_rows();
		$row = array();	

		foreach($q->result() as $data) {	
            $tersedia = 'text-muted';
            $qPelanggan = $this->db->get_where('pelanggan', array('id' => $data->id_pelanggan))->result();
            $qLembaga = $this->db->get_where('lembaga', array('id' => $data->id_lembaga))->result();

            #CEK TOTAL QTY TERPACKING DAN SUDAH DI VALIDASI DO nya
            $qTerpacking = $this->db->query("SELECT
                                a.id_pesanan_m, 
                                SUM(a.qty_terpacking) AS total_qty_terpacking 
                                FROM packing_detail a, packing_do b
                                WHERE a.id_packing_m = b.id_packing_m 
                                AND a.id_pesanan_m='".$data->id_pesanan_m."';
                                ")->result();

            #total produk yang sudah di validasi DO                    
            $totalQtyDo = (isset($qTerpacking[0]->total_qty_terpacking) ? $qTerpacking[0]->total_qty_terpacking : 0); 

            #JIKA SEMUA QTY PRODUK DI SP TERLAYANI SEMUA (TELAH DI VALIDASI DO)
            #TIDAK AKAN DITAMPILKAN DI DAFTAR SP YANG AKAN DI PACKING
            $sisaQty = ($data->total_qty_sp - $totalQtyDo);

            if($sisaQty > 0){
                //informasi pada tombol packing jika stock barang tersedia

                $detail_barang = $this->db->get_where('pesanan_detail', array('id_pesanan_m' => $data->id_pesanan_m))->result();
                $barang_tersedia = '';
                $qty_sp = 0;

                foreach($detail_barang as $d){
                    //$data_barang .= ' '.$d->id_barang;
                    $qty_sp = $d->jumlah_beli;
                    $data_stok = $this->db->query("select total_stok from barang where id_barang='".$d->id_barang."' and total_stok > 0")->num_rows();


                    #ambil jumlah qty barang yang dipesan sudah terpacking
                    $Qdetail_terpacking = $this->pesanan->count_qty_terpacking( $data->id_pesanan_m, $d->id_barang)->row();
                    $qty_terpacking = (isset($Qdetail_terpacking->total_qty_terpacking) ? $Qdetail_terpacking->total_qty_terpacking : 0);
                    $qty_sebelum_packing = ($qty_sp - $qty_terpacking);


                    $stok_barang = $data_stok;
                    $qty = ($qty_sp - $qty_terpacking);

                    #kalo jumlah pesanan melebihi stok digudang
                    #maka sisanya akan jadi SO
                    if ($qty > $stok_barang) {
                        $qty_tersedia = $stok_barang;
                        $sisa = $qty - $qty_tersedia;
                    } else {
                        $qty_tersedia = $qty;
                    }

                  
                    if($qty_tersedia > 0){
                        //$barang_tersedia .= ' tersedia';
                        $tersedia = 'text-info';
                    }
                }

                $jumlah_do =$this->pesanan->count_do($data->id_pesanan_m);
                if($jumlah_do->total_do > 0){
                    $span_class = '';
                    $class_badge= 'themed-border-muted themed-background-muted';
                }
                else{
                    $span_class = '"badge themed-border-autumn themed-background-autumn" style="font-size: 1em; font-weight: bold;"';
                    $class_badge = 'themed-border-autumn themed-background-autumn';
                }

                $row[] = array(
                    'no'=> '<div class="text-center">'.$no.'</div>',
                    'nomor_sp'=>'<span class="'.$span_class.'">' . $data->nomor_sp . '</span>',
                    'jenis_sp'=>'<span class="'.$span_class.'">'  . strtoupper($data->jenis_sp) . '</span>',
                    'pelanggan'=>'<span class="'.$span_class.'">' . strtoupper(isset($qPelanggan[0]->nama_pelanggan) ? $qPelanggan[0]->nama_pelanggan : '-') . '</span>',
                    'lembaga'=>'<span class="'.$span_class.'">' . strtoupper(isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-') . '</span>',
                    'status'=>'<span class="'.$span_class.'">' . strtoupper(isset($qLembaga[0]->satus) ? $qLembaga[0]->satus : '-') . '</span>',
                    'jenjang'=>'<span class="'.$span_class.'">' . strtoupper(isset($qLembaga[0]->jenjang) ? $qLembaga[0]->jenjang : '-') . '</span>',
                    'nilai_sp'=>str_replace(',', '.', number_format($data->grand_total)),
                    'aksi'=>'<div class="text-center">
                                <div class="btn-group btn-group-sm ">
                                    <a href="#" data-toggle="tooltip" title="Jumlah Terpacking" 
                                        class="btn btn-alt btn-xs btn-default">
                                        <span class="badge '.$class_badge.'">'.$jumlah_do->total_do.'</span>
                                    </a>
                                    <a href="' . site_url('admin/packing/form_packing/' . $data->id_pesanan_m . '/barang') . '" data-toggle="tooltip" title="Form Packing Barang" 
                                        class="btn btn-alt btn-xs btn-default '.$tersedia.'">
                                        <i class="gi gi-package '.$tersedia.'"></i> Packing
                                    </a>
                                    <a href="javascript:void(0)" data-toggle="tooltip" title="Cetak Surat Pesanan" 
                                        class="btn btn-alt btn-xs btn-default cetak" onclick="form_cektak(' . "'" . $data->id_pesanan_m . "'" . ')">
                                        <i class="fa fa-file-pdf-o text-muted"></i>
                                    </a>

                                </div>
                            </div>' 
                );
                $no++;
            }
		}
		
		$result = array('aaData'=>$row);
		echo json_encode($result);
        //$this->cek(5);
		
	}

    public function cek($a){
        $response = array();
        $posts = array();
        $posts[] = array(
            "total"    => $a	
        );
        $response['posts'] = $posts; 
        echo json_encode($response,TRUE);

    }

    public function ajax_list_pesanan()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tglHariIni = date('Y-m-d');


        $sp_bulan_ini = $this->input->post('sp_bulanini');
        $tAwal = $this->input->post('tAwal');
        $tAkhir = $this->input->post('tAkhir');
        //$sp_bulan_ini = $_POST['sp_bulanini'];
        if (!empty($sp_bulan_ini)) {
            $data_wheres = array('month(tanggal_sp)' => $sp_bulan_ini);
        } else {
            $id_lembaga = $this->input->post('id_lembaga');
            $id_pelanggan = $this->input->post('id_pelanggan');
            if ((!empty($id_lembaga) && !empty($id_pelanggan))) {
                $data_wheres = array(
                    'id_lembaga' => $id_lembaga,
                    'id_pelanggan' => $id_pelanggan,
                    'date(tanggal_sp)>=' => $tAwal,
                    'date(tanggal_sp)<=' => $tAkhir
                );
            } else if (!empty($id_lembaga)) {
                $data_wheres = array(
                    'id_lembaga' => $id_lembaga,
                    'date(tanggal_sp)>=' => $tAwal,
                    'date(tanggal_sp)<=' => $tAkhir
                );
            } else if (!empty($id_pelanggan)) {
                $data_wheres = array(
                    'id_pelanggan' => $id_pelanggan,
                    'date(tanggal_sp)>=' => $tAwal,
                    'date(tanggal_sp)<=' => $tAkhir
                );
            } else {
                $data_wheres = array(
                    'date(tanggal_sp)>=' => $tAwal,
                    'date(tanggal_sp)<=' => $tAkhir
                );
            }
        }

        $list = $this->pesanan->get_datatables($data_wheres);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pesanan) {
            $qLembaga = $this->db->get_where('lembaga', array('id' => $pesanan->id_lembaga))->result();
            $qPelanggan = $this->db->get_where('pelanggan', array('id' => $pesanan->id_pelanggan))->result();

            $no++;
            $row = array();
            $row[] = '<div class="text-center">' . $no . '</div>';
            $row[] = '<span>' . $pesanan->nomor_sp . '</span>';
            $row[] = '<span>' . strtoupper($pesanan->jenis_sp) . '</span>';
            $row[] = '<span>' . strtoupper(isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-') . '</span>';
            $row[] = '<span>' . 'Rp. ' . str_replace(',', '.', number_format($pesanan->grand_total)) . '</span>';
            $row[] = '<div class="text-center">
                        <div class="btn-group btn-group-sm">
                            <a href="' . site_url('admin/order/delivery/' . $pesanan->id_pesanan_m . '/list') . '" data-toggle="tooltip" title="Delivery Order" 
                                class="btn btn-alt btn-default btn-xs">
                                <i class="fa fa-truck text-success"></i>
                            </a>
                            <a href="javascript:void(0)" data-toggle="tooltip" title="Cetak Surat Pesanan" 
                                class="btn btn-alt btn-default cetak" onclick="form_cektak(' . "'" . $pesanan->id_pesanan_m . "'" . ')">
                                <i class="fa fa-file-pdf-o text-warning"></i>
                            </a>
                            <a href="' . site_url('admin/packing/form_packing/' . $pesanan->id_pesanan_m . '/barang') . '" data-toggle="tooltip" title="Packing Order" 
                                class="btn btn-alt btn-xs btn-default">
                                <i class="gi gi-package text-info"></i>
                            </a>
                        </div>
                    </div>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pesanan->count_all($data_wheres),
            "recordsFiltered" => $this->pesanan->count_filtered($data_wheres),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function form_packing($id_pesanan_m)
    {
        if (empty($id_pesanan_m)) {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Surat Pesanan Tidak Dapat Ditemukan'));
            redirect('admin/packing');
        } else {
            $title = 'FORM KELUAR BARANG';
            $jumlah_do = $this->pesanan->count_do($id_pesanan_m);

            $data = array(
                'title'         => $title,
                'jumlah_do'         => $jumlah_do->total_do,
                'id_pesanan'         => $id_pesanan_m,
                'action_packing' => site_url('admin/packing/simpan'),
                'action_cetak' => site_url('admin/cetak/surat_pesanan'),
                'action_validasi' => site_url('admin/order/validasi'),
                'view' => 'admin/packing/form-packing-barang'
            );
            $this->load->view('admin/template', $data);
        }
    }

    function simpan()
    {
        if ($this->input->server('HTTP_REFERER')) {
            $idpengguna            = $this->session->userdata('idPengguna');

            $id_pesanan_m = $this->input->post('id_sp');
            $nomor_sp = $this->input->post('nomor_sp');
            $tanggal_packing = $this->input->post('tanggal_packing');

            if (empty($tanggal_packing)) {
                $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Tidak ada data yang ditambahkan!'));
                redirect('admin/packing/form_packing/' . $id_pesanan_m . '/barang');
            } else {

                #nomor urut do
                $t = explode("-", $tanggal_packing);
                $format = ($t[0] . $t[1] . $t[2]); //tahun-bulan-tanggal

                $qNumber = $this->db->query("SELECT
                            last_number_packing AS maxs
                            FROM counter_number WHERE id='1' limit 0, 1")->row();
                $last_no    = $qNumber->maxs;
                $no_urut    = (($last_no == 0) ? 1 : $last_no += 1);
                $nomor_packing     = 'PK' . $format . sprintf("%05s", $no_urut);
    
                #data master packing
                $data_mPacking = array(
                    'id_pesanan_m'  => $id_pesanan_m,
                    'nomor_sp'      => $nomor_sp,
                    'nomor_packing' => $nomor_packing,
                    'tanggal_packing' => $tanggal_packing,
                    'id_user'   => $idpengguna,
                );
                $this->db->insert('packing_master', $data_mPacking);

                #return last id packing_master
                $lastid_packing_m = $this->db->insert_id();

                if ($this->db->affected_rows() > 0) {
                    $sisa_belum_terpacking = $this->input->post('sisa_val');
                    $qty_tersedia = $this->input->post('tersedia');

                    $i = 1;
                    foreach ($this->input->post('id_barang') as $idx => $val) :
                        $index = $idx;
                        $id_barang   = $val;
                        $qty_unpacking = (isset($sisa_belum_terpacking[$index]) ? $sisa_belum_terpacking[$index] : '0');
                        $qty_terpacking = (isset($qty_tersedia[$index]) ? $qty_tersedia[$index] : '0');
                        //$qty_terpacking = $this->input->post('tersedia' . $i);

                        $data_detail_packing = array(
                            'id_packing_m'  => $lastid_packing_m,
                            'id_pesanan_m' => $id_pesanan_m,
                            'id_barang' => $id_barang,
                            'qty_terpacking' => $qty_terpacking,
                            'qty_so' => $qty_unpacking
                        );
                        #insert ke detail packing barang
                        $detail = $this->db->insert('packing_detail', $data_detail_packing);
                        #UBAH STOK DI TABLE BARANG
                        if ($detail) {
                            $this->barang->update_stok($id_barang, $qty_terpacking);

                            #update NOMOR URUT 
                            $newNumber = array('last_number_packing' => $no_urut);
                            $this->db->where('id', 1);
                            $this->db->update('counter_number', $newNumber);

                        }

                        $i++;
                    endforeach;
                    $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Berhasil menambahkan data packing barang'));
                } else {

                    $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Packing barang tidak berhasil dilakukan'));
                }
            }
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Opps. terjadi duplikasi data, silahkan cek daftar packing!'));
        }
        redirect('admin/packing/form_packing/' . $id_pesanan_m . '/barang');
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

/* End of file admin/Packing.php */
