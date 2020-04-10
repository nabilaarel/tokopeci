<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	// Listing all customer
	public function listing()
	{
		$this->db->select(' * ');
		$this->db->from('customer');
		$this->db->order_by('id_customer', 'desc');
		$query = $this->db->get();
		return $query->result();
	}

	// Login customer
	public function login ( $email,$password )
	{
		$this->db->select(' * ');
		$this->db->from('customer');
		$this->db->where(array( 'email' 	=> $email,
								'password' 	=> SHA1($password)
							));
		$this->db->order_by('id_customer', 'desc');
		$query = $this->db->get();
		return $query->row();
	}

// Sudah login
	public function sudah_login ( $email,$nama_customer)
	{
		$this->db->select(' * ');
		$this->db->from('customer');
		$this->db->where(array( 'email' 		=> $email,
								'nama_customer' 	=> $nama_customer
							));
		$this->db->order_by('id_customer', 'desc');
		$query = $this->db->get();
		return $query->row();
	}

	// Detail customer
	public function detail ( $id_customer )
	{
		$this->db->select(' * ');
		$this->db->from('customer');
		$this->db->where('id_customer', $id_customer);
		$this->db->order_by('id_customer', 'desc');
		$query = $this->db->get();
		return $query->row();
	}

	// Tambah
	public function tambah($data)
	{
		$this->db->insert('customer', $data);
	}

	// Edit
	public function edit($data)
	{
		$this->db->where('id_customer', $data['id_customer']);
		$this->db->update('customer', $data);
	}

	// Delete
	public function delete($data)
	{
		$this->db->where('id_customer', $data['id_customer']);
		$this->db->delete('customer', $data);
	}	

}

/* End of file customer_model.php */
/* Location: ./application/models/customer_model.php */