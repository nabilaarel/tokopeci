<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Masuk extends CI_Controller {

	// load model
	public function __construct()
	{
		parent::__construct();
		$this->load->model('customer_model');
	}

	// login pelanggan
	public function index()
	{

		// Validasi
			$this->form_validation->set_rules('email','Email/username','required',
			array ( 'required'	=> '%s harus diisi'));

			$this->form_validation->set_rules('password','Password','required',
			array ( 'required'	=> '%s harus diisi'));

			if($this->form_validation->run())
			{
				$email     = $this->input->post('email');
				$password 	= $this->input->post('password');
				//Proses ke simple login 
				$this->simple_customer->login($email,$password);
			}

			// End validasi

		$data = array( 	'title' 	=> 'Login customer',
						'isi' 		=> 'masuk/list'
					);
		$this->load->view('layout/wrapper', $data, FALSE);
	}

	// logout
	public function logout()
	{
		// ambil fungsi logout di Simple_pelanggan yang sudah diset di autoload libraries
		$this->simple_customer->logout();
	}
}

/* End of file Masuk.php */
/* Location: ./application/controllers/Masuk.php */