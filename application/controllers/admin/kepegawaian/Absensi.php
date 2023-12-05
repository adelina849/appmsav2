<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Absensi extends Auth_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->load->model('msa_model', 'msa');
		$this->load->model('kepegawaian_model', 'absensi');
	}

	public function index()
	{
		$this->daftar();
	}

	public function daftar()
	{

		$bulan = date('n');
		$tahun = date('Y');
		$absensi_bulan_ini   = '';
		$absensi_tahun_ini =  '';
		// filter list stok opname
		if ($this->input->post('filter', TRUE)) {
			$bulan_filter = $this->input->post('pilih_bulan', TRUE);
			$tahun_filter = $this->input->post('pilih_tahun', TRUE);
			$title = 'ABSENSI BULAN ' . strtoupper($this->tanggal->bulan($bulan_filter)) . ' TAHUN ' . $tahun_filter;
		} else {
			$absensi_bulan_ini = $bulan;
			$absensi_tahun_ini = $tahun;
			$title = 'ABSENSI BULAN ' . strtoupper($this->tanggal->bulan($bulan)) . ' TAHUN ' . $tahun;
		}
		$data = array(
			'title' => $title,
			'absensi_bulan_ini' => $absensi_bulan_ini,
			'absensi_tahun_ini' => $absensi_tahun_ini,
			'bulan_filter' => $this->input->post('pilih_bulan', TRUE),
			'tahun_filter' => $this->input->post('pilih_tahun', TRUE),
			'action_filter' => site_url('admin/kepegawaian/absensi/daftar'),
			'existing_absensi' => $this->absensi->count_existing($bulan, $tahun, 'absensi'),
			'absensi' => $this->absensi->count_existing($bulan, $tahun, 'absensi'),
			'view' => 'admin/kepegawaian/absensi-list'
		);
		$this->load->view('admin/template', $data);
	}

	public function ajax_list_absensi()
	{
		date_default_timezone_set('Asia/Jakarta');

		$absensi_bulan_ini = $this->input->post('absensi_bulanini');
		$absensi_tahun_ini = $this->input->post('absensi_tahunini');
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');

		if (!(empty($absensi_bulan_ini) and empty($absensi_tahun_ini))) {
			$data_wheres = array('bulan' => $absensi_bulan_ini, 'tahun' => $absensi_tahun_ini);
		} else {
			$data_wheres = array(
				'bulan' => $bulan,
				'tahun' => $tahun
			);
		}

		$list = $this->absensi->get_datatables($data_wheres, 'absensi');

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $d) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">' . $no . '</div>';
			$row[] = '<span>' . $d->id_karyawan . '</span>';
			$row[] = '<span>' . $d->nama_karyawan . '</span>';
			$row[] = '<span>
						<input type="number" data-id="' . $d->id_karyawan . '" data-bulan="' . $d->bulan . '" data-tahun="' . $d->tahun . '" id="total_tidak_hadir" name="total_tidak_hadir" class="form-control" value="' . $d->jumlah_tidak_hadir . '" placeholder=".." min="0" required>
					 </span>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->absensi->count_all('absensi'),
			"recordsFiltered" => $this->absensi->count_filtered($data_wheres, 'absensi'),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function baru()
	{
		$data = $this->absensi->get_data_karyawan();

		$inserted = 0;
		foreach ($data as $d) {
			$data_karyawan = array(
				'bulan'    => date('n'), //insert bulan saat ini
				'tahun'    => date('Y'), //insert tahun saat ini
				'id_karyawan'    => $d->idpengguna,
				'nama_karyawan'    => $d->nama_lengkap,
				'jumlah_tidak_hadir'    => 0, //nge get dari kalkulasi absensi
			);

			$insert_data = $this->msa->insert('absensi', $data_karyawan);

			if ($insert_data) {
				$inserted++;
			}
		}


		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data absensi berhasil dibuat'));
		}
		redirect(site_url('admin/kepegawaian/absensi/daftar/inserted-success'));
	}

	public function update_absen()
	{
		$data = array(
			'jumlah_tidak_hadir' => $this->input->post('newAbsen'),
		);
		$this->db->where('id_karyawan', $this->input->post('id'));
		$this->db->where('bulan', $this->input->post('bulan'));
		$this->db->where('tahun', $this->input->post('tahun'));
		$this->db->update('absensi', $data);
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
