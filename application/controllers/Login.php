<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	// public function __construct()
	// {
        // cek session
        // echo "TES";
        // if($this->CI->session->userdata('username') != "") {
			// $this->CI->session->set_flashdata('warning', 'Anda belum login');
			// redirect(base_url('admin/Dasbor'),'refresh');
		// }
	// }
	// Halaman login
	public function index()
	{
			// Validasi
			$this->form_validation->set_rules('username','Username','required',
			array ( 'required'	=> '%s harus diisi'));

			$this->form_validation->set_rules('password','Password','required',
			array ( 'required'	=> '%s harus diisi'));

			if($this->form_validation->run())
			{
				$username     = $this->input->post('username');
				$password 	= $this->input->post('password');
				//Proses ke simple login 
				$this->simple_login->login($username,$password);
			}

			// End validasi

			$data = array('title'	=> 'Login Admin');
			$this->load->view('login/list', $data, FALSE);
	}

	// Fungsi logout
	public function logout()
	{
		// Ambil fungsi logout dari simple_login
		$this->simple_login->logout();
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */