<?php

use Dompdf\Dompdf;

class Pengguna extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if($this->session->login['role'] != 'kasir' && $this->session->login['role'] != 'admin') redirect();
		$this->data['aktif'] = 'pengguna';
		$this->load->model('M_pengguna', 'm_pengguna');
	}

	public function index(){
		if ($this->session->login['role'] == 'kasir'){
			$this->session->set_flashdata('error', 'Managemen Pengguna hanya untuk admin!');
			redirect('penjualan');
		}

		$this->data['title'] = 'Data Pengguna';
		$this->data['all_pengguna'] = $this->m_pengguna->lihat();
		$this->data['no'] = 1;

		$this->load->view('pengguna/lihat', $this->data);
	}

	public function tambah(){
		if ($this->session->login['role'] == 'kasir'){
			$this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
			redirect('penjualan');
		}

		$this->data['title'] = 'Tambah Pengguna';

		$this->load->view('pengguna/tambah', $this->data);
	}

	public function proses_tambah(){
		if ($this->session->login['role'] == 'kasir'){
			$this->session->set_flashdata('error', 'Tambah data hanya untuk admin!');
			redirect('penjualan');
		}

		$data = [
			'kode_pengguna' => $this->input->post('kode_pengguna'),
			'nama_pengguna' => $this->input->post('nama_pengguna'),
			'username_pengguna' => $this->input->post('username_pengguna'),
			'password_pengguna' => $this->input->post('password_pengguna'),
		];

		if($this->m_pengguna->tambah($data)){
			$this->session->set_userdata('persistent_success', 'Data Admin <strong>Berhasil</strong> Ditambahkan!');
			redirect('pengguna');
		} else {
			$this->session->set_flashdata('error', 'Data Pengguna <strong>Gagal</strong> Ditambahkan!');
			redirect('pengguna');
		}
	}

	public function ubah($id){
		if ($this->session->login['role'] == 'kasir'){
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('penjualan');
		}

		$this->data['title'] = 'Ubah Pengguna';
		$this->data['pengguna'] = $this->m_pengguna->lihat_id($id);

		$this->load->view('pengguna/ubah', $this->data);
	}

	public function proses_ubah($id){
		if ($this->session->login['role'] == 'kasir'){
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('penjualan');
		}

		$data = [
			'kode_pengguna' => $this->input->post('kode_pengguna'),
			'nama_pengguna' => $this->input->post('nama_pengguna'),
			'username_pengguna' => $this->input->post('username_pengguna'),
			'password_pengguna' => $this->input->post('password_pengguna'),
		];

		if($this->m_pengguna->ubah($data, $id)){
			$this->session->set_userdata('persistent_success', 'Data Admin <strong>Berhasil</strong> Diubah!');
			redirect('pengguna');
		} else {
			$this->session->set_flashdata('error', 'Data Pengguna <strong>Gagal</strong> Diubah!');
			redirect('pengguna');
		}
	}

	public function hapus($id){
		if ($this->session->login['role'] == 'kasir'){
			$this->session->set_flashdata('error', 'Ubah data hanya untuk admin!');
			redirect('penjualan');
		}

		if($this->m_pengguna->hapus($id)){
			$this->session->set_userdata('persistent_success', 'Data Admin <strong>Berhasil</strong> Dihapus!');
			redirect('pengguna');
		} else {
			$this->session->set_flashdata('error', 'Data Pengguna <strong>Gagal</strong> Dihapus!');
			redirect('pengguna');
		}
	}

	public function export_pdf_lihat(){
		// $this->data['perusahaan'] = $this->m_usaha->lihat();
		$data['all_pengguna'] = $this->m_pengguna->lihat();
		$data['title'] = 'Laporan Data Pengguna';
		$data['no'] = 1;

		$this->load->library('dompdf_gen');
        
        $this->load->view('pengguna/report_pdf', $data);
		$paper_size = 'A4'; // ukuran kertas
        $orientation = 'landscape'; //tipe format kertas potrait atau landscape
        $html = $this->output->get_output();
        
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        ob_end_clean();
        $this->dompdf->stream('Laporan Data Pengguna Tanggal ' . date('d F Y'), array("Attachment" => false));
        // nama file pdf yang di hasilkan
	}

	public function export_print_lihat(){
		// $this->data['perusahaan'] = $this->m_usaha->lihat();
		$data['all_pengguna'] = $this->m_pengguna->lihat();
		$data['title'] = 'Laporan Data Pengguna Tangggal ' .  date('d F Y');
		$data['no'] = 1;

        $this->load->view('pengguna/report_print', $data);
	}
}