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

			/*
				BASE ON PESANAN DETAIL
					$s = "SELECT a.id_barang,
			(
				SUM(a.jumlah_beli)-(
					SELECT SUM(b.qty_terpacking) FROM packing_detail b 
					WHERE a.id_barang=b.id_barang
				)
			) AS qty_so
			FROM pesanan_detail a GROUP BY a.id_barang HAVING qty_so > 0";
			*/

		$s = "SELECT a.id_barang, SUM(a.qty_terpacking) AS jml_terpacking,
		(
			(
				SELECT SUM(b.jumlah_beli) FROM pesanan_detail b 
				WHERE a.id_barang=b.id_barang
			) - SUM(a.qty_terpacking)		
		) AS qty_so
		FROM packing_detail a GROUP BY a.id_barang HAVING qty_so > 0";

		$q = $this->db->query($s);
		$no = 1;
		$result = array();
		$result['total'] = $q->num_rows();
		$row = array();

		foreach($q->result() as $data) {	
			$total = 0;
            $barang = $this->db->get_where('barang', array('id_barang' => $data->id_barang))->result();
			$harga_beli = (isset($barang[0]->harga_beli) ? $barang[0]->harga_beli:0);
			$total = $harga_beli * $data->qty_so;

			$Qqty_sp = $this->db->query("SELECT SUM(jumlah_beli) AS qty_sp FROM pesanan_detail WHERE id_barang='".$data->id_barang."'")->result();
			$qty_sp = (isset($Qqty_sp[0]->qty_sp) ? $Qqty_sp[0]->qty_sp : 0);

			$row[] = array(
				'no'=> '<div class="text-center">'.$no.'</div>',
				'kode'=>'<span>' . (isset($barang[0]->kode_barang) ? $barang[0]->kode_barang : '-').'</span>',
				'nama'=>'<span>' . strtoupper(isset($barang[0]->nama_barang) ? $barang[0]->nama_barang : '-') . '</span>',
				'jenis'=>'<span>' . strtoupper(isset($barang[0]->jenis_barang) ? $barang[0]->jenis_barang : '-') . '</span>',
				'qty_sp'=>'<div class="text-center">'.$qty_sp.'</div>',
				'terpacking'=>'<div class="text-center">'.$data->jml_terpacking.'</div>',
				'so'=>'<div class="text-center"><span class="label label-info">'.$data->qty_so.'</span></div>',
				'harga'=>'<div class="text-right">' . str_replace(',', '.', number_format($harga_beli)) . '</div>',
				'total'=>'<div class="text-right">' . str_replace(',', '.', number_format($total)) . '</div>',
			);
			$no++;
		}
		$result = array('aaData'=>$row);
		echo json_encode($result);
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

        // $s = "SELECT 
        //         a.*,
        //         c.id_pesanan_m, c.id_lembaga, c.id_pelanggan,
        //         d.id_vendor, 
        //         e.kode AS kode_vendor, e.nama_vendor
        //         FROM packing_detail AS a
        //         INNER JOIN packing_master AS b
        //         ON a.id_packing_m=b.id_packing_m
        //         INNER JOIN pesanan_master AS c
        //         ON b.id_pesanan_m = c.id_pesanan_m
        //         INNER JOIN barang AS d
        //         ON a.id_barang=d.id_barang
        //         INNER JOIN vendor AS e
        //         ON d.id_vendor=e.id
        //         AND a.qty_so > 0
        //         GROUP BY d.id_vendor
        //         ORDER BY a.id_packing_d DESC";
        $s = "SELECT p.id_vendor, a.id_barang, SUM(a.qty_terpacking) AS jml_terpacking,
				(
					(
						SELECT SUM(b.jumlah_beli) 
						FROM pesanan_detail b, barang q
						WHERE b.id_barang=q.id_barang
						AND p.id_vendor=q.id_vendor
						GROUP BY p.id_vendor
					)-SUM(a.qty_terpacking)		
				) AS qty_so
				FROM packing_detail a, barang p
				WHERE a.id_barang=p.id_barang
				GROUP BY p.id_vendor HAVING qty_so > 0";
        $q = $this->db->query($s);
        $no = 1;
        $result = array();
        $result['total'] = $q->num_rows();
        $row = array();

        foreach($q->result() as $data) {	
        //$qPelanggan = $this->db->get_where('pelanggan', array('id' => $data->id_pelanggan))->result();
        //$qLembaga = $this->db->get_where('lembaga', array('id' => $data->id_lembaga))->result();
        $vendor = $this->db->get_where('vendor', array('id' => $data->id_vendor))->result();
        $row[] = array(
            'no'=> '<div class="text-center">'.$no.'</div>',
            'kode'=>'<span>' . $vendor[0]->kode.'</span>',
            'nama'=>'<span>' . strtoupper(isset($vendor[0]->nama_vendor) ? $vendor[0]->nama_vendor : '-') . '</span>',
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
