<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penerimaan extends Auth_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('access');
        $this->load->model('msa_model', 'msa');
        $this->load->model('pesanan_model', 'pesanan');
        $this->load->model('barang_model');
		$this->load->model('standing_order_model', 'so');

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

        $title = 'DAFTAR PENERIMAAN BARANG';
        if ($this->input->post('filter', TRUE)) {
            $tAwal = $this->input->post('awal', TRUE);
            $tAkhir = $this->input->post('akhir', TRUE);
            $tanggal = $this->tanggal->konversi($tAwal) . ' - ' . $this->tanggal->konversi($tAkhir);
            $title = 'DAFTAR PENERIMAAN BARANG ' . $tanggal;
        } else {
            $tanggal = $hr . ' ' . $this->tanggal->bulan($bln) . ' ' . $th;
            $surat_bulan_ini = $bln;
            $title = 'DAFTAR PENERIMAAN BARANG ';
        }

        $data = array(
            'title'         => $title,
            'surat_bulan_ini'  => $surat_bulan_ini,
            'tAwal'    => $tAwal,
            'tAkhir'    => $tAkhir,
            'tanggal'       => $tanggal,
            'action_filter' => site_url('admin/penerimaan/daftar'),
            'view' => 'admin/penerimaan/daftar-penerimaan-barang'
        );
        $this->load->view('admin/template', $data);
    }

	public function all_penerimaan(){
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
                FROM penerimaan_master AS a
                WHERE dihapus='tidak'
                $data_wheres
                ORDER BY a.tanggal DESC";

		$q = $this->db->query($s);
		$no = 1;
		$result = array();
		$result['total'] = $q->num_rows();
		$row = array();
        
		foreach($q->result() as $data) {	
			$jatuh_tempo='';
			$pembelian = $this->db->get_where('pembelian_master', array('id_pembelian_m' => $data->id_pembelian_m))->result();
			$id_supplier = (isset($pembelian[0]->id_supplier) ? $pembelian[0]->id_supplier : '0');

			$supplier = $this->db->get_where('vendor', array('id' => $id_supplier))->result();
			//$marketing = $this->db->get_where('marketing_supplier', array('id' => $data->id_marketing))->result();

			if(isset($pembelian[0]->nomor_spb)){
				if($pembelian[0]->jatuh_tempo!='0000-00-00'){
					$jatuh_tempo = (isset($pembelian[0]->jatuh_tempo) ? $pembelian[0]->jatuh_tempo : '-');
				}else{
					$jatuh_tempo='-';
				}
			}

            $row[] = array(
                'no'=> '<div class="text-center">'.$no.'</div>',
                'nomor'=>'<span>' . $data->nomor_penerimaan . '</span>',
                'nomor_pembelian'=>'<span>' . (isset($pembelian[0]->nomor_spb) ? $pembelian[0]->nomor_spb : '-'). '</span>',
                'supplier'=>'<span>' . strtoupper(isset($supplier[0]->nama_vendor) ? $supplier[0]->nama_vendor : '-'). '</span>',
                'sistem_pembayaran'=>'<span>' . strtoupper(isset($pembelian[0]->sistem_pembayaran) ? $pembelian[0]->sistem_pembayaran : '-'). '</span>',
                'jatuh_tempo'=>'<span>' . $jatuh_tempo. '</span>',
                'total'=>'<div class="text-right"><span>' . str_replace(',', '.', number_format($data->netto_bayar)). '</span></div>',
                'aksi'=>'<div class="text-center">
                            <div class="btn-group-vertical btn-group-sm">
                                <a href="' . site_url('admin/penerimaan/detail_penerimaan/' . $data->id_penerimaan_m. '/barang') . '" data-toggle="tooltip" title="detail barang yang diterima" 
                                    class="btn btn-alt btn-default btn-xs themed-color-blackberry themed-border-blackberry">
									<i class="fa fa-eye"></i> Detail
                                </a>
								<button onclick="print('.$data->id_penerimaan_m.')" 
									class="btn btn-alt btn-default btn-xs btn-xs themed-color-blackberry themed-border-blackberry" data-toggle="tooltip" title="Cetak Surat Pembelian">
									<i class="fa fa-print"></i> Print
								</button>								
							</div>                      
                    </div>' 
            );
			$no++;
		}
		
		$result = array('aaData'=>$row);
		echo json_encode($result);
		
	}

    function pembelian(){
        date_default_timezone_set('Asia/Jakarta');

        $tglHariIni = date('Y-m-d');
        $th = date('Y');
        $bln = date('m');
        $hr = date('d');
        $tanggal = $surat_bulan_ini = $tAwal = $tAkhir = $dateRange ='';

        $title = 'DAFTAR SURAT PEMBELIAN';
        if ($this->input->post('filter', TRUE)) {
            $tAwal = $this->input->post('awal', TRUE);
            $tAkhir = $this->input->post('akhir', TRUE);
            $tanggal = $this->tanggal->konversi($tAwal) . ' - ' . $this->tanggal->konversi($tAkhir);
            $title = 'DAFTAR SURAT PEMBELIAN ' . $tanggal;
        } else {
            $tanggal = $hr . ' ' . $this->tanggal->bulan($bln) . ' ' . $th;
            $surat_bulan_ini = $bln;
            $title = 'DAFTAR SURAT PEMBELIAN ';
        }

        $data = array(
            'title'         => $title,
            'surat_bulan_ini'  => $surat_bulan_ini,
            'tAwal'    => $tAwal,
            'tAkhir'    => $tAkhir,
            'tanggal'       => $tanggal,
            'action_filter' => site_url('admin/penerimaan/pembelian'),
            'view' => 'admin/penerimaan/daftar-surat-pembelian'
        );
        $this->load->view('admin/template', $data);
    }

	public function all_surat_pembelian(){
        $surat_bulan_ini = $this->input->post('surat_bulan_ini');
        $tAwal = $this->input->post('tAwal');
        $tAkhir = $this->input->post('tAkhir');

        if (!empty($surat_bulan_ini)) {
            #tampilkan bulan aktif kalo tidak ada filter
            $data_wheres = "";
        } else {            
            $data_wheres = "AND date(a.tanggal_spb)>='".$tAwal."' 
                        AND date(a.tanggal_spb)<='".$tAkhir."'";
        }

		#tampilkan data pembelian yang belum diterima
		$s = "SELECT *
                FROM pembelian_master AS a
                WHERE dihapus='tidak'
				AND a.id_pembelian_m NOT IN (SELECT id_pembelian_m FROM penerimaan_master where id_pembelian_m IS NOT NULL)
                $data_wheres
                ORDER BY a.tanggal_spb DESC";

		$q = $this->db->query($s);
		$no = 1;
		$result = array();
		$result['total'] = $q->num_rows();
		$row = array();
        
		foreach($q->result() as $data) {	
			$supplier = $this->db->get_where('vendor', array('id' => $data->id_supplier))->result();
			$marketing = $this->db->get_where('marketing_supplier', array('id' => $data->id_marketing))->result();
			$jenis_pembelian='';

			if($data->jenis_spb=='so'){
				$jenis_pembelian = 'SO';
			}else{
				$jenis_pembelian='STOK';
			}

            $row[] = array(
                'no'=> '<div class="text-center">'.$no.'</div>',
                'nomor'=>'<span>' . $data->nomor_spb . '</span>',
                'marketing'=>'<span>' . (isset($marketing[0]->nama_lengkap) ? $marketing[0]->nama_lengkap : '-'). '</span>',
                'supplier'=>'<span>' . strtoupper(isset($supplier[0]->nama_vendor) ? $supplier[0]->nama_vendor : '-'). '</span>',
                'pembelian'=>'<span>' . $jenis_pembelian. '</span>',
                'pembayaran'=>'<div class="text-center">' .ucwords($data->sistem_pembayaran). '</div>',
                'aksi'=>'<div class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="' . site_url('admin/penerimaan/form_penerimaan/' . $data->id_pembelian_m. '/list-pembelian') . '" data-toggle="tooltip" title="Input pada form penerimaan barang" 
                                    class="btn btn-alt btn-info btn-xs themed-color-blackberry themed-border-blackberry">
									<i class="gi gi-inbox_in"></i> Penerimaan Barang
                                </a>
							</div>                      
                    </div>' 
            );
			$no++;
		}
		
		$result = array('aaData'=>$row);
		echo json_encode($result);
		
	}

	public function form_penerimaan($id_pembelian_m){

		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('transaksi_model');
		//$this->load->model('barang_model');

		#surat pembelian detail
		$spb = $this->db->get_where('pembelian_master', array('id_pembelian_m' => $id_pembelian_m))->result();

		$level                 = $this->session->userdata('level');
		$idpengguna            = $this->session->userdata('idPengguna');
		$data['level']        = $level;
		$data['idpengguna']    = $idpengguna;
		$table                 = $this->keamanan->table_pengguna($level);

		$qNumber = $this->db->query("SELECT
			last_number_penerimaan AS maxs
			FROM counter_number WHERE id='1' limit 0, 1")->row();

		$last_no    = $qNumber->maxs;
		$no_urut    = (($last_no == 0) ? 1 : $last_no += 1);
		$nomor_nota     = $no_urut;

		if ($level == 'admin') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}
					if ($total > 0) {
						$no = 0;

						// foreach ($_POST['kode_barang'] as $d) {
						// 	if (!empty($d)) {
						// 		$this->form_validation->set_rules('kode_barang[' . $no . ']', 'Kode Barang #' . ($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang[' . $no . ']]');
						// 		$this->form_validation->set_rules('jumlah_beli_spb[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli_spb[' . $no . ']]');
						// 		$this->form_validation->set_rules('harga_satuan[' . $no . ']', 'Harga Pembelian #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[harga_satuan[' . $no . ']]');
						// 	}
						// 	$no++;
						// }

						$this->form_validation->set_rules('invoice', 'Nomor Invoice', 'required');
						$this->form_validation->set_message('required', '%s harus diisi');

						$this->form_validation->set_rules('pengirim', 'Nama pengirim', 'required');
						$this->form_validation->set_message('required', '%s harus diisi');

						if ($this->form_validation->run() == TRUE) {

							//format nomor SP tahun bulan tanggal nomor urut

							$no_urut_old     = $this->input->post('no_urut');
							$id_kasir        = $idpengguna;
							$nomor_spb		= $this->input->post('nomor_spb');
							$TotalBayar    	= $this->input->post('TotalBayarHidden');
							$ppn    		= $this->input->post('ppn');
							$Netto    		= $this->input->post('NettoHidden');
							$DiskonPembelian	= $this->input->post('DiskonPembelianHidden');
							$NettoBayar			= $this->input->post('NettoBayarHidden');
							$UangMuka    		= $this->input->post('UangCash');
							$SisaBayar			= $this->input->post('SisaBayarHidden');

							$invoice            = $this->input->post('invoice');
							$pengirim            = $this->input->post('pengirim');

							#kalo sisa bayar terisi artinya ada barang yang diinput

							if($SisaBayar > 0){

								$tanggal    = date('Y-m-d');
								$t 			= explode("-", $tanggal);
								$format 	= ($t[0] . $t[1] . $t[2]); //tahun-bulan-tanggal
	
								$nomor_old	= 'PNR' . $format . sprintf("%05s", $no_urut_old);
								$cek_nomor 	= $this->transaksi_model->get_nomor_penerimaan($nomor_old);
	
								#cek kalo nomor penerimaan sudah ada jangan rubah nomor urut
								if ($cek_nomor->num_rows() > 0) {
									$idmaster_old = $cek_nomor->row();
									echo json_encode(array(
										'status' => 0,
										"pesan" => "<font color='red'><i class='fa fa-warning'></i> Penerimaan barang untuk nomor " . $nomor_old . " Sudah dicatat, Untuk transaksi baru Silahkan Klik menu Penerimaan</font>"
									));
								} else {
	
									#update NOMOR URUT 
									$newNumber = array('last_number_penerimaan' => $no_urut);
									$this->db->where('id', 1);
									$this->db->update('counter_number', $newNumber);
									$nomor_new     = 'PNR' . $format . sprintf("%05s", $no_urut);
	
									$data_master = array(
										'id_pembelian_m'      => $id_pembelian_m,
										'nomor_penerimaan'      => $nomor_new,
										'tanggal'    => $tanggal,
										'grand_total'    => $TotalBayar,
										'ppn' => $ppn,
										'netto' => $Netto,
										'diskon' => $DiskonPembelian,
										'netto_bayar' => $NettoBayar,
										'uang_muka' => $UangMuka,
										'sisa_bayar' => $SisaBayar,
										'nomor_invoice' => $invoice,
										'pengirim' => $pengirim,
										'id_user' => $id_kasir
									);
									
									$master = $this->db->insert('penerimaan_master', $data_master);
									if ($master) {
										#return last id inserted
										$lastid_master = $this->db->insert_id();
										$inserted = $no_array= 0;
	
										foreach ($_POST['kode_barang'] as $k) {
											if (!empty($k)) {
												$kode_barang    = $_POST['kode_barang'][$no_array];
												$jumlah_beli    = $_POST['jumlah_beli_spb'][$no_array];
												$harga_satuan = $_POST['harga_satuan'][$no_array];
												$id_barang      = $this->barang_model->get_id($kode_barang)->row()->id_barang;												
	
												#kalo harga dan qty barang tidak diisi
												if(($harga_satuan > 0) && ($jumlah_beli > 0)){
													$data_detail = array(
														'id_penerimaan_m'  => $lastid_master,
														'id_barang'     => $id_barang,
														'jumlah_beli'   => $jumlah_beli,
														'harga_satuan'  => $harga_satuan,
														'spesifikasi'   => $_POST['spesifikasi'][$no_array],
														'satuan'        => $_POST['satuan'][$no_array],
														'total'         => $_POST['sub_total_spb'][$no_array],
														'ppn'           => $_POST['ppn1'][$no_array],
														'harga_pajak'   => $_POST['harga_pajak'][$no_array],
														'diskon'   		=> $_POST['diskon_pembelian'][$no_array],
														'harga_diskon'   => $_POST['diskon_harga'][$no_array],
													);
		
													$insert_detail	= $this->db->insert('penerimaan_detail', $data_detail);
													if ($insert_detail) {
														//$this->barang_model->update_stok($id_barang, $jumlah_beli);
														$this->barang_model->tambah_stok($id_barang, $jumlah_beli);

														#update harga beli barang terbaru sesuai penerimaan barang																											#UPDATE HARGA BARANG TERBARU DARI PENERIMAAN BARANG
														$data_barang = array(
															'harga_beli' => $harga_satuan,
														);
														$this->msa->update('barang', 'id_barang', $id_barang, $data_barang);

														$inserted++;
													}	
												}// END #kalo harga dan qty barang tidak diisi
											}
											$no_array++;
										}
	
										if ($inserted > 0) {
											echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
										} else {
											echo json_encode(array(
												'status' => 0,
												"pesan" => "<font color='red'><i class='fa fa-warning'></i>Transaksi gagal disimpan</font>"
											));
										}
									} else {
										echo json_encode(array(
											'status' => 0,
											"pesan" => "<font color='red'><i class='fa fa-warning'></i>Transaksi gagal disimpan</font>"
										));
									}
								}

							}else{

								#tidak ada barang yang disimpan/diterima
								echo json_encode(array(
									'status' => 0,
									"pesan" => "<font color='red'><i class='fa fa-warning'></i>Masukan minimal 1 barang dengan harga dan QTY</font>"
								));
							}


						} //end if validations run 
						else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						echo json_encode(array(
							'status' => 0,
							"pesan" => "<font color='red'><i class='fa fa-warning'></i> Masukan minimal 1 barang</font>
						"
						));
					}
				} else {
					echo json_encode(array(
						'status' => 0,
						"pesan" => "<font color='red'><i class='fa fa-warning'></i> Masukan minimal 1 barang</font>
					"
					));
				}
			} else {
				//$data['info_pengguna'] = $this->login_model->info_pengguna($table, 'idpengguna', $idpengguna);
				$data['view']        	= 'admin/penerimaan/form-penerimaan-barang';
				$data['title']        	= 'INPUT PENERIMAAN BARANG';
				$data['nomor_nota']		= $nomor_nota;
				$data['id_supplier']	= $spb[0]->id_supplier;	
				$data['spb']        	= $spb;								
				$data['id_pembelian_m']	= $id_pembelian_m;				
				$this->load->view('admin/template', $data);
			}
		}
	}

	public function detail_penerimaan($id_penerimaan_m){
		$penerimaan_master = $this->db->get_where('penerimaan_master', array('id_penerimaan_m' => $id_penerimaan_m))->result();
		// $penerimaan_detail = $this->db->get_where('penerimaan_detail', array('id_penerimaan_m' => $id_penerimaan_m))->result();

		$data['view']        	= 'admin/penerimaan/detail-penerimaan-barang';
		$data['title']        	= 'DETAIL PENERIMAAN BARANG';
		$data['id_penerimaan_m']	= $id_penerimaan_m;								
		$data['penerimaan_master']	= $penerimaan_master;								
		$this->load->view('admin/template', $data);

	}

	public function print_surat_penerimaan($id_penerimaan_m){
		$penerimaan_master = $this->db->get_where('penerimaan_master', array('id_penerimaan_m' => $id_penerimaan_m))->result();

        $data = array(
            'id_penerimaan_m' => $id_penerimaan_m,
            'penerimaan_master'	=> $penerimaan_master,
            'title'         => 'SURAT PENERIMAAN BARANG'
        );

        $this->load->view('admin/print/print-surat-penerimaan', $data);
    }    


	public function cek_kode_barang($kode)
	{
		//$this->load->model('barang_model');
		$cek_kode = $this->barang_model->cek_kode($kode);

		if ($cek_kode->num_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}

	public function cek_nol($qty)
	{
		if ($qty > 0) {
			return TRUE;
		}
		return FALSE;
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

/* End of file admin/Penerimaan.php */
