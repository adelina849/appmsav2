<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Standing_order extends Auth_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('access');
		$this->load->model('msa_model');
		$this->load->model('standing_order_model', 'so');
	}

	public function daftar_so_barang()
	{
		$filter = 'barang';
		$data = array(
			'view' => 'admin/standing_order/so_barang',
			'action_cetak' => site_url('admin/standing_order/insert_spb/' . $filter),
		);
		$this->load->view('admin/template', $data);
	}

	public function ajax_list_so_barang()
	{
		$data = array();

		$items = $this->so->get_datatables('packing_detail', 'barang');

		$no = $_POST['start'];


		foreach ($items as $item) {
			$total = 0;
			$qty_so = $qty_sp = 0;
			$q_sp = '';

			#RUMUS MENGHITUNG SO BARANG : QTY BARANG YANG DIPESAN - QTY BARANG TERPACKING
			$q = $this->db->query("SELECT id_barang, SUM(jumlah_beli) AS qty_sp FROM pesanan_detail 
									WHERE id_barang='".$item->id_barang."' GROUP BY id_barang ");
			if($q->num_rows() > 0){
				$q_sp = $q->row();
				$qty_sp = $q_sp->qty_sp;
				$qty_so = ($qty_sp - $item->total_terpacking);
				$total = $qty_so * $item->harga_beli;
			}
			$no++;
			$row = array();
			$row[] = '<div class="text-center">' . $no . '</div>';
			$row[] = '<span>' . $item->kode_barang . '</span>';
			$row[] = '<span>' . $item->nama_barang . '</span>';
			$row[] = '<span>' . strtoupper($item->jenis_barang) . '</span>';
			$row[] = '<div class="text-center">' . $qty_sp . '</div>';
			$row[] = '<div class="text-center">' . $item->total_terpacking . '</div>';
			$row[] = '<div class="text-center"><span class="label label-info">' . $qty_so . '</span></div>';
			$row[] = '<div class="text-right">' . str_replace(',', '.', number_format($item->harga_beli)) . '</div>';
			$row[] = '<div class="text-right">' . str_replace(',', '.', number_format($total)) . '</div>';
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->so->count_all('packing_detail'),
			"recordsFiltered" => $this->so->count_filtered('packing_detail', 'barang'),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function daftar_so_vendor()
	{
		$filter = 'supplier';
		$data = array(
			'view' => 'admin/standing_order/so_vendor',
		);
		$this->load->view('admin/template', $data);
	}

	public function ajax_vendor()
	{

        $s = "SELECT 
                a.*,
                c.id_pesanan_m, c.id_lembaga, c.id_pelanggan,
                d.id_vendor, 
                e.kode AS kode_vendor, e.nama_vendor
                FROM packing_detail AS a
                INNER JOIN packing_master AS b
                ON a.id_packing_m=b.id_packing_m
                INNER JOIN pesanan_master AS c
                ON b.id_pesanan_m = c.id_pesanan_m
                INNER JOIN barang AS d
                ON a.id_barang=d.id_barang
                INNER JOIN vendor AS e
                ON d.id_vendor=e.id
                AND a.qty_so > 0
                GROUP BY d.id_vendor
                ORDER BY a.id_packing_d DESC";

        $q = $this->db->query($s);
        $no = 1;
        $result = array();
        $result['total'] = $q->num_rows();
        $row = array();

        foreach($q->result() as $data) {	
        //$qPelanggan = $this->db->get_where('pelanggan', array('id' => $data->id_pelanggan))->result();
        //$qLembaga = $this->db->get_where('lembaga', array('id' => $data->id_lembaga))->result();
        $row[] = array(
            'no'=> '<div class="text-center">'.$no.'</div>',
            'kode'=>'<span>' . $data->kode_vendor.'</span>',
            'nama'=>'<span>' . strtoupper(isset($data->nama_vendor) ? $data->nama_vendor : '-') . '</span>',
            'aksi'=>'<div class="text-center">
                        <div class="btn-group btn-group-sm">
                            <button onclick="print('.$data->id_vendor.')" 
                                class="btn btn-alt btn-default btn-xs text-info" data-toggle="tooltip" title="Cetak SO">
                                <i class="fa fa-print text-info"></i> Detail SO
                            </button>
                        </div>                      
                </div>' 
        );
        $no++;
        }

        $result = array('aaData'=>$row);
        echo json_encode($result);


    }

	public function daftar_so_pelanggan()
	{
		$filter = 'pelanggan';
		$data = array(
			'view' => 'admin/standing_order/so_pelanggan',
		);
		$this->load->view('admin/template', $data);
	}

    public function ajax_pelanggan()
    {

		$s = "SELECT 
                    a.*,
                    b.id_packing_m, b.nomor_packing, b.tanggal_packing,
                    c.id_pesanan_m, c.id_lembaga, c.id_pelanggan
                FROM packing_detail AS a
                INNER JOIN packing_master AS b
                ON a.id_packing_m=b.id_packing_m
                INNER JOIN pesanan_master AS c
                ON b.id_pesanan_m = c.id_pesanan_m
                AND a.qty_so > 0
                GROUP BY c.id_pelanggan
                ORDER BY b.id_packing_m DESC";

		$q = $this->db->query($s);
		$no = 1;
		$result = array();
		$result['total'] = $q->num_rows();
		$row = array();
        
		foreach($q->result() as $data) {	
            $qPelanggan = $this->db->get_where('pelanggan', array('id' => $data->id_pelanggan))->result();
            $qLembaga = $this->db->get_where('lembaga', array('id' => $data->id_lembaga))->result();
            $row[] = array(
                'no'=> '<div class="text-center">'.$no.'</div>',
                'kode'=>'<span>' . strtoupper(isset($qPelanggan[0]->kode) ? $qPelanggan[0]->kode : '-') . '</span>',
                'nama'=>'<span>' . strtoupper(isset($qPelanggan[0]->nama_pelanggan) ? $qPelanggan[0]->nama_pelanggan : '-') . '</span>',
                'lembaga'=>'<span>' . strtoupper(isset($qLembaga[0]->nama_lembaga) ? $qLembaga[0]->nama_lembaga : '-') . '</span>',
                'alamat'=>'<span>' . isset($qLembaga[0]->alamat) ? $qLembaga[0]->alamat : '-'. '</span>',
                'aksi'=>'<div class="text-center">
                            <div class="btn-group btn-group-sm">
								<button onclick="print('.$data->id_pelanggan.','.$data->id_pesanan_m.','.$data->id_lembaga.')" 
									class="btn btn-alt btn-default btn-xs text-info" data-toggle="tooltip" title="Cetak SO">
									<i class="fa fa-print text-info"></i> Detail SO
								</button>
							</div>                      
                    </div>' 
            );
			$no++;
		}
		
		$result = array('aaData'=>$row);
		echo json_encode($result);
		
	}

	public function print_so_pelanggan($id_pelanggan, $id_pesanan_m, $id_lembaga){
        $data = array(
            'id_pesanan_m' => $id_pesanan_m,
            'id_pelanggan' => $id_pelanggan,
            'id_lembaga' => $id_lembaga,
            'title'         => 'STANDING ORDER PELANGGAN'
        );

        $this->load->view('admin/print/print-so-pelanggan', $data);
    }    

	public function print_so_supplier($id_vendor){
        $data = array(
            'id_vendor' => $id_vendor,
            'title'         => 'STANDING ORDER SUPPLIER'
        );

        $this->load->view('admin/print/print-so-supplier', $data);
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

/* End of file admin/Standing_order.php */
