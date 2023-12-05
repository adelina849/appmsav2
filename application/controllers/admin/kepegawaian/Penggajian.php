<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penggajian extends Auth_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->load->model('msa_model', 'msa');
		$this->load->model('kepegawaian_model', 'penggajian');
	}

	public function index()
	{
		$this->daftar();
	}

	public function daftar()
	{

		$bulan = date('n');
		$tahun = date('Y');
		$penggajian_bulan_ini   = '';
		$penggajian_tahun_ini =  '';
		// filter list stok opname
		if ($this->input->post('filter', TRUE)) {
			$bulan_filter = $this->input->post('pilih_bulan', TRUE);
			$tahun_filter = $this->input->post('pilih_tahun', TRUE);
			$title = 'PENGGAJIAN BULAN ' . strtoupper($this->tanggal->bulan($bulan_filter)) . ' TAHUN ' . $tahun_filter;
		} else {
			$penggajian_bulan_ini = $bulan;
			$penggajian_tahun_ini = $tahun;
			$title = 'PENGGAJIAN BULAN ' . strtoupper($this->tanggal->bulan($bulan)) . ' TAHUN ' . $tahun;
		}
		$data = array(
			'title' => $title,
			'penggajian_bulan_ini' => $penggajian_bulan_ini,
			'penggajian_tahun_ini' => $penggajian_tahun_ini,
			'bulan_filter' => $this->input->post('pilih_bulan', TRUE),
			'tahun_filter' => $this->input->post('pilih_tahun', TRUE),
			'action_filter' => site_url('admin/kepegawaian/penggajian/daftar'),
			'action_cetak' => site_url('admin/cetak/slip_gaji'),
			'existing_penggajian' => $this->penggajian->count_existing($bulan, $tahun, 'penggajian'),
			'view' => 'admin/kepegawaian/penggajian-list'
		);
		$this->load->view('admin/template', $data);
	}

	public function ajax_list_penggajian()
	{
		date_default_timezone_set('Asia/Jakarta');

		$penggajian_bulan_ini = $this->input->post('penggajian_bulanini');
		$penggajian_tahun_ini = $this->input->post('penggajian_tahunini');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		if (!(empty($penggajian_bulan_ini) and empty($penggajian_tahun_ini))) {
			$data_wheres = array('bulan' => $penggajian_bulan_ini, 'tahun' => $penggajian_tahun_ini);
		} else {
			$data_wheres = array(
				'bulan' => $bulan,
				'tahun' => $tahun
			);
		}

		$list = $this->penggajian->get_datatables($data_wheres, 'penggajian');

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $key => $d) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">' . $no . '</div>';
			$row[] = '<span>' . $d->nama_pegawai . '</span>';
			$row[] = '<span>' . $d->jabatan . '</span>';
			$row[] = '<span>' . 'Rp. ' . str_replace(',', '.', number_format($d->gaji_pokok)) . '</span>';
			$row[] = '<div class="input-group"><span class="input-group-addon">Rp.</span><input type="text" id="potongan" name="potongan" data-id="' . $d->id_pegawai . '" data-gapok="' . $d->gaji_pokok . '" data-bulan="' . date('n') . '" data-tahun="' . date('Y') . '" value="' . str_replace(',', '.', number_format($d->potongan)) . '" class="form-control" placeholder=".." required></div>';
			$row[] = '<span id="total" data-id="' . $d->id_pegawai . '">' . 'Rp. ' . str_replace(',', '.', number_format($d->total)) . '</span>';
			$row[] = '<div class="text-center">
							<a href="javascript:void(0)" data-toggle="tooltip" title="Cetak Slip Gaji" 
								class="btn btn-alt btn-default cetak" onclick="form_cetak(' . "'" . $d->id . "'" . ')">
								<i class="fa fa-file-pdf-o text-info"></i>
							</a>
						</div>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->penggajian->count_all('penggajian'),
			"recordsFiltered" => $this->penggajian->count_filtered($data_wheres, 'penggajian'),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function baru()
	{
		$data = $this->penggajian->get_data_karyawan();

		$inserted = 0;
		foreach ($data as $d) {

			//variable bulan digunakan untuk get data absensi di bulan sebelumnya
			$bulan = date('n', mktime(0, 0, 0, date("n") - 1, date("d"), date("Y")));

			//variable tahun digunakan untuk get data absensi di tahun tersebut atau tahun sebelumnya (untuk bulan januari)
			if (date('n') == 1) { // jika penggajian dilakukan untuk bulan januari, maka tahun akan mundur
				$tahun = date('Y', mktime(0, 0, 0, date("n"), date("d"), date("Y") - 1));
			} else { // jika penggajian dilakukan selain januari
				$tahun = date('Y', mktime(0, 0, 0, date("n"), date("d"), date("Y")));
			}

			//potongan gaji dari ketidakhadiran kerja
			$potongan = $this->db->get_where('absensi', array('id_karyawan' => $d->idpengguna, 'bulan' => $bulan, 'tahun' => $tahun))->result();
			$besaran_potongan = $this->db->get_where('potongan', array('id' => 1))->result();
			$nominal_potongan = ($potongan[0]->jumlah_tidak_hadir * $besaran_potongan[0]->nominal_potongan);

			$data_karyawan = array(
				'bulan'    => date('n'), //insert bulan saat ini
				'tahun'    => date('Y'), //insert tahun saat ini
				'id_pegawai'    => $d->idpengguna,
				'nama_pegawai'    => $d->nama_lengkap,
				'jabatan'    => $d->nama_jabatan,
				'gaji_pokok'    => $d->gaji_pokok,
				'potongan'    => $nominal_potongan, //nge get dari kalkulasi absensi
				'total' => $d->gaji_pokok - $nominal_potongan
			);

			$insert_data = $this->msa->insert('penggajian', $data_karyawan);

			if ($insert_data) {
				$inserted++;
			}
		}

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Penggajian berhasil dibuat'));
		}
		redirect(site_url('admin/kepegawaian/penggajian/daftar/inserted-success'));
	}

	function update_potongan()
	{
		$total = $this->input->post('gapok') - $this->input->post('potongan');
		$data = array(
			'potongan' => $this->input->post('potongan'),
			'total' => $total,
		);
		$this->db->where('id_pegawai', $this->input->post('id'));
		$this->db->where('bulan', $this->input->post('bulan'));
		$this->db->where('tahun', $this->input->post('tahun'));
		$this->db->update('penggajian', $data);

		echo json_encode($total);
	}


	public function laporan_penggajian()
	{
		$data = array(
			'action_print' => site_url('admin/cetak/slip_laporan_penggajian'),
			'view' => 'admin/kepegawaian/laporan-penggajian'
		);
		$this->load->view('admin/template', $data);
	}

	function messageAlert($type, $title)
	{
		$messageAlert = "const Toast = Swal.mixin({
	    	toast: true,
	    	position: 'bottom-end',
	        showConfirmButton: true,
	    	timer: 6000,
	    });
	    Toast.fire({
	    	type: '" . $type . "',
	    	title: '" . $title . "',
	    });";
		return $messageAlert;
	}
}
