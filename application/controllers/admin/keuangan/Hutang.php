<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hutang extends Auth_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->load->model('msa_model');
		$this->load->model('keuangan_model', 'hutang');
	}

	public function index()
	{
		$this->daftar();
	}

	public function daftar()
	{
		//generate kode hutang
		$query = $this->msa_model->get_last_code('hutang', 'id')->result();
		$max_id = isset($query[0]->kode) ? $query[0]->kode : 0;
		$angka = (int) substr($max_id, 4, 7);
		$angka++;
		$huruf = "D-HT";
		$kode_baru = $huruf . sprintf("%05s", $angka);

		$data = array(
			'generate_kode' => $kode_baru,
			'action_add' => site_url('admin/keuangan/hutang/baru'),
			'action_delete' => site_url('admin/keuangan/hutang/hapus'),
			'vendor' => $this->msa_model->get_all('vendor', 'id'),
			'data' => $this->msa_model->get_all('hutang', 'id'),
			'view' => 'admin/keuangan/hutang-list'
		);
		$this->load->view('admin/template', $data);
	}

	public function ajax_list_hutang()
	{
		$list = $this->hutang->get_datatables('hutang');
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $d) {
			$vendor = $this->db->get_where('vendor', array('id' => $d->id_vendor))->result();
			$no++;
			$row = array();
			$row[] = '<div class="text-center">' . $no . '</div>';
			$row[] = '<td class="text-center">' . $d->kode . '</td>';
			$row[] = '<td class="text-center">' . $d->tanggal . '</td>';
			$row[] = '<span>' .
				isset($vendor[0]->nama_vendor) ? $vendor[0]->nama_vendor : '-' .
				'</span>';
			$row[] = '<td class="text-center">Rp.' . str_replace(',', '.', number_format($d->nominal)) . '</td>';
			$row[] = '<td class="text-center">' . $d->keterangan . '</td>';

			if ($d->status === "lunas") $row[] = '<span class="label label-success">' . strtoupper($d->status) . '</span>';
			else  $row[] = '<span class="label label-warning">' . strtoupper($d->status) . '</span>';
			$row[] = '<div class="text-center">
						<a href="javascript:void(0)" data-toggle="tooltip" title="Hapus" 
							class="btn btn-xs btn-danger hapus" onclick="form_hapus(' . "'" . $d->id . "'" . ')">
							<i class="fa fa-trash-o"></i>
						</a>
		            </div>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->hutang->count_all('hutang'),
			"recordsFiltered" => $this->hutang->count_filtered('hutang'),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	function baru()
	{

		$id_vendor = $this->keamanan->post($this->input->post('id_vendor', TRUE));
		$vendor = $this->db->get_where('vendor', array('id' => $id_vendor))->result();

		$nominal_uang = $this->keamanan->post($this->input->post('nominal', TRUE));

		$nominal = str_replace('.', '', $nominal_uang);

		if ($vendor) {
			$data = array(
				'kode'    => $this->keamanan->post($this->input->post('kode', TRUE)),
				'tanggal'    => $this->keamanan->post($this->input->post('tanggal', TRUE)),
				'id_vendor'    => $id_vendor,
				'nominal'    => $nominal,
				'keterangan'    => $this->keamanan->post($this->input->post('keterangan', TRUE)),
				'nama_vendor' => $vendor[0]->nama_vendor
			);

			$this->msa_model->insert('hutang', $data);

			if ($this->db->affected_rows() > 0) {
				$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data hutang berhasil ditambahkan'));
			}
			redirect(site_url('admin/keuangan/hutang/daftar/inserted-success'));
		}
	}


	function hapus()
	{
		$id = $this->keamanan->post($this->input->post('id'));

		// $this->msa_model->delete('hutang', 'id', $id);

		$data = array(
			'dihapus' => 'ya',
		);
		$this->msa_model->update('hutang', 'id', $id, $data);

		if ($this->db->affected_rows() > 0) {
			$this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Data Hutang berhasil dihapus'));
		}
		redirect(site_url('admin/keuangan/hutang/daftar/deleted-success'));
	} // end hapus

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

/* End of file admin/keuangan/Hutang.php */
