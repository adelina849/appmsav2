                    <?php
                        $dtsp = $this->db->get_where('pesanan_detail', array('id_pesanan_m' => $id_pesanan_m))->result();
                        $i=0;
                        foreach($dtsp as $dt){
                        ?>
                            <tr>

        <td></td>
        <td>
        <input type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Barang'>
        <div id='hasil_pencarian'></div>
       </td>
        <td></td>
        <td>
       <input type='hidden' name='spesifikasi[]'>
        <span></span>
        </td>
        
        <td>
        <input type='hidden' name='satuan[]'>
        <span></span>
        </td>
        
        <td>
        <input type='hidden' name='harga_satuan[]'>
        <span></span>
        </td>
        <td><input type='text' class='form-control text-center' id='jumlah_beli' name='jumlah_beli[]' onkeypress='return check_int(event)' disabled></td>
        
        <td>
        <input type='hidden' name='sub_total[]'>
        <span></span>
        </td>

        <td>
        <div class='input-group'>
        <input type='hidden' id='ppn11_barang_value'>
        <input type='text' id='ppn11_barang' name='ppn11_barang[]' class='decimal form-control' placeholder='0' disabled>
        <span class='input-group-addon'>
        <input type='checkbox' id='checkbox_ppn_barang' name='checkbox_ppn_barang' value='1'>
        </span>
        </div>
        </td>

        <td>
        <div class='input-group'>
        <input type='hidden' id='pph21_barang_value'>
        <input type='text' id='pph21_barang' name='pph21_barang[]' class='decimal form-control' placeholder='0' disabled>
        <span class='input-group-addon'>
        <input type='checkbox' id='checkbox_pph21_barang' name='checkbox_pph21_barang' value='1'>
        </span>
        </div>
        </td>

        <td>
        <div class='input-group'>
        <input type='hidden' id='pph23_barang_value'>
        <input type='text' id='pph23_barang' name='pph23_barang[]' class='decimal form-control' placeholder='0' disabled>
        <span class='input-group-addon'>
        <input type='checkbox' id='checkbox_pph23_barang' name='checkbox_pph23_barang' value='1'>
        </span>
        </div>
        </td>

        <td>
        <input type='hidden' name='harga_pajak[]'>
        <span></span>
        </td>

        <td>
        <input type='text' class='decimal form-control text-center' id='diskon_barang' name='diskon_barang[]' placeholder='0%' disabled>
        <span>
        <input type='hidden' id='nilaiDiskon' name='nilai_diskon[]'>
        </span>
        </td>

        <td>
        <input type='hidden' name='harga_diskon[]'>
        <span></span>
        </td>

        <td><a href='#' class='' id='HapusBaris'><i class='fa fa-times btn-xs' style='color:red;'></i></a></td>

        </tr>


                            </tr>
                        <?php
                        }
                    ?>
