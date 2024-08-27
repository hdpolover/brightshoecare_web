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

	public function lacak($noTransaksi = null)
	{
		$noTransaksi = $this->input->get('no_transaksi');
		
		if (!$noTransaksi) {
			$data = [
				'content'	=> $this->folder . ('lacak'),
				'tampil' 	=> null,
				'id'		=> '',
				'section' => 'Lacak Status Laundry'
			];
		} else {
			$cek = $this->model->get_by('transaksi1', 'no_transaksi', $noTransaksi)->result_array();
			$jum = count($cek);

			if ($jum < 1) {
				$data = [
					'content'	=> $this->folder . ('lacak'),
					'tampil'	=> 'noData',
				];
			} else {
				$transaksi = $this->model->get_by($this->table, 'no_transaksi', $noTransaksi)->row();
				$detail_transaksi = $this->model->get_by('transaksi_detail1', 'id_transaksi', $transaksi->id_transaksi)->result();
				$pelanggan = $this->model->get_by('pelanggan', 'id', $transaksi->id_pelanggan)->row();
				$status_pesanan = $this->model->get_by('transaksi_status1', 'id_transaksi', $transaksi->id_transaksi)->row();
				$pembayaran = $this->model->get_by('pembayaran', 'id_transaksi', $transaksi->id_transaksi)->row();

				$data = [
					'content'	=> $this->folder . ('lacak'),
					'tampil' 	=> 1,
					'transaksi'	=> $transaksi,
					'pelanggan'	=> $pelanggan,
					'status_pesanan' => $status_pesanan,
					'detail_transaksi' => $detail_transaksi,
					'pembayaran' => $pembayaran,
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