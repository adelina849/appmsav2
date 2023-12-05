<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Retur_barang extends Auth_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->load->model('msa_model', 'msa');
		$this->load->model('pesanan_model', 'pesanan');
		$this->load->model('barang_model', 'barang');
		$this->load->model('lembaga_model', 'lembaga');
	}

	function retur_pembelian()
	{
		date_default_timezone_set('Asia/Jakarta');

		$tglHariIni = date('Y-m-d');
		$th = date('Y');
		$bln = date('m');
		$hr = date('d');
		$tanggal = $retur_bulan_ini = $tAwal = $tAkhir = $dateRange = '';

		$title = 'DAFTAR RETUR PEMBELIAN';
		if ($this->input->post('filter', TRUE)) {
			$tAwal = $this->input->post('awal', TRUE);
			$tAkhir = $this->input->post('akhir', TRUE);
			$tanggal = $this->tanggal->konversi($tAwal) . ' - ' . $this->tanggal->konversi($tAkhir);
			$title = 'DAFTAR RETUR PEMBELIAN ' . $tanggal;
		} else {
			$tanggal = $hr . ' ' . $this->tanggal->bulan($bln) . ' ' . $th;
			$retur_bulan_ini = $bln;
			$title = 'DAFTAR RETUR PEMBELIAN ';
		}

		$data = array(
			'title'         => $title,
			'retur_bulan_ini'  => $retur_bulan_ini,
			'tAwal'    => $tAwal,
			'tAkhir'    => $tAkhir,
			'tanggal'       => $tanggal,
			'action_filter' => site_url('admin/retur_barang/retur_pembelian'),
			'action_cetak' => site_url('admin/cetak/retur_pembelian'),
			'view' => 'admin/retur_barang/daftar-retur-pembelian'
		);
		$this->load->view('admin/template', $data);
	}

	public function detail_retur_pembelian($id_retur)
	{
		$qReturMaster = $this->db->get_where('retur_barang_pembelian_master', array('id' => $id_retur))->result();
		$qMarketing = $this->db->get_where('marketing_supplier', array('id' => isset($qReturMaster[0]->id_marketing) ? $qReturMaster[0]->id_marketing : 0))->result();
		$qVendor = $this->db->get_where('vendor', array('id' => isset($qReturMaster[0]->id_supplier) ? $qReturMaster[0]->id_supplier : 0))->result();
		$data = array(
			'title'         => 'Detail Retur Pembelian',
			'id_retur_master' => $id_retur,
			'retur_master'	=> $qReturMaster,
			'qMarketing'	=> $qMarketing,
			'qVendor'	=> $qVendor,
			'view' => 'admin/retur_barang/detail-retur-pembelian'
		);
		$this->load->view('admin/template', $data);
	}

	public function daftar_penerimaan(){

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
            'action_filter' => site_url('admin/retur_barang/daftar_penerimaan'),
            'view' => 'admin/retur_barang/daftar-penerimaan-barang'
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

			$pembelian = $this->db->get_where('pembelian_master', array('id_pembelian_m' => $data->id_pembelian_m))->result();
			$id_supplier = (isset($pembelian[0]->id_supplier) ? $pembelian[0]->id_supplier : '0');

			$supplier = $this->db->get_where('vendor', array('id' => $id_supplier))->result();
			//$marketing = $this->db->get_where('marketing_supplier', array('id' => $data->id_marketing))->result();

            $row[] = array(
                'no'=> '<div class="text-center">'.$no.'</div>',
                'nomor'=>'<span>' . $data->nomor_penerimaan . '</span>',
                'nomor_pembelian'=>'<span>' . (isset($pembelian[0]->nomor_spb) ? $pembelian[0]->nomor_spb : '-'). '</span>',
                'supplier'=>'<span>' . strtoupper(isset($supplier[0]->nama_vendor) ? $supplier[0]->nama_vendor : '-'). '</span>',
                'total'=>'<span>' . str_replace(',', '.', number_format($data->netto_bayar)). '</span>',
                'aksi'=>'<div class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="' . site_url('admin/retur_barang/form_retur_pembelian/' . $data->id_penerimaan_m. '/barang') . '" data-toggle="tooltip" title="retur detail barang diterima" 
                                    class="btn btn-alt btn-info btn-xs themed-color themed-border">
									<i class="fa fa-retweet"></i> Retur Barang
                                </a>
							</div>                      
                    </div>' 
            );
			$no++;
		}
		
		$result = array('aaData'=>$row);
		echo json_encode($result);
		
	}
	
	public function form_retur_pembelian($id_penerimaan_m)
	{
		$title = 'Input Retur Pembelian';
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('transaksi_model');
		$this->load->model('barang_model');

		$level 		= $this->session->userdata('level');
		$idpengguna	= $this->session->userdata('idPengguna');

		$data['level']		= $level;
		$data['idpengguna']	= $idpengguna;
		$table 				= $this->keamanan->table_pengguna($level);

		$qNumber = $this->db->query("SELECT
			last_number_retur AS maxs
			FROM counter_number WHERE id='1' limit 0, 1")->row();
		$last_no    = $qNumber->maxs;
		$no_urut    = (($last_no == 0) ? 1 : $last_no += 1);
		$nomor_nota     = $no_urut;

		$penerimaan_master = $this->db->get_where('penerimaan_master', array('id_penerimaan_m' => $id_penerimaan_m))->result();

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
						$this->form_validation->set_rules('tanggal', 'Tanggal Retur', 'required');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							//format nomor SP tahun bulan tanggal nomor urut
							$no_urut_old     = $this->input->post('no_retur');

							$tanggal_retur     = $this->input->post('tanggal');
							$t = explode("-", $tanggal_retur);
							$format_noretur = ($t[0] . $t[1] . $t[2]); //tahun-bulan-tanggal

							$id_pembelian    = $this->input->post('id_pembelian');
							$id_penerimaan    = $this->input->post('id_penerimaan');
							$id_marketing    = $this->input->post('id_marketing');
							$id_supplier    = $this->input->post('id_supplier');
							$jenis_pembelian    = $this->input->post('jenis_pembelian');
							$keterangan    = $this->input->post('keterangan');
							$TotalBayarHidden    = $this->input->post('TotalBayarHidden');

							$jumlah_qoli    = $this->input->post('jumlah_qoli');
							$jumlah_ikat    = $this->input->post('jumlah_ikat');
							$id_kasir        = $idpengguna;

							$nomor_retur_old     = 'RTR' . $format_noretur . sprintf("%05s", $no_urut_old);
							$cek_nomor_retur = $this->transaksi_model->get_nomor_retur($nomor_retur_old, 'retur_barang_pembelian_master');

							if ($cek_nomor_retur->num_rows() > 0) {
								$idmaster_old = $cek_nomor_retur->row();
								echo json_encode(array(
									'status' => 0,
									"pesan" => "<font color='red'><i class='fa fa-warning'></i> Retur untuk nomor " . $nomor_retur_old . " Sudah dicatat, Untuk transaksi baru Silahkan kembali ke form utama</font>"
								));
							} else {

								#update NOMOR URUT 
								$newNumber = array('last_number_retur' => $no_urut);
								$this->db->where('id', 1);
								$this->db->update('counter_number', $newNumber);
								$nomor_retur_new     = 'RTR' . $format_noretur . sprintf("%05s", $no_urut);

								$data_master = array(
									'id_pembelian'	=>$id_pembelian,
									'id_penerimaan'	=>$id_penerimaan,
									'nomor_retur'	=> $nomor_retur_new,
									'tanggal_retur' => $tanggal_retur,
									'id_marketing'	=>$id_marketing,
									'jenis_spb'		=>$jenis_pembelian,	
									'keterangan'	=>$keterangan,
									'id_supplier'	=>$id_supplier,			
									'jumlah_qoli' 	=>$jumlah_qoli,
									'jumlah_ikat' 	=>$jumlah_ikat,
									'total'			=>$TotalBayarHidden,		
								);

								$master = $this->db->insert('retur_barang_pembelian_master', $data_master);
								if ($master) {
									#return last id inserted
									$lastid_master = $this->db->insert_id();
									$inserted = $no_array = 0;

									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$kode_barang    = $_POST['kode_barang'][$no_array];
											$jumlah_retur    = $_POST['jumlah_retur'][$no_array];
											$harga_satuan = $_POST['harga_satuan'][$no_array];
											$harga_retur = $_POST['harga_retur'][$no_array];
																						
											$id_barang      = $this->barang_model->get_id($kode_barang)->row()->id_barang;	
											$stok_awal = $this->barang_model->get_id($kode_barang)->row()->total_stok;												

											#kalo harga dan qty barang tidak diisi
											if(($harga_retur > 0) && ($jumlah_retur > 0)){
												$data_detail = array(
													'id_retur_master'  	=> $lastid_master,
													'id_barang'     	=> $id_barang,
													'jumlah_retur'  	=> $jumlah_retur,
													'harga_satuan'      => $harga_satuan,
													'total'         	=> $harga_retur,
												);
	
												$insert_detail	= $this->db->insert('retur_barang_pembelian_detail', $data_detail);
												if ($insert_detail) {
													//$this->barang_model->update_stok($id_barang, $jumlah_beli);
													//$this->barang_model->tambah_stok($id_barang, $jumlah_retur);
													$inserted++;
													//if($stok_awal > 0){
														$this->barang_model->kurangi_stok($id_barang, $jumlah_retur);
													//}
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
				$data['view']        = 'admin/retur_barang/form-retur-pembelian';
				$data['title']        = 'INPUT RETUR PEMBELIAN';
				$data['no_retur']     = $no_urut;
				$data['id_penerimaan_m']	= $id_penerimaan_m;								
				$data['penerimaan_master']	= $penerimaan_master;								
				$this->load->view('admin/template', $data);
			}
		}
	} //END LEVEL ADMIN


	public function all_retur_pembelian()
	{
		$retur_bulan_ini = $this->input->post('retur_bulan_ini');
		$tAwal = $this->input->post('tAwal');
		$tAkhir = $this->input->post('tAkhir');

		if (!empty($retur_bulan_ini)) {
			#tampilkan bulan aktif kalo tidak ada filter
			$data_wheres = "";
		} else {
			$data_wheres = "AND date(a.tanggal_retur)>='" . $tAwal . "' 
                        AND date(a.tanggal_retur)<='" . $tAkhir . "'";
		}

		$s = "SELECT *
                FROM retur_barang_pembelian_master AS a
                WHERE dihapus='tidak'
                $data_wheres
                ORDER BY a.tanggal_retur DESC";

		$q = $this->db->query($s);
		$no = 1;
		$result = array();
		$result['total'] = $q->num_rows();
		$row = array();

		foreach ($q->result() as $data) {
			$supplier = $this->db->get_where('vendor', array('id' => $data->id_supplier))->result();
			$marketing = $this->db->get_where('marketing_supplier', array('id' => $data->id_marketing))->result();
			$jenis_pembelian='';

			if($data->jenis_spb=='so'){
				$jenis_pembelian = 'SO';
			}else{
				$jenis_pembelian='STOK';
			}


			$row[] = array(
				'no' => '<div class="text-center">' . $no . '</div>',
				'nomor_retur' => '<span>' . $data->nomor_retur . '</span>',
				'tanggal_retur' => '<span>' . $this->tanggal->konversi($data->tanggal_retur) . '</span>',
				'marketing' => '<span>' . strtoupper(isset($marketing[0]->nama_lengkap) ? $marketing[0]->nama_lengkap : '-') . '</span>',
				'supplier' => '<span>' . strtoupper(isset($supplier[0]->nama_vendor) ? $supplier[0]->nama_vendor : '-') . '</span>',
				'aksi' => '<div class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="' . site_url('admin/retur_barang/detail_retur_pembelian/' . $data->id . '/list') . '" data-toggle="tooltip" title="Detail Retur Pembelian" 
                                    class="btn btn-alt btn-default btn-xs text-success">
                                    <i class="fa fa-eye text-success"></i>
                                </a>

								<button onclick="print(' . $data->id . ')" 
									class="btn btn-alt btn-default btn-xs text-info" data-toggle="tooltip" title="Cetak Retur Pembelian">
									<i class="fa fa-print text-info"></i>
								</button>
								<button onclick="print(' . $data->id . ')" 
									class="btn btn-alt btn-default btn-xs text-mutted" data-toggle="tooltip" title="Hapus Retur Pembelian">
									<i class="fa fa-trash text-mutted"></i>
								</button>

							</div>                      
                    </div>'
			);
			$no++;
		}

		$result = array('aaData' => $row);
		echo json_encode($result);
	}

	public function print_retur_pembelian($id_retur)
	{


		// $qReturMaster = $this->db->get_where('retur_barang_pembelian_master', array('id' => $id_retur))->result();
		// $qMarketing = $this->db->get_where('marketing_supplier', array('id' => isset($qReturMaster[0]->id_marketing) ? $qReturMaster[0]->id_marketing : 0))->result();
		// $qVendor = $this->db->get_where('vendor', array('id' => isset($qReturMaster[0]->id_supplier) ? $qReturMaster[0]->id_supplier : 0))->result();

		$qReturMaster = $this->db->get_where('retur_barang_pembelian_master', array('id' => $id_retur))->result();
		$qMarketing = $this->db->get_where('marketing_supplier', array('id' => isset($qReturMaster[0]->id_marketing) ? $qReturMaster[0]->id_marketing : 0))->result();
		$qVendor = $this->db->get_where('vendor', array('id' => isset($qMarketing[0]->id_vendor) ? $qMarketing[0]->id_vendor : 0))->result();
		$qPelanggan = $this->db->get_where('pelanggan', array('id' => isset($qReturMaster[0]->id_pelanggan) ? $qReturMaster[0]->id_pelanggan : 0))->result();
		$data = array(
			'title'         => 'FORM RETUR PEMBELIAN',
			'id_retur_master' => $id_retur,
			'retur_master'	=> $qReturMaster,
			'qMarketing'	=> $qMarketing,
			'qVendor'	=> $qVendor,
			'qPelanggan'	=> $qPelanggan,
			'view' => 'admin/retur_barang/detail-retur-pembelian'
		);

		$this->load->view('admin/print/print-retur-pembelian', $data);
	}

	function retur_penjualan()
	{
		date_default_timezone_set('Asia/Jakarta');

		$tglHariIni = date('Y-m-d');
		$th = date('Y');
		$bln = date('m');
		$hr = date('d');
		$tanggal = $retur_bulan_ini = $tAwal = $tAkhir = $dateRange = '';

		$title = 'DAFTAR RETUR PENJUALAN';
		if ($this->input->post('filter', TRUE)) {
			$tAwal = $this->input->post('awal', TRUE);
			$tAkhir = $this->input->post('akhir', TRUE);
			$tanggal = $this->tanggal->konversi($tAwal) . ' - ' . $this->tanggal->konversi($tAkhir);
			$title = 'DAFTAR RETUR PENJUALAN ' . $tanggal;
		} else {
			$tanggal = $hr . ' ' . $this->tanggal->bulan($bln) . ' ' . $th;
			$retur_bulan_ini = $bln;
			$title = 'DAFTAR RETUR PENJUALAN ';
		}

		$data = array(
			'title'         => $title,
			'retur_bulan_ini'  => $retur_bulan_ini,
			'tAwal'    => $tAwal,
			'tAkhir'    => $tAkhir,
			'tanggal'       => $tanggal,
			'action_filter' => site_url('admin/retur_barang/retur_penjualan'),
			'action_cetak' => site_url('admin/cetak/retur_penjualan'),
			'view' => 'admin/retur_barang/daftar-retur-penjualan'
		);
		$this->load->view('admin/template', $data);
	}

	public function detail_retur_penjualan($id_retur)
	{
		$qReturMaster = $this->db->get_where('retur_barang_penjualan_master', array('id' => $id_retur))->result();
		$qMarketing = $this->db->get_where('marketing', array('id' => isset($qReturMaster[0]->id_marketing) ? $qReturMaster[0]->id_marketing : 0))->result();
		$qPelanggan = $this->db->get_where('pelanggan', array('id' => isset($qReturMaster[0]->id_pelanggan) ? $qReturMaster[0]->id_pelanggan : 0))->result();
		$qLembaga = $this->db->get_where('lembaga', array('id' => isset($qPelanggan[0]->id_lembaga) ? $qPelanggan[0]->id_lembaga : 0))->result();
		$data = array(
			'title'         => 'Detail Retur Penjualan',
			'id_retur_master' => $id_retur,
			'retur_master'	=> $qReturMaster,
			'qMarketing'	=> $qMarketing,
			'qLembaga'	=> $qLembaga,
			'qPelanggan'	=> $qPelanggan,
			'view' => 'admin/retur_barang/detail-retur-penjualan'
		);
		$this->load->view('admin/template', $data);
	}


	public function form_retur_penjualan($id_packing_do,$id_pesanan_m, $id_packing_m)
	{
		$title = 'Input Retur Penjualan';
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('transaksi_model');
		//$this->load->model('barang_model');

		$level 		= $this->session->userdata('level');
		$idpengguna	= $this->session->userdata('idPengguna');

		$data['level']		= $level;
		$data['idpengguna']	= $idpengguna;
		$table 				= $this->keamanan->table_pengguna($level);

		$qNumber = $this->db->query("SELECT
			last_number_retur AS maxs
			FROM counter_number WHERE id='1' limit 0, 1")->row();
		$last_no    = $qNumber->maxs;
		$no_urut    = (($last_no == 0) ? 1 : $last_no += 1);
		$nomor_nota     = $no_urut;

		$data['view']        = 'admin/retur_barang/form-retur-penjualan';
		$data['action_retur'] = site_url('admin/retur_barang/simpan_retur_penjualan');
		$data['title']        = 'INPUT RETUR PENJUALAN';
		$data['no_retur']        = $no_urut;
		$data['id_packing_do']        = $id_packing_do;
		$data['id_pesanan_m']        = $id_pesanan_m;
		$data['id_packing_m']        = $id_packing_m;
		$this->load->view('admin/template', $data);
	} //END LEVEL ADMIN


	function simpan_retur_penjualan(){
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('transaksi_model');

		$level 		= $this->session->userdata('level');
		$idpengguna	= $this->session->userdata('idPengguna');

        if ($this->input->server('HTTP_REFERER')) {
			$id_do     = $this->input->post('id_do');
			$no_urut     = $this->input->post('no_retur');
			$tanggal_retur     = $this->input->post('tanggal_retur');
			$t = explode("-", $tanggal_retur);
			$format_noretur = ($t[0] . $t[1] . $t[2]); //tahun-bulan-tanggal


			$jumlah_qoli    = $this->input->post('jumlah_qoli');
			$jumlah_ikat    = $this->input->post('jumlah_ikat');
			$id_kasir        = $idpengguna;
			$id_marketing    = $this->input->post('marketing');
			$id_pelanggan    = $this->input->post('pelanggan');
			$id_lembaga    = $this->input->post('lembaga');

			$nomor_retur_old     = 'RTR' . $format_noretur . sprintf("%05s", $no_urut);
			$cek_nomor_retur = $this->transaksi_model->get_nomor_retur($nomor_retur_old, 'retur_barang_penjualan_master');

			if ($cek_nomor_retur->num_rows() > 0) {
				$idmaster_old = $cek_nomor_retur->row();
				$this->session->set_flashdata('messageAlert', $this->messageAlert('warning', 'nomor retur sudah dicatat, silahkan proses retur baru'));
				redirect(site_url('admin/retur_barang/retur_penjualan'));
			}else {
				#update NOMOR URUT 
				$newNumber = array('last_number_retur' => $no_urut);
				$this->db->where('id', 1);
				$this->db->update('counter_number', $newNumber);
				$nomor_retur_new     = 'RTR' . $format_noretur . sprintf("%05s", $no_urut);

				$data_master = array(
					'id_do'      => $id_do,
					'nomor_retur'      => $nomor_retur_new,
					'tanggal_retur'    => $tanggal_retur,
					'id_marketing' => $id_marketing,
					'id_pelanggan' => $id_pelanggan,
					'id_lembaga' => $id_lembaga,
					'jumlah_qoli' => $jumlah_qoli,
					'jumlah_ikat' => $jumlah_ikat,
				);
			}
			$master = $this->db->insert('retur_barang_penjualan_master', $data_master);
			if ($master) {
				#return last id inserted
				$lastid_master = $this->db->insert_id();
				$inserted = $no_array = 0;

				$i = 1;
				foreach ($this->input->post('id_barang') as $idx => $val) :
					$index = $idx;
					$id_barang   = $val;
					$jumlah_retur    = $this->input->post('qty_retur' . $i);

					$data_detail = array(
						'id_retur_master'  => $lastid_master,
						'id_barang'     => $id_barang,
						'jumlah_retur'   => $jumlah_retur
					);
					if(!empty($jumlah_retur) && $jumlah_retur > 0){
						$insert_detail	= $this->db->insert('retur_barang_penjualan_detail', $data_detail);
						if ($insert_detail) {
							$this->barang->tambah_stok($id_barang, $jumlah_retur);
							$inserted++;
						}
					}
					$i++;
				endforeach;
				$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Retur barang berhasil disimpan !'));

			} else {
				$this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Retur barang tidak berhasil dilakukan'));
			}
        } else {
            $this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Opps. terjadi duplikasi data, silahkan cek daftar retur!'));
        }
		redirect(site_url('admin/retur_barang/retur_penjualan'));
	}

	public function do_validate_list(){
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
        } else {
            $tanggal = $hr . ' ' . $this->tanggal->bulan($bln) . ' ' . $th;
            $sp_bulan_ini = $bln;
            $title = 'DAFTAR DELIVERY ORDER (DO) ';
        }		

        $data = array(
            'title'         => $title,
            'sp_bulan_ini'  => $sp_bulan_ini,
            'tAwal'    => $tAwal,
            'tAkhir'    => $tAkhir,
            'id_lembaga'    => $id_lembaga,
            'id_pelanggan'    => $id_pelanggan,
            'tanggal'       => $tanggal,
            'action_filter' => site_url('admin/retur_barang/do_validate_list'),
            'view' => 'admin/retur_barang/daftar-validasi-do'
        );
        $this->load->view('admin/template', $data);


	}
	public function all_dovalidate(){
        $sp_bulan_ini = $this->input->post('sp_bulanini');
        $tAwal = $this->input->post('tAwal');
        $tAkhir = $this->input->post('tAkhir');

        if (!empty($sp_bulan_ini)) {
            #tampilkan bulan aktif kalo tidak ada filter
            $data_wheres = "";
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
                    a.nomor_do, a.id AS id_packing_do,
                    b.id_packing_m, b.nomor_packing, b.tanggal_packing,
                    c.id_pesanan_m, c.id_lembaga, c.id_pelanggan, c.id_mitra, c.grand_total, c.sisa_bayar
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

			//$id_packing_do.','.$id_pesanan.','.$pm->id_packing_m.'

            $row[] = array(
                'no'=> '<div class="text-center">'.$no.'</div>',
                'nomor_sp'=>'<span>' . $data->nomor_do . '</span>',
                'pelanggan'=>'<span>' . strtoupper(isset($qPelanggan[0]->nama_pelanggan) ? $qPelanggan[0]->nama_pelanggan : '-') . '</span>',
                'lembaga'=>'<span>' . strtoupper(isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-') . '</span>',
                'status'=>'<span>' . strtoupper(isset($qLembaga[0]->satus) ? $qLembaga[0]->satus : '-') . '</span>',
                'jenjang'=>'<span>' . strtoupper(isset($qLembaga[0]->jenjang) ? $qLembaga[0]->jenjang : '-') . '</span>',
                'nilai_sp'=>'<div class="text-right">' . str_replace(',', '.', number_format($data->grand_total)) . '</div>',
                'aksi'=>'<div class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="' . site_url('admin/retur_barang/form_retur_penjualan/'.$data->id_packing_do.'/'.$data->id_pesanan_m .'/'.$data->id_packing_m.'/list') . '" data-toggle="tooltip" title="Detail Order" 
                                    class="btn btn-alt btn-primary btn-xs">
                                    <i class="fa fa-refresh"></i> Retur Barang
                                </a>
                            </div>        
                        </div>' 
            );
			$no++;
		}
		
		$result = array('aaData'=>$row);
		echo json_encode($result);
		
	}


	public function all_retur_penjualan()
	{
		$retur_bulan_ini = $this->input->post('retur_bulan_ini');
		$tAwal = $this->input->post('tAwal');
		$tAkhir = $this->input->post('tAkhir');

		if (!empty($retur_bulan_ini)) {
			#tampilkan bulan aktif kalo tidak ada filter
			$data_wheres = "";
		} else {
			$data_wheres = "AND date(a.tanggal_retur)>='" . $tAwal . "' 
                        AND date(a.tanggal_retur)<='" . $tAkhir . "'";
		}

		$s = "SELECT *
                FROM retur_barang_penjualan_master AS a
                WHERE dihapus='tidak'
                $data_wheres
                ORDER BY a.tanggal_retur DESC";

		$q = $this->db->query($s);
		$no = 1;
		$result = array();
		$result['total'] = $q->num_rows();
		$row = array();

		foreach ($q->result() as $data) {
			$qPelanggan = $this->db->get_where('pelanggan', array('id' => $data->id_pelanggan))->result();
			$qMarketing = $this->db->get_where('marketing', array('id' => $data->id_marketing))->result();
            $qLembaga = $this->db->get_where('lembaga', array('id' => $data->id_lembaga))->result();

			$row[] = array(
				'no' => '<div class="text-center">' . $no . '</div>',
				'nomor_retur' => '<span>' . $data->nomor_retur . '</span>',
				'lembaga' => '<span>' . strtoupper(isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-') . '</span>',
				'marketing' => '<span>' . strtoupper(isset($qMarketing[0]->nama_lengkap) ? $qMarketing[0]->nama_lengkap : '-') . '</span>',
				'pelanggan' => '<span>' . strtoupper(isset($qPelanggan[0]->nama_pelanggan) ? $qPelanggan[0]->nama_pelanggan : '-') . '</span>',
				'aksi' => '<div class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="' . site_url('admin/retur_barang/detail_retur_penjualan/' . $data->id . '/list') . '" data-toggle="tooltip" title="Detail Retur Pembelian" 
                                    class="btn btn-alt btn-default btn-xs text-primary">
                                    <i class="fa fa-eye text-primary"></i>
                                </a>

								<button onclick="print(' . $data->id . ')" 
									class="btn btn-alt btn-default btn-xs text-info" data-toggle="tooltip" title="Cetak Retur Penjualan">
									<i class="fa fa-print text-info"></i>
								</button>
							</div>                      
                    </div>'
			);
			$no++;
		}

		$result = array('aaData' => $row);
		echo json_encode($result);
	}

	public function print_retur_penjualan($id_retur)
	{

		// $qReturMaster = $this->db->get_where('retur_barang_penjualan_master', array('id' => $id_retur))->result();
		// $qMarketing = $this->db->get_where('marketing', array('id' => isset($qReturMaster[0]->id_marketing) ? $qReturMaster[0]->id_marketing : 0))->result();
		// $qLembaga = $this->db->get_where('lembaga', array('id' => isset($qMarketing[0]->id_lembaga) ? $qMarketing[0]->id_lembaga : 0))->result();
		// $qPelanggan = $this->db->get_where('pelanggan', array('id' => isset($qReturMaster[0]->id_pelanggan) ? $qReturMaster[0]->id_pelanggan : 0))->result();
		// $data = array(
		// 	'title'         => 'PRINT RETUR PENJUALAN',
		// 	'id_retur_master' => $id_retur,
		// 	'retur_master'	=> $qReturMaster,
		// 	'qMarketing'	=> $qMarketing,
		// 	'qLembaga'	=> $qLembaga,
		// 	'qPelanggan'	=> $qPelanggan,
		// 	//'view' => 'admin/retur_barang/detail-retur-penjualan'
		// );
		$qReturMaster = $this->db->get_where('retur_barang_penjualan_master', array('id' => $id_retur))->result();
		$qMarketing = $this->db->get_where('marketing', array('id' => isset($qReturMaster[0]->id_marketing) ? $qReturMaster[0]->id_marketing : 0))->result();
		$qPelanggan = $this->db->get_where('pelanggan', array('id' => isset($qReturMaster[0]->id_pelanggan) ? $qReturMaster[0]->id_pelanggan : 0))->result();
		$qLembaga = $this->db->get_where('lembaga', array('id' => isset($qPelanggan[0]->id_lembaga) ? $qPelanggan[0]->id_lembaga : 0))->result();
		
		$data = array(
			'title'         => 'RETUR PENJUALAN',
			'id_retur_master' => $id_retur,
			'retur_master'	=> $qReturMaster,
			'qMarketing'	=> $qMarketing,
			'qLembaga'	=> $qLembaga,
			'qPelanggan'	=> $qPelanggan,
			'view' => 'admin/retur_barang/detail-retur-penjualan'
		);

		$this->load->view('admin/print/print-retur-penjualan', $data);
	}

	public function ajax_detail_do()
	{
		$this->load->model('retur_model');
		$id_do 	= $this->input->post('id_do');

		$s = "SELECT *
                FROM packing_do
                WHERE dihapus='tidak'
                AND id='" . $id_do . "'";

		$q = $this->db->query($s);

		if ($q->num_rows() > 0) {
			$do = $q->row();
			$packing_detail = $this->retur_model->get_data_do($do->id_packing_m);
			echo json_encode(array(
				'data' => $packing_detail,
				'status' => 1,
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

	public function cari_barang()
	{
		if ($this->input->is_ajax_request()) {
			$keyword     = $this->input->post('keyword');
			$registered    = $this->input->post('registered');

			$barang = $this->barang->get_kode_barang($keyword, $registered);

			if ($barang->num_rows() > 0) {
				$json['status']     = 1;
				$json['datanya']     = "<ul id='daftar-autocomplete'>";
				foreach ($barang->result() as $b) {
					$json['datanya'] .= "
						<li>
							<b>Kode</b> : 
							<span id='idnya' hidden>" . $b->id_barang . "</span> <br />
							<span id='kodenya'>" . $b->kode_barang . "</span> <br />
							<span id='barangnya'>" . $b->nama_barang . "</span> <br />
                            <b>Spesifikasi</b> :
                            <span id='speknya'>" . $b->spesifikasi . "</span>
                            <b>Satuan</b> :
                            <span id='satuannya'>" . $b->satuan . "</span>
                            <span id='harganya' style='display:none;'>" . $b->harga_jual . "</span>
						</li>
					";
				}
				$json['datanya'] .= "</ul>";
			} else {
				$json['status']     = 0;
			}
		}
		echo json_encode($json);
	}

	public function cari_lembaga()
	{
		if ($this->input->is_ajax_request()) {
			$keyword     = $this->input->post('keyword');
			$registered    = $this->input->post('registered');

			$lembaga = $this->lembaga->get_kode_lembaga($keyword, $registered);

			if ($lembaga->num_rows() > 0) {
				$json['status']     = 1;
				$json['datanya']     = "<ul id='daftar-autocomplete-lembaga'>";
				foreach ($lembaga->result() as $b) {
					$json['datanya'] .= "
						<li>
							<b>Kode</b> : 
							<span id='idnya' hidden>" . $b->id . "</span> <br />
							<span id='kodenya'>" . $b->kode . "</span> <br />
							<span id='lembaganya'>" . $b->nama_lembaga . "</span> <br />
                            <b>Klasifikasi</b> :
                            <span id='speknya'>" . $b->klasifikasi . "</span>
						</li>
					";
				}
				$json['datanya'] .= "</ul>";
			} else {
				$json['status']     = 0;
			}
		}
		echo json_encode($json);
	}


	public function cek_nol($qty)
	{
		if ($qty > 0) {
			return TRUE;
		}
		return FALSE;
	}

	public function cek_kode_barang($kode)
	{
		$cek_kode = $this->barang->cek_kode($kode);

		if ($cek_kode->num_rows() > 0) {
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

/* End of file admin/Retur_barang.php */
