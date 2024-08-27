<?php
defined('BASEPATH') or exit('No direct scrip access allowed');

class Transaksi extends CI_Controller
{

	var $folder 	= 'transaksi/';
	var $section 	= 'Transaksi';
	var $table		= 'transaksi1';


	function __construct()
	{
		parent::__construct();
		$this->load->model(['model', 'validation']);
		$this->load->library(['form_validation', 'encryption', 'pdf']);
	}

	public function index()
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};
		$this->db->order_by('id_transaksi', 'DESC');
		$data = [
			'content'	=> $this->folder . ('view'),
			'section'	=> $this->section,
			'tampil'	=> $this->model->get_all($this->table)->result(),
			'status'	=> $this->model->get_all('transaksi_status1')->result(),
			'pembayaran' => $this->model->get_all('pembayaran')->result(),
		];

		$this->load->view('template/template', $data);
	}

	// public function cetak($id = null)
	// {
	// 	if ($this->session->userdata('masuk') != TRUE) {
	// 		redirect(base_url(''));
	// 	};

	// 	$id = str_replace(['-', '_', '~'], ['=', '+', '/'], $id);
	// 	$id = $this->encryption->decrypt($id);
	// 	$transaksi = $this->model->get_by($this->table, 'id_transaksi', $id)->row();
	// 	$detail_transaksi = $this->model->get_by('transaksi_detail1', 'id_transaksi', $id)->result();
	// 	$pelanggan = $this->model->get_by('pelanggan', 'id', $transaksi->id_pelanggan)->row();
	// 	$status_pesanan = $this->model->get_by('transaksi_status1', 'id_transaksi', $id)->row();

	// 	$data = [
	// 		'transaksi'	=> $transaksi,
	// 		'pelanggan'	=> $pelanggan,
	// 		'status_pesanan' => $status_pesanan,
	// 		'detail_transaksi' => $detail_transaksi,
	// 	];

	// 	$this->pdf->setPaper('A4', 'potrait');
	// 	$this->pdf->filename = "Detail " . $transaksi->no_transaksi . ".pdf";
	// 	$this->pdf->load_view('transaksi/cetak', $data);
	// }

	public function detail($id = null)
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};

		$id = str_replace(['-', '_', '~'], ['=', '+', '/'], $id);
		$id = $this->encryption->decrypt($id);
		$transaksi = $this->model->get_by($this->table, 'id_transaksi', $id)->row();
		$detail_transaksi = $this->model->get_by('transaksi_detail1', 'id_transaksi', $id)->result();
		$pelanggan = $this->model->get_by('pelanggan', 'id', $transaksi->id_pelanggan)->row();
		$status_pesanan = $this->model->get_by('transaksi_status1', 'id_transaksi', $id)->row();
		$pembayaran = $this->model->get_by('pembayaran', 'id_transaksi', $id)->row();

		$data = [
			'content'	=> $this->folder . ('detail'),
			'transaksi'	=> $transaksi,
			'pelanggan'	=> $pelanggan,
			'status_pesanan' => $status_pesanan,
			'detail_transaksi' => $detail_transaksi,
			'pembayaran' => $pembayaran,
		];

		$this->load->view('template/template', $data);
	}

	public function tambah()
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};
		$data = [
			'content'	=> $this->folder . ('tambah'),
			'section'	=> $this->section,
			'pelanggan' => $this->model->get_all('pelanggan')->result(),
			'layanan' => $this->model->get_all('layanan')->result(),
		];

		$this->load->view('template/template', $data);
	}

	public function pesan()
	{
		// Get form data
		$id_pelanggan = $this->input->post('id_pelanggan');
		$total_price = $this->input->post('total_price');
		$tgl_dibuat = date('Y-m-d H:i:s'); // Get current date and time
		$catatan = $this->input->post('catatan'); // Add this field in your form if necessary

		// Prepare data for insertion into transaksi1
		$data_transaksi = array(
			'id_pelanggan' => $id_pelanggan,
			'tgl_dibuat' => $tgl_dibuat,
			'no_transaksi' => $this->generate_transaction_number(),
			'total' => $total_price,
			'catatan' => $catatan
		);

		// Insert data into transaksi1 table
		$insert_id = $this->model->save_and_return_id('transaksi1', $data_transaksi);

		if ($insert_id) {
			// Get services data from form
			$layanan = $this->input->post('services');
			$quantity = $this->input->post('quantity');

			// Ensure that layanan and quantities are arrays and have the same length
			if (is_array($layanan)) {
				// Loop through services and insert into transaksi_detail1
				foreach ($layanan as $l) {
					// Get service details from the database
					$service = $this->model->get_by("layanan", "id_layanan", $l)->row(); // Make sure this method exists and works correctly

					$sub_total = $service->harga * $quantity;

					// Prepare data for insertion into transaksi_detail1
					$data_detail = array(
						'id_transaksi' => $insert_id,
						'id_layanan' => $service->id_layanan,
						'jumlah' => $quantity,
						'sub_total' => $sub_total
					);

					// Insert data into transaksi_detail1 table
					$this->model->save("transaksi_detail1", $data_detail);

					// Insert status
					$this->insert_status($insert_id);
				}
			} else {
				// Get service details from the database
				$service = $this->model->get_by("layanan", "id_layanan", $layanan)->row(); // Make sure this method exists and works correctly

				$sub_total = $service->harga * $quantity;

				// Prepare data for insertion into transaksi_detail1
				$data_detail = array(
					'id_transaksi' => $insert_id,
					'id_layanan' => $service->id_layanan,
					'jumlah' => $quantity,
					'sub_total' => $sub_total
				);

				// Insert data into transaksi_detail1 table
				$this->model->save("transaksi_detail1", $data_detail);

				// Insert status
				$this->insert_status($insert_id);
			}

			$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">Pesanan berhasil dibuat.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('admin/transaksi/bayar/' . $insert_id);
		} else {
			$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>Terjadi kesalahan!</b> Pesananan gagal dibuat.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('admin/transaksi');
		}
	}

	public function insert_status($id_transaksi)
	{
		$data_detail = array(
			'id_transaksi' => $id_transaksi,
			'dibuat' => 1,
			'menunggu' => 0,
			'proses' => 0,
			'siap' => 0,
			'selesai' => 0,
		);

		// Insert data into transaksi_detail1 table
		$this->model->save("transaksi_status1", $data_detail);
	}

	public function ubah_status()
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};

		$id = $this->input->post('id');
		$status = $this->input->post('status');

		$status_change = [];

		if ($status == 1) {
			$status_change = ['dibuat' => 1, 'menunggu' => 0, 'proses' => 0, 'siap' => 0, 'selesai' => 0];
		} elseif ($status == 2) {
			$status_change = ['dibuat' => 1, 'menunggu' => 1, 'proses' => 0, 'siap' => 0, 'selesai' => 0];
		} elseif ($status == 3) {
			$status_change = ['dibuat' => 1, 'menunggu' => 1, 'proses' => 1, 'siap' => 0, 'selesai' => 0];
		} elseif ($status == 4) {
			$status_change = ['dibuat' => 1, 'menunggu' => 1, 'proses' => 1, 'siap' => 1, 'selesai' => 0];
		} elseif ($status == 5) {
			$status_change = ['dibuat' => 1, 'menunggu' => 1, 'proses' => 1, 'siap' => 1, 'selesai' => 1];
		}

		$this->model->update('transaksi_status1', 'id_transaksi', $id, $status_change);


		$status_pesanan = $this->model->get_by('transaksi_status1', 'id_transaksi', $id)->row();

		$transaksi = $this->model->get_by($this->table, 'id_transaksi', $id)->row();
		$detail_transaksi = $this->model->get_by('transaksi_detail1', 'id_transaksi', $id)->result();
		$pelanggan = $this->model->get_by('pelanggan', 'id', $transaksi->id_pelanggan)->row();
		$status_pesanan = $this->model->get_by('transaksi_status1', 'id_transaksi', $id)->row();
		$pembayaran = $this->model->get_by('pembayaran', 'id_transaksi', $id)->row();

		$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">Status berhasil di ubah.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

		$data = [
			'content'	=> $this->folder . ('detail'),
			'transaksi'	=> $transaksi,
			'pelanggan'	=> $pelanggan,
			'status_pesanan' => $status_pesanan,
			'detail_transaksi' => $detail_transaksi,
			'pembayaran' => $pembayaran,
		];

		$this->load->view('template/template', $data);
	}

	public function bayar($id_transaksi = null)
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		}

		// Fetch the transaction data
		$transaksi = $this->model->get_by('transaksi1', 'id_transaksi', $id_transaksi)->row();

		// Fetch the details for the specific transaction
		$transaksi_detail = $this->model->get_by('transaksi_detail1', 'id_transaksi', $id_transaksi)->result();

		// Calculate total and subtotals
		$total_price = 0;
		foreach ($transaksi_detail as $detail) {
			$total_price += $detail->sub_total;
		}

		$data = [
			'content' => $this->folder . 'bayar',
			'section' => $this->section,
			'transaksi' => $transaksi,
			'layanan' => $this->model->get_all('layanan')->result(),
			'id_transaksi' => $id_transaksi,
			'no_transaksi' => $transaksi->no_transaksi,
			'transaksi_detail' => $transaksi_detail,
			'metode_bayar' => $this->model->get_all('metode_bayar')->result(),
			'total_price' => $total_price
		];

		$this->load->view('template/template', $data);
	}

	public function generate_transaction_number()
	{
		// Prefix for transaction number (optional)
		$prefix = 'TRX-';

		// Get the current date and time
		$date_time = date('Ymd-His'); // Format: yyyyMMdd-HHmmss

		// Generate a random 4-digit number
		$random_number = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

		// Combine all parts to create the transaction number
		$transaction_number = $prefix . $date_time . '-' . $random_number;

		return $transaction_number;
	}

	public function generate_invoice_number()
	{
		// Prefix for invoice number
		$prefix = 'INV-';

		// Get the current date and time
		$date_time = date('YmdHis'); // Format: yyyyMMddHHmmss

		// Generate a random 4-digit number
		$random_number = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

		// Combine all parts to create the invoice number
		$invoice_number = $prefix . $date_time . '-' . $random_number;

		return $invoice_number;
	}

	public function save_bayar()
	{
		// Check if user is logged in
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		}

		// Initialize the data array
		$data = array(
			'id_transaksi' => $this->input->post('id_transaksi'),
			'id_metode_bayar' => $this->input->post('id_metode_bayar'),
			'status' => $this->input->post('status_pembayaran'),
			'no_invoice' => $this->generate_invoice_number(),
			'tgl_bayar' => date('Y-m-d H:i:s'), // Current date and time
			'catatan' => $this->input->post('catatan')
		);

		// Handle file upload
		if (!empty($_FILES['bukti_pembayaran']['name'])) {
			// Configuration for file upload
			$config['upload_path']   = 'uploads/pembayaran/';
			$config['allowed_types'] = 'jpg|jpeg|png|pdf';
			$config['max_size']      = 2048; // Maximum file size in KB

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('bukti_pembayaran')) {
				$upload_data = $this->upload->data();
				$timestamp = time(); // Get current timestamp
				$file_extension = pathinfo($upload_data['file_name'], PATHINFO_EXTENSION);
				$new_file_name = $timestamp . '.' . $file_extension;
				rename($upload_data['full_path'], $config['upload_path'] . $new_file_name); // Rename the file

				$data['bukti_bayar'] = $config['upload_path'] . $new_file_name; // Save the new file path
			} else {
				// Handle upload error
				$error = $this->upload->display_errors();
				$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><b>Terjadi kesalahan!</b><?php $error ?>.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect(base_url('admin/transaksi/bayar/' . $this->input->post('id_transaksi')));
			}
		}

		// Insert data into 'pembayaran' table
		$this->model->save('pembayaran', $data);

		// Redirect or load a view with a success message
		$this->session->set_flashdata('flash', '<div class="alert alert-success alert-dismissible fade show" role="alert">Pembayaran berhasil dibuat.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');

		redirect(base_url('admin/transaksi'));
	}



	public function paket()
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};
		$data = [
			'content'	=> $this->folder . ('paket'),
			'section'	=> $this->section,
		];

		$this->load->view('template/template', $data);
	}

	public function kiloan()
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};
		$this->db->order_by('nama_pakaian', 'ASC');
		$data = [
			'content'	=> $this->folder . ('kiloan'),
			'section'	=> $this->section,
			'tampil'	=> $this->model->get_all('pakaian')->result(),
			'tarif'	=> $this->model->get_by('tarif', 'jenis_tarif', 'Kg')->result()
		];

		$this->load->view('template/template', $data);
	}

	public function add_cart_kiloan()
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};
		$id 	= $this->input->post('id');
		$p 		= $this->model->get_by('pakaian', 'id_pakaian', $id)->row_array();
		$i 		= $p;

		$data = [
			'id'	=> $p['id_pakaian'],
			'name'	=> $p['nama_pakaian'],
			'price'	=> 0,
			'qty'	=> $this->input->post('jumlah')
		];

		if ($this->cart->total_items() > 0) {
			$id 		= $items['id'];
			$idPakaian 	= $this->input->post('id');
			if ($id == $idPakaian) {
				$up = ['rowid' => $rowid];
				$this->cart->update($up);
			} else {
				$this->cart->insert($data);
			}
		} else {
			$this->cart->insert($data);
		}
		redirect('admin/transaksi/kiloan');
	}

	public function remove_kiloan()
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};
		$row_id = $this->uri->segment(4);
		$this->cart->update(array(
			'rowid'      => $row_id,
			'qty'     	=> 0
		));
		redirect('admin/transaksi/kiloan');
	}

	public function save_kiloan()
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};

		$this->form_validation->set_rules($this->validation->val_transaksi_kiloan());

		if ($this->form_validation->run() == true) {
			// Save ke table transaksi
			date_default_timezone_set('Asia/Jakarta');
			$row 	= count($this->model->get_all($this->table)->result());
			$id 	= date('dmyHis') . '0' . ($row + 1);
			$nama 	= $this->input->post('nama');
			$paket 	= $this->input->post('paket');
			$berat 	= $this->input->post('berat');
			$bayar 	= $this->input->post('total');

			$data = [
				'id_transaksi' 		=> $id,
				'nama'				=> $nama,
				'tgl_transaksi'		=> date('d-m-Y'),
				'jam_transaksi'		=> date("H:i"),
				'paket_transaksi'	=> $paket . ')',
				'jenis_paket'		=> 'Kg',
				'berat_jumlah'		=> $berat,
				'total_transaksi'	=> $bayar,
				'status'			=> 0
			];
			$this->model->save($this->table, $data);


			// save ke table detail transaksi
			foreach ($this->cart->contents() as $item) {
				$data =	[
					'id_detail' 			=>	null,
					'id_transaksi_d'		=>	$id,
					'nama_d'				=>	$item['name'],
					'jumlah_d'				=>	$item['qty'],
				];
				$this->model->save('transaksi_detail', $data);
				$this->cart->destroy();
			}

			// Save ke table status laundry
			$data = [
				'id_status'			=> null,
				'id_transaksi_s'	=> $id,
				'cuci'				=> 1,
				'kering'			=> 0,
				'strika'			=> 0,
				'siap'				=> 0,
				'selesai'			=> 0,
				'tgl_ambil'			=> 0,
			];
			$this->model->save('transaksi_status', $data);
			$id = str_replace(['=', '+', '/'], ['-', '_', '~'], $this->encryption->encrypt($id));
			redirect('admin/transaksi/cetak/' . $id);
		} else {
			$this->db->order_by('nama_pakaian', 'ASC');
			$data = [
				'content'	=> $this->folder . ('kiloan'),
				'section'	=> $this->section,
				'tampil'	=> $this->model->get_all('pakaian')->result(),
				'tarif'		=> $this->model->get_by('tarif', 'jenis_tarif', 'Kg')->result()
			];

			$this->load->view('template/template', $data);
		}
	}

	public function satuan()
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};
		$this->db->order_by('nama_tarif', 'ASC');
		$data = [
			'content'	=> $this->folder . ('satuan'),
			'section'	=> $this->section,
			'tampil'	=> $this->model->get_by('tarif', 'jenis_tarif', 'Satuan')->result()
		];

		$this->load->view('template/template', $data);
	}

	public function add_cart_satuan()
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};
		$id 	= $this->input->post('id');
		$p 		= $this->model->get_by('tarif', 'id_tarif', $id)->row_array();
		$i 		= $p;

		$data = [
			'id'	=> $p['id_tarif'],
			'name'	=> $p['nama_tarif'],
			'price'	=> $p['biaya_tarif'],
			'qty'	=> $this->input->post('jumlah')
		];

		if ($this->cart->total_items() > 0) {
			$id 		= $items['id'];
			$idBarang 	= $this->input->post('id');
			if ($id == $idBarang) {
				$up = ['rowid' => $rowid];
				$this->cart->update($up);
			} else {
				$this->cart->insert($data);
			}
		} else {
			$this->cart->insert($data);
		}
		redirect('admin/transaksi/satuan');
	}

	public function remove_satuan()
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};
		$row_id = $this->uri->segment(4);
		$this->cart->update(array(
			'rowid'      => $row_id,
			'qty'     	=> 0
		));
		redirect('admin/transaksi/satuan');
	}

	public function save_satuan()
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};
		$this->form_validation->set_rules($this->validation->val_transaksi_satuan());

		if ($this->form_validation->run() == true) {
			// Save ke table transaksi
			date_default_timezone_set('Asia/Jakarta');
			$bayar 	= $this->cart->total();
			$nama 	= $this->input->post('nama');

			foreach ($this->cart->contents() as $item) {
				$row 	= count($this->model->get_all($this->table)->result());
				$id 	= date('dmyHis') . '0' . ($row + 1);
				$data = [
					'id_transaksi' 		=> $id,
					'nama'				=> $nama,
					'tgl_transaksi'		=> date('d-m-Y'),
					'jam_transaksi'		=> date('H-i-s'),
					'paket_transaksi'	=> $item['name'] . ' (' . $item['price'] . ')',
					'jenis_paket'		=> 'Pcs',
					'berat_jumlah'		=> $item['qty'],
					'total_transaksi'	=> $item['subtotal']
				];
				$this->model->save($this->table, $data);

				// save ke table detail transaksi
				$dati =	[
					'id_detail' 			=>	null,
					'id_transaksi_d'	=>	$id,
					'nama_d'					=>	$item['name'],
					'jumlah_d'				=>	$item['qty'],
				];
				$this->model->save('transaksi_detail', $dati);
				$this->cart->destroy();
			}

			// Save ke table status laundry
			$data = [
				'id_status'				=> null,
				'id_transaksi_s'	=> $id,
				'cuci'						=> 1,
				'kering'					=> 0,
				'strika'					=> 0,
				'siap'						=> 0,
				'selesai'					=> 0,
				'tgl_ambil'				=> 0,
			];
			$this->model->save('transaksi_status', $data);

			$id = str_replace(['=', '+', '/'], ['-', '_', '~'], $this->encryption->encrypt($id));
			redirect('admin/transaksi/cetak/' . $id);
		} else {
			$data = [
				'content'	=> $this->folder . ('satuan'),
				'section'	=> $this->section,
				'tampil'	=> $this->model->get_by('tarif', 'jenis_tarif', 'Satuan')->result(),
			];

			$this->load->view('template/template', $data);
		}
	}

	public function berhasil()
	{
		if ($this->session->userdata('masuk') != TRUE) {
			redirect(base_url(''));
		};
		echo 'Berhasil';
	}

	public function cetak($idTransaksi = null)
	{
		if (!isset($idTransaksi)) show_404();

		$idTransaksi = str_replace(['-', '_', '~'], ['=', '+', '/'], $idTransaksi);
		$idTransaksi = $this->encryption->decrypt($idTransaksi);

		$transaksi = $this->db->select('nama, tgl_transaksi, paket_transaksi, jenis_paket, berat_jumlah, total_transaksi, nama_d, jumlah_d')
			->from('transaksi as a')
			->join('transaksi_detail as b', 'a.id_transaksi=b.id_transaksi_d')
			->where('id_transaksi', $idTransaksi)
			->get()
			->result();

		if (count($transaksi) === 0) {
			redirect('admin/transaksi');
		}

		$struk 		= $idTransaksi;
		$jml_uang 	= 5000;
		$nama  		= $transaksi[0]->nama;
		$total 		= $transaksi[0]->total_transaksi;
		$berat 		= $transaksi[0]->berat_jumlah . ' ' . $transaksi[0]->jenis_paket;
		$paket 		= $transaksi[0]->paket_transaksi;
		$tanggal 	= $transaksi[0]->tgl_transaksi;


		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'B', 16);
		$pdf->Cell(190, 7, 'Struk Laundry', 0, 0, 'C');
		$pdf->Cell(10, 20, '', 0, 1); //Jarak


		$pdf->SetFont('Arial', '', 12);
		$pdf->Cell(125, 6, 'No.Struk  : ' . $struk, 0, 0);
		$pdf->Cell(80, 6, 'Paket    : ' . $paket, 0, 1);
		$pdf->Cell(125, 6, 'Name       : ' . $nama, 0, 0);
		$pdf->Cell(80, 6, 'Berat     : ' . $berat, 0, 1);
		$pdf->Cell(125, 6, 'Tanggal  	 : ' . $tanggal, 0, 0);
		$pdf->Cell(80, 6, 'Total      : Rp ' . number_format($total, 0, '', '.'), 0, 1);
		$pdf->Cell(10, 10, '', 0, 1); //Jarak

		// Start table
		$pdf->SetFont('Arial', 'B', '10');
		$pdf->Cell(10, 6, 'NO', 1, 0);
		$pdf->Cell(133, 6, 'Jenis Pakaian', 1, 0);
		$pdf->Cell(20, 6, 'Jumlah', 1, 1, 'C');

		$pdf->SetFont('Arial', '', '10');

		$no = 1;
		foreach ($transaksi as $t) {
			$pdf->Cell(10, 6, $no, 1, 0, 'C');
			$pdf->Cell(133, 6, $t->nama_d, 1, 0);
			$pdf->Cell(20, 6, $t->jumlah_d, 1, 1);
			$no++;
		}

		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(0, 2, '', 0, 1); //Jarak
		$pdf->Cell(125, 6, '*Note: untuk pengecekan progres laundry di https://yuklaundry-in.000webhostapp.com/ dan masukkan no struk anda.', 0, 0);
		// End Table
		$pdf->Output();
	}
	public function delete($id = null)
	{
		if (!isset($id)) show_404();
		$id = str_replace(['-', '_', '~'], ['=', '+', '/'], $id);
		$id = $this->encryption->decrypt($id);
		$this->model->delete($this->table, 'id_transaksi', $id);
		$this->session->set_flashdata('flash', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Data Pakaian telah di hapus.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		redirect('admin/transaksi');
	}
}
