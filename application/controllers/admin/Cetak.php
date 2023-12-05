<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cetak extends Auth_Controller
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
		redirect('admin/dashboard');
	}

	public function surat_pesanan()
	{
		$this->load->model('barang_model', 'barang');
		$this->load->model('transaksi_model', 'transaksi');
		date_default_timezone_set('Asia/Jakarta');

		$id_pesanan_m = $this->keamanan->post($this->input->post('id_pesanan_m'));
		if (empty($id_pesanan_m)) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Surat Pesanan Tidak Dapat Dicetak'));
			redirect('admin/pesanan');
		} else {

			$profil = $this->db->get_where('profil_perusahaan', array('id' => 1))->result();


			//$this->load->library('Fpdf/fpdf');
			//$pdf = new FPDF('P', 'mm', 'A4');
			//$pdf->AddPage();
			
			$this->load->library('PDF_MC_Table');		

			$pdf=new PDF_MC_Table('P','mm','Letter');
			$pdf->AddPage();
				
			
			$pdf->SetFont('Arial', '', 7);
			//SetMargins(float left, float top [, float right])
			$pdf->SetLeftMargin(5);
			$pdf->Ln();
			//$pdf->Cell(143, 7, 'Kintan MS Glow Cianjur', 0, 1, 'L'); 

			// $logo = base_url() . 'assets/img/logo1.png';
			// $pdf->Image($logo, 10, 8, 50);
			// $pdf->Ln();

			// $pdf->Cell(190, 15, '', 0, 1, 'L');
			// $pdf->SetTextColor(255, 140, 0); //orange

			// $pdf->Cell(190, 4, isset($profil[0]->alamat) ? $profil[0]->alamat : '', 0, 1, 'L');
			// $pdf->Cell(190, 4, 'Website: ' . ((isset($profil[0]->website) ? $profil[0]->website : '') .
			// 	', email: ' . (isset($profil[0]->email) ? $profil[0]->email : '')), 0, 1, 'L');
			// $pdf->Cell(190, 4, (isset($profil[0]->tlp) ? $profil[0]->tlp : '') . ' NPWP: ' . (isset($profil[0]->npwp) ? $profil[0]->npwp : ''), 0, 1, 'L');

			$pdf->Ln(7);
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->Cell(190, 7, 'SURAT PESANAN', 0, 1, 'C');
			$pdf->Line(6, 24, 200, 24);
			$pdf->Line(6, 25, 200, 25);
			$pdf->Ln(3);
			$pdf->SetFont('Arial', '', 7);

			$this->load->helper('text');

			$pesanan_m = $this->db->get_where('pesanan_master', array('id_pesanan_m' => $id_pesanan_m))->result();
			$lembaga = $this->db->get_where('lembaga', array('id' => $pesanan_m[0]->id_lembaga))->result();
			$pelanggan = $this->db->get_where('pelanggan', array('id' => $pesanan_m[0]->id_pelanggan))->result();
			$qdana = $this->db->get_where('sumber_dana', array('id' => $pesanan_m[0]->idsumber_dana))->result();

			$pdf->Cell(30, 5, 'Tanggal SP', 0, 0, 'L');
			$pdf->Cell(80, 5, ': ' . $this->tanggal->konversi($pesanan_m[0]->tanggal_sp), 0, 0, 'L');
			$pdf->Cell(30, 5, 'Sumber Dana', 0, 0, 'L');
			$pdf->Cell(45, 5, ': ' . (isset($qdana[0]->sumber_dana) ? $qdana[0]->sumber_dana : ''), 0, 1, 'L');

			$pdf->Cell(30, 5, 'Nomor SP', 0, 0, 'L');
			$pdf->Cell(80, 5, ': ' . $pesanan_m[0]->nomor_sp, 0, 0, 'L');
			$pdf->Cell(30, 5, 'Anggaran Tahap Ke', 0, 0, 'L');
			$pdf->Cell(55, 5, ': ' . $pesanan_m[0]->tahap_anggaran, 0, 1, 'L');

			$pdf->Cell(30, 5, 'Jenis SP', 0, 0, 'L');
			$pdf->Cell(80, 5, ': ' . ucwords(strtolower($pesanan_m[0]->jenis_sp)), 0, 0, 'L');
			$pdf->Cell(30, 5, 'Tahun Anggaran', 0, 0, 'L');
			$pdf->Cell(55, 5, ': ' . $pesanan_m[0]->tahun_anggaran, 0, 1, 'L');


			$pdf->Cell(30, 5, 'Sistem Transaksi', 0, 0, 'L');
			$pdf->Cell(80, 5, ': ' . strtoupper($pesanan_m[0]->sistem_transaksi), 0, 0, 'L');
			$pdf->Cell(30, 5, 'Tanggal Jatuh Tempo', 0, 0, 'L');
			$pdf->Cell(45, 5, ': ' . (($pesanan_m[0]->jatuh_tempo != NULL) ? $this->tanggal->konversi($pesanan_m[0]->jatuh_tempo):'-'), 0, 1, 'L');

			$pdf->Cell(30, 5, 'Sistem Pembayaran', 0, 0, 'L');
			$pdf->Cell(80, 5, ': ' . strtoupper($pesanan_m[0]->sistem_pembayaran), 0, 0, 'L');
			$pdf->Cell(30, 5, 'Kode Pelanggan', 0, 0, 'L');
			$pdf->Cell(45, 5, ': ' . (isset($pelanggan[0]->kode) ? $pelanggan[0]->kode : ''), 0, 1, 'L');

			$pdf->Cell(30, 5, 'Kode Lembaga', 0, 0, 'L');
			$pdf->Cell(80, 5, ': ' . (isset($lembaga[0]->kode) ? $lembaga[0]->kode : ''), 0, 0, 'L');
			$pdf->Cell(30, 5, 'Nama Pelanggan', 0, 0, 'L');
			$pdf->Cell(45, 5, ': ' . (isset($pelanggan[0]->nama_pelanggan) ? $pelanggan[0]->nama_pelanggan : ''), 0, 1, 'L');

			$pdf->Cell(30, 5, 'Nama Lembaga', 0, 0, 'L');
			$pdf->Cell(80, 5, ': ' . (isset($lembaga[0]->nama_lembaga) ? $lembaga[0]->nama_lembaga : ''), 0, 0, 'L');
			$pdf->Cell(30, 5, 'Jabatan Pelanggan', 0, 0, 'L');
			$pdf->Cell(45, 5, ': ' . (isset($pelanggan[0]->jabatan) ? $pelanggan[0]->jabatan : ''), 0, 1, 'L');

			$pdf->Cell(30, 5, '', 0, 0, 'L');
			$pdf->Cell(80, 5, '' .'', 0, 0, 'L');
			$pdf->Cell(30, 5, 'Kontak Pelanggan', 0, 0, 'L');
			$pdf->Cell(45, 5, ': ' . (isset($pelanggan[0]->kontak) ? $pelanggan[0]->kontak : ''), 0, 1, 'L');
			
			$pdf->Ln(1);
			$pdf->Cell(30, 5, 'Alamat Lembaga', 0, 0, 'L');
			$pdf->Cell(2, 5, ':', 0, 0, 'L');
			$pdf->MultiCell(165, 5, (isset($lembaga[0]->alamat) ? $lembaga[0]->alamat : ''), 0, 1);

			$pdf->Ln(8);
			
			$pdf->Cell(197, 5, 'Kepada Yth,', 0, 1, 'L');
			$pdf->Cell(197, 5, 'Dani Hermawan, S.Pd', 0, 1, 'L');
			$pdf->Cell(197, 5, 'Direktur CV. Mega Setia Abadi', 0, 1, 'L');
			$pdf->Cell(197, 5, 'JL. Cangklek No. 61 RT. 004 RW. 01 Ds. Sukamanah', 0, 1, 'L');
			$pdf->Cell(197, 5, 'Kec. Cugenang Kab. Cianjur', 0, 1, 'L');

			$pdf->Ln(8);
			$pdf->Cell(197, 5, 'Dengan Hormat,', 0, 1, 'L');
			$pdf->Cell(197, 5, 'Melalui surat ini kami memesan barang sebagaimana rincian di bawah ini :', 0, 1, 'L');

			$pdf->Ln(3);
			$pdf->Cell(7, 5, 'NO', 1, 0, 'C');
			$pdf->Cell(20, 5, 'KODE BARANG', 1, 0, 'C');
			$pdf->Cell(85, 5, 'NAMA BARANG', 1, 0, 'C');
			$pdf->Cell(20, 5, 'SPESIFIKASI', 1, 0, 'C');
			$pdf->Cell(15, 5, 'SATUAN', 1, 0, 'C');
			$pdf->Cell(20, 5, 'HARGA', 1, 0, 'C');
			$pdf->Cell(10, 5, 'QTY', 1, 0, 'C');
			$pdf->Cell(20, 5, 'JUMLAH', 1, 1, 'C');

			$pesanan_d = $this->db->order_by('id_pesanan_d', 'ASC')->get_where('pesanan_detail', array('id_pesanan_m' => $id_pesanan_m))->result();

			$pdf->SetWidths(array(7,20,85,20,15,20,10,20));
			$pdf->SetAligns(array('','','','','C','R','C','R'));


			$no = 0;
			foreach ($pesanan_d as $kd) {

				if (!empty($kd->id_barang)) {
					$id_barang = $kd->id_barang;
					$barang = $this->db->get_where('barang', array('id_barang' => $id_barang))->result();

					$nama_barang = (isset($barang[0]->nama_barang) ? strtoupper(html_entity_decode($barang[0]->nama_barang)) : '');
					// $pdf->Cell(7, 5, ++$no, 1, 0, 'C');
					// $pdf->Cell(20, 5, (isset($barang[0]->kode_barang) ? $barang[0]->kode_barang : ''), 1, 0, 'R');
					// $pdf->Cell(75, 5, $nama_barang, 1, 0, 'L');
					// $pdf->Cell(30, 5, $kd->spesifikasi, 1, 0, 'L');
					// $pdf->Cell(15, 5, $kd->satuan, 1, 0, 'C');
					// $pdf->Cell(20, 5, str_replace(',', '.', number_format($kd->harga_satuan)), 1, 0, 'C');
					// $pdf->Cell(10, 5, $kd->jumlah_beli, 1, 0, 'C');
					// $pdf->Cell(20, 5, str_replace(',', '.', number_format($kd->total)), 1, 1, 'R');

					$pdf->Row(array(
                        ++$no,
                        (isset($barang[0]->kode_barang) ? $barang[0]->kode_barang : ''),
                        $nama_barang,
                        $kd->spesifikasi,
                        $kd->satuan,
                        str_replace(',', '.', number_format($kd->harga_satuan)),
                        $kd->jumlah_beli,
                        str_replace(',', '.', number_format($kd->total))     
					));

					//$no++;
				}
			}
			$pdf->Cell(147, 5, '', 0, 0, 'R');
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(30, 5, 'TOTAL', 1, 0, 'C');
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(20, 5, str_replace(',', '.', number_format($pesanan_m[0]->grand_total)), 1, 1, 'R');

			$pdf->SetFont('Arial', '', 7);

			$pdf->Ln(8);
			$pdf->Cell(197, 5, 'Kami harap bisa menerima barang paling lambat 14 hari setelah pesanan ini dibuat', 0, 1, 'L');
			$pdf->Cell(197, 5, 'Demikian surat ini kami sampaikan atas perhatian dan kerjasama saudara kami ucapkan terimakasih. :', 0, 1, 'L');

			$pdf->Ln(2);

			$pdf->Cell(147, 5, '', 0, 0, 'R');
			$pdf->Cell(30, 5, 'Pemesan,', 0, 1, 'L');

			$pdf->Ln(25);
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(147, 5, '', 0, 0, 'R');
			$pdf->Cell(30, 5, (isset($pelanggan[0]->nama_pelanggan) ? $pelanggan[0]->nama_pelanggan : ''), 0, 1, 'L');
			$pdf->Cell(147, 3, '', 0, 0, 'R');
			$pdf->MultiCell(55, 4, (isset($pelanggan[0]->jabatan) ? $pelanggan[0]->jabatan : ''), 0, 'L');
			//$pdf->MultiCell(165, 5, (isset($lembaga[0]->alamat) ? $lembaga[0]->alamat : ''), 0, 1);

			//$pdf->Cell(30, 4, (isset($pelanggan[0]->jabatan) ? $pelanggan[0]->jabatan : ''), 0, 0, 'L');

			$pdf->Output();
		}
	}

	public function slip_gaji()
	{
		$this->load->model('msa_model', 'msa');
		date_default_timezone_set('Asia/Jakarta');

		$id_penggajian = $this->keamanan->post($this->input->post('id_penggajian'));
		if (empty($id_penggajian)) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Slip Gaji Tidak Dapat Dicetak'));
			redirect('admin/kepegawaian/penggajian');
		} else {

			$profil = $this->db->get_where('profil_perusahaan', array('id' => 1))->result();


			$this->load->library('cfpdf');
			$pdf = new FPDF('P', 'mm', 'A4');
			$pdf->AddPage();
			$pdf->SetFont('Arial', '', 7);
			//SetMargins(float left, float top [, float right])
			$pdf->SetLeftMargin(10);
			$pdf->Ln();
			//$pdf->Cell(143, 7, 'Kintan MS Glow Cianjur', 0, 1, 'L'); 

			$logo = base_url() . 'assets/img/logo1.png';
			$pdf->Image($logo, 10, 8, 50);
			$pdf->Ln();

			$pdf->Cell(190, 15, '', 0, 1, 'L');
			$pdf->SetTextColor(255, 140, 0); //orange

			$pdf->Cell(190, 4, isset($profil[0]->alamat) ? $profil[0]->alamat : '', 0, 1, 'L');
			$pdf->Cell(190, 4, 'Website: ' . ((isset($profil[0]->website) ? $profil[0]->website : '') .
				', email: ' . (isset($profil[0]->email) ? $profil[0]->email : '')), 0, 1, 'L');
			$pdf->Cell(190, 4, (isset($profil[0]->tlp) ? $profil[0]->tlp : '') . ' NPWP: ' . (isset($profil[0]->npwp) ? $profil[0]->npwp : ''), 0, 1, 'L');

			$pdf->Ln();
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->Cell(190, 7, 'SLIP GAJI', 0, 1, 'C');
			$pdf->Line(10, 49, 200, 49);
			$pdf->Ln(3);
			$pdf->SetFont('Arial', '', 7);

			$this->load->helper('text');

			$gaji = $this->db->get_where('penggajian', array('id' => $id_penggajian))->result();

			$pdf->Cell(30, 5, 'Pembayaran', 0, 0, 'L');
			$pdf->Cell(80, 5, ': ' . (isset($gaji[0]->bulan) ? $this->tanggal->bulan($gaji[0]->bulan) . ' ' . $gaji[0]->tahun : ''), 0, 1, 'L');
			$pdf->Cell(30, 5, 'Nama Lengkap', 0, 0, 'L');
			$pdf->Cell(45, 5, ': ' . (isset($gaji[0]->nama_pegawai) ? $gaji[0]->nama_pegawai : ''), 0, 1, 'L');

			$pdf->Cell(30, 5, 'Jabatan', 0, 0, 'L');
			$pdf->Cell(80, 5, ': ' . $gaji[0]->jabatan, 0, 0, 'L');

			$pdf->Ln(15);
			$pdf->Cell(7, 5, 'NO', 1, 0, 'C');
			$pdf->Cell(50, 5, 'GAJI POKOK', 1, 0, 'C');
			$pdf->Cell(50, 5, 'POTONGAN', 1, 0, 'C');
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(50, 5, 'TOTAL', 1, 1, 'C');
			$pdf->SetFont('Arial', '', 7);

			$no = 0;

			$pdf->Cell(7, 5, ++$no, 1, 0, 'C');
			$pdf->Cell(50, 5, 'Rp. ' . str_replace(',', '.', number_format(isset($gaji[0]->gaji_pokok) ? $gaji[0]->gaji_pokok : 0)) . ',- ', 1, 0, 'C');
			$pdf->Cell(50, 5, 'Rp. ' . str_replace(',', '.', number_format(isset($gaji[0]->potongan) ? $gaji[0]->potongan : 0)) . ',- ', 1, 0, 'C');
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(50, 5, 'Rp. ' . str_replace(',', '.', number_format(isset($gaji[0]->total) ? $gaji[0]->total : 0)) . ',- ', 1, 0, 'C');
			$no++;

			$pdf->Output('slip_' . $gaji[0]->nama_pegawai . '_' . $gaji[0]->bulan . $gaji[0]->tahun . '.pdf', "D");
		}
	}

	public function slip_laporan_penggajian()
	{
		$this->load->model('msa_model', 'msa');
		date_default_timezone_set('Asia/Jakarta');

		$pilih_bulan = $this->keamanan->post($this->input->post('pilih_bulan'));
		$pilih_tahun = $this->keamanan->post($this->input->post('pilih_tahun'));


		$list_penggajian = $this->db->get_where('penggajian', array('bulan' => $pilih_bulan, 'tahun' => $pilih_tahun))->result();

		if (empty($list_penggajian)) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('error', 'Penggajian Belum Dilakukan!'));
			redirect('admin/kepegawaian/penggajian');
		} else {

			$profil = $this->db->get_where('profil_perusahaan', array('id' => 1))->result();

			$this->load->library('cfpdf');
			$pdf = new FPDF('P', 'mm', 'A4');
			$pdf->AddPage();
			$pdf->SetFont('Arial', '', 7);
			//SetMargins(float left, float top [, float right])
			$pdf->SetLeftMargin(10);
			$pdf->Ln();

			$logo = base_url() . 'assets/img/logo1.png';
			$pdf->Image($logo, 10, 8, 50);
			$pdf->Ln();

			$pdf->Cell(190, 15, '', 0, 1, 'L');
			$pdf->SetTextColor(255, 140, 0); //orange

			$pdf->Cell(190, 4, isset($profil[0]->alamat) ? $profil[0]->alamat : '', 0, 1, 'L');
			$pdf->Cell(190, 4, 'Website: ' . ((isset($profil[0]->website) ? $profil[0]->website : '') .
				', email: ' . (isset($profil[0]->email) ? $profil[0]->email : '')), 0, 1, 'L');
			$pdf->Cell(190, 4, (isset($profil[0]->tlp) ? $profil[0]->tlp : '') . ' NPWP: ' . (isset($profil[0]->npwp) ? $profil[0]->npwp : ''), 0, 1, 'L');

			$pdf->Ln();
			$pdf->SetFont('Arial', 'B', 10);
			$pdf->SetTextColor(0, 0, 0);
			$pdf->Cell(190, 7, 'LAPORAN PENGGAJIAN BULAN ' . strtoupper($this->tanggal->bulan($pilih_bulan)) . ' ' . $pilih_tahun, 0, 1, 'C');
			$pdf->Line(10, 49, 200, 49);
			$pdf->Ln(3);
			$pdf->SetFont('Arial', '', 7);

			$this->load->helper('text');

			$pdf->Ln(15);
			$pdf->Cell(7, 5, 'NO', 1, 0, 'C');
			$pdf->Cell(78, 5, 'NAMA PEGAWAI', 1, 0, 'C');
			$pdf->Cell(30, 5, 'JABATAN', 1, 0, 'C');
			$pdf->Cell(25, 5, 'GAJI POKOK', 1, 0, 'C');
			$pdf->Cell(25, 5, 'POTONGAN', 1, 0, 'C');
			$pdf->Cell(25, 5, 'TOTAL', 1, 1, 'C');

			$no = 0;
			$pengeluaran_bulan_ini = 0;
			foreach ($list_penggajian as $gaji) {
				$pdf->Cell(7, 5, ++$no, 1, 0, 'C');
				$pdf->Cell(78, 5, $gaji->nama_pegawai, 1, 0, 'L');
				$pdf->Cell(30, 5, $gaji->jabatan, 1, 0, 'C');
				$pdf->Cell(25, 5, 'Rp. ' . str_replace(',', '.', number_format($gaji->gaji_pokok)), 1, 0, 'L');
				$pdf->Cell(25, 5, 'Rp. ' . str_replace(',', '.', number_format($gaji->potongan)), 1, 0, 'L');
				$pdf->Cell(25, 5, 'Rp. ' . str_replace(',', '.', number_format($gaji->total)), 1, 1, 'R');

				$no++;
				$pengeluaran_bulan_ini += $gaji->total;
			}
			$pdf->Cell(165, 5, 'TOTAL', 1, 0, 'R');
			$pdf->SetFont('Arial', 'B', 7);
			$pdf->Cell(25, 5, 'Rp. ' . str_replace(',', '.', number_format($pengeluaran_bulan_ini)), 1, 1, 'R');

			$pdf->SetFont('Arial', '', 7);

			$pdf->Output('laporan_gaji_bulan_' . $this->tanggal->bulan($pilih_bulan) . '_' . $pilih_tahun . '.pdf', "D");
		}
	}

	//alert default
	public function messageAlert($type, $title)
	{
		$messageAlert = "
        Swal.fire({
            type: '" . $type . "',
            title: '" . $title . "'
        });
        ";
		return $messageAlert;
	}
}

/* End of file admin/Cetak.php */
