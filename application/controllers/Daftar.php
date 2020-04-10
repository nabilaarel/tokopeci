<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar extends CI_Controller {

	// Load model
	public function __construct()
	{
		parent::__construct();
		$this->load->model('customer_model');
	}

	//halaman daftar
	public function index()
	{

		// validasi input
		$valid = $this->form_validation;

		$valid->set_rules('nama_customer','Nama lengkap','required',
				array( 'required' 		=> '%s Harus Diisi'));

		$valid->set_rules('email','Email','required|valid_email|is_unique[customer.email]',
				array( 'required' 		=> '%s Harus Diisi',
						'valid_email' 	=> '%s Tidak Valid',
						'is_unique' 	=> '%s Sudah terdaftar'));

		$valid->set_rules('password','Password','required',
				array( 'required' => '%s Harus Diisi'));


		if($valid->run()===FALSE) {
			// End validasi
		$data = array(	'title' 	=> 'Daftar Customer',
						'isi' 		=> 'daftar/list'
					);
		$this->load->view('layout/wrapper', $data, FALSE);
		// masuk database
		}else{
		$i = $this->input;
		$data = array ( 'status_customer' 	=> 'pending',
						'nama_customer'		=> $i->post('nama_customer'),
						'email'			 	=> $i->post('email'),
						'password'		 	=> SHA1($i->post('password')),
						'telepon'		 	=> $i->post('telepon'),
						'alamat'		 	=> $i->post('alamat'),
						'tanggal_daftar'	=> date('Y-m-d H:i:s')
					);
		$this->customer_model->tambah($data);
		// create session login customer
		$this->session->set_userdata('email',$i->post('email'));
		$this->session->set_userdata('nama_customer',$i->post('nama_customer'));
		// end create session
		$this->session->set_flashdata('sukses', 'Daftar berhasil');
		redirect(base_url('daftar/sukses'),'refresh');
	}
		// End masuk database
	}

	// Sukses
	public function sukses() 
	{
		$data = array(	'title' 	=> 'Daftar berhasil',
						'isi' 		=> 'daftar/sukses'
					);
		$this->load->view('layout/wrapper', $data, FALSE);
	}

}

/* End of file Daftar.php */
/* Location: ./application/controllers/Daftar.php */