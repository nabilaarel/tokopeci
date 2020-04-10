<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Belanja extends CI_Controller {

	// Load model
	public function __construct()
	{
		parent::__construct();
		$this->load->model('produk_model');
		$this->load->model('kategori_model');
		$this->load->model('konfigurasi_model');
		$this->load->model('customer_model');
		$this->load->model('header_transaksi_model');
		$this->load->model('transaksi_model');
		// load helper random string
		$this->load->helper('string');
	}

	// Halaman belanja
	public function index()
	{
		$keranjang  = $this->cart->contents();

		$data = array(	'title'		=> 'Keranjang Belanja',
						'keranjang'	=> $keranjang,
						'isi'		=> 'belanja/list'
					);	
		$this->load->view('layout/wrapper', $data, FALSE);	
	}

	// sukses belanja
	public function sukses()
	{

		$data = array(	'title'		=> 'Belanja Berhasil',
						'isi'		=> 'belanja/sukses'
					);	
		$this->load->view('layout/wrapper', $data, FALSE);	
	}

	// Checkout
	public function checkout()
	{
		// check pelanggan sudah login atau belum? jika belum maka nanti harus daftar 
		// dan juga sekaligus login. Mengecek dengan session email

		// kondisi sudah login
			if($this->session->userdata('email')) {
			$email 			= $this->session->userdata('email');
			$nama_customer 	= $this->session->userdata('nama_customer');
			$customer		= $this->customer_model->sudah_login($email,$nama_customer);

			$keranjang 	    = $this->cart->contents();

			// validasi input
			$valid = $this->form_validation;

			$valid->set_rules('nama_customer','Nama lengkap','required',
					array( 'required' 		=> '%s Harus Diisi'));

			$valid->set_rules('telepon','Nomor telepon','required',
					array( 'required' 		=> '%s Harus Diisi'));

			$valid->set_rules('alamat','Alamat','required',
					array( 'required' 		=> '%s Harus Diisi'));


			$valid->set_rules('email','Email','required|valid_email',
					array( 'required' 		=> '%s Harus Diisi',
							'valid_email' 	=> '%s Tidak Valid'));

			if($valid->run()===FALSE) {
			// End validasi

			$data = array(	'title'		=> 'Checkout',
							'keranjang'	=> $keranjang,
							'customer'	=> $customer,
							'isi'		=> 'belanja/checkout'
						);	
			$this->load->view('layout/wrapper', $data, FALSE);
			// masuk database
			}else{
		$i = $this->input;
		$data = array ( 'id_customer' 		=> $customer->id_customer,
						'nama_customer'		=> $i->post('nama_customer'),
						'email'			 	=> $i->post('email'),
						'telepon'		 	=> $i->post('telepon'),
						'alamat'		 	=> $i->post('alamat'),
						'kode_transaksi'	=> $i->post('kode_transaksi'),
						'tanggal_transaksi'	=> $i->post('tanggal_transaksi'),
						'jumlah_transaksi'	=> $i->post('jumlah_transaksi'),
						'status_bayar'		=> 'Belum',
						'tanggal_post'		=> date('Y-m-d H:i:s')
					);
		// proses masuk ke header transaksi
		$this->header_transaksi_model->tambah($data);
		// proses masuk ke tabel transaksi
		foreach($keranjang as $keranjang) {
			$sub_total = $keranjang['price'] * $keranjang['qty'];

			$data = array( 	'id_customer' 		=> $customer->id_customer,
							'kode_transaksi' 	=> $i->post('kode_transaksi'),
							'id_produk' 		=> $keranjang['id'],
							'harga' 			=> $keranjang['price'],
							'jumlah' 			=> $keranjang['qty'],
							'total_harga'		=> $sub_total,
							'tanggal_transaksi' => $i->post('tanggal_transaksi')
						);
			$this->transaksi_model->tambah($data);
		}
		// end proses masuk ke tabel transaksi
		// setelah masuk ke tabel transaksi, maka kerajang dikosongkan lagi
		$this->cart->destroy();
		// end pengosongan keranjang
		$this->session->set_flashdata('sukses', 'Check out berhasil');
		redirect(base_url('belanja/sukses'),'refresh');
	}
			// end masuk database
		}else{
			// kalau belum, maka harus daftar
			$this->session->set_flashdata('sukses', 'Silahkan login atau daftar terlebih dahulu');
			redirect(base_url('daftar'),'refresh');
		}
	}

	// Tambahkan ke keranjang belanja
	public function add()
	{
		// Ambil data dari form
		$id 			= $this->input->post('id');
		$qty 			= $this->input->post('qty');
		$price 			= $this->input->post('price');
		$name 			= $this->input->post('name');
		$redirect_page 	= $this->input->post('redirect_page');
		// Proses memasukkan ke keranjang belanja
		$data = array(	'id'		=> $id,
						'qty'		=> $qty,
						'price' 	=> $price,
						'name' 		=> $name
						);
		$this->cart->insert($data);
		// Redirect page
		redirect($redirect_page,'refresh');
	}

	// update cart
	public function update_cart($rowid)
	{
		// jika ada data rowid
		if($rowid) {
			$data = array( 	'rowid' 	=> $rowid,
							'qty' 		=> $this->input->post('qty')
						);
			$this->cart->update($data);
			$this->session->set_flashdata('sukses', 'Data keranjang telah diupdate');
			redirect(base_url('belanja'),'refresh');

		}else{
			// jika ga ada rowid
			redirect(base_url('belanja'),'refresh');
		}
	}

	// Hapus semua isi keranjang belanja
	public function hapus($rowid='')
	{
		if($rowid) {
			// hapus per item
			$this->cart->remove($rowid);
			$this->session->set_flashdata('sukses', 'Data keranjang belanja telah dihapus');
			redirect(base_url('belanja'),'refresh');

		}else{
			// hapus all
			$this->cart->destroy();
			$this->session->set_flashdata('sukses', 'Data keranjang belanja telah dihapus');
			redirect(base_url('belanja'),'refresh');	
		}
		
	}

}

/* End of file Belanja.php */
/* Location: ./application/controllers/Belanja.php */