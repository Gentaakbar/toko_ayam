<?php


class Penjualan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if ($this->session->login['role'] != 'kasir' && $this->session->login['role'] != 'admin')
			redirect();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('M_barang', 'm_barang');
		$this->load->model('M_penjualan', 'm_penjualan');
		$this->load->model('M_detail_penjualan', 'm_detail_penjualan');
		$this->data['aktif'] = 'penjualan';
	}

	public function index()
	{
		$this->data['title'] = 'Data Penjualan';
		$this->data['all_penjualan'] = $this->m_penjualan->lihat();

		$this->load->view('penjualan/lihat', $this->data);
	}

	public function tambah()
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('error', 'tambah transaksi hanya untuk kasir!');
			redirect('penjualan');
		}
		$this->data['title'] = 'Tambah Penjualan';
		$this->data['all_barang'] = $this->m_barang->lihat_stok();

		$this->load->view('penjualan/tambah', $this->data);
	}

	public function proses_tambah()
	{
		$jumlah_barang_dibeli = count($this->input->post('nama_barang_hidden'));

		$data_penjualan = [
			'no_penjualan' => $this->input->post('no_penjualan'),
			'nama_kasir' => $this->input->post('nama_kasir'),
			'tgl_penjualan' => $this->input->post('tgl_penjualan'),
			'jam_penjualan' => $this->input->post('jam_penjualan'),
			'total' => $this->input->post('total_hidden'),
		];

		$data_detail_penjualan = [];

		for ($i = 0; $i < $jumlah_barang_dibeli; $i++) {
			array_push($data_detail_penjualan, ['nama_barang' => $this->input->post('nama_barang_hidden')[$i]]);
			$data_detail_penjualan[$i]['no_penjualan'] = $this->input->post('no_penjualan');
			$data_detail_penjualan[$i]['harga_barang'] = $this->input->post('harga_barang_hidden')[$i];
			$data_detail_penjualan[$i]['jumlah_barang'] = $this->input->post('jumlah_hidden')[$i];
			$data_detail_penjualan[$i]['satuan'] = $this->input->post('satuan_hidden')[$i];
			$data_detail_penjualan[$i]['sub_total'] = $this->input->post('sub_total_hidden')[$i];
		}

		if ($this->m_penjualan->tambah($data_penjualan) && $this->m_detail_penjualan->tambah($data_detail_penjualan)) {
			for ($i = 0; $i < $jumlah_barang_dibeli; $i++) {
				$this->m_barang->min_stok($data_detail_penjualan[$i]['jumlah_barang'], $data_detail_penjualan[$i]['nama_barang']) or die('gagal min stok');
			}
			$this->session->set_flashdata('success', 'Invoice <strong>Penjualan</strong> Berhasil Dibuat!');
			redirect('penjualan');
		} else {
			$this->session->set_flashdata('success', 'Invoice <strong>Penjualan</strong> Berhasil Dibuat!');
			redirect('penjualan');
		}
	}

	public function detail($no_penjualan)
	{
		if ($this->session->login['role'] == 'admin') {
			$this->session->set_flashdata('error', 'detail hanya untuk kasir!');
			redirect('penjualan');
		}
		$this->data['title'] = 'Detail Penjualan';
		$this->data['penjualan'] = $this->m_penjualan->lihat_no_penjualan($no_penjualan);
		$this->data['all_detail_penjualan'] = $this->m_detail_penjualan->lihat_no_penjualan($no_penjualan);
		$this->data['no'] = 1;

		$this->load->view('penjualan/detail', $this->data);
	}

	// public function hapus($no_penjualan)
	// {
	// 	if ($this->m_penjualan->hapus($no_penjualan) && $this->m_detail_penjualan->hapus($no_penjualan)) {
	// 		$this->session->set_flashdata('success', 'Invoice Penjualan <strong>Berhasil</strong> Dihapus!');
	// 		redirect('penjualan');
	// 	} else {
	// 		$this->session->set_flashdata('error', 'Invoice Penjualan <strong>Gagal</strong> Dihapus!');
	// 		redirect('penjualan');
	// 	}
	// }


	public function get_all_barang()
	{
		$data = $this->m_barang->lihat_nama_barang($_POST['nama_barang']);
		echo json_encode($data);
	}

	public function keranjang_barang()
	{
		$this->load->view('penjualan/keranjang');
	}

	public function export_pdf_lihat()
	{
		// $this->data['perusahaan'] = $this->m_usaha->lihat();
		$data['all_penjualan'] = $this->m_penjualan->lihat();
		$data['title'] = 'Laporan Data Penjualan';
		$data['no'] = 1;

		$this->load->library('dompdf_gen');

		$this->load->view('penjualan/report', $data);
		$paper_size = 'A4'; // ukuran kertas
		$orientation = 'landscape'; //tipe format kertas potrait atau landscape
		$html = $this->output->get_output();

		$this->dompdf->set_paper($paper_size, $orientation);
		//Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		ob_end_clean();

		$this->dompdf->stream('Laporan Data Penjualan Tanggal ' . date('d F Y'), array("Attachment" => false));
	}

	public function export_pdf_detail_penjualan($no_penjualan)
	{
		;
		// $this->data['perusahaan'] = $this->m_usaha->lihat();
		$data['penjualan'] = $this->m_penjualan->lihat_no_penjualan($no_penjualan);
		$data['all_detail_penjualan'] = $this->m_detail_penjualan->lihat_no_penjualan($no_penjualan);
		$data['title'] = 'Laporan Detail Penjualan';
		$data['no'] = 1;

		$this->load->library('dompdf_gen');

		$this->load->view('penjualan/detail_report', $data);
		$paper_size = 'A4'; // ukuran kertas
		$orientation = 'landscape'; //tipe format kertas potrait atau landscape
		$html = $this->output->get_output();

		$this->dompdf->set_paper($paper_size, $orientation);
		//Convert to PDF
		$this->dompdf->load_html($html);
		$this->dompdf->render();
		ob_end_clean();
		$this->dompdf->stream('Laporan Detail Penjualan Tanggal ' . date('d F Y'), array("Attachment" => false));
		// nama file pdf yang di hasilkan

	}

	public function export_print_detail_penjualan($no_penjualan)
	{
		;
		// $this->data['perusahaan'] = $this->m_usaha->lihat();
		$data['penjualan'] = $this->m_penjualan->lihat_no_penjualan($no_penjualan);
		$data['all_detail_penjualan'] = $this->m_detail_penjualan->lihat_no_penjualan($no_penjualan);
		$data['title'] = 'Laporan Detail Penjualan Tanggal ' . date('d F Y');
		$data['no'] = 1;

		$this->load->view('penjualan/detail_report_print', $data);
	}

	public function export_print_lihat()
	{
		// $this->data['perusahaan'] = $this->m_usaha->lihat();
		$data['all_penjualan'] = $this->m_penjualan->lihat();
		$data['title'] = 'Laporan Data Penjualan Tanggal ' . date('d F Y');
		$data['no'] = 1;

		$this->load->view('penjualan/report_print', $data);
	}
}