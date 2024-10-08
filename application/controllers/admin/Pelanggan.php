<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{

	var $table		= 'pelanggan';
	var $section	= 'Pelanggan';
	var $folder		= 'pelanggan/';

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};
		$this->load->model(['model', 'validation']);
		$this->load->library(['form_validation', 'encryption']);
	}

	public function index()
	{
		$data = [
			'content'	=> $this->folder . ('view'),
			'section'	=> $this->section,
			'tampil'	=> $this->model->get_all($this->table)->result()
		];
		$this->load->view('template/template', $data);
	}

	public function add()
	{
		$data = [
			'content'	=> $this->folder . ('post'),
			'section'	=> $this->section,
		];
		$this->load->view('template/template', $data);
	}

	public function edit($id = null)
	{
		if (!isset($id)) show_404();
		$id = str_replace(['-', '_', '~'], ['=', '+', '/'], $id);
		$id = $this->encryption->decrypt($id);

		$data = [
			'content'	=> $this->folder . ('edit'),
			'section'	=> $this->section,
			'tampil'	=> $this->model->get_by($this->table, 'id', $id)->result()
		];

		$this->load->view('template/template', $data);
	}

	public function save()
	{
		$post		= $this->input->post();
		$validasi 	= $this->form_validation->set_rules($this->validation->val_user());
		if ($validasi->run() == false) {
			$data = [
				'content'	=> $this->folder . ('post'),
				'section'	=> $this->section,
			];
			$this->load->view('template/template', $data);
		} else {
			$data = [
				'id' 		=> null,
				'nama'		=> $post['nama'],
				'password'	=> password_hash($post['password1'], PASSWORD_DEFAULT),
				'level'		=> $post['level'],
				'email' 	=> $post['email'],
				'no_hp'		=> $post['no_hp'],
				'alamat'	=> $post['alamat'],
				'tgl_dibuat' => date('Y-m-d H:i:s')
			];
			$this->model->save($this->table, $data);
			$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil disimpan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('admin/pelanggan');
		}
	}

	public function update()
	{

		$cek 	= $this->model->get_by($this->table, 'email', $this->input->post('old_email'))->result_array();
		$jum 	= count($this->model->get_by($this->table, 'nama_tarif', $this->input->post('nama'))->result_array());
		$id 	= $cek[0]['id_tarif'];
		$post 	= $this->input->post();
		$nama 	= $post['nama'];
		$oldNama = $post['oldNama'];


		$this->form_validation->set_rules('nama', 'Nama', 'required|rtrim', ['required' 	=> 'Form <b>%s</b> tidak boleh kosong']);
		$this->form_validation->set_rules('waktu', 'Waktu', 'required|rtrim', ['required' => 'Form <b>%s</b> tidak boleh kosong.']);
		$this->form_validation->set_rules('biaya', 'Biaya', 'required|rtrim', ['required' => 'Form <b>%s</b> tidak boleh kosong.']);

		if ($this->form_validation->run() == true) {
			if ($nama == $oldNama) {
				$data = [
					'nama_tarif'	=> $post['nama'],
					'waktu_tarif'	=> $post['waktu'],
					'biaya_tarif'	=> $post['biaya'],
					'jenis_tarif'	=> $post['jenis']
				];
				$this->model->update($this->table, 'id_tarif', $id, $data);
				$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil di Ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('admin/tarif');
			} else {
				if ($jum == 0) {
					$data = [
						'nama_tarif'	=> $post['nama'],
						'waktu_tarif'	=> $post['waktu'],
						'biaya_tarif'	=> $post['biaya'],
						'jenis_tarif'	=> $post['jenis']
					];
					$this->model->update($this->table, 'id_tarif', $id, $data);
					$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil di Ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					redirect('admin/tarif');
				} else {
					$data = [
						'content'	=> $this->folder . ('edit'),
						'section'	=> $this->section,
						'tampil'	=> $this->model->get_by($this->table, 'id_tarif', $id)->result()
					];
					$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>Gagal!</b> Nama Tarif sudah ada.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					$this->load->view('template/template', $data);
				}
			}
		} else {
			$data = [
				'content'	=> $this->folder . ('edit'),
				'section'	=> $this->section,
				'tampil'	=> $this->model->get_by($this->table, 'id_tarif', $id)->result()
			];
			$this->load->view('template/template', $data);
		}
	}

	public function reset($id = null)
	{
		if (!isset($id)) show_404();
		$id = str_replace(['-', '_', '~',], ['=', '+', '/'], $id);
		$id = $this->encryption->decrypt($id);

		$this->model->reset_pass($this->table, 'id', $id, 'password');
		$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert"><b>Password</b> berhasil direset.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/pelanggan');
	}

	public function delete($id = null)
	{
		if (!isset($id)) show_404();
		$id = str_replace(['-', '_', '~'], ['=', '+', '/'], $id);
		$id = $this->encryption->decrypt($id);

		$this->model->delete($this->table, 'id', $id);
		$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil dihapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/pelanggan');
	}
}
