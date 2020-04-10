<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dasbor extends CI_Controller {

	// load model
	public function __construct()
	{
		parent::__construct();
		$this->load->model('customer_model');
		$this->load->model('header_transaksi_model');
		$this->load->model('transaksi_model');
		$this->load->model('rekening_model');
		// halaman ini diproteksi dengan Simple_customer => Check Login
		$this->simple_customer->cek_login();
	}

	// halaman dasbor
	public function index()
	{
		// ambil data login id_customer dari SESSION
		$id_customer = $this->session->userdata('id_customer');
		$header_transaksi = $this->header_transaksi_model->customer($id_customer);

		$data = array( 	'title' 			=> 'Halaman Dashboard Customer',
						'header_transaksi' 	=> $header_transaksi,
						'isi' 				=> 'dasbor/list'
					);
		$this->load->view('layout/wrapper', $data, FALSE);
	}

	// Belanja
	public function belanja()
	{
		// ambil data login id_customer dari SESSION
		$id_customer 		= $this->session->userdata('id_customer');
		$header_transaksi 	= $this->header_transaksi_model->customer($id_customer);


		$data = array( 	'title' 			=> 'Riwayat Belanja',
						'header_transaksi' 	=> $header_transaksi,
						'isi' 				=> 'dasbor/belanja'
					);
		$this->load->view('layout/wrapper', $data, FALSE);
	}

	// Detail
	public function detail($kode_transaksi)
	{
		// ambil data login id_customer dari SESSION
		$id_customer 		= $this->session->userdata('id_customer');
		$header_transaksi 	= $this->header_transaksi_model->kode_transaksi($kode_transaksi);
		$transaksi 			= $this->transaksi_model->kode_transaksi($kode_transaksi);

		// pastikan bahwa customer hanya mengakses data transaksinya
		if($header_transaksi->id_customer != $id_customer) {
			$this->session->set_flashdata('warning', 'Anda mencoba mengakses data transaksi orang lain');
			redirect(base_url('masuk'));
		}

		$data = array( 	'title' 			=> 'Riwayat Belanja',
						'header_transaksi' 	=> $header_transaksi,
						'transaksi' 		=> $transaksi,
						'isi' 				=> 'dasbor/detail'
					);
		$this->load->view('layout/wrapper', $data, FALSE);
	}

	// Profil
	public function profil()
	{
		// ambil data login id_customer dari SESSION
		$id_customer 		= $this->session->userdata('id_customer');
		$customer 			= $this->customer_model->detail($id_customer);

		// validasi input
		$valid = $this->form_validation;

		$valid->set_rules('nama_customer','Nama lengkap','required',
				array( 'required' 		=> '%s Harus Diisi'));

		$valid->set_rules('alamat','Alamat lengkap','required',
				array( 'required' 		=> '%s Harus Diisi'));

		$valid->set_rules('telepon','Nomor Telepon','required',
				array( 'required' 		=> '%s Harus Diisi'));

		if($valid->run()===FALSE) {
			// End validasi

		$data = array( 	'title' 			=> 'Profil Saya',
						'customer' 			=> $customer,
						'isi' 				=> 'dasbor/profil'
					);
		$this->load->view('layout/wrapper', $data, FALSE);

		// masuk database
		}else{
			$i = $this->input;
			// kalau password lebih dari 6 karakter, maka password diganti
			if(strlen($i->post('password')) >= 6) {
				$data = array ( 'id_customer' 		=> $id_customer,
								'nama_customer'		=> $i->post('nama_customer'),
								'password'		 	=> SHA1($i->post('password')),
								'telepon'		 	=> $i->post('telepon'),
								'alamat'		 	=> $i->post('alamat'),
							);
		}else{
			// kalau password kurang dari 6 maka password ga diganti
			$data = array ( 'id_customer' 			=> $id_customer,
								'nama_customer'		=> $i->post('nama_customer'),
								'telepon'		 	=> $i->post('telepon'),
								'alamat'		 	=> $i->post('alamat'),
							);
		}
		// End data update
		$this->customer_model->edit($data);
		$this->session->set_flashdata('sukses', 'Update profil berhasil');
		redirect(base_url('dasbor/profil'),'refresh');
	}
		// End masuk database
	}

	// Konfirmasi pembayaran
	public function konfirmasi($kode_transaksi)
	{
		$header_transaksi 	= $this->header_transaksi_model->kode_transaksi($kode_transaksi);
		$rekening 			= $this->rekening_model->listing();

		// Validasi input
		$valid 	    = $this->form_validation;

		$valid->set_rules('nama_bank','Nama Bank','required',
				array( 'required' => '%s Harus Diisi'));

		$valid->set_rules('rekening_pembayaran','Nomor Rekening','required',
				array( 'required' => '%s Harus Diisi'));

		$valid->set_rules('rekening_customer','Nama Pemilik Rekening','required',
				array( 'required' => '%s Harus Diisi'));

		$valid->set_rules('tanggal_bayar','Tanggal Pembayaran','required',
				array( 'required' => '%s Harus Diisi'));

		$valid->set_rules('jumlah_bayar','Jumlah Pembayaran','required',
				array( 'required' => '%s Harus Diisi'));

		if($valid->run()) {
			// check jika gambar diganti
			if(!empty($_FILES['bukti_bayar']['name'])) {

			$config['upload_path'] 		= './assets/upload/image/';
			$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$config['max_size']  		= '2400'; //dalam kb
			$config['max_width']  		= '2024';
			$config['max_height']  		= '2024';
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('bukti_bayar')){
			// End validasi

		    $data = array( 'title' 			=> 'Konfirmasi Pembayaran',
						 'header_transaksi' => $header_transaksi,
						 'rekening' 		=> $rekening,
						 'error'			=> $this->display->upload_errors(),
						 'isi' 				=> 'dasbor/konfirmasi'
						);
		$this->load->view('layout/wrapper', $data, FALSE);

				// masuk database
	}else{
		$upload_gambar = array('upload_data' => $this->upload->data());

		// create thumbnail
		$config['image_library'] 	= 'gd2';
		$config['source_image'] 	= './assets/upload/image/'.$upload_gambar['upload_data']['file_name'];
		// lokasi folder thumbnail
		$config['new_image']		= './assets/upload/image/thumbs/';
		$config['create_thumb']		= TRUE;
		$config['maintain_ratio'] 	= TRUE;
		$config['width']         	= 250; //pixel
		$config['height']       	= 250; //pixel
		$config['thumb_marker']		= '';

		$this->load->library('image_lib', $config);

		$this->image_lib->resize();
		// end create thumbnail
		$i = $this->input;

		$data = array ( 'id_header_transaksi'	=> $header_transaksi->id_header_transaksi,
						'status_bayar'			=> 'Konfirmasi',
						'jumlah_bayar'	 		=> $i->post('jumlah_bayar'),
						'rekening_pembayaran'	=> $i->post('rekening_pembayaran'),
						'rekening_customer'		=> $i->post('rekening_customer'),
						'bukti_bayar'			=> $upload_gambar['upload_data']['file_name'],
						'id_rekening'			=> $i->post('id_rekening'),
						'tanggal_bayar'			=> $i->post('tanggal_bayar'),
						'nama_bank'				=> $i->post('nama_bank'),
					);
		$this->header_transaksi_model->edit($data);
		$this->session->set_flashdata('sukses', 'Konfirmasi Pembayaran Berhasil');
		redirect(base_url('dasbor'),'refresh');
	}}else{
			// edit produk tanpa ganti gambar
		$i = $this->input;

		$data = array ( 'id_header_transaksi'	=> $header_transaksi->id_header_transaksi,
						'status_bayar'			=> 'Konfirmasi',
						'jumlah_bayar'	 		=> $i->post('jumlah_bayar'),
						'rekening_pembayaran'	=> $i->post('rekening_pembayaran'),
						'rekening_customer'		=> $i->post('rekening_customer'),
						//'bukti_bayar'			=> $upload_gambar['upload_data']['file_name'],
						'id_rekening'			=> $i->post('id_rekening'),
						'tanggal_bayar'			=> $i->post('tanggal_bayar'),
						'nama_bank'				=> $i->post('nama_bank'),
					);
		$this->header_transaksi_model->edit($data);
		$this->session->set_flashdata('sukses', 'Konfirmasi Pembayaran Berhasil');
		redirect(base_url('dasbor'),'refresh');
	}}
	// End masuk database

	 $data = array( 	'title' 			=> 'Konfirmasi Pembayaran',
						 'header_transaksi' => $header_transaksi,
						 'rekening' 		=> $rekening,
						 'isi' 				=> 'dasbor/konfirmasi'
						);
		$this->load->view('layout/wrapper', $data, FALSE);
	}
}

/* End of file Dasbor.php */
/* Location: ./application/controllers/Dasbor.php */