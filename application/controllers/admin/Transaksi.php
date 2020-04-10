<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	// Load model
	public function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi_model');
		$this->load->model('rekening_model');
		$this->load->model('header_transaksi_model');
		$this->load->model('konfigurasi_model');
	}
	
	// Load data transaksi	
	public function index()
	{
		$header_transaksi = $this->header_transaksi_model->listing();

		$data = array( 	'title'				=> 'Data Transaksi',
						'header_transaksi' 	=> $header_transaksi,
						'isi' 				=> 'admin/transaksi/list'
						);
		$this->load->view('admin/layout/wrapper', $data, FALSE);
	}

	// Detail
	public function detail($kode_transaksi)
	{
		$header_transaksi 	= $this->header_transaksi_model->kode_transaksi($kode_transaksi);
		$transaksi 			= $this->transaksi_model->kode_transaksi($kode_transaksi);

		$data = array( 	'title' 			=> 'Riwayat Belanja',
						'header_transaksi' 	=> $header_transaksi,
						'transaksi' 		=> $transaksi,
						'isi' 				=> 'admin/transaksi/detail'
					);
		$this->load->view('admin/layout/wrapper', $data, FALSE);
	}

	// Cetak
	public function cetak($kode_transaksi)
	{
		$header_transaksi 	= $this->header_transaksi_model->kode_transaksi($kode_transaksi);
		$transaksi 			= $this->transaksi_model->kode_transaksi($kode_transaksi);
		$site 				= $this->konfigurasi_model->listing();

		$data = array( 	'title' 			=> 'Riwayat Belanja',
						'header_transaksi' 	=> $header_transaksi,
						'transaksi' 		=> $transaksi,
						'site' 				=> $site,
					);
		$this->load->view('admin/transaksi/cetak', $data, FALSE);
	}

	// Konfirmasi kirim
	public function konfirmasi($kode_transaksi)
	{
		$header_transaksi 	= $this->header_transaksi_model->kode_transaksi($kode_transaksi);
		$rekening 			= $this->rekening_model->listing();

		// Validasi input
		$valid 	    = $this->form_validation;

		// $valid->set_rules('rekening_pembayaran','Nomor Rekening','required',
		// 		array( 'required' => '%s Harus Diisi'));

		// $valid->set_rules('rekening_customer','Nama Pemilik Rekening','required',
		// 		array( 'required' => '%s Harus Diisi'));

		// $valid->set_rules('tanggal_bayar','Tanggal Pembayaran','required',
		// 		array( 'required' => '%s Harus Diisi'));

		$valid->set_rules('tanggal_kirim','Tanggal Pengiriman','required',
				array( 'required' => '%s Harus Diisi'));

		// $valid->set_rules('jumlah_bayar','Jumlah Pembayaran','required',
		// 		array( 'required' => '%s Harus Diisi'));

		if($valid->run()) {
			// check jika gambar diganti
			if(!empty($_FILES['bukti_kirim']['name'])) {

			$config['upload_path'] 		= './assets/upload/image/';
			$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$config['max_size']  		= '2400'; //dalam kb
			$config['max_width']  		= '2024';
			$config['max_height']  		= '2024';
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('bukti_kirim')){
			// End validasi

		    $data = array( 'title' 			=> 'Konfirmasi Pengiriman',
						 'header_transaksi' => $header_transaksi,
						 'rekening' 		=> $rekening,
						 'error'			=> $this->display->upload_errors(),
						 'isi' 				=> 'admin/transaksi/konfirmasi'
						);
		$this->load->view('admin/transaksi/konfirmasi', $data, FALSE);

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
						// 'status_bayar'			=> 'Konfirmasi',
						'status_kirim'			=> 'Konfirmasi',
						// 'jumlah_bayar'	 		=> $i->post('jumlah_bayar'),
						// 'rekening_customer'		=> $i->post('rekening_customer'),
						'bukti_kirim'			=> $upload_gambar['upload_data']['file_name'],
						// 'id_rekening'			=> $i->post('id_rekening'),
						// 'tanggal_bayar'			=> $i->post('tanggal_bayar'),
						'tanggal_kirim'			=> $i->post('tanggal_kirim'),
					);
		$this->header_transaksi_model->edit($data);
		$this->session->set_flashdata('sukses', 'Konfirmasi Pengiriman Berhasil');
		redirect(base_url('admin/transaksi'),'refresh');
	}}else{
			// edit produk tanpa ganti gambar
		$i = $this->input;

		$data = array ( 'id_header_transaksi'	=> $header_transaksi->id_header_transaksi,
						// 'status_bayar'			=> 'Konfirmasi',
						'status_kirim'			=> 'Konfirmasi',
						// 'jumlah_bayar'	 		=> $i->post('jumlah_bayar'),
						// 'rekening_customer'		=> $i->post('rekening_customer'),
						'bukti_kirim'			=> $upload_gambar['upload_data']['file_name'],
						// 'id_rekening'			=> $i->post('id_rekening'),
						// 'tanggal_bayar'			=> $i->post('tanggal_bayar'),
						'tanggal_kirim'			=> $i->post('tanggal_kirim'),
					);
		$this->header_transaksi_model->edit($data);
		$this->session->set_flashdata('sukses', 'Konfirmasi Pengiriman Berhasil');
		redirect(base_url('admin/transaksi'),'refresh');
	}}
	// End masuk database

	 $data = array( 	'title' 			=> 'Konfirmasi Pengiriman',
						 'header_transaksi' => $header_transaksi,
						 'rekening' 		=> $rekening,
						 'isi' 				=> 'admin/transaksi/konfirmasi'
						);
		$this->load->view('admin/layout/wrapper', $data, FALSE);
	}
}

/* End of file Transaksi.php */
/* Location: ./application/controllers/admin/Transaksi.php */