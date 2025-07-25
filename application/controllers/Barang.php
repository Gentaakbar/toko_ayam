<?php

class Barang extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->login['role'] != 'kasir' && $this->session->login['role'] != 'admin')
			redirect();
		$this->data['aktif'] = 'barang';
		$this->load->model('M_barang', 'm_barang');
	}

	public function index()
	{
		$this->data['title'] = 'Data Stok';
		$this->data['all_barang'] = $this->m_barang->lihat();
		$this->data['no'] = 1;

		$this->load->view('barang/lihat', $this->data);
	}

	public function tambah()
	{
		if ($this->session->login['role'] == 'kasir') {
			$this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
			redirect('penjualan');
		}

		$this->data['title'] = 'Tambah Stok';

		$this->load->view('barang/tambah', $this->data);
	}

	public function proses_tambah()
	{
		if ($this->session->login['role'] == 'kasir') {
			$this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
			redirect('penjualan');
		}

		$data = [
			'kode_barang' => $this->input->post('kode_barang'),
			'nama_barang' => $this->input->post('nama_barang'),
			'harga_jual' => $this->input->post('harga_jual'),
			'stok' => $this->input->post('stok'),
		];

		if ($this->m_barang->tambah($data)) {
			$this->session->set_userdata('persistent_success', 'Data Barang <strong>Berhasil</strong> Ditambahkan!');
		} else {
			$this->session->set_userdata('persistent_error', 'Data Barang <strong>Gagal</strong> Ditambahkan!');
		}
		redirect('barang');

	}

	public function ubah($kode_barang)
	{
		if ($this->session->login['role'] == 'kasir') {
			// Cek apakah sudah pernah ditampilkan
			if (!$this->session->flashdata('already_warned')) {
				$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
				$this->session->set_flashdata('already_warned', true); // tandai sudah tampilkan
			}
			redirect('penjualan');
		}


		$this->data['title'] = 'Ubah Stok';
		$this->data['barang'] = $this->m_barang->lihat_id($kode_barang);

		$this->load->view('barang/ubah', $this->data);
	}

	public function proses_ubah($kode_barang)
	{
		if ($this->session->login['role'] == 'kasir') {
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('penjualan');
		}

		$data = [
			'kode_barang' => $this->input->post('kode_barang'),
			'nama_barang' => $this->input->post('nama_barang'),
			'harga_jual' => $this->input->post('harga_jual'),
			'stok' => $this->input->post('stok'),
		];

		if ($this->m_barang->ubah($data, $kode_barang)) {
			$this->session->set_userdata('persistent_success', 'Data Barang <strong>Berhasil</strong> Diubah!');
			redirect('barang');
		} else {
			$this->session->set_userdata('persistent_error', 'Data Barang <strong>Gagal</strong> Ditambahkan!');
		}
	}

	public function hapus($kode_barang)
	{
		if ($this->session->login['role'] == 'kasir') {
			$this->session->set_flashdata('error', 'Hapus data hanya untuk admin!');
			redirect('penjualan');
		}

		if ($this->m_barang->hapus($kode_barang)) {
			$this->session->set_userdata('persistent_success', 'Data Barang <strong>Berhasil</strong> dihapus!');
			redirect('barang');
		} else {
			$this->session->set_flashdata('error', 'Data Barang <strong>Gagal</strong> Dihapus!');
			redirect('barang');
		}
	}

	public function export_pdf_lihat()
	{
		// $this->data['perusahaan'] = $this->m_usaha->lihat();
		$data['all_barang'] = $this->m_barang->lihat();
		$data['title'] = 'Laporan Data Stok';
		$data['no'] = 1;
		$this->load->library('dompdf_gen');

		$this->load->view('barang/report_pdf', $data);
		$paper_size = 'A4'; // ukuran kertas
		$orientation = 'landscape'; //tipe format kertas potrait atau landscape
		$html = $this->output->get_output();

		$this->dompdf->set_paper($paper_size, $orientation);
		//Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		ob_end_clean();
		$this->dompdf->stream("Laporan Data Barang Tanggal " . date('d F Y'), array('Attachment' => 0));
		// nama file pdf yang di hasilkan
	}

	public function export_print_lihat()
	{
		// $this->data['perusahaan'] = $this->m_usaha->lihat();
		$data['all_barang'] = $this->m_barang->lihat();
		$data['title'] = 'Laporan Data Stok Tanggal ' . date('d F Y');
		$data['no'] = 1;

		$this->load->view('barang/report_print', $data);
	}

}