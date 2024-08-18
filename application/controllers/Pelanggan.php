<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{

	var $folder = 'users/';
	var $layout = 'users/layout';
	var $table	= 'transaksi1';
	var $section = 'Home';

	function __construct()
	{
		parent::__construct();
		$this->load->library('encryption');

		$this->load->model('model');
		$this->load->model('validation', 'val');
		$this->load->library('form_validation');
	}

	public function index()
	{

		$data = ['content' => $this->folder . ('home'), 'section' => $this->section];
		$this->load->view($this->layout, $data);
	}

	public function listHarga()
	{
		$data = [
			'content'	=> $this->folder . ('tarif'),
			'data'		=> $this->model->get_all('layanan')->result(),
			'section' => 'Daftar Layanan'
		];
		$this->load->view($this->layout, $data);
	}

	public function masuk()
	{
		$data = [
			'content'	=> 'users/login',
		];

		$this->load->view('users/template/login', $data);
	}

	public function login()
	{

		$post 	= $this->input->post();
		$user 	= $post['email'];
		$pass	= $post['password'];
		$cek 	= $this->model->get_by('pelanggan', 'email', $user)->row_array();
		$validasi = $this->form_validation->set_rules($this->val->val_login_pelanggan());

		if ($validasi->run() == false) {
			$data = [
				'content' 	=> 'users/login',
				'section'	=> $this->section,
			];
			$this->load->view('users/template/login', $data);
		} else {
			if ($cek) {
				if (password_verify($pass, $cek['password'])) {
					$data = [
						'masuk'		=> true,
						'email'	=> $cek['email'],
						'nama'		=> $cek['nama'],
						'level'		=> $cek['level']
					];
					$this->session->set_userdata($data);

					redirect('pelanggan/dashboard');
				} else {
					$data = [
						'content' 	=> 'users/login',
						'section'	=> $this->section,
					];
					$this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">Password yang anda masukkan salah! </div>');
					$this->load->view('users/template/login', $data);
				}
			} else {
				$data = [
					'content' 	=> 'users/login',
					'section'	=> $this->section,
				];
				$this->session->set_flashdata('flash', '<div class="alert alert-danger" role="alert">Email tidak ada! </div>');
				$this->load->view('users/template/login', $data);
			}
		};
	}

	public function logout()
	{
		session_destroy();
		redirect('users/login');
	}

	public function lacak($id = null)
	{
		$id = $this->input->get('idOrder');
		if (!$id) {
			$data = [
				'content'	=> $this->folder . ('lacak'),
				'tampil' 	=> null,
				'id'		=> '',
				'section' => 'Lacak Status Laundry'
			];
		} else {
			$cek = $this->model->get_by('transaksi_status', 'id_transaksi_s', $id)->result_array();
			$jum = count($cek);

			if ($jum < 1) {
				$data = [
					'content'	=> $this->folder . ('lacak'),
					'tampil'	=> 'noData',
					'id'		=> $id
				];
			} else {
				$data = [
					'content'	=> $this->folder . ('lacak'),
					'tampil' 	=> 1,
					'data'		=> $cek,
					'id'		=> $id
				];
			}
		}
		$this->load->view($this->layout, $data);
	}

	public function kontak()
	{
		$data = [
			'content' => $this->folder . ('contact'),
			'section' => 'Kontak'
		];
		$this->load->view($this->layout, $data);
	}
}

/* End of file UserController.php */
/* Location: ./application/controllers/UserController.php */