<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Simple_customer
{
	protected $CI;

	public function __construct()
	{
        $this->CI =& get_instance();
        // Load data model user
        $this->CI->load->model('customer_model');
	}

	// Fungsi login
	public function login($email,$password)
	{
		$check = $this->CI->customer_model->login($email,$password);
		// Jika ada data user, maka create session login
		if($check) {
			$id_customer	= $check->id_customer;
			$nama_customer	= $check->nama_customer;
			// Create session
			$this->CI->session->set_userdata('id_customer',$id_customer);
			$this->CI->session->set_userdata('nama_customer',$nama_customer);
			$this->CI->session->set_userdata('email',$email);
			// redirect ke halaman admin yang di proteksi
			redirect(base_url('dasbor'),'refresh');

		}else{
			// kalau tidak ada (username password salah), maka suruh login lagi
			$this->CI->session->set_flashdata('warning', 'Username atau password salah');
			redirect(base_url('masuk'),'refresh');
		}
	}
	
	// Fungsi cek login
	public function cek_login()
	{
		// Memeriksa apakah session sudah atau belum, jika belum  alihkan ke halaman login
		if($this->CI->session->userdata('email') == "") {
			$this->CI->session->set_flashdata('warning', 'Anda belum login');
			redirect(base_url('masuk'),'refresh');
		}
	}

	// Fungsi logout
	public function logout()
	{
	// Membuang semua session yang telah diset pada saat login
			$this->CI->session->unset_userdata('id_customer');
			$this->CI->session->unset_userdata('nama_customer');
			$this->CI->session->unset_userdata('email');
			// Setelah session dibuang maka rediret ke login
			$this->CI->session->set_flashdata('sukses', 'Anda berhasil logout');
			redirect(base_url('masuk'),'refresh');
	}
}

/* End of file Simple_customer.php */
/* Location: ./application/libraries/Simple_customer.php */
