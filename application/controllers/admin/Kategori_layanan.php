<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Kategori_layanan extends CI_Controller
{

	var $table 		= 'kategori_layanan';
	var $folder		= 'kategori_layanan/';
	var $section 	= 'Kategori Layanan';

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
		$this->form_validation->set_rules('nama', 'Kategori Layanan', 'required|rtrim');
		$post 	= $this->input->post();
		$cek 	= count($this->model->get_by($this->table, 'nama', $post['nama'])->result());
		if ($this->form_validation->run() == true) {
			if ($cek < 1) {
				$data = [
					'id_kategori_layanan'	=> null,
					'nama'	=> $post['nama'],
					'deskripsi'	=> $post['deskripsi'],
				];
				$this->model->save($this->table, $data);
				$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil di simpan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('admin/kategori_layanan');
			} else {
				$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>Kategori Layanan</b> sudah ada.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('admin/kategori_layanan');
			}
		} else {
		}
		$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Form <b>Kategori Layanan</b> tidak boleh kosong.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/kategori_layanan');
	}


	public function edit()
	{
		$this->form_validation->set_rules('nama', 'Nama Kategori Layanan', "required|rtrim|");
		$post 		= $this->input->post();
		$oldNama	= $post['oldNama'];
		$nama 		= $post['nama'];
		$deskripsi 		= $post['deskripsi'];
		$cek = count($this->model->get_by($this->table, 'nama', $nama)->result());

		if ($this->form_validation->run() == False) {
			if ($cek < 1) {
				$data = ['nama' => $nama, 'deskripsi' => $deskripsi];
				$this->model->update($this->table, 'nama', $oldNama, $data);

				$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('admin/kategori_layanan');
			} else {
				$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>kategori Layanan</b> sudah ada.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('admin/kategori_layanan');
			}
		} else {
			$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Form <b>kategori Layanan</b> tidak boleh kosong.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('admin/kategori_layanan');
		}
	}

	public function delete($id = null)
	{
		if (!isset($id)) show_404();
		$id = str_replace(['-', '_', '~'], ['=', '+', '/'], $id);
		$id = $this->encryption->decrypt($id);
		$this->model->delete($this->table, 'id_kategori_layanan', $id);
		$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Data Kategori Layanan telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/kategori_layanan');
	}
}
