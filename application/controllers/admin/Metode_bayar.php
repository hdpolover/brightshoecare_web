<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Metode_bayar extends CI_Controller
{

	var $table 		= 'metode_bayar';
	var $folder		= 'metode_bayar/';
	var $section 	= 'Metode Pembayaran';

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};
		$this->load->model(['model']);
		$this->load->library(['form_validation', 'encryption']);
	}

	public function index()
	{
		$this->db->order_by('nama', 'ASC');
		$data = [
			'content' 	=> $this->folder . ('view'),
			'section'	=> $this->section,
			'tampil'	=> $this->model->get_all($this->table)->result()
		];
		$this->load->view('template/template', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('nama', 'Metode Pembayaran', 'required|rtrim');
		$post 	= $this->input->post();
		$cek 	= count($this->model->get_by($this->table, 'nama', $post['nama'])->result());
		if ($this->form_validation->run() == true) {
			if ($cek < 1) {
				$data = [
					'id_metode_bayar'	=> null,
					'nama'	=> $post['nama'],
					'deskripsi'	=> $post['deskripsi'],
					'kategori'	=> $post['kategori'],
				];
				$this->model->save($this->table, $data);
				$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil di simpan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('admin/metode_bayar');
			} else {
				$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>Metode Pembayaran</b> sudah ada.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('admin/metode_bayar');
			}
		} else {
		}
		$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Form <b>Kategori Layanan</b> tidak boleh kosong.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/metode_bayar');
	}


	public function edit()
	{
		$this->form_validation->set_rules('nama', 'Nama Metode Pembayaran', "required|rtrim|");
		$post 		= $this->input->post();
		$oldNama	= $post['oldNama'];
		$nama 		= $post['nama'];
		$deskripsi 		= $post['deskripsi'];
		$deskripsi 		= $post['kategori'];
		$cek = count($this->model->get_by($this->table, 'nama', $nama)->result());

		if ($this->form_validation->run() == False) {
			if ($cek < 1) {
				$data = ['nama' => $nama, 'deskripsi' => $deskripsi, 'kategori' => $kat];
				$this->model->update($this->table, 'nama', $oldNama, $data);

				$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('admin/metode_bayar');
			} else {
				$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>Metode pembayaran</b> sudah ada.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('admin/metode_bayar');
			}
		} else {
			$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Form <b>Metode pembayaran</b> tidak boleh kosong.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('admin/metode_bayar');
		}
	}

	public function delete($id = null)
	{
		if (!isset($id)) show_404();
		$id = str_replace(['-', '_', '~'], ['=', '+', '/'], $id);
		$id = $this->encryption->decrypt($id);
		$this->model->delete($this->table, 'id_metode_bayar', $id);
		$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Data Metode Pembayaran telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/metode_bayar');
	}
}
