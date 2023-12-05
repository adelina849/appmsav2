<div id="sidebar">
	<!-- Wrapper for scrolling functionality -->
	<div id="sidebar-scroll">
		<!-- Sidebar Content -->
		<div class="sidebar-content">
			<!-- Brand -->
			<a href="<?= base_url() . 'admin/dashboard'; ?>" class="sidebar-brand">
				<img src="<?php echo base_url(); ?>assets/img/logo-kecil.png" alt="" style="margin-top: -5px">
				<span class="sidebar-nav-mini-hide"><strong> CV. MSA</strong></span>
			</a>
			<!-- END Brand -->

			<!-- User Info -->
			<div class="sidebar-section sidebar-user clearfix sidebar-nav-mini-hide">
				<div class="sidebar-user-avatar">
					<a href="#">
						<img src="<?php echo base_url(); ?>assets/img/avatar.jpg" alt="avatar">
					</a>
				</div>
				<div class="sidebar-user-name"><?= ucwords($this->session->userdata('level')); ?></div>
				<div class="sidebar-user-links">
					<small><i class="fa fa-circle text-success"></i>
						<span class="label label-default animation-pulse">
							<?php
							$nama = '';
							$idPengguna = $this->session->userdata('idPengguna');
							$sql = $this->db->query("select nama_lengkap from pengguna where idpengguna='" . $idPengguna . "'")->row();
							echo ucwords($sql->nama_lengkap);
							?>
						</span>
					</small>
				</div>
			</div>
			<!-- END User Info -->

			<!-- Sidebar Navigation -->
			<ul class="sidebar-nav">
				<?php
				$active_master = $active_dashboard = $active_pengaturan = '';
				$active_pesanan = $active_so =  $active_do = $active_packing =$surat_jalan= '';
				$active_pembelian=$active_penerimaan = $retur_barang = $active_order ='';
				$menu = $this->uri->segment(2);
				switch ($menu):
					case 'master':
						$active_master = 'active';
						$surat_jalan = $active_pembelian = $active_packing = '';
						$active_packing = $active_so=$active_penerimaan=$retur_barang = $active_order = '';
						break;
					case 'pesanan':
						$active_pesanan = 'active';
						$surat_jalan = $active_pembelian = $active_packing = $active_so= $active_penerimaan = $retur_barang = $active_order = '';
						break;
					case 'packing':
						$active_packing = 'active';
						$surat_jalan = $active_pembelian = $active_pesanan = $active_so=$active_penerimaan = $retur_barang = $active_order = '';
						break;
					case 'surat_jalan':
						$surat_jalan = 'active';
						$active_packing = $active_pembelian = $active_pesanan = $active_so=$active_penerimaan = $retur_barang = $active_order = '';
						break;
					case 'pembelian':
						$active_pembelian = 'active';
						$active_packing = $surat_jalan = $active_pesanan = $active_so=$active_penerimaan = $retur_barang = $active_order='';
						break;
					case 'standing_order':
						$active_so = 'active';
						$active_packing = $surat_jalan = $active_pesanan = $active_pembelian=$active_penerimaan = $retur_barang = $active_order = '';
						break;	
					case 'penerimaan':
						$active_penerimaan = 'active';
						$active_packing = $surat_jalan = $active_pesanan = $active_pembelian = $active_so=$retur_barang = $active_order='';
						break;	
					case 'retur_barang':
						$retur_barang = 'active';
					break;
					case 'order':
						$active_order = 'active';
					break;
					default:
					$active_dashboard = 'active';
				endswitch;
				?>
				<li>
					<?= anchor('admin/dashboard', '<i class="gi gi-stopwatch sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Dashboard</span>', array('class' => $active_dashboard)); ?>
				</li>
				
				
				<li class="sidebar-header" style="background-color:grey;">
					<span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title="Database"><i class="fa fa-database"></i></a></span>
					<span class="sidebar-header-title"><b>MASTER DATA</b></span>
				</li>
				<?php
					if(($idPengguna=='A00001')|| $idPengguna=='A00012'){
						?>
							<li class="<?= $active_master; ?>">
								<a href="#" class="sidebar-nav-menu <?= $active_master; ?>">
									<i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
									<i class="gi gi-shopping_bag sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Master Data</span>
								</a>
								<ul>
									<li><?= anchor('admin/master/profil_perusahaan', 'Profil Perusahaan', array('class' => '')); ?></li>
									
									<li><?= anchor('#', 'Assets', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/akun', 'Akun', array('class' => '')); ?></li>
									<li><?= anchor('#', 'Jenjang', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/wilayah', 'Wilayah Kerja', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/pengguna', 'Karyawan', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/marketing', 'Marketing', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/jabatan', 'Jabatan', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/barang', 'Barang', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/kategori', 'Kategori Barang', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/sub_kategori', 'Sub Kategori Barang', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/satuan', 'Satuan', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/lembaga', 'Lembaga', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/pelanggan', 'Pelanggan', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/vendor', 'Supplier', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/vendor_klasifikasi', 'Klasifikasi Supplier', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/marketing_supplier', 'Marketing Supplier', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/gudang', 'Lokasi Gudang', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/mitra', 'Mitra', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/pelaksana', 'Perusahaan Pelaksana', array('class' => '')); ?></li>
									<li><?= anchor('admin/master/sumber_dana', 'Sumber Dana', array('class' => '')); ?></li>
								</ul>
							</li>						
						<?php
					}
				?>
				
				<li class="sidebar-header" style="background-color:grey;">
					<span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title="Keuangan"><i class="gi gi-money"></i></a></span>
					<span class="sidebar-header-title"><b>TRANSAKSI</b></span>
					
					<li class="<?= $active_pesanan; ?>">
						<a href="#" class="sidebar-nav-menu <?= $active_pesanan; ?>">
							<i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
							<i class="gi gi-envelope sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Surat Pesanan</span>
						</a>
						<ul>
							<li><?= anchor('admin/pesanan', '<i class="gi gi-book_open sidebar-nav-icon"></i> Buku'); ?></li>
							<li><?= anchor('admin/pesanan/non_buku', '<i class="gi gi-macbook sidebar-nav-icon"></i> Non-Buku'); ?></li>
						</ul>
					</li>
					
					<li>
						<?= anchor('admin/packing', '<i class="gi gi-package sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Packing</span>', array('class' => $active_packing)); ?>
					</li>
					
					<li class="<?= $active_order; ?>">
						<?= anchor('admin/order/daftar/daftar-delivery-order', '<i class="gi gi-truck sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Delivery Order</span>', array('class' => $active_do)); ?>
					</li>
					
					<li class="<?= $active_so; ?>">
						<a href="#" class="sidebar-nav-menu <?= $active_so; ?>">
							<i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
							<i class="fa fa-hourglass-o sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Standing Order (SO)</span>
						</a>
						<ul>
							<li><?= anchor('admin/standing_order/daftar_so_pelanggan', 'SO Pelanggan'); ?></li>
							<li><?= anchor('admin/standing_order/daftar_so_vendor', 'SO Supplier'); ?></li>
							<li><?= anchor('admin/standing_order/daftar_so_barang', 'SO Produk'); ?></li>
						</ul>
					</li>
					
					<li class="<?= $active_pembelian; ?>">
						<a href="#" class="sidebar-nav-menu <?= $active_pembelian; ?>">
							<i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
							<i class="fa fa-clipboard sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Surat Pembelian</span>
						</a>
						<ul>
							<li><?= anchor('admin/pembelian', 'Daftar Pembelian'); ?></li>
							<li><?= anchor('admin/pembelian/form_stok', 'Pembelian Stok'); ?></li>
							<li><?= anchor('admin/pembelian/so', 'Pembelian SO'); ?></li>
						</ul>
					</li>
					
					<li class="<?= $active_penerimaan; ?>">
						<a href="#" class="sidebar-nav-menu <?= $active_penerimaan; ?>">
							<i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
							<i class="gi gi-inbox_in sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Penerimaan Barang</span>
						</a>
						<ul>
							<li><?= anchor('admin/penerimaan/pembelian', 'Daftar Pembelian'); ?></li>
							<li><?= anchor('admin/penerimaan/daftar', 'Daftar Penerimaan'); ?></li>
							<li><?= anchor('admin/gudang/barang_masuk', 'Penerimaan Lain-Lain', array('class' => '')); ?></li>
						</ul>
					</li>
					
					<li class="<?= $retur_barang; ?>">
						<a href="#" class="sidebar-nav-menu <?= $retur_barang; ?>">
							<i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
							<i class="fa fa-retweet sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Retur Barang</span>
						</a>
						<ul>
							<li><?= anchor('admin/retur_barang/retur_pembelian', 'Retur Pembelian'); ?></li>
							<li><?= anchor('admin/retur_barang/retur_penjualan', 'Retur Penjualan'); ?></li>
						</ul>
					</li>
					
					<li class="<?= $surat_jalan; ?>">
						<a href="#" class="sidebar-nav-menu <?= $surat_jalan; ?>">
							<i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
							<i class="fa fa-external-link sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Surat Jalan</span>
						</a>
						<ul>
							<li><?= anchor('admin/surat_jalan', 'Daftar Surat Jalan'); ?></li>
							<li><?= anchor('admin/surat_jalan/penerimaan/form-penerimaan-do', 'Penerimaan DO'); ?></li>
							<li><?= anchor('admin/surat_jalan/terkirim/laporan-do-terkirim', 'Laporan DO Terkirim'); ?></li>
						</ul>
					</li>
					
				</li>
				
				<li class="sidebar-header" style="background-color:grey;">
					<span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title="Stok"><i class="gi gi-settings"></i></a></span>
					<span class="sidebar-header-title">GUDANG/STOCK</span>
					
					<li class="<?= $active_pengaturan; ?>">
						<a href="#" class="sidebar-nav-menu <?= $active_pengaturan; ?>">
							<i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
							<i class="gi gi-package sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Stok Gudang</span>
						</a>
						<ul>
							<li><?= anchor('admin/gudang/stok_barang', 'Stok Barang', array('class' => '')); ?></li>
							<li><?= anchor('admin/gudang/stok_opname', 'Stok Opname', array('class' => '')); ?></li>
						</ul>
					</li>
					
				</li>
				
				
				

				<!-- <li>
					<?= anchor('admin/constructions', '<i class="gi gi-folder_lock sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Rekap Pengiriman</span>', array('class' => '')); ?>
				</li>
				<li>
					<?= anchor('admin/constructions', '<i class="gi gi-restart sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Retur</span>', array('class' => '')); ?>
				</li> -->

				<li class="sidebar-header" style="background-color:grey;">
					<span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title="Keuangan"><i class="gi gi-money"></i></a></span>
					<span class="sidebar-header-title">KEUNGAN</span>
				</li>

				<li class="<?= $active_pengaturan; ?>">
					<a href="#" class="sidebar-nav-menu <?= $active_pengaturan; ?>">
						<i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
						<i class="gi gi-git_pull_request sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Arus KAS</span>
					</a>
					<ul>
						<li><?= anchor('admin/keuangan/hutang', 'Hutang Usaha', array('class' => '')); ?></li>
						<li><?= anchor('admin/keuangan/piutang', 'Piutang Usaha', array('class' => '')); ?></li>
						<li><?= anchor('admin/constructions', 'Pembayaran', array('class' => '')); ?></li>
						<li><?= anchor('admin/constructions', 'Cash Flow', array('class' => '')); ?></li>
						<li><?= anchor('admin/constructions', 'Rekap Fee', array('class' => '')); ?></li>
						<li><?= anchor('admin/constructions', 'Rekap Cash Flow', array('class' => '')); ?></li>
					</ul>
				</li>

				<!-- <li class="sidebar-header">
					<span class="sidebar-header-options clearfix"><a href="javascript:void(0)" data-toggle="tooltip" title="Kepegawaian"><i class="fa fa-user"></i></a></span>
					<span class="sidebar-header-title">KEPEGAWAIAN</span>
				</li>

				<li>
					<?= anchor('admin/kepegawaian/absensi', '<i class="fa fa-user sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Absensi Karyawan</span>', array('class' => '')); ?>
				<li class="<?= $active_pengaturan; ?>">
					<a href="#" class="sidebar-nav-menu <?= $active_pengaturan; ?>">
						<i class="fa fa-angle-left sidebar-nav-indicator sidebar-nav-mini-hide"></i>
						<i class="fa fa-money sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Gaji Karyawan</span>
					</a>
					<ul>
						<li><?= anchor('admin/kepegawaian/penggajian', 'Penggajian', array('class' => '')); ?></li>
						<li><?= anchor('admin/kepegawaian/penggajian/laporan_penggajian', 'Laporan Penggajian', array('class' => '')); ?></li>
					</ul>
				</li>
				</li> -->

			</ul>
			<!-- END Sidebar Navigation -->
		</div>
		<!-- END Sidebar Content -->
	</div>
	<!-- END Wrapper for scrolling functionality -->
</div>