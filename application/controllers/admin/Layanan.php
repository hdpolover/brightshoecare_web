<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Layanan extends CI_Controller
{

	var $table 		= 'layanan';
	var $folder		= 'layanan/';
	var $section 	= 'Layanan';

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
			'tampil'	=> $this->model->get_all($this->table)->result(),
			'kategori_layanan' => $this->model->get_all('kategori_layanan')->result()
		];

		$this->load->view('template/template', $data);
	}

	public function add()
	{
		$this->form_validation->set_rules('nama', 'Nama Layanan', 'required|rtrim');
		$this->form_validation->set_rules('deskripsi', 'Deskripsi', 'required|rtrim');
		$this->form_validation->set_rules('kategori_layanan', 'Kategori Layanan', 'required|rtrim');
		$this->form_validation->set_rules('harga', 'Harga', 'required|numeric');

		if ($this->form_validation->run() == true) {
			$post = $this->input->post();
			$cek = count($this->model->get_by($this->table, 'nama', $post['nama'])->result());

			if ($cek < 1) {
				$upload_path = 'uploads/layanan/';
				$config['upload_path'] = $upload_path;
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size'] = 2048; // 2MB
				$config['file_name'] = time(); // Use timestamp as file name

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('image')) {
					$uploadData = $this->upload->data();
					$gambar = $upload_path . $uploadData['file_name'];

					$data = [
						'id_layanan' => null,
						'nama' => $post['nama'],
						'deskripsi' => $post['deskripsi'],
						'id_kategori_layanan' => $post['kategori_layanan'],
						'harga' => $post['harga'],
						'gambar' => $gambar,
					];

					$this->model->save($this->table, $data);
					$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil disimpan.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					redirect('admin/layanan');
				} else {
					$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Gagal mengupload gambar. ' . $this->upload->display_errors() . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					redirect('admin/layanan');
				}
			} else {
				$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>Layanan</b> sudah ada.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('admin/layanan');
			}
		} else {
			$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Form <b>Layanan</b> tidak boleh kosong.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('admin/layanan');
		}
	}


	public function edit()
	{
		$this->form_validation->set_rules('nama', 'Nama Layanan', 'required|rtrim');
		$post = $this->input->post();
		$id_layanan = $post['id_layanan']; // Assuming you have an input field with name="id_layanan" in your form
		$oldNama = $post['old_nama'];
		$nama = $post['nama'];
		$deskripsi = $post['deskripsi'];
		$harga = $post['harga1'];
		$old_gambar = $post['old_gambar']; // This comes from the hidden input for the existing image file name

		// Validate the form
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Form <b>Nama Layanan</b> tidak boleh kosong.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('admin/layanan');
		} else {
			// Prepare data to update
			$data = [
				'nama' => $nama,
				'deskripsi' => $deskripsi,
				'harga' => $harga,
			];

			// Handle file upload if there's a new image
			if (!empty($_FILES['image']['name'])) {
				$config['upload_path'] = 'uploads/layanan/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['file_name'] = time(); // Rename file to timestamp
				$config['overwrite'] = TRUE; // Overwrite if file exists

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('image')) {
					$upload_data = $this->upload->data();
					$data['gambar'] =  'uploads/layanan/' . $upload_data['file_name'];
					// Delete old image file if exists
					if (!empty($old_gambar) && file_exists(FCPATH . $old_gambar)) {
						unlink(FCPATH . $old_gambar);
					}
				} else {
					$error = array('error' => $this->upload->display_errors());
					print_r($error);
				}
			}

			// Update database
			$this->model->update($this->table, 'id_layanan', $id_layanan, $data);

			$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">Data berhasil diubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('admin/layanan');
		}
	}


	public function delete($id = null)
	{
		if (!isset($id)) show_404();
		$id = str_replace(['-', '_', '~'], ['=', '+', '/'], $id);
		$id = $this->encryption->decrypt($id);
		$this->model->delete($this->table, 'id_layanan', $id);
		$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Data Layanan telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/layanan');
	}
}
