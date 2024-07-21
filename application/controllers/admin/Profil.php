<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

	class Profil extends CI_Controller{

		var $folder		= 'admin/';

		function __construct(){
			parent::__construct();
			if($this->session->userdata('masuk') !=TRUE){
	            redirect(base_url('')); 
	        };
	        $this->load->model(['model']);
		}

		var $section = 'Profil';
		public function index()
		{
			$data = ['content'=>'admin/profil',
					 'section'=>$this->section
					 ];
			$this->load->view('template/template', $data);
		}

		public function ubahprofil()
		{
			$data = ['content'	=> $this->folder.('ubahprofil'),
					 'section'	=> $this->section,
					 ];
			$this->load->view('template/template', $data);
		}

		public function save()
	{
		$post 	 = $this->input->post();
		$nama 	 = $post['nama'];
		$where   = [
			'username' => $this->session->userdata('username')];
		$data = array('nama' => $nama);
		$this->model->update_profil($where,$data,'user');
		redirect('admin/profil');

	}

	}
 ?>