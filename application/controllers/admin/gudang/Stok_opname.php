<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stok_opname extends Auth_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->load->model('msa_model', 'msa');
		$this->load->model('stok_opname_model', 'so');
		$this->load->model('barang_model', 'barang');
	}

	public function index()
	{
		$this->daftar();
	}

	public function cari_gudang()
	{
		$autocomplite = '';
		if ($this->input->is_ajax_request()) {
			$keyword     = $this->input->post('nama_gudang');

			$gudang = $this->so->cari_gudang($keyword);

			$autocomplite = "<ul id='daftar-autocomplete' class='fa-ul'>";
			if ($gudang->num_rows() > 0) {
				foreach ($gudang->result() as $g) {
					$autocomplite .=
						"
                    <li class='first_item'>
                        <span id='id_gudang' style='display:none;'>" . $g->id . '</span>'
						. "<span id='nama_gudang' class='judul'>" . strtoupper($g->gudang) . '</span>'
						. "
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

	public function ajax_list_so()
	{
		date_default_timezone_set('Asia/Jakarta');
		$tglHariIni = date('Y-m-d');


		$so_bulan_ini = $this->input->post('so_bulanini');
		$tAwal = $this->input->post('tAwal');
		$tAkhir = $this->input->post('tAkhir');

		if (!empty($so_bulan_ini)) {
			$data_wheres = array('month(tanggal_mulai)' => $so_bulan_ini);
		} else {
			$id_gudang = $this->input->post('id_gudang');
			if (!empty($id_gudang)) {
				$data_wheres = array(
					'id_gudang' => $id_gudang,
					'date(tanggal_mulai)>=' => $tAwal,
					'date(tanggal_mulai)<=' => $tAkhir
				);
			} else {
				$data_wheres = array(
					'date(tanggal_mulai)>=' => $tAwal,
					'date(tanggal_mulai)<=' => $tAkhir
				);
			}
		}

		$list = $this->so->get_datatables($data_wheres);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $so) {
			$qGudang = $this->db->get_where('gudang', array('id' => $so->id_gudang))->result();

			$no++;
			$row = array();
			$row[] = '<div class="text-center">' . $no . '</div>';
			$row[] = '<span>' . $so->kode_so . '</span>';
			$row[] = '<span>' . $so->tanggal_mulai . '</span>';
			$row[] = '<span>' . strtoupper(isset($qGudang[0]->gudang) ? $qGudang[0]->gudang : '-') . '</span>';
			if ($so->status === "selesai") $row[] = '<span class="label label-success">' . strtoupper($so->status) . '</span>';
			else  $row[] = '<span class="label label-warning">' . strtoupper($so->status) . '</span>';
			if ($so->status == "selesai") {
				$row[] = '<div class="text-center">
							<div class="btn-group btn-group-sm">
								<a href="' . site_url('admin/gudang/stok_opname/hasil_so/' . $so->kode_so . '/detail-so') . '" data-toggle="tooltip" title="Lihat Hasil" class="btn btn-xs btn-success">LIHAT HASIL</a>
							</div>
						</div>';
			} else {
				$row[] = '<div class="text-center">
							<div class="btn-group btn-group-sm">
								<a href="' . site_url('admin/gudang/stok_opname/form_so/' . $so->kode_so . '/detail-so') . '" data-toggle="tooltip" title="Lanjutkan" class="btn btn-xs btn-warning">LANJUTKAN</a>
							</div>
						</div>';
			}
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->so->count_all($data_wheres),
			"recordsFiltered" => $this->so->count_filtered($data_wheres),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_list_barang()
	{

		$list = $this->so->cek_draft($this->input->post('kode_so'), $this->input->post('id_gudang'));

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $value) {
			$no++;
			$row = array();
			$row[] = '<div class="text-center">' . $no . '</div>';
			$row[] = '<span>' . $value->kode_barang . '</span>';
			$row[] = '<span>' . strtoupper($value->nama_barang) . '</span>';
			$row[] = '<span>' . $value->total_stok . '</span>';
			$row[] = '<div class="text-center">
							<div class="input-group">
								<input type="number" id="selisih_' . $value->id_barang . '" name="selisih" class="form-control" value="' . (isset($value->selisih) ? $value->selisih : 0) . '" readonly>
								<span class="input-group-addon">
									<input type="checkbox" id="edit_' . $value->id_barang . '" name="selected_barang" value="' . $value->id_barang . '">
								</span>
							</div>
						</div>';
			$row[] = '<div class="text-center">
							<div class="input-group" style="width:100%;">
								<input type="text" id="keterangan_' . $value->id_barang . '" name="keterangan" class="form-control" value="' . (isset($value->keterangan) ? $value->keterangan : "") . '" autocomplete="off" readonly>
							</div>
						</div>';
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->barang->count_all_by_gudang($this->input->post('id_gudang')),
			"recordsFiltered" => $this->barang->count_filtered_by_gudang($this->input->post('id_gudang')),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function daftar()
	{
		$this->load->model('msa_model');

		//untuk generate kode stok opname
		$query = $this->msa_model->get_last_code('stok_opname', 'id')->result();
		$max_id = isset($query[0]->kode_so) ? $query[0]->kode_so : 0;
		$angka = (int) substr($max_id, 3, 6);
		$angka++;
		$huruf = "SO-";
		$kode_baru = $huruf . sprintf("%04s", $angka);
		// selesai generate kode stok opname

		date_default_timezone_set('Asia/Jakarta');

		$tglHariIni = date('Y-m-d');
		$th = date('Y');
		$bln = date('m');
		$hr = date('d');
		$tanggal = $so_bulan_ini = $tAwal = $tAkhir = $id_gudang  = '';

		$title = 'DAFTAR STOK OPNAME';

		// filter list stok opname
		if ($this->input->post('filter', TRUE)) {
			$tAwal = $this->input->post('awal', TRUE);
			$tAkhir = $this->input->post('akhir', TRUE);
			$id_gudang = $this->input->post('gudang', TRUE);
			$tanggal = $this->tanggal->konversi($tAwal) . ' - ' . $this->tanggal->konversi($tAkhir);
			$title = 'DAFTAR STOK OPNAME ' . $tanggal;
		} else {
			$tanggal = $hr . ' ' . $this->tanggal->bulan($bln) . ' ' . $th;
			$so_bulan_ini = $bln;
			$title = 'DAFTAR STOK OPNAME BULAN ' . strtoupper($this->tanggal->bulan($bln)) . ' ' . $th;
		}

		$data = array(
			'title'         => $title,
			'so_bulan_ini'  => $so_bulan_ini,
			'tAwal'    => $tAwal,
			'tAkhir'    => $tAkhir,
			'id_gudang'    => $id_gudang,
			'tanggal'       => $tanggal,
			'action_filter' => site_url('admin/gudang/stok_opname/daftar'),
			'action_add' => site_url('admin/gudang/stok_opname/baru'),
			'data' => $this->msa->get_all('stok_opname', 'id'),
			'generate_kode' => $kode_baru,
			'list_gudang' => $this->msa->get_all('gudang', 'id'),
			'view' => 'admin/gudang/stok-opname-list'
		);
		$this->load->view('admin/template', $data);
	}

	function baru()
	{
		$this->load->model('msa_model');

		$kode_so = $this->keamanan->post($this->input->post('kode_so', TRUE));

		$data = array(
			'kode_so' => $kode_so,
			'id_gudang'    => $this->keamanan->post($this->input->post('id_gudang', TRUE)),
		);

		$this->msa_model->insert('stok_opname', $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Stok opname berhasil ditambahkan'));
		}
		redirect(site_url("admin/gudang/stok_opname/form_so/" . $kode_so . "/detail-so"));
	}

	function simpan_hasil_so()
	{
		$inserted = 0;
		$no_array = 0;

		$status = $this->input->post('status');
		$id_so = $this->input->post('idSo');
		$kode_so = $this->input->post('kodeSo');

		// untuk cancel terjadinya selisih yang sudah tersimpan as a draft
		$hasil_invalid = $this->input->post('hasilInvalid');
		$data_invalid = json_decode($hasil_invalid);
		foreach ($data_invalid as $value) {
			$this->so->delete_detail($value->id_barang, $id_so);
		}

		date_default_timezone_set('Asia/Jakarta');

		if ($status == "done") {
			$ubah_status = array(
				"status" => "selesai",
				"tanggal_selesai" => date('Y-m-d H:i:s'),
			);

			$this->msa->update('stok_opname', 'id', $id_so, $ubah_status);
		}

		$hasil_so = $_POST['hasil'];
		$data = json_decode($hasil_so);

		foreach ($data as $d) {
			if (!empty($d)) {
				if (!($d->selisih == 0)) {
					$barang = $this->msa->get_by_id('id_barang', $d->id_barang, 'barang');
					$data_barang = array(
						'id_so'  => $id_so,
						'kode_so'     => $kode_so,
						'id_barang'     => $d->id_barang,
						'total_stok' => $barang->total_stok,
						'selisih'  => $d->selisih,
						'keterangan'  => $d->keterangan,
					);

					$delete_detail    = $this->so->delete_detail($d->id_barang, $id_so);
					$insert_detail    = $this->so->insert_detail($data_barang);
					if ($insert_detail) {
						$inserted++;
					}
				}
			}
			$no_array++;
		}

		if ($inserted > 0) {
			echo json_encode(array('status' => 1, 'pesan' => "Opname berhasil disimpan !"));
		} else {
			echo json_encode(array(
				'status' => 0,
				"pesan" => "<font color='red'><i class='fa fa-warning'></i>Opname gagal disimpan</font>"
			));
		}
	}

	function selesai_so()
	{
		$id_so = $this->input->post('idSo');

		$ubah_status = array(
			"status" => "selesai",
			"tanggal_selesai" => date('Y-m-d H:i:s'),
		);

		$this->msa->update('stok_opname', 'id', $id_so, $ubah_status);

		// untuk cancel terjadinya selisih yang sudah tersimpan as a draft
		$hasil_invalid = $this->input->post('hasilInvalid');
		$data_invalid = json_decode($hasil_invalid);
		foreach ($data_invalid as $value) {
			$this->so->delete_detail($value->id_barang, $id_so);
		}

		json_encode(array('pesan' => "Opname berhasil disimpan !"));
	}

	function form_so($kode_so)
	{
		$this->load->model('msa_model');
		$data = array(
			'action_add' => site_url('admin/gudang/barang_masuk/baru'),
			'data' => $this->db->get_where('stok_opname', array('kode_so' => $kode_so))->result(),
			'view' => 'admin/gudang/stok-opname-form',
		);

		$this->load->view('admin/template', $data);
	}

	function hasil_so($kode_so)
	{
		$this->load->model('msa_model');
		$data = array(
			'action_add' => site_url('admin/gudang/barang_masuk/baru'),
			'data' => $this->db->get_where('stok_opname_detail', array('kode_so' => $kode_so))->result(),
			'so' => $this->db->get_where('stok_opname', array('kode_so' => $kode_so))->result(),
			'view' => 'admin/gudang/stok-opname-hasil',
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

/* End of file admin/gudang/Stok_Opname.php */
