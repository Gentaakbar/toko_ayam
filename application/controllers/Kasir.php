<?php

class Kasir extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->login['role'] != 'kasir' && $this->session->login['role'] != 'admin')
			redirect();
		$this->data['aktif'] = 'kasir';
		$this->load->model('M_kasir', 'm_kasir');
	}

	public function index()
	{
		$this->data['title'] = 'Data Kasir';
		$this->data['all_kasir'] = $this->m_kasir->lihat();
		$this->data['no'] = 1;

		$this->load->view('kasir/lihat', $this->data);
	}

	public function tambah()
	{
		if ($this->session->login['role'] == 'kasir') {
			$this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
			redirect('penjualan');
		}

		$this->data['title'] = 'Tambah Kasir';

		$this->load->view('kasir/tambah', $this->data);
	}

	public function proses_tambah()
	{
		if ($this->session->login['role'] == 'kasir') {
			$this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
			redirect('penjualan');
		}

		$data = [
			'kode_kasir' => $this->input->post('kode_kasir'),
			'nama_kasir' => $this->input->post('nama_kasir'),
			'username_kasir' => $this->input->post('username_kasir'),
			'password_kasir' => $this->input->post('password_kasir'),
		];

		if ($this->m_kasir->tambah($data)) {
			$this->session->set_userdata('persistent_success', 'Data Kasir <strong>Berhasil</strong> Ditambahkan!');
			redirect('kasir');
		} else {
			$this->session->set_flashdata('error', 'Data Kasir <strong>Gagal</strong> Ditambahkan!');
			redirect('kasir');
		}
	}

	public function ubah($id)
	{
		if ($this->session->login['role'] == 'kasir') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('penjualan');
		}

		$this->data['title'] = 'Ubah Kasir';
		$this->data['kasir'] = $this->m_kasir->lihat_id($id);

		$this->load->view('kasir/ubah', $this->data);
	}

	public function proses_ubah($id)
	{
		if ($this->session->login['role'] == 'kasir') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('penjualan');
		}

		$data = [
			'kode_kasir' => $this->input->post('kode_kasir'),
			'nama_kasir' => $this->input->post('nama_kasir'),
			'username_kasir' => $this->input->post('username_kasir'),
			'password_kasir' => $this->input->post('password_kasir'),
		];

		if ($this->m_kasir->ubah($data, $id)) {
			$this->session->set_userdata('persistent_success', 'Data Kasir <strong>Berhasil</strong> Diubah!');
			redirect('kasir');
		} else {
			$this->session->set_flashdata('error', 'Data Kasir <strong>Gagal</strong> Diubah!');
			redirect('kasir');
		}
	}

	public function hapus($id)
	{
		if ($this->session->login['role'] == 'kasir') {
			$this->session->set_flashdata('error', 'Hapus data hanya untuk admin!');
			redirect('penjualan');
		}

		if ($this->m_kasir->hapus($id)) {
			$this->session->set_userdata('persistent_success', 'Data Kasir <strong>Berhasil</strong> Dihapus!');
			redirect('kasir');
		} else {
			$this->session->set_flashdata('error', 'Data Kasir <strong>Gagal</strong> Dihapus!');
			redirect('kasir');
		}
	}

	public function export_pdf_lihat()
	{
		// $this->data['perusahaan'] = $this->m_usaha->lihat();
		$data['all_kasir'] = $this->m_kasir->lihat();
		$data['title'] = 'Laporan Data Kasir';
		$data['no'] = 1;

		$this->load->library('dompdf_gen');

		$this->load->view('kasir/report_pdf', $data);
		$paper_size = 'A4'; // ukuran kertas
		$orientation = 'landscape'; //tipe format kertas potrait atau landscape
		$html = $this->output->get_output();

		$this->dompdf->set_paper($paper_size, $orientation);
		//Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		ob_end_clean();

		$this->dompdf->stream('Laporan Data Kasir Tanggal ' . date('d F Y'), array("Attachment" => false));
	}

	public function export_print_lihat()
	{
		// $this->data['perusahaan'] = $this->m_usaha->lihat();
		$data['all_kasir'] = $this->m_kasir->lihat();
		$data['title'] = 'Laporan Data Kasir Tanggal ' . date('d F Y');
		$data['no'] = 1;

		$this->load->view('kasir/report_print', $data);
	}
}