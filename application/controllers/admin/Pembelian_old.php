<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian extends Auth_Controller
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
        $tanggal = $surat_bulan_ini = $tAwal = $tAkhir = $dateRange = $supplier = '';

        $title = 'DAFTAR SURAT PEMBELIAN';
        if ($this->input->post('filter', TRUE)) {
            $tAwal = $this->input->post('awal', TRUE);
            $tAkhir = $this->input->post('akhir', TRUE);			
            $tanggal = $this->tanggal->konversi($tAwal) . ' - ' . $this->tanggal->konversi($tAkhir);
			$supplier = $this->input->post('vendor', TRUE);

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
            'supplier'       => $supplier,
            'action_filter' => site_url('admin/pembelian/daftar'),
            'action_delete' => site_url('admin/pembelian/hapus_pembelian'),
            'view' => 'admin/pembelian/daftar-surat-pembelian'
        );
        $this->load->view('admin/template', $data);
    }

	public function all_surat_pembelian(){
        $surat_bulan_ini = $this->input->post('surat_bulan_ini');
        $tAwal = $this->input->post('tAwal');
        $tAkhir = $this->input->post('tAkhir');
		$supplier = $this->input->post('supplier', TRUE);

        if (!empty($surat_bulan_ini)) {
            #tampilkan bulan aktif kalo tidak ada filter
            $data_wheres = "";
        }else if(!empty($supplier)){
            $data_wheres = "AND date(a.tanggal_spb)>='".$tAwal."' 
                        AND date(a.tanggal_spb)<='".$tAkhir."' AND id_supplier='".$supplier."'";

		}
		else {            
            $data_wheres = "AND date(a.tanggal_spb)>='".$tAwal."' 
                        AND date(a.tanggal_spb)<='".$tAkhir."'";
        }

		$s = "SELECT *
                FROM pembelian_master AS a
                WHERE dihapus='tidak'
                $data_wheres
                ORDER BY a.tanggal_spb DESC";

		$q = $this->db->query($s);
		$no = 1;
		$result = array();
		$result['total'] = $q->num_rows();
		$row = array();
        
		foreach($q->result() as $data) {
			$tgl_jatuh_tempo='';	
			$supplier = $this->db->get_where('vendor', array('id' => $data->id_supplier))->result();
			$marketing = $this->db->get_where('marketing_supplier', array('id' => $data->id_marketing))->result();
			$jenis_pembelian='';

			if($data->jenis_spb=='so'){
				$jenis_pembelian = 'SO';
			}else{
				$jenis_pembelian='STOK';
			}
			if($data->jatuh_tempo=='0000-00-00'){
				$tanggal_jatuh_tempo='-';	
			}else{
				$tanggal_jatuh_tempo=$this->tanggal->konversi($data->jatuh_tempo);
			}

            $row[] = array(
                'no'=> '<div class="text-center">'.$no.'</div>',
                'nomor'=>'<span>' . $data->nomor_spb . '</span>',
                'marketing'=>'<span>' . (isset($marketing[0]->nama_lengkap) ? $marketing[0]->nama_lengkap : '-'). '</span>',
                'supplier'=>'<span>' . strtoupper(isset($supplier[0]->nama_vendor) ? $supplier[0]->nama_vendor : '-'). '</span>',
                'pembelian'=>'<span>' . $jenis_pembelian. '</span>',
                'pembayaran'=>'<div class="text-center">' .ucwords($data->sistem_pembayaran). '</div>',
                'tempo'=>'<span>' .$tanggal_jatuh_tempo.
				'</span>',
                'total'=>'<div class="text-right">' .str_replace(',', '.', number_format($data->grand_total)). '</div>',
                'aksi'=>'<div class="text-center">
                            <div class="btn-group-vertical btn-group-sm">
								<button onclick="print('.$data->id_pembelian_m.')" 
									class="btn btn-alt btn-default btn-xs text-info" data-toggle="tooltip" title="Cetak Surat Pembelian">
									<i class="fa fa-print text-info"></i>
								</button>
								<a href="javascript:void(0)" data-toggle="tooltip" title="Hapus" 
									class="btn btn-alt btn-xs btn-default hapus" onclick="form_hapus(' . "'" . $data->id_pembelian_m . "'" . ')">
									<i class="fa fa-trash-o text-danger"></i>
								</a>

							</div>                      
                    </div>' 
            );
			$no++;
		}
		
		$result = array('aaData'=>$row);
		echo json_encode($result);
		
	}

	public function form_stok()
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('transaksi_model');
		//$this->load->model('barang_model');

		$level                 = $this->session->userdata('level');
		$idpengguna            = $this->session->userdata('idPengguna');
		$data['level']        = $level;
		$data['idpengguna']    = $idpengguna;
		$table                 = $this->keamanan->table_pengguna($level);

		$qNumber = $this->db->query("SELECT
			last_number_spb AS maxs
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

						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {
								$this->form_validation->set_rules('kode_barang[' . $no . ']', 'Kode Barang #' . ($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang[' . $no . ']]');
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
								$this->form_validation->set_rules('harga_satuan[' . $no . ']', 'Harga Pembelian #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[harga_satuan[' . $no . ']]');							
							}
							$no++;
						}


						$this->form_validation->set_rules('tanggal', 'Tanggal Pembelian', 'required');
						$this->form_validation->set_rules('jenis_spb', 'Jenis Pembelian', 'required');
						$this->form_validation->set_rules('marketing', 'Nama Marketing', 'required');												
						$this->form_validation->set_rules('sistem_pembayaran', 'Sistem Pembayaran', 'required');
						
						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						$sistem_pembayaran    = $this->input->post('sistem_pembayaran');
						#kalo sistem pembayaran tunai, tanggal jatuh tempo tidak usah disii.
						$tanggal_jatuh_tempo    = $this->input->post('tanggal_jatuh_tempo');
						if($sistem_pembayaran=='kredit'){
							$this->form_validation->set_rules('tanggal_jatuh_tempo', 'Tanggal Jatuh Tempo', 'required');
						}

						if ($this->form_validation->run() == TRUE) {
							//format nomor SP tahun bulan tanggal nomor urut
							$no_urut_old     = $this->input->post('no_urut');

							$tanggal_spb     = $this->input->post('tanggal');
							$t = explode("-", $tanggal_spb);
							$format_spb = ($t[0] . $t[1] . $t[2]); //tahun-bulan-tanggal

							$id_kasir        = $idpengguna;
							$id_marketing    = $this->input->post('marketing');

                            $supplier = $this->db->get_where('marketing_supplier', array('id' => $id_marketing))->result();

							$id_supplier =  (isset($supplier[0]->id_vendor) ? $supplier[0]->id_vendor : '0'); 

							$ppn    = $this->input->post('ppn');

							$jenis_spb            = $this->input->post('jenis_spb');
							$grand_total    = $this->input->post('grand_total');
							$SisaBayar    = $this->input->post('SisaBayar');
							$SisaBayarHidden    = $this->input->post('SisaBayarHidden');

							#cek kalo nomor SPB sudah ada jangan rubah nomor urut

							$nomor_spb_old     = 'SPB' . $format_spb . sprintf("%05s", $no_urut_old);
							$cek_nomor_spb = $this->transaksi_model->get_nomor_spb($nomor_spb_old);

							if ($cek_nomor_spb->num_rows() > 0) {
								$idmaster_old = $cek_nomor_spb->row();
								echo json_encode(array(
									'status' => 0,
									"pesan" => "<font color='red'><i class='fa fa-warning'></i> Surat Pembelian untuk nomor " . $nomor_spb_old . " Sudah dicatat, Untuk transaksi baru Silahkan Klik menu Surat Pembelian</font>"
								));
							} else {

                                #update NOMOR URUT 
                                $newNumber = array('last_number_spb' => $no_urut);
                                $this->db->where('id', 1);
                                $this->db->update('counter_number', $newNumber);
								$nomor_spb_new     = 'SPB' . $format_spb . sprintf("%05s", $no_urut);

								$data_master = array(
									'nomor_spb'      => $nomor_spb_new,
									'tanggal_spb'    => $tanggal_spb,
									'jenis_spb'      => $jenis_spb,
									'grand_total'   => $grand_total,
									'sistem_pembayaran' => $sistem_pembayaran,
									'jatuh_tempo' => $tanggal_jatuh_tempo,
									'id_marketing' => $id_marketing,
									'id_supplier' => $id_supplier,
									'ppn' => $ppn,
									'harga_setelah_pajak' => $SisaBayarHidden,
									'id_user' => $id_kasir
								);
								
								$master = $this->db->insert('pembelian_master', $data_master);
								if ($master) {
									#return last id inserted
									$lastid_master = $this->db->insert_id();
									$inserted = $no_array= 0;

									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$kode_barang    = $_POST['kode_barang'][$no_array];
											$id_barang      = $this->barang_model->get_id($kode_barang)->row()->id_barang;
											$jumlah_beli    = $_POST['jumlah_beli'][$no_array];

											$data_detail = array(
												'id_pembelian_m'  => $lastid_master,
												'id_barang'     => $id_barang,
												'jumlah_beli'   => $jumlah_beli,
												'harga_satuan'  => $_POST['harga_satuan'][$no_array],
												'spesifikasi'   => $_POST['spesifikasi'][$no_array],
												'satuan'        => $_POST['satuan'][$no_array],
												'total'         => $_POST['sub_total'][$no_array],
												'ppn'           => $_POST['ppn11_barang'][$no_array],
												'harga_pajak'   => $_POST['harga_pajak'][$no_array],
											);

											$insert_detail	= $this->db->insert('pembelian_detail', $data_detail);
											if ($insert_detail) {
												//$this->barang_model->update_stok($id_barang, $jumlah_beli);
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
				$data['view']        = 'admin/pembelian/form-pembelian-stok';
				$data['title']        = 'INPUT SURAT PEMBELIAN STOK';
				$data['nomor_nota']        = $nomor_nota;
				$this->load->view('admin/template', $data);
			}
		}
	}

    public function cari_kode()
	{
		if ($this->input->is_ajax_request()) {
			$keyword     = $this->input->post('keyword');
			$registered    = $this->input->post('registered');

			$barang = $this->barang_model->get_kode_barang($keyword, $registered);

			if ($barang->num_rows() > 0) {
				$json['status']     = 1;
				$json['datanya']     = "<ul id='daftar-autocomplete'>";
				foreach ($barang->result() as $b) {
					$json['datanya'] .= "
						<li>
							<b>Kode</b> : 
							<span id='kodenya'>" . $b->kode_barang . "</span> <br />
							<span id='barangnya'>" . $b->nama_barang . "</span> <br />
                            <b>Spesifikasi</b> :
                            <span id='speknya'>" . $b->spesifikasi . "</span><br />
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

	public function so(){
		$qNumber = $this->db->query("SELECT
			last_number_spb AS maxs
			FROM counter_number WHERE id='1' limit 0, 1")->row();

		$last_no    = $qNumber->maxs;
		$no_urut    = (($last_no == 0) ? 1 : $last_no += 1);
		$nomor_nota     = $no_urut;

		$filter = 'supplier';
		$data = array(
			'title' => 'PEMBELIAN BERDASARKAN SO',
			'view' => 'admin/pembelian/pembelian-so-supplier',
			'nomor_nota' => $nomor_nota,
			'action_cetak' => site_url('admin/standing_order/insert_spb/' . $filter),
		);
		$this->load->view('admin/template', $data);

	}

	public function ajax_list_so_vendor()
	{
		$data = array();

		$list_data = $this->so->get_datatables('packing_detail', 'supplier');

		$no = $_POST['start'];

		foreach ($list_data as $d) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">' . $no . '</div>';
			$row[] = '<span>' . $d->kode . '</span>';
			$row[] = '<span>' . strtoupper($d->nama_vendor) . '</span>';
			$row[] = '<div class="text-center">
                        <div class="btn-group btn-group-sm">
							<a href="' . site_url('admin/pembelian/form_so/' . $d->id_vendor. '/list') . '" data-toggle="tooltip" title="Buat Surat Pembelian" 
								class="btn btn-alt btn-info btn-xs">
								<i class="fa fa-file-o"></i> Surat Pembelian
							</a>
						</div>
                    </div>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->so->count_all('packing_detail'),
			"recordsFiltered" => $this->so->count_filtered('packing_detail', 'supplier'),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}	

	public function form_so($id_supplier){

		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('transaksi_model');
		//$this->load->model('barang_model');

		$level                 = $this->session->userdata('level');
		$idpengguna            = $this->session->userdata('idPengguna');
		$data['level']        = $level;
		$data['idpengguna']    = $idpengguna;
		$table                 = $this->keamanan->table_pengguna($level);

		$qNumber = $this->db->query("SELECT
			last_number_spb AS maxs
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

						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {
								$this->form_validation->set_rules('kode_barang[' . $no . ']', 'Kode Barang #' . ($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang[' . $no . ']]');
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
								$this->form_validation->set_rules('harga_satuan[' . $no . ']', 'Harga Pembelian #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[harga_satuan[' . $no . ']]');
							}
							$no++;
						}

						$this->form_validation->set_rules('tanggal', 'Tanggal Pembelian', 'required');
						$this->form_validation->set_rules('jenis_spb', 'Jenis Pembelian', 'required');
						$this->form_validation->set_rules('marketing', 'Nama Marketing', 'required');
												
						$this->form_validation->set_rules('sistem_pembayaran', 'Sistem Pembayaran', 'required');
						//$this->form_validation->set_rules('tanggal_jatuh_tempo', 'Tanggal Jatuh Tempo', 'required');
						//$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							//format nomor SP tahun bulan tanggal nomor urut
							$no_urut_old     = $this->input->post('no_urut');

							$tanggal_spb     = $this->input->post('tanggal');
							$t = explode("-", $tanggal_spb);
							$format_spb = ($t[0] . $t[1] . $t[2]); //tahun-bulan-tanggal

							$id_kasir        = $idpengguna;
							$id_marketing    = $this->input->post('marketing');

                            $supplier = $this->db->get_where('marketing_supplier', array('id' => $id_marketing))->result();

							$id_supplier =  (isset($supplier[0]->id_vendor) ? $supplier[0]->id_vendor : '0'); 


							$sistem_pembayaran    = $this->input->post('sistem_pembayaran');
							$tanggal_jatuh_tempo    = $this->input->post('tanggal_jatuh_tempo');
							$ppn    = $this->input->post('ppn');

							$jenis_spb            = $this->input->post('jenis_spb');
							$grand_total    = $this->input->post('grand_total');
							$SisaBayar    = $this->input->post('SisaBayar');
							$SisaBayarHidden    = $this->input->post('SisaBayarHidden');

							#cek kalo nomor SPB sudah ada jangan rubah nomor urut

							$nomor_spb_old     = 'SPB' . $format_spb . sprintf("%05s", $no_urut_old);
							$cek_nomor_spb = $this->transaksi_model->get_nomor_spb($nomor_spb_old);

							if ($cek_nomor_spb->num_rows() > 0) {
								$idmaster_old = $cek_nomor_spb->row();
								echo json_encode(array(
									'status' => 0,
									"pesan" => "<font color='red'><i class='fa fa-warning'></i> Surat Pembelian untuk nomor " . $nomor_spb_old . " Sudah dicatat, Untuk transaksi baru Silahkan Klik menu Surat Pembelian</font>"
								));
							} else {

                                #update NOMOR URUT 
                                $newNumber = array('last_number_spb' => $no_urut);
                                $this->db->where('id', 1);
                                $this->db->update('counter_number', $newNumber);
								$nomor_spb_new     = 'SPB' . $format_spb . sprintf("%05s", $no_urut);

								$data_master = array(
									'nomor_spb'      => $nomor_spb_new,
									'tanggal_spb'    => $tanggal_spb,
									'jenis_spb'      => $jenis_spb,
									'grand_total'   => $grand_total,
									'sistem_pembayaran' => $sistem_pembayaran,
									'jatuh_tempo' => $tanggal_jatuh_tempo,
									'id_marketing' => $id_marketing,
									'id_supplier' => $id_supplier,
									'ppn' => $ppn,
									'harga_setelah_pajak' => $SisaBayarHidden,
									'id_user' => $id_kasir
								);
								
								$master = $this->db->insert('pembelian_master', $data_master);
								if ($master) {
									#return last id inserted
									$lastid_master = $this->db->insert_id();
									$inserted = $no_array= 0;

									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$kode_barang    = $_POST['kode_barang'][$no_array];
											$id_barang      = $this->barang_model->get_id($kode_barang)->row()->id_barang;
											$jumlah_beli    = $_POST['jumlah_beli'][$no_array];
											$harga_satuan = $_POST['harga_satuan'][$no_array];

											$data_detail = array(
												'id_pembelian_m'  => $lastid_master,
												'id_barang'     => $id_barang,
												'jumlah_beli'   => $jumlah_beli,
												'harga_satuan'  => $harga_satuan,
												'spesifikasi'   => $_POST['spesifikasi'][$no_array],
												'satuan'        => $_POST['satuan'][$no_array],
												'total'         => $_POST['sub_total'][$no_array],
												'ppn'           => $_POST['ppn11_barang'][$no_array],
												'harga_pajak'   => $_POST['harga_pajak'][$no_array],
											);

											$insert_detail	= $this->db->insert('pembelian_detail', $data_detail);
											if ($insert_detail) {
												//$this->barang_model->update_stok($id_barang, $jumlah_beli);
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
				$data['view']        = 'admin/pembelian/form-pembelian-so-supplier';
				$data['title']        = 'INPUT SURAT PEMBELIAN SO SUPPLIER';
				$data['nomor_nota']        = $nomor_nota;
				$data['id_supplier']        = $id_supplier;				
				$this->load->view('admin/template', $data);
			}
		}


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

	public function print_surat_pembelian($pembelian_id){
		$pembelian = $this->db->get_where('pembelian_master', array('id_pembelian_m' => $pembelian_id))->result();

        $data = array(
            'pembelian_id' => $pembelian_id,
            'pembelian'	=> $pembelian,
            'title'         => 'SURAT PEMBELIAN BARANG'
        );

        $this->load->view('admin/print/print-surat-pembelian', $data);
    }    


	public function hapus_pembelian()
	{

		$id = $this->keamanan->post($this->input->post('id_pembelian_m'));

		$this->msa->delete('pembelian_master', 'id_pembelian_m', $id);
		$this->msa->delete('pembelian_master', 'id_pembelian_m', $id);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Semua data terkait surat pembelian telah dihapus'));
		}
		redirect(site_url('admin/pembelian/daftar/deleted-success'));
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

/* End of file admin/Pemblian.php */
