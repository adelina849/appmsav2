<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Surat_jalan extends Auth_Controller
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
        $tanggal = $surat_bulan_ini = $tAwal = $tAkhir = $dateRange ='';

        $title = 'DAFTAR SURAT JALAN';
        if ($this->input->post('filter', TRUE)) {
            $tAwal = $this->input->post('awal', TRUE);
            $tAkhir = $this->input->post('akhir', TRUE);
            $tanggal = $this->tanggal->konversi($tAwal) . ' - ' . $this->tanggal->konversi($tAkhir);
            $title = 'DAFTAR SURAT JALAN ' . $tanggal;
        } else {
            $tanggal = $hr . ' ' . $this->tanggal->bulan($bln) . ' ' . $th;
            $surat_bulan_ini = $bln;
            $title = 'DAFTAR SURAT JALAN ';
        }

		$qFaktur = "SELECT COUNT(b.id) AS total_faktur
					FROM  surat_jalan_master b, surat_jalan_detail a
					WHERE b.id=a.surat_jalan_id 
					AND b.dihapus='tidak'";
		$allFaktur = $this->db->query($qFaktur)->row();		

        $data = array(
            'title'         => $title,
            'surat_bulan_ini'  => $surat_bulan_ini,
            'tAwal'    => $tAwal,
            'tAkhir'    => $tAkhir,
            'tanggal'       => $tanggal,
            'allFaktur'       => $allFaktur->total_faktur,
            'action_filter' => site_url('admin/surat_jalan/daftar'),
            'action_cetak' => site_url('admin/cetak/surat_jalan'),
            'view' => 'admin/surat_jalan/daftar-surat-jalan'
        );
        $this->load->view('admin/template', $data);
    }

	public function all_surat_jalan(){
        $surat_bulan_ini = $this->input->post('surat_bulan_ini');
        $tAwal = $this->input->post('tAwal');
        $tAkhir = $this->input->post('tAkhir');

        if (!empty($surat_bulan_ini)) {
            #tampilkan bulan aktif kalo tidak ada filter
            $data_wheres = "";
        } else {            
            $data_wheres = "AND date(a.tanggal)>='".$tAwal."' 
                        AND date(a.tanggal)<='".$tAkhir."'";
        }

		$s = "SELECT *
                FROM surat_jalan_master AS a
                WHERE dihapus='tidak'
                $data_wheres
                ORDER BY a.id DESC";

		$q = $this->db->query($s);
		$no = 1;
		$result = array();
		$result['total'] = $q->num_rows();
		$row = array();
        
		foreach($q->result() as $data) {	
            // $qPelanggan = $this->db->get_where('pelanggan', array('id' => $data->id_pelanggan))->result();
            // $qLembaga = $this->db->get_where('lembaga', array('id' => $data->id_lembaga))->result();
				#status DO: 0 = BELUM KEMBALI
				# 1 = KEMBALI
				# 2 = GAGAL KIRIM

			$coutn_do = $this->db
				->from('surat_jalan_detail')
				->where('surat_jalan_id', $data->id)
				->count_all_results();

			$coutn_kembali = $this->db
					->from('surat_jalan_detail')
					->where('surat_jalan_id', $data->id)
					->where('status_kirim', 1)
					->count_all_results();

			$coutn_belum_kembali = $this->db
					->from('surat_jalan_detail')
					->where('surat_jalan_id', $data->id)
					->where('status_kirim', 0)
					->count_all_results();

			$coutn_gagal = $this->db
					->from('surat_jalan_detail')
					->where('surat_jalan_id', $data->id)
					->where('status_kirim', 2)
					->count_all_results();


            $row[] = array(
                'no'=> '<div class="text-center">'.$no.'</div>',
                'nomor'=>'<span>' . $data->nomor . '</span>',
                'tanggal'=>'<span>' .$this->tanggal->konversi($data->tanggal). '</span>',
                'exspedisi'=>'<span>' . strtoupper($data->exspedisi). '</span>',
                'jumlah'=>'<div class="text-center">' . $coutn_do . '</div>',
                'kembali'=>'<div class="text-center"><span class="badge themed-background-spring">' . $coutn_kembali . '</span></div>',
                'belum_kembali'=>'<div class="text-center"><span class="badge themed-background-autumn">' . $coutn_belum_kembali . '</span></div>',
                'gagal'=>'<div class="text-center"><span class="badge themed-background-night">' . $coutn_gagal . '</span></div>',
                'aksi'=>'<div class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="' . site_url('admin/surat_jalan/detail/' . $data->id. '/list') . '" data-toggle="tooltip" title="Detail Surat Jalan" 
                                    class="btn btn-alt btn-default btn-xs text-primary">
                                    <i class="fa fa-eye text-primary"></i>
                                </a>

								<button onclick="print('.$data->id.')" 
									class="btn btn-alt btn-default btn-xs text-info" data-toggle="tooltip" title="Cetak Surat Jalan">
									<i class="fa fa-print text-info"></i>
								</button>
							</div>                      
                    </div>' 
            );
			$no++;
		}
		
		$result = array('aaData'=>$row);
		echo json_encode($result);		
	}

    public function form(){
        $title = 'Input Surat Jalan';
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('transaksi_model');
		//$this->load->model('barang_model');

		$level 		= $this->session->userdata('level');
		$idpengguna	= $this->session->userdata('idPengguna');

		$data['level']		= $level;
		$data['idpengguna']	= $idpengguna;
		$table 				= $this->keamanan->table_pengguna($level);

		$qNumber = $this->db->query("SELECT
			last_number_sj AS maxs
			FROM counter_number WHERE id='1' limit 0, 1")->row();
		$last_no    = $qNumber->maxs;
		$no_urut    = (($last_no == 0) ? 1 : $last_no += 1);


		if ($level == 'admin') {
			if ($_POST)
			{
				if (!empty($_POST['nomor_do'])) {
					$total = 0;
					foreach ($_POST['nomor_do'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$no = 0;
						foreach ($_POST['nomor_do'] as $d) {
							if (!empty($d)) {
								$this->form_validation->set_rules('nomor_do[' . $no . ']', 'Nomor DO #' . ($no + 1), 'trim|required|max_length[40]|callback_cek_nomor_do[nomor_do[' . $no . ']]');
							}
							$no++;
						}

						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_nomor_do', '%s tidak ditemukan');
						//$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$id_kasir		= $idpengguna;
							$catatan		= $this->input->post('catatan');
							$tanggal_sj     = $this->input->post('tanggal');
							$no_urut_old = $this->input->post('no_urut');

							$t = explode("-", $tanggal_sj);
							$format = ($t[0] . $t[1] . $t[2]); //tahun-bulan-tanggal
					
							$nomor_sj_old     = 'SJ' . $format . sprintf("%05s", $no_urut_old);
							#cek kalo nomor SP sudah ada jangan rubah nomor urut
							$cek_nomor_sj = $this->transaksi_model->get_nomor_sj($nomor_sj_old);

							if ($cek_nomor_sj->num_rows() > 0) {
								$idmaster_old = $cek_nomor_sj->row();
								echo json_encode(array(
									'status' => 0,
									"pesan" => "<font color='red'><i class='fa fa-warning'></i> Surat Jalan untuk nomor " . $nomor_sj_old . " Sudah dicatat, Untuk transaksi baru Silahkan Klik Input Surat Jalan</font>"
								));
							} else {

                                #update NOMOR URUT 
                                $newNumber = array('last_number_sj' => $no_urut);
                                $this->db->where('id', 1);
                                $this->db->update('counter_number', $newNumber);
								$nomor_sj_new     = 'SJ' . $format . sprintf("%05s", $no_urut);
	
                                #BARU SAMPAI SINI..
								$exspedisi = $this->input->post('exspedisi');

								$data_master = array(
									'tanggal'	=> $tanggal_sj,
									'nomor'    	=> $nomor_sj_new,
									'exspedisi'	=> $exspedisi,
									'catatan'   => $catatan,
									'status'	=> 0
								);

								$master = $this->db->insert('surat_jalan_master', $data_master);

								if ($master) {
									//$id_master 	= $this->transaksi_model->get_id($nomor_nota)->row()->id_penjualan_m;
									#return last id inserted
									$lastid_master = $this->db->insert_id();
									$inserted	= $no_array	= 0;
									
									foreach ($_POST['nomor_do'] as $k) {
										if (!empty($k)) {
											
											$nomor_do    = $_POST['nomor_do'][$no_array];
											$id_lembaga    = $_POST['id_lembaga'][$no_array];

											$data_detail = array(
												'surat_jalan_id'  => $lastid_master,
												'nomor_do'     => $nomor_do,
												'id_lembaga'   => $id_lembaga,
												'status_kirim'  => 0
											);

											$insert_detail	= $this->db->insert('surat_jalan_detail', $data_detail);

											if ($insert_detail) {
												//$this->transaksi_model->update_stok($id_barang, $jumlah_beli);
												$inserted++;
											}
										}
										$no_array++;
									}
									if ($inserted > 0) {
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									} else {
										echo json_encode(array(
											'status' => 0,
											"pesan" => "<font color='red'><i class='fa fa-warning'></i>Transaksi gagal disimpan</font>
										"
										));
									}
								} else {
									echo json_encode(array(
										'status' => 0,
										"pesan" => "<font color='red'><i class='fa fa-warning'></i>Transaksi gagal disimpan</font>
									"
									));
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						echo json_encode(array(
							'status' => 0,
							"pesan" => "<font color='red'><i class='fa fa-warning'></i> Masukan minimal 1 Nomor DO</font>
						"
						));
					}
				} else {
					echo json_encode(array(
						'status' => 0,
						"pesan" => "<font color='red'><i class='fa fa-warning'></i> Masukan minimal 1 Nomor DO</font>
					"
					));
				}
			} else {
				$data = array(
					'title'         => $title,
					'no_urut'         => $no_urut,
					'view' => 'admin/surat_jalan/input-surat-jalan'
				);
		
				$this->load->view('admin/template', $data);
			}//END ELSE
		}//END POST		
    }//END LEVEL ADMIN

	public function ajax_detail_do()
	{
        $this->load->model('delivery_order_model');
		$id_do 	= $this->input->post('id_do');

        $s = "SELECT *
                FROM packing_do
                WHERE dihapus='tidak'
                AND id='".$id_do."'";

        $q = $this->db->query($s);
		
        if ($q->num_rows() > 0) {
            $nama_lembaga = $id_lembaga = '';
			$do = $q->row();
            $packing_master = $this->db->select('id_pesanan_m')->get_where('packing_master', array('id_packing_m' => $do->id_packing_m))->result();
            if(isset($packing_master[0]->id_pesanan_m)){
                $id_pesanan_m =$packing_master[0]->id_pesanan_m;
                $pesanan_master = $this->db->select('id_lembaga')->get_where('pesanan_master', array('id_pesanan_m' => $id_pesanan_m))->result();
                
                $id_lembaga = $pesanan_master[0]->id_lembaga;
                $qLembaga = $this->db->get_where('lembaga', array('id' => $id_lembaga))->result();
                $nama_lembaga = strtoupper(isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-');
            }
			echo json_encode(array(
				'status' => 1, 
                'nomor_do' => $do->nomor_do,
				'tanggal' => $do->tanggal,
				'jumlah_qoli' => $do->jumlah_qoli,
				'jumlah_ikat' => $do->jumlah_ikat,
				'kepala_gudang' => $do->kepala_gudang,
				'pengirim' => $do->pengirim,
                'nama_lembaga'=>$nama_lembaga,
                'id_lembaga'=>$id_lembaga
			));
		} else {
			echo json_encode(array(
				'status' => 0,
				"pesan" => "<font color='red'><i class='fa fa-warning'></i> Nomor DO tidak ditemukan.</font>
			"
			));
		}
		//echo '<input type="text" name="h[]" class="id" value="'.$id_barang.' '.$qty.'">';			
	}

	public function detail($id_surat_jalan){
		if ($_POST) {
			if (!empty($_POST['id_do'])) {
				$id_do		= $this->input->post('id_do');

				$s = "SELECT *
					FROM packing_do
					WHERE dihapus='tidak'
					AND id='".$id_do."'";

				$q = $this->db->query($s);				
				if ($q->num_rows() > 0) {
					$nama_lembaga = $id_lembaga = '';
					$inserted = 0;
					$do = $q->row();
					$nomor_do = $do->nomor_do;

					$packing_master = $this->db->select('id_pesanan_m')->get_where('packing_master', array('id_packing_m' => $do->id_packing_m))->result();
					if(isset($packing_master[0]->id_pesanan_m)){
						$id_pesanan_m =$packing_master[0]->id_pesanan_m;
						$pesanan_master = $this->db->select('id_lembaga')->get_where('pesanan_master', array('id_pesanan_m' => $id_pesanan_m))->result();

						$id_lembaga = $pesanan_master[0]->id_lembaga;
						// $qLembaga = $this->db->get_where('lembaga', array('id' => $id_lembaga))->result();
						// $nama_lembaga = strtoupper(isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-');
					}

					$data_detail = array(
						'surat_jalan_id'  => $id_surat_jalan,
						'nomor_do'     => $nomor_do,
						'id_lembaga'   => $id_lembaga,
						'status_kirim'  => 0
					);

					$insert_detail	= $this->db->insert('surat_jalan_detail', $data_detail);

					if ($insert_detail) {
						//$this->transaksi_model->update_stok($id_barang, $jumlah_beli);
						$inserted++;
					}
					if ($inserted > 0) {
						echo json_encode(array('status' => 1, 'pesan' => "DO baru berhasil ditambahkan !"));
					} else {
						echo json_encode(array(
							'status' => 0,
							"pesan" => "<font color='red'><i class='fa fa-warning'></i> DO baru gagal ditambahkan</font>
						"
						));
					}
				}
			}else{
				echo json_encode(array(
					'status' => 0,
					"pesan" => "<font color='red'><i class='fa fa-warning'></i> Nomor DO tidak ditemukan.</font>
				"
				));	
			}
		}else{
			//$qSuratJalan = $this->db->select('id_pesanan_m')->get_where('packing_master', array('id_packing_m' => $do->id_packing_m))->result();
			$qSuratJalan = $this->db->get_where('surat_jalan_master', array('id' => $id_surat_jalan))->result();
			$data = array(
				'title'         => 'Detail Surat Jalan',
				'id_surat_jalan'=> $id_surat_jalan,
				'surat_jalan'	=> $qSuratJalan,
				'action_delete' => site_url('admin/surat_jalan/hapus'),
				'view' => 'admin/surat_jalan/detail-surat-jalan'
			);
			$this->load->view('admin/template', $data);

		}
	}

	public function penerimaan(){
        $title = 'PENERIMAAN DO';
        $data = array(
            'title'         => $title,
			'action_status' => site_url('admin/surat_jalan/status'),
            'view' => 'admin/surat_jalan/form-penerimaan-do'
        );
        $this->load->view('admin/template', $data);
	}

	public function terkirim(){
        $title = 'LAPORAN DO TERKIRIM';
        $data = array(
            'title'         => $title,
            'view' => 'admin/surat_jalan/do-terkirim-list'
        );
        $this->load->view('admin/template', $data);
	}


	public function cari_kode_do()
	{
		$autocomplite = '';
		if ($this->input->is_ajax_request()) {
			$keyword 	= $this->input->post('keyword');
			$registered 	= $this->input->post('registered');
			// $registered	= $this->input->post('registered');
			$registered = 'xxx';

			$this->load->model('delivery_order_model');
			$do = $this->delivery_order_model->get_do($keyword, $registered);

			$autocomplite = "<ul id='daftar-autocomplete'>";
			if ($do->num_rows() > 0) {
				foreach ($do->result() as $b) {
					$nomor_do = $b->nomor_do;
					$autocomplite .=
						"<li>" .
                            "<span id='nomor_donya'>" . $b->nomor_do . '</span>' . ' '
                            // "<span id='id_packing_donya' style='display:none;'>" . $b->id . '</span>'. 
                            // "<span id='id_packing_m' style='display:none;'>" . $b->id_packing_m . '</span>'. 
                            // "<span id='jumlah_qoli' style='display:none;'>" . $b->jumlah_qoli . '</span>'. 
                            // "<span id='jumlah_ikat' style='display:none;'>" . $b->jumlah_ikat . '</span>'. 
                            // "<span id='kepala_gudang' style='display:none;'>" . $b->kepala_gudang . '</span>'. 
                            // "<span id='pengirim' style='display:none;'>" . $b->pengirim . '</span>'                             
						. "</li>";
				}
			} else {
				$autocomplite .= '<li>Tidak ada yang cocok.</li>';
			}
			$autocomplite .= "</ul>";
		}
		echo $autocomplite;
		//echo json_encode($json);
	}

    public function cek_nomor_do($kode)
	{
		$cek_kode = $this->db
                        ->select('id')
                        ->where('nomor_do', $kode)
                        ->where('dihapus', 'tidak')
                        ->limit(1)
                        ->get('packing_do');
		if ($cek_kode->num_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}

	public function print_surat_jalan($id_surat_jalan){
		$qSuratJalan = $this->db->get_where('surat_jalan_master', array('id' => $id_surat_jalan))->result();

        $data = array(
            'id_surat_jalan' => $id_surat_jalan,
            'surat_jalan'	=> $qSuratJalan,
            'title'         => 'SURAT JALAN'
        );

        $this->load->view('admin/print/print-surat-jalan', $data);
    }    

	function status()
	{
		$id = $this->keamanan->post($this->input->post('id_detail'));
		$id_status = $this->keamanan->post($this->input->post('id_status'));
		$date_status = date('Y-m-d');
		$data = array(
			'status_kirim' => $id_status,
			'date_status' => $date_status
		);
		$this->msa->update('surat_jalan_detail', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Status Pengiriman Berhasil Diperbaharui'));
		}
		redirect(site_url('admin/surat_jalan/penerimaan/'.'change-status-successfully'));
	} // end hapus

	function hapus()
	{
		$id = $this->keamanan->post($this->input->post('id_detail'));
		$id_surat_jalan = $this->keamanan->post($this->input->post('id_suratjln'));

		$this->msa->delete('surat_jalan_detail', 'id', $id);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Nomor DO berhasil dihapus'));
		}
		redirect(site_url('admin/surat_jalan/detail/'.$id_surat_jalan.'/deleted-success'));
	} // end hapus


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

/* End of file admin/Surat_jalan.php */
