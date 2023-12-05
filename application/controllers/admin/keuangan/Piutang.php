<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Piutang extends Auth_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->load->model('msa_model');
		$this->load->model('keuangan_model', 'piutang');
	}

	public function index()
	{
		$this->daftar();
	}

	public function daftar()
	{
		$data = array(
			'data' => $this->msa_model->get_all('piutang', 'id'),
			'view' => 'admin/keuangan/piutang-list'
		);
		$this->load->view('admin/template', $data);
	}

	public function ajax_list_piutang()
	{
		$list = $this->piutang->get_datatables('piutang');
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $d) {
			$lembaga = $this->db->get_where('lembaga', array('id' => $d->id_lembaga))->result();
			$pelanggan = $this->db->get_where('pelanggan', array('id' => $d->id_pelanggan))->result();
			$mitra = $this->db->get_where('mitra', array('id' => $d->id_mitra))->result();
			$pelaksana = $this->db->get_where('pelaksana', array('id' => $d->id_pelaksana))->result();
			$no++;
			$row = array();
			$row[] = '<div class="text-center">' . $no . '</div>';
			$row[] = '<td class="text-center">' . $d->nomor_sp . '</td>';
			$row[] = '<td class="text-center">' . $d->tanggal_sp . '</td>';
			$row[] = '<td class="text-center">' . $d->jatuh_tempo . '</td>';
			$row[] = '<span>' .
				isset($lembaga[0]->nama_lembaga) ? $lembaga[0]->nama_lembaga : '-' .
				'</span>';
			$row[] = '<span>' .
				isset($pelanggan[0]->nama_pelanggan) ? $pelanggan[0]->nama_pelanggan : '-' .
				'</span>';
			$row[] = '<span>' .
				isset($mitra[0]->nama_mitra) ? $mitra[0]->nama_mitra : '-' .
				'</span>';
			$row[] = '<span>' .
				isset($pelaksana[0]->nama_cv) ? $pelaksana[0]->nama_cv : '-' .
				'</span>';
			$row[] = '<td class="text-center">Rp.' . str_replace(',', '.', number_format($d->nominal)) . '</td>';
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
			"recordsTotal" => $this->piutang->count_all('piutang'),
			"recordsFiltered" => $this->piutang->count_filtered('piutang'),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
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

/* End of file admin/keuangan/Hutang.php */
