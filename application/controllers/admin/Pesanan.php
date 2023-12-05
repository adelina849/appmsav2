<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pesanan extends Auth_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->load->model('msa_model', 'msa');
		$this->load->model('pesanan_model', 'pesanan');
	}

	public function index()
	{
		$this->daftar();
	}

	public function ajax_get_lembaga()
    {
        $id_pelanggan     = $this->input->post('id_pelanggan');
        $d = $this->msa->get_by_id('id', $id_pelanggan, 'pelanggan');

        echo json_encode(array(
			'id_lembaga'		=> $d->id_pelanggan
        ));
    }	
	public function cari_kode()
	{
		if ($this->input->is_ajax_request()) {
			$keyword     = $this->input->post('keyword');
			$registered    = $this->input->post('registered');
			$jenis_barang    = $this->input->post('jenis_barang');

			$this->load->model('barang_model');
			$barang = $this->barang_model->cari_kode($keyword, $registered, $jenis_barang);

			if ($barang->num_rows() > 0) {
				$json['status']     = 1;
				$json['datanya']     = "<ul id='daftar-autocomplete'>";
				foreach ($barang->result() as $b) {
					$qSupplier = $this->db->get_where('vendor', array('id' => $b->id_vendor))->result();
					$supplier = (isset($qSupplier[0]->nama_vendor) ? $qSupplier[0]->nama_vendor : '');

					$json['datanya'] .= "
						<li>
							<b>Kode</b> : 
							<span id='kodenya'>" . $b->kode_barang . "</span> <br />
							<span id='barangnya'>" . $b->nama_barang . "</span> <br />
                            <b>Supplier</b> :
							<span id='id_vendor' style='display:none;'>" . $b->id_vendor . "</span>
							<span id='vendor'>" . $supplier . "</span> <br />
							<b>Stok Tersedia</b> :
							<span id='total_stok'>" . $b->total_stok . "</span> <br />
	
							<b>Spesifikasi</b> :
                            <span id='speknya'>" . $b->spesifikasi . "</span> <br />

							<b>Satuan</b> :
                            <span id='satuannya'>" . $b->satuan . "</span> <br />
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
		$autocomplite = '';
		if ($this->input->is_ajax_request()) {
			$keyword     = $this->input->post('nama_lembaga');

			$lembaga = $this->pesanan->cari_lembaga($keyword);

			$autocomplite = "<ul id='daftar-autocomplete' class='fa-ul'>";
			if ($lembaga->num_rows() > 0) {
				foreach ($lembaga->result() as $lembagas) {
					$autocomplite .=
						"
                    <li class='first_item'>
                        <span id='id_lembaga' style='display:none;'>" . $lembagas->id . '</span>'
						. "<span id='nama_lembaga' class='judul'>" . strtoupper($lembagas->nama_lembaga) . '</span>'
						. "<ul class='fa-ul'>
                            <li>
                                <span id='kode_lembaga'> Kode: " . $lembagas->kode . '</span>' . "
                            </li>
                            <li>
                                <span id='jenjang'> Jenjang: " . $lembagas->jenjang . '</span>' . "
                            </li>
                            <li>
                                <span id='status'> Status: " . $lembagas->status . '</span>' . "
                            </li>
                            <li>
                                <span id='klasifikasi'> Klasifikasi: " . $lembagas->klasifikasi . '</span>' . "
                            </li>
                        </ul>
                    </li>
                    ";
				}
			} else {
				$autocomplite .= '<li>Tidak ada yang cocok.</li>';
			}
			$autocomplite .= "</ul>";
		}
		echo $autocomplite;
	}

	public function cari_pelanggan()
	{
		$autocomplite = '';
		if ($this->input->is_ajax_request()) {
			$keyword     = $this->input->post('nama_pelanggan');

			$pelanggan = $this->pesanan->cari_pelanggan($keyword);

			$autocomplite = "<ul id='daftar-autocomplete' class='fa-ul'>";
			if ($pelanggan->num_rows() > 0) {
				foreach ($pelanggan->result() as $pelanggans) {
					$autocomplite .=
						"
                    <li class='first_item'>
                        <span id='id_pelanggan' style='display:none;'>" . $pelanggans->id . '</span>'
						. "<span id='nama_pelanggan' class='judul'>" . strtoupper($pelanggans->nama_pelanggan) . '</span>'
						. "<ul class='fa-ul'>
                            <li>
                                <span id='kode_pelanggan'> Kode: " . $pelanggans->kode . '</span>' . "
                            </li>
                            <li>
                                <span id='jabatan'> Jabatan: " . $pelanggans->jabatan . '</span>' . "
                            </li>
                            <li>
                                <span id='kontak'> Kontak: " . $pelanggans->kontak . '</span>' . "
                            </li>
                        </ul>
                    </li>
                    ";
				}
			} else {
				$autocomplite .= '<li>Tidak ada yang cocok.</li>';
			}
			$autocomplite .= "</ul>";
		}
		echo $autocomplite;
	}

	public function ajax_list_pesanan($jenis_sp)
	{
		date_default_timezone_set('Asia/Jakarta');
		$tglHariIni = date('Y-m-d');


		$sp_bulan_ini = $this->input->post('sp_bulanini');
		$tAwal = $this->input->post('tAwal');
		$tAkhir = $this->input->post('tAkhir');
		//$sp_bulan_ini = $_POST['sp_bulanini'];

		$form_edit = 'edit';
		
		if($jenis_sp == 'non-buku'){
			$form_edit = 'edit_nonbuku';
		}

		if (!empty($sp_bulan_ini)) {
			$data_wheres = array('month(tanggal_sp)' => $sp_bulan_ini, 'jenis_sp' => $jenis_sp);
		} else {
			$id_lembaga = $this->input->post('id_lembaga');
			$id_pelanggan = $this->input->post('id_pelanggan');
			if ((!empty($id_lembaga) && !empty($id_pelanggan))) {
				$data_wheres = array(
					'jenis_sp' => $jenis_sp,
					'id_lembaga' => $id_lembaga,
					'id_pelanggan' => $id_pelanggan,
					'date(tanggal_sp)>=' => $tAwal,
					'date(tanggal_sp)<=' => $tAkhir
				);
			} else if (!empty($id_lembaga)) {
				$data_wheres = array(
					'jenis_sp' => $jenis_sp,
					'id_lembaga' => $id_lembaga,
					'date(tanggal_sp)>=' => $tAwal,
					'date(tanggal_sp)<=' => $tAkhir
				);
			} else if (!empty($id_pelanggan)) {
				$data_wheres = array(
					'jenis_sp' => $jenis_sp,
					'id_pelanggan' => $id_pelanggan,
					'date(tanggal_sp)>=' => $tAwal,
					'date(tanggal_sp)<=' => $tAkhir
				);
			} else {
				$data_wheres = array(
					'jenis_sp' => $jenis_sp,
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
			$row[] = '<span>' . $this->tanggal->konversi($pesanan->tanggal_sp) . '</span>';
			$row[] = '<span>' . strtoupper($pesanan->jenis_sp) . '</span>';
			$row[] = '<span>' . strtoupper($pesanan->sistem_pembayaran) . '</span>';
			$row[] = '<span>' . strtoupper(isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-') . '</span>';
			$row[] = '<span>' . strtoupper(isset($qPelanggan[0]->nama_pelanggan) ? $qPelanggan[0]->nama_pelanggan : '-') . '</span>';
			$row[] = '<div class="text-right">' . str_replace(',', '.', number_format($pesanan->grand_total)) . '</div>';
			$row[] = '<div class="text-center">
                        <div class="btn-group btn-group-sm">
                            <a href="javascript:void(0)" data-toggle="tooltip" title="Cetak Surat Pesanan" 
                                class="btn btn-alt btn-default cetak" onclick="form_cektak(' . "'" . $pesanan->id_pesanan_m . "'" . ')">
                                <i class="fa fa-file-pdf-o text-info"></i>
                            </a>
                            <a href="' . site_url('admin/pesanan/'.$form_edit.'/'.$jenis_sp.'/' . $pesanan->id_pesanan_m) . '" data-toggle="tooltip" title="Detail Surat Pesanan" 
                                class="btn btn-alt btn-default btn-xs">
                                <i class="fa fa-eye text-success"></i>
                            </a>
                            <a href="javascript:void(0)" data-toggle="tooltip" title="Hapus" 
                                class="btn btn-alt btn-xs btn-default hapus" onclick="form_hapus(' . "'" . $pesanan->id_pesanan_m . "'" . ')">
                                <i class="fa fa-trash-o text-default"></i>
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

	public function daftar()
	{
		date_default_timezone_set('Asia/Jakarta');

		$tglHariIni = date('Y-m-d');
		$th = date('Y');
		$bln = date('m');
		$hr = date('d');
		$tanggal = $sp_bulan_ini = $tAwal = $tAkhir = $id_lembaga = $id_pelanggan = '';

		$title = 'DAFTAR SP BUKU';
		$and = null;
		$jenis_sp = 'buku';

		if ($this->input->post('filter', TRUE)) {
			$tAwal = $this->input->post('awal', TRUE);
			$tAkhir = $this->input->post('akhir', TRUE);
			$id_lembaga = $this->input->post('lembaga', TRUE);
			$id_pelanggan = $this->input->post('pelanggan', TRUE);
			$tanggal = $this->tanggal->konversi($tAwal) . ' - ' . $this->tanggal->konversi($tAkhir);
			$title = 'DAFTAR SP BUKU ' . $tanggal;
			$and = "AND date(tanggal_sp) >= '".$tAwal."' AND date(tanggal_sp) <='".$tAkhir."'";
			// $data_where = array('date(tanggal_sp)>=' => '2022-12-01', 'date(tanggal_sp)<=' => '2022-12-30');
		} else {
			$tanggal = $hr . ' ' . $this->tanggal->bulan($bln) . ' ' . $th;
			$sp_bulan_ini = $bln;
			$and = "AND month(tanggal_sp) = '".$bln."'";
			//$data_where = array('date(tanggal_sp)=' => $tglHariIni);
			$title = 'DAFTAR SP BUKU BULAN ' . strtoupper($this->tanggal->bulan($bln)) . ' ' . $th;
		}

		$count_sp = $this->pesanan->count_sp($and, $jenis_sp)->row();
		$count_sp_all = $this->pesanan->count_sp_all($jenis_sp)->row();
		
		$q = $this->pesanan->nominal_pesanan($and, $jenis_sp)->row();

		$data = array(
			'title'         => $title,
			'sp_bulan_ini'  => $sp_bulan_ini,
			'tAwal'    => $tAwal,
			'tAkhir'    => $tAkhir,
			'id_lembaga'    => $id_lembaga,
			'id_pelanggan'    => $id_pelanggan,
			'tanggal'       => $tanggal,
			'count_sp_all'	=>$count_sp_all->jumlah_all,
			'count_sp'	=>$count_sp->jumlah,
			'total_sp'	=> str_replace(',', '.', number_format($q->total_rupiah)),
			'action_filter' => site_url('admin/pesanan/daftar'),
			'action_cetak' => site_url('admin/cetak/surat_pesanan'),
			'action_delete' => site_url('admin/pesanan/hapus_pesanan_buku'),
			'barang' => $this->msa->get_all('barang', 'id_barang'),
			'view' => 'admin/pesanan/pesanan-list'
		);
		$this->load->view('admin/template', $data);
	}

	public function form_pesanan()
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('transaksi_model');
		$this->load->model('barang_model');

		$level                 = $this->session->userdata('level');
		$idUser            	   = $this->session->userdata('id');
		$idpengguna            = $this->session->userdata('idPengguna');
		$data['level']         = $level;
		$data['idpengguna']    = $idpengguna;
		$table                 = $this->keamanan->table_pengguna($level);

		$no_urutsp     = $this->transaksi_model->last_nokwitansi(1);
		$last_no        = $no_urutsp->maxs;
		$no_urut             = (($last_no == 0) ? 1 : $last_no += 1);
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
							}
							$no++;
						}

						$sistem_pembayaran    = $this->input->post('sistem_pembayaran');
						$this->form_validation->set_rules('sistem_pembayaran', 'Sistem Pembayaran', 'required');
						if($sistem_pembayaran=='kredit'){
							$this->form_validation->set_rules('tanggal_jatuh_tempo', 'Tanggal Jatuh Tempo', 'required');
						}

						$this->form_validation->set_rules('tanggal_pesanan', 'Tanggal Pemesanan', 'required');
						$this->form_validation->set_rules('jenis_sp', 'Jenis SP', 'required');
						//$this->form_validation->set_rules('lembaga', 'Nama Lembaga', 'required');
						$this->form_validation->set_rules('pelanggan', 'Nama Pelanggan', 'required');
						$this->form_validation->set_rules('sumber', 'Sumber Dana', 'required');
												
						$this->form_validation->set_rules('mitra', 'Nama Mitra', 'required');
						$this->form_validation->set_rules('sistem_transaksi', 'Sistem Transaksi', 'required');
						$this->form_validation->set_rules('tahap_anggaran', 'Tahap Anggaran', 'required');
						$this->form_validation->set_rules('tahun_anggaran', 'Tahun Anggaran', 'required');
						$this->form_validation->set_rules('diskon', 'Diskon', 'required');
						$this->form_validation->set_rules('uang_muka', 'Uang Muka', 'trim|numeric|required');
						//$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$id_kasir        = $idpengguna;

							//format nomor SP tahun bulan tanggal nomor urut
							$nomor_urut_nota     = $this->input->post('nomor_nota');

							$tanggal_pesanan     = $this->input->post('tanggal_pesanan');
							$t = explode("-", $tanggal_pesanan);
							$format_sp = ($t[0] . $t[1] . $t[2]); //tahun-bulan-tanggal

							$nomor_sp     = 'SP' . $format_sp . sprintf("%05s", $nomor_urut_nota).$idUser;

							$idsumber_dana    = $this->input->post('sumber');
							$id_pelanggan    = $this->input->post('pelanggan');

							#id lembaga diambil dari field pelanggan							
							//$id_lembaga    = $this->input->post('lembaga');
							$pel = $this->db->get_where('pelanggan', array('id' => $id_pelanggan))->result();

							$id_lembaga =  (isset($pel[0]->id_lembaga) ? $pel[0]->id_lembaga : '0'); 

							$id_mitra    = $this->input->post('mitra');
							$sistem_transaksi    = $this->input->post('sistem_transaksi');
							$tanggal_jatuh_tempo    = $this->input->post('tanggal_jatuh_tempo');
							$tahap_anggaran    = $this->input->post('tahap_anggaran');
							$tahun_anggaran    = $this->input->post('tahun_anggaran');
							$cv_pelaksana    = $this->input->post('cv_pelaksana');
							$ppn    = $this->input->post('ppn');
							$pph22    = $this->input->post('pph22');
							$pph23   = $this->input->post('pph23');

							$jenis_sp            = $this->input->post('jenis_sp');
							$netto            = $this->input->post('netto');
							$diskon            = $this->input->post('diskon');
							$netto_bayar            = $this->input->post('netto_bayar');

							$grand_total    = $this->input->post('grand_total');
							$uang_muka            = $this->input->post('uang_muka');
							$SisaBayar    = $this->input->post('SisaBayar');
							$SisaBayarHidden    = $this->input->post('SisaBayarHidden');

							#cek kalo nomor SP sudah ada jangan rubah nomor urut
							$cek_nomor_sp = $this->transaksi_model->get_nomor_sp($nomor_sp);

							if ($cek_nomor_sp->num_rows() > 0) {
								$idmaster_old = $cek_nomor_sp->row();
								echo json_encode(array(
									'status' => 0,
									"pesan" => "<font color='red'><i class='fa fa-warning'></i> Surat Pesanan untuk nomor " . $nomor_sp . " Sudah dicatat, Untuk transaksi baru Silahkan Klik menu Input Pesanan pada halaman Daftar Surat Pesanan</font>"
								));
							} else {
								//update counter nomor sp
								$dkwt = array('last_number' => $no_urut);
								$this->transaksi_model->update_nomor_sp($dkwt, 1);

								$data_master = array(
									'nomor_sp'      => $nomor_sp,
									'tanggal_sp'    => $tanggal_pesanan,
									'jenis_sp'      => $jenis_sp,
									'grand_total'   => $grand_total,
									'sistem_transaksi' => $sistem_transaksi,
									'sistem_pembayaran' => $sistem_pembayaran,
									'tahun_anggaran' => $tahun_anggaran,
									'tahap_anggaran' => $tahap_anggaran,
									'jatuh_tempo' => $tanggal_jatuh_tempo,
									'id_lembaga' => $id_lembaga,
									'id_pelanggan' => $id_pelanggan,
									'id_mitra' => $id_mitra,
									'id_pelaksana' => $cv_pelaksana,
									'ppn' => $ppn,
									'pph22' => $pph22,
									'pph23' => $pph23,
									'netto' => $netto,
									'diskon' => $diskon,
									'netto_bayar' => $netto_bayar,
									'uang_muka' => $uang_muka,
									'sisa_bayar' => $SisaBayarHidden,
									'idsumber_dana' => $idsumber_dana,
									'id_user' => $id_kasir,
								);

								$master = $this->transaksi_model->insert_master($data_master);

								#return last id inserted
								$lastid_master = $this->db->insert_id();

								if ($master) {
									$inserted    = 0;
									$no_array    = 0;
									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$kode_barang    = $_POST['kode_barang'][$no_array];
											$id_vendor    	= $_POST['id_vendor'][$no_array];
											//$id_barang      = $this->barang_model->get_id($kode_barang)->row()->id_barang;
											$id_barang      = $this->barang_model->get_id_bysupplier($kode_barang, $id_vendor)->row()->id_barang;
											
											$jumlah_beli    = $_POST['jumlah_beli'][$no_array];

											$data_barang = array(
												'id_pesanan_m'  => $lastid_master,
												'id_barang'     => $id_barang,
												'jumlah_beli'   => $jumlah_beli,
												'harga_satuan'  => $_POST['harga_satuan'][$no_array],
												'spesifikasi'   => $_POST['spesifikasi'][$no_array],
												'satuan'        => $_POST['satuan'][$no_array],
												'total'         => $_POST['sub_total'][$no_array],
												'ppn'           => $_POST['ppn11_barang'][$no_array],
												'pph22'         => $_POST['pph21_barang'][$no_array],
												'pph23'         => $_POST['pph23_barang'][$no_array],
												'harga_pajak'   => $_POST['harga_pajak'][$no_array],
												'diskon_barang' => $_POST['diskon_barang'][$no_array],
												'diskon_nominal' => $_POST['nilai_diskon'][$no_array],
												'harga_diskon'  => $_POST['harga_diskon'][$no_array]
											);

											$insert_detail    = $this->transaksi_model->insert_detail($data_barang);
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
				$data['view']        = 'admin/pesanan/pesanan-form';
				$data['title']        = 'Dashboard ' . ucwords($level);
				$data['nomor_nota']        = $nomor_nota;
				$this->load->view('admin/template', $data);
			}
		}
	}

	#NON BUKU

	public function non_buku()
	{
		date_default_timezone_set('Asia/Jakarta');

		$tglHariIni = date('Y-m-d');
		$th = date('Y');
		$bln = date('m');
		$hr = date('d');
		$tanggal = $sp_bulan_ini = $tAwal = $tAkhir = $id_lembaga = $id_pelanggan = '';

		$title = 'DAFTAR SP NON-BUKU';
		$and = null;
		$jenis_sp = 'non-buku';

		if ($this->input->post('filter', TRUE)) {
			$tAwal = $this->input->post('awal', TRUE);
			$tAkhir = $this->input->post('akhir', TRUE);
			$id_lembaga = $this->input->post('lembaga', TRUE);
			$id_pelanggan = $this->input->post('pelanggan', TRUE);
			$tanggal = $this->tanggal->konversi($tAwal) . ' - ' . $this->tanggal->konversi($tAkhir);
			$title = 'DAFTAR SP NON-BUKU ' . $tanggal;
			$and = "AND date(tanggal_sp) >= '".$tAwal."' AND date(tanggal_sp) <='".$tAkhir."'";
			// $data_where = array('date(tanggal_sp)>=' => '2022-12-01', 'date(tanggal_sp)<=' => '2022-12-30');
		} else {
			$tanggal = $hr . ' ' . $this->tanggal->bulan($bln) . ' ' . $th;
			$sp_bulan_ini = $bln;
			//$data_where = array('date(tanggal_sp)=' => $tglHariIni);
			$and = "AND month(tanggal_sp) = '".$bln."'";
			$title = 'DAFTAR SP NON-BUKU BULAN ' . strtoupper($this->tanggal->bulan($bln)) . ' ' . $th;
		}

		$count_sp = $this->pesanan->count_sp($and, $jenis_sp)->row();
		$count_sp_all = $this->pesanan->count_sp_all($jenis_sp)->row();
		
		$q = $this->pesanan->nominal_pesanan($and, $jenis_sp)->row();


		$data = array(
			'title'         => $title,
			'sp_bulan_ini'  => $sp_bulan_ini,
			'tAwal'    => $tAwal,
			'tAkhir'    => $tAkhir,
			'id_lembaga'    => $id_lembaga,
			'id_pelanggan'    => $id_pelanggan,
			'tanggal'       => $tanggal,
			'count_sp_all'	=>$count_sp_all->jumlah_all,
			'count_sp'	=>$count_sp->jumlah,
			'total_sp'	=> str_replace(',', '.', number_format($q->total_rupiah)),
			'action_filter' => site_url('admin/pesanan/non_buku'),
			'action_cetak' => site_url('admin/cetak/surat_pesanan'),
			'action_delete' => site_url('admin/pesanan/hapus_pesanan_nonbuku'),
			'barang' => $this->msa->get_all('barang', 'id_barang'),
			'view' => 'admin/pesanan/non-buku-list'
		);
		$this->load->view('admin/template', $data);
	}

	public function form_nonbuku()
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('transaksi_model');
		$this->load->model('barang_model');

		$level                 = $this->session->userdata('level');
		$idpengguna            = $this->session->userdata('idPengguna');
		$idUser            	   = $this->session->userdata('id');
		$data['level']        = $level;
		$data['idpengguna']    = $idpengguna;
		$table                 = $this->keamanan->table_pengguna($level);

		$no_urutsp     = $this->transaksi_model->last_nokwitansi(1);
		$last_no        = $no_urutsp->maxs;
		$no_urut             = (($last_no == 0) ? 1 : $last_no += 1);
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
							}
							$no++;
						}

						$sistem_pembayaran    = $this->input->post('sistem_pembayaran');
						$this->form_validation->set_rules('sistem_pembayaran', 'Sistem Pembayaran', 'required');
						if($sistem_pembayaran=='kredit'){
							$this->form_validation->set_rules('tanggal_jatuh_tempo', 'Tanggal Jatuh Tempo', 'required');
						}

						$this->form_validation->set_rules('tanggal_pesanan', 'Tanggal Pemesanan', 'required');
						$this->form_validation->set_rules('jenis_sp', 'Jenis SP', 'required');
						//$this->form_validation->set_rules('lembaga', 'Nama Lembaga', 'required');
						$this->form_validation->set_rules('pelanggan', 'Nama Pelanggan', 'required');
						$this->form_validation->set_rules('sumber', 'Sumber Dana', 'required');
												
						$this->form_validation->set_rules('mitra', 'Nama Marketing', 'required');
						$this->form_validation->set_rules('sistem_transaksi', 'Sistem Transaksi', 'required');
						$this->form_validation->set_rules('tahap_anggaran', 'Tahap Anggaran', 'required');
						$this->form_validation->set_rules('tahun_anggaran', 'Tahun Anggaran', 'required');
						$this->form_validation->set_rules('diskon', 'Diskon', 'required');
						$this->form_validation->set_rules('uang_muka', 'Uang Muka', 'trim|numeric|required');
						//$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {

							//format nomor SP tahun bulan tanggal nomor urut
							$nomor_urut_nota     = $this->input->post('nomor_nota');

							$tanggal_pesanan     = $this->input->post('tanggal_pesanan');
							$t = explode("-", $tanggal_pesanan);
							$format_sp = ($t[0] . $t[1] . $t[2]); //tahun-bulan-tanggal

							$nomor_sp     = 'SP' . $format_sp . sprintf("%05s", $nomor_urut_nota).$idUser;

							$id_kasir        = $idpengguna;
							$idsumber_dana    = $this->input->post('sumber');
							$id_pelanggan    = $this->input->post('pelanggan');

							#id lembaga diambil dari field pelanggan							
							//$id_lembaga    = $this->input->post('lembaga');
							$pel = $this->db->get_where('pelanggan', array('id' => $id_pelanggan))->result();

							$id_lembaga =  (isset($pel[0]->id_lembaga) ? $pel[0]->id_lembaga : '0'); 

							$id_mitra    = $this->input->post('mitra');
							$sistem_transaksi    = $this->input->post('sistem_transaksi');
							$tanggal_jatuh_tempo    = $this->input->post('tanggal_jatuh_tempo');
							$tahap_anggaran    = $this->input->post('tahap_anggaran');
							$tahun_anggaran    = $this->input->post('tahun_anggaran');
							$cv_pelaksana    = $this->input->post('cv_pelaksana');
							$ppn    = $this->input->post('ppn');
							$pph22    = $this->input->post('pph22');
							$pph23   = $this->input->post('pph23');

							$jenis_sp            = $this->input->post('jenis_sp');
							$netto            = $this->input->post('netto');
							$diskon            = $this->input->post('diskon');
							$netto_bayar            = $this->input->post('netto_bayar');

							$grand_total    = $this->input->post('grand_total');
							$uang_muka            = $this->input->post('uang_muka');
							$SisaBayar    = $this->input->post('SisaBayar');
							$SisaBayarHidden    = $this->input->post('SisaBayarHidden');

							#cek kalo nomor SP sudah ada jangan rubah nomor urut
							$cek_nomor_sp = $this->transaksi_model->get_nomor_sp($nomor_sp);

							if ($cek_nomor_sp->num_rows() > 0) {
								$idmaster_old = $cek_nomor_sp->row();
								echo json_encode(array(
									'status' => 0,
									"pesan" => "<font color='red'><i class='fa fa-warning'></i> Surat Pesanan untuk nomor " . $nomor_sp . " Sudah dicatat, Untuk transaksi baru Silahkan Klik menu Input Pesanan pada halaman Daftar Surat Pesanan</font>"
								));
							} else {
								//update counter nomor sp
								$dkwt = array('last_number' => $no_urut);
								$this->transaksi_model->update_nomor_sp($dkwt, 1);

								$data_master = array(
									'nomor_sp'      => $nomor_sp,
									'tanggal_sp'    => $tanggal_pesanan,
									'jenis_sp'      => $jenis_sp,
									'grand_total'   => $grand_total,
									'sistem_transaksi' => $sistem_transaksi,
									'sistem_pembayaran' => $sistem_pembayaran,
									'tahun_anggaran' => $tahun_anggaran,
									'tahap_anggaran' => $tahap_anggaran,
									'jatuh_tempo' => $tanggal_jatuh_tempo,
									'id_lembaga' => $id_lembaga,
									'id_pelanggan' => $id_pelanggan,
									'id_mitra' => $id_mitra,
									'id_pelaksana' => $cv_pelaksana,
									'ppn' => $ppn,
									'pph22' => $pph22,
									'pph23' => $pph23,
									'netto' => $netto,
									'diskon' => $diskon,
									'netto_bayar' => $netto_bayar,
									'uang_muka' => $uang_muka,
									'sisa_bayar' => $SisaBayarHidden,
									'idsumber_dana' => $idsumber_dana,
									'id_user' => $id_kasir,
								);

								$master = $this->transaksi_model->insert_master($data_master);

								#return last id inserted
								$lastid_master = $this->db->insert_id();

								if ($master) {
									$inserted    = 0;
									$no_array    = 0;
									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$kode_barang    = $_POST['kode_barang'][$no_array];
											$id_vendor    	= $_POST['id_vendor'][$no_array];

											//$id_barang      = $this->barang_model->get_id($kode_barang)->row()->id_barang;
											$id_barang      = $this->barang_model->get_id_bysupplier($kode_barang, $id_vendor)->row()->id_barang;
											$jumlah_beli    = $_POST['jumlah_beli'][$no_array];

											$data_barang = array(
												'id_pesanan_m'  => $lastid_master,
												'id_barang'     => $id_barang,
												'jumlah_beli'   => $jumlah_beli,
												'harga_satuan'  => $_POST['hpp_markup'][$no_array],
												'spesifikasi'   => $_POST['spesifikasi'][$no_array],
												'satuan'        => $_POST['satuan'][$no_array],
												'total'         => $_POST['sub_total'][$no_array],
												'ppn'           => $_POST['ppn11_barang'][$no_array],
												'pph22'         => $_POST['pph21_barang'][$no_array],
												'pph23'         => $_POST['pph23_barang'][$no_array],
												'harga_pajak'   => $_POST['harga_pajak'][$no_array],
												'diskon_barang' => $_POST['diskon_barang'][$no_array],
												'diskon_nominal' => $_POST['nilai_diskon'][$no_array],
												'harga_diskon'  => $_POST['harga_diskon'][$no_array]
											);

											$insert_detail    = $this->transaksi_model->insert_detail($data_barang);
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
				$data['view']        = 'admin/pesanan/pesanan-form-nonbuku';
				$data['title']        = 'Dashboard ' . ucwords($level);
				$data['nomor_nota']        = $nomor_nota;
				$this->load->view('admin/template', $data);
			}
		}
	}

	#EDIT PESANAN NON BUKU
	public function edit_nonbuku($jenis_sp, $id_pesanan_m)
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('transaksi_model');
		$this->load->model('barang_model');

		$level                 = $this->session->userdata('level');
		$idpengguna            = $this->session->userdata('idPengguna');
		$idUser            	   = $this->session->userdata('id');

		$data['level']        = $level;
		$data['idpengguna']    = $idpengguna;
		$table                 = $this->keamanan->table_pengguna($level);

		$sp = $this->db->get_where('pesanan_master', array('id_pesanan_m' => $id_pesanan_m))->result();
		$nomor_nota =  (isset($sp[0]->nomor_sp) ? $sp[0]->nomor_sp : '-'); 

		$data['id_pesanan_m']		= $id_pesanan_m;
		$data['jenis_sp']		= $jenis_sp;
		$data['tanggal_sp']		= (isset($sp[0]->tanggal_sp) ? $sp[0]->tanggal_sp : '-');
		$data['id_pelanggan']	= (isset($sp[0]->id_pelanggan) ? $sp[0]->id_pelanggan : '-');
		$data['id_marketing']	= (isset($sp[0]->id_mitra) ? $sp[0]->id_mitra : '-');
		$data['idsumber_dana']	= (isset($sp[0]->idsumber_dana) ? $sp[0]->idsumber_dana : '-');
		$data['sistem_transaksi']	= (isset($sp[0]->sistem_transaksi) ? $sp[0]->sistem_transaksi : '-');
		$data['sistem_pembayaran']	= (isset($sp[0]->sistem_pembayaran) ? $sp[0]->sistem_pembayaran : '-');
		$data['jatuh_tempo']	= (isset($sp[0]->jatuh_tempo) ? $sp[0]->jatuh_tempo : '0000-00-00');
		$data['tahun_anggaran']	= (isset($sp[0]->tahun_anggaran) ? $sp[0]->tahun_anggaran : '-');
		$data['tahap_anggaran']	= (isset($sp[0]->tahap_anggaran) ? $sp[0]->tahap_anggaran : '-');
		$data['id_pelaksana']	= (isset($sp[0]->id_pelaksana) ? $sp[0]->id_pelaksana : '-');
		$data['uang_muka']	= (isset($sp[0]->uang_muka) ? $sp[0]->uang_muka : '0');
		$data['sisa_bayar']	= (isset($sp[0]->sisa_bayar) ? $sp[0]->sisa_bayar : '0');

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
							}
							$no++;
						}

						$sistem_pembayaran    = $this->input->post('sistem_pembayaran');
						$this->form_validation->set_rules('sistem_pembayaran', 'Sistem Pembayaran', 'required');
						if($sistem_pembayaran=='kredit'){
							$this->form_validation->set_rules('tanggal_jatuh_tempo', 'Tanggal Jatuh Tempo', 'required');
						}

						$this->form_validation->set_rules('tanggal_pesanan', 'Tanggal Pemesanan', 'required');
						$this->form_validation->set_rules('jenis_sp', 'Jenis SP', 'required');
						//$this->form_validation->set_rules('lembaga', 'Nama Lembaga', 'required');
						$this->form_validation->set_rules('pelanggan', 'Nama Pelanggan', 'required');
						$this->form_validation->set_rules('sumber', 'Sumber Dana', 'required');
												
						$this->form_validation->set_rules('mitra', 'Nama Marketing', 'required');
						$this->form_validation->set_rules('sistem_transaksi', 'Sistem Transaksi', 'required');
						$this->form_validation->set_rules('tahap_anggaran', 'Tahap Anggaran', 'required');
						$this->form_validation->set_rules('tahun_anggaran', 'Tahun Anggaran', 'required');
						$this->form_validation->set_rules('diskon', 'Diskon', 'required');
						$this->form_validation->set_rules('uang_muka', 'Uang Muka', 'trim|numeric|required');
						//$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {

							#HAPUS DULU SP YANG LAMA:
							$this->msa->delete('pesanan_master', 'id_pesanan_m', $id_pesanan_m);
							$this->msa->delete('pesanan_detail', 'id_pesanan_m', $id_pesanan_m);
							//format nomor SP tahun bulan tanggal nomor urut
							//$nomor_urut_nota     = $this->input->post('nomor_nota');

							$tanggal_pesanan     = $this->input->post('tanggal_pesanan');
							//$t = explode("-", $tanggal_pesanan);
							//$format_sp = ($t[0] . $t[1] . $t[2]); //tahun-bulan-tanggal

							//$nomor_sp     = 'SP' . $format_sp . sprintf("%05s", $nomor_urut_nota).$idUser;
							$nomor_sp     = $this->input->post('nomor_nota');

							$id_kasir        = $idpengguna;
							$idsumber_dana    = $this->input->post('sumber');
							$id_pelanggan    = $this->input->post('pelanggan');

							#id lembaga diambil dari field pelanggan							
							//$id_lembaga    = $this->input->post('lembaga');
							$pel = $this->db->get_where('pelanggan', array('id' => $id_pelanggan))->result();

							$id_lembaga =  (isset($pel[0]->id_lembaga) ? $pel[0]->id_lembaga : '0'); 

							$id_mitra    = $this->input->post('mitra');
							$sistem_transaksi    = $this->input->post('sistem_transaksi');
							$tanggal_jatuh_tempo    = $this->input->post('tanggal_jatuh_tempo');
							$tahap_anggaran    = $this->input->post('tahap_anggaran');
							$tahun_anggaran    = $this->input->post('tahun_anggaran');
							$cv_pelaksana    = $this->input->post('cv_pelaksana');
							$ppn    = $this->input->post('ppn');
							$pph22    = $this->input->post('pph22');
							$pph23   = $this->input->post('pph23');

							$jenis_sp            = $this->input->post('jenis_sp');
							$netto            = $this->input->post('netto');
							$diskon            = $this->input->post('diskon');
							$netto_bayar            = $this->input->post('netto_bayar');

							$grand_total    = $this->input->post('grand_total');
							$uang_muka            = $this->input->post('uang_muka');
							$SisaBayar    = $this->input->post('SisaBayar');
							$SisaBayarHidden    = $this->input->post('SisaBayarHidden');

							#cek kalo nomor SP sudah ada jangan rubah nomor urut
							//$cek_nomor_sp = $this->transaksi_model->get_nomor_sp($nomor_sp);

							$data_master = array(
								'nomor_sp'      => $nomor_sp,
								'tanggal_sp'    => $tanggal_pesanan,
								'jenis_sp'      => $jenis_sp,
								'grand_total'   => $grand_total,
								'sistem_transaksi' => $sistem_transaksi,
								'sistem_pembayaran' => $sistem_pembayaran,
								'tahun_anggaran' => $tahun_anggaran,
								'tahap_anggaran' => $tahap_anggaran,
								'jatuh_tempo' => $tanggal_jatuh_tempo,
								'id_lembaga' => $id_lembaga,
								'id_pelanggan' => $id_pelanggan,
								'id_mitra' => $id_mitra,
								'id_pelaksana' => $cv_pelaksana,
								'ppn' => $ppn,
								'pph22' => $pph22,
								'pph23' => $pph23,
								'netto' => $netto,
								'diskon' => $diskon,
								'netto_bayar' => $netto_bayar,
								'uang_muka' => $uang_muka,
								'sisa_bayar' => $SisaBayarHidden,
								'idsumber_dana' => $idsumber_dana,
								'id_user' => $id_kasir,
							);

							$master = $this->transaksi_model->insert_master($data_master);

							#return last id inserted
							$lastid_master = $this->db->insert_id();

							if ($master) {
								$inserted    = 0;
								$no_array    = 0;
								foreach ($_POST['kode_barang'] as $k) {
									if (!empty($k)) {
										$kode_barang    = $_POST['kode_barang'][$no_array];
										$id_vendor    	= $_POST['id_vendor'][$no_array];

										//$id_barang      = $this->barang_model->get_id($kode_barang)->row()->id_barang;
										$id_barang      = $this->barang_model->get_id_bysupplier($kode_barang, $id_vendor)->row()->id_barang;
										// $id_barang      = $this->barang_model->get_id($kode_barang)->row()->id_barang;
										$jumlah_beli    = $_POST['jumlah_beli'][$no_array];

										$data_barang = array(
											'id_pesanan_m'  => $lastid_master,
											'id_barang'     => $id_barang,
											'jumlah_beli'   => $jumlah_beli,
											'harga_satuan'  => $_POST['hpp_markup'][$no_array],
											'spesifikasi'   => $_POST['spesifikasi'][$no_array],
											'satuan'        => $_POST['satuan'][$no_array],
											'total'         => $_POST['sub_total'][$no_array],
											'ppn'           => $_POST['ppn11_barang'][$no_array],
											'pph22'         => $_POST['pph21_barang'][$no_array],
											'pph23'         => $_POST['pph23_barang'][$no_array],
											'harga_pajak'   => $_POST['harga_pajak'][$no_array],
											'diskon_barang' => $_POST['diskon_barang'][$no_array],
											'diskon_nominal' => $_POST['nilai_diskon'][$no_array],
											'harga_diskon'  => $_POST['harga_diskon'][$no_array]
										);

										$insert_detail    = $this->transaksi_model->insert_detail($data_barang);
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
				$data['view']        = 'admin/pesanan/pesanan-form-edit-nonbuku';
				$data['title']        = 'Dashboard ' . ucwords($level);
				$data['nomor_nota']        = $nomor_nota;
				$this->load->view('admin/template', $data);
			}
		}		


	}
	#EDIT PESANAN BUKU
	public function edit($jenis_sp, $id_pesanan_m)
	{
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('transaksi_model');
		$this->load->model('barang_model');

		$level                 = $this->session->userdata('level');
		$idpengguna            = $this->session->userdata('idPengguna');
		$idUser            	   = $this->session->userdata('id');

		$data['level']        = $level;
		$data['idpengguna']    = $idpengguna;
		$table                 = $this->keamanan->table_pengguna($level);

		$sp = $this->db->get_where('pesanan_master', array('id_pesanan_m' => $id_pesanan_m))->result();
		$nomor_nota =  (isset($sp[0]->nomor_sp) ? $sp[0]->nomor_sp : '-'); 

		$data['id_pesanan_m']		= $id_pesanan_m;
		$data['jenis_sp']		= $jenis_sp;
		$data['tanggal_sp']		= (isset($sp[0]->tanggal_sp) ? $sp[0]->tanggal_sp : '-');
		$data['id_pelanggan']	= (isset($sp[0]->id_pelanggan) ? $sp[0]->id_pelanggan : '-');
		$data['id_marketing']	= (isset($sp[0]->id_mitra) ? $sp[0]->id_mitra : '-');
		$data['idsumber_dana']	= (isset($sp[0]->idsumber_dana) ? $sp[0]->idsumber_dana : '-');
		$data['sistem_transaksi']	= (isset($sp[0]->sistem_transaksi) ? $sp[0]->sistem_transaksi : '-');
		$data['sistem_pembayaran']	= (isset($sp[0]->sistem_pembayaran) ? $sp[0]->sistem_pembayaran : '-');
		$data['jatuh_tempo']	= (isset($sp[0]->jatuh_tempo) ? $sp[0]->jatuh_tempo : '0000-00-00');
		$data['tahun_anggaran']	= (isset($sp[0]->tahun_anggaran) ? $sp[0]->tahun_anggaran : '-');
		$data['tahap_anggaran']	= (isset($sp[0]->tahap_anggaran) ? $sp[0]->tahap_anggaran : '-');
		$data['id_pelaksana']	= (isset($sp[0]->id_pelaksana) ? $sp[0]->id_pelaksana : '-');
		$data['uang_muka']	= (isset($sp[0]->uang_muka) ? $sp[0]->uang_muka : '0');
		$data['sisa_bayar']	= (isset($sp[0]->sisa_bayar) ? $sp[0]->sisa_bayar : '0');

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
							}
							$no++;
						}

						$sistem_transaksi    = $this->input->post('sistem_transaksi');

						#KALO KREDIT WAJIB ISI TANGGAL JATUH TEMPO
						if($sistem_transaksi == 'kredit'){
							$this->form_validation->set_rules('tanggal_jatuh_tempo', 'Tanggal Jatuh Tempo', 'required');						
						}

						$this->form_validation->set_rules('tanggal_pesanan', 'Tanggal Pemesanan', 'required');
						$this->form_validation->set_rules('jenis_sp', 'Jenis SP', 'required');
						//$this->form_validation->set_rules('lembaga', 'Nama Lembaga', 'required');
						$this->form_validation->set_rules('pelanggan', 'Nama Pelanggan', 'required');
						$this->form_validation->set_rules('sumber', 'Sumber Dana', 'required');
												
						$this->form_validation->set_rules('mitra', 'Nama Mitra', 'required');
						$this->form_validation->set_rules('sistem_transaksi', 'Sistem Transaksi', 'required');
						$this->form_validation->set_rules('sistem_pembayaran', 'Sistem Pembayaran', 'required');
						$this->form_validation->set_rules('tahap_anggaran', 'Tahap Anggaran', 'required');
						$this->form_validation->set_rules('tahun_anggaran', 'Tahun Anggaran', 'required');
						$this->form_validation->set_rules('diskon', 'Diskon', 'required');
						$this->form_validation->set_rules('uang_muka', 'Uang Muka', 'trim|numeric|required');
						//$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {

							// echo json_encode(array('status' => 1, 'pesan' => "tessss !"));


							#HAPUS DULU SP YANG LAMA:
							$this->msa->delete('pesanan_master', 'id_pesanan_m', $id_pesanan_m);
							$this->msa->delete('pesanan_detail', 'id_pesanan_m', $id_pesanan_m);


							//format nomor SP tahun bulan tanggal nomor urut
							//$nomor_urut_nota     = $this->input->post('nomor_nota');
							$tanggal_pesanan     = $this->input->post('tanggal_pesanan');
							// $t = explode("-", $tanggal_pesanan);
							// $format_sp = ($t[0] . $t[1] . $t[2]); //tahun-bulan-tanggal

							$nomor_sp     = $this->input->post('nomor_nota');

							$id_kasir        = $idpengguna;
							$idsumber_dana    = $this->input->post('sumber');
							$id_pelanggan    = $this->input->post('pelanggan');

							#id lembaga diambil dari field pelanggan							
							//$id_lembaga    = $this->input->post('lembaga');
							$pel = $this->db->get_where('pelanggan', array('id' => $id_pelanggan))->result();

							$id_lembaga =  (isset($pel[0]->id_lembaga) ? $pel[0]->id_lembaga : '0'); 

							$id_mitra    = $this->input->post('mitra');
							$sistem_pembayaran    = $this->input->post('sistem_pembayaran');
							$tanggal_jatuh_tempo    = $this->input->post('tanggal_jatuh_tempo');
							$tahap_anggaran    = $this->input->post('tahap_anggaran');
							$tahun_anggaran    = $this->input->post('tahun_anggaran');
							$cv_pelaksana    = $this->input->post('cv_pelaksana');
							$ppn    = $this->input->post('ppn');
							$pph22    = $this->input->post('pph22');
							$pph23   = $this->input->post('pph23');

							$jenis_sp            = $this->input->post('jenis_sp');
							$netto            = $this->input->post('netto');
							$diskon            = $this->input->post('diskon');
							$netto_bayar            = $this->input->post('netto_bayar');

							$grand_total    = $this->input->post('grand_total');
							$uang_muka            = $this->input->post('uang_muka');
							$SisaBayar    = $this->input->post('SisaBayar');
							$SisaBayarHidden    = $this->input->post('SisaBayarHidden');

							#cek kalo nomor SP sudah ada jangan rubah nomor urut
							// $cek_nomor_sp = $this->transaksi_model->get_nomor_sp($nomor_sp);
							$data_master = array(
								'nomor_sp'      => $nomor_sp,
								'tanggal_sp'    => $tanggal_pesanan,
								'jenis_sp'      => $jenis_sp,
								'grand_total'   => $grand_total,
								'sistem_transaksi' => $sistem_transaksi,
								'sistem_pembayaran' => $sistem_pembayaran,
								'tahun_anggaran' => $tahun_anggaran,
								'tahap_anggaran' => $tahap_anggaran,
								'jatuh_tempo' => $tanggal_jatuh_tempo,
								'id_lembaga' => $id_lembaga,
								'id_pelanggan' => $id_pelanggan,
								'id_mitra' => $id_mitra,
								'id_pelaksana' => $cv_pelaksana,
								'ppn' => $ppn,
								'pph22' => $pph22,
								'pph23' => $pph23,
								'netto' => $netto,
								'diskon' => $diskon,
								'netto_bayar' => $netto_bayar,
								'uang_muka' => $uang_muka,
								'sisa_bayar' => $SisaBayarHidden,
								'idsumber_dana' => $idsumber_dana,
								'id_user' => $id_kasir,
							);

							$master = $this->transaksi_model->insert_master($data_master);

							#return last id inserted
							$lastid_master = $this->db->insert_id();

							if ($master) {
								$inserted    = 0;
								$no_array    = 0;
								foreach ($_POST['kode_barang'] as $k) {
									if (!empty($k)) {
										$kode_barang    = $_POST['kode_barang'][$no_array];
										$id_vendor    	= $_POST['id_vendor'][$no_array];
										//$id_barang      = $this->barang_model->get_id($kode_barang)->row()->id_barang;
										$id_barang      = $this->barang_model->get_id_bysupplier($kode_barang, $id_vendor)->row()->id_barang;
																			
										$jumlah_beli    = $_POST['jumlah_beli'][$no_array];

										$data_barang = array(
											'id_pesanan_m'  => $lastid_master,
											'id_barang'     => $id_barang,
											'jumlah_beli'   => $jumlah_beli,
											'harga_satuan'  => $_POST['harga_satuan'][$no_array],
											'spesifikasi'   => $_POST['spesifikasi'][$no_array],
											'satuan'        => $_POST['satuan'][$no_array],
											'total'         => $_POST['sub_total'][$no_array],
											'ppn'           => $_POST['ppn11_barang'][$no_array],
											'pph22'         => $_POST['pph21_barang'][$no_array],
											'pph23'         => $_POST['pph23_barang'][$no_array],
											'harga_pajak'   => $_POST['harga_pajak'][$no_array],
											'diskon_barang' => $_POST['diskon_barang'][$no_array],
											'diskon_nominal' => $_POST['nilai_diskon'][$no_array],
											'harga_diskon'  => $_POST['harga_diskon'][$no_array]
										);

										$insert_detail    = $this->transaksi_model->insert_detail($data_barang);
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
				$data['view']        = 'admin/pesanan/pesanan-form-edit';
				$data['title']        = 'Dashboard ' . ucwords($level);
				$data['nomor_nota']        = $nomor_nota;
				$this->load->view('admin/template', $data);
			}
		}
	}




	public function cek_kode_barang($kode)
	{
		$this->load->model('barang_model');
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

	public function hapus_pesanan_buku()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id_pesanan_m'));


		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->delete('pesanan_master', 'id_pesanan_m', $id);
		$this->msa_model->delete('pesanan_detail', 'id_pesanan_m', $id);
		// $this->msa_model->update('pesanan_master', 'id_pesanan_m', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Semua data terkait surat pesanan telah dihapus'));
		}
		redirect(site_url('admin/pesanan/daftar/deleted-success'));
	}	

	public function hapus_pesanan_nonbuku()
	{
		$this->load->model('msa_model');

		$id = $this->keamanan->post($this->input->post('id_pesanan_m'));


		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->delete('pesanan_master', 'id_pesanan_m', $id);
		$this->msa_model->delete('pesanan_detail', 'id_pesanan_m', $id);
		// $this->msa_model->update('pesanan_master', 'id_pesanan_m', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Semua data terkait surat pesanan non-buku telah dihapus'));
		}
		redirect(site_url('admin/pesanan/non_buku'));
	}	


}

/* End of file admin/Pesanan.php */
