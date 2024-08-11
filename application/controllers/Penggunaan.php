<?php

/**
 * Controller Penggunaan
 * Mengelola data penggunaan listrik pelanggan
 */
class Penggunaan extends CI_Controller
{

    /**
     * Constructor
     * Memuat model penggunaan
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Penggunaan_model');
        $this->load->model('Pelanggan_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('form');
        if (!$this->session->userdata('username')) {
            redirect('auth/login');
        }
    }

    private function get_month_name($month_num)
    {
        $months = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April', '05' => 'Mei', '06' => 'Juni',
            '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];

        return $months[$month_num] ?? '';
    }

    /**
     * Menampilkan data penggunaan listrik
     */
    public function index()
    {
        $data['title'] = 'Penggunaan';

        if ($this->session->userdata('role') === 'admin') {
            $data['penggunaan'] = $this->Penggunaan_model->get_all_penggunaan();
            $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan();
        } else {
            $data['penggunaan'] = $this->Penggunaan_model->get_all_penggunaan_by_id();
        }

        foreach ($data['penggunaan'] as &$penggunaan) {
            $penggunaan['bulan'] = $this->get_month_name($penggunaan['bulan']);
        }

        $this->load->view('templates/auth_header', $data);
        $this->load->view('penggunaan/index', $data);
        $this->load->view('templates/auth_footer');
    }

    public function edit($id)
    {
        if ($this->session->userdata('role') === 'admin') {
            $data['title'] = 'Edit Penggunaan';
            $data['penggunaan'] = $this->Penggunaan_model->edit($id);
            $data['pelanggan'] = $this->Pelanggan_model->get_pelanggan();
            $this->load->view('templates/auth_header', $data);
            $this->load->view('penggunaan/edit', $data);
            $this->load->view('templates/auth_footer');
        } else {
            redirect('penggunaan');
        }
    }

    /**
     * Membuat data penggunaan listrik baru
     */
    public function create()
    {
        if ($this->session->userdata('role') === 'admin') {
            if ($this->input->post()) {
                $data = array(
                    'id_pelanggan' => $this->input->post('id_pelanggan'),
                    'meter_awal' => $this->input->post('meter_awal'),
                    'meter_akhir' => $this->input->post('meter_akhir'),
                );
                $date = explode('-', $this->input->post('bulan') ?? '');
                $data['bulan'] = $date[1];
                $data['tahun'] = $date[0];

                if ($this->Penggunaan_model->tambah($data)) {
                    $this->session->set_flashdata('success', 'Penggunaan berhasil ditambahkan.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan Penggunaan.');
                }
                redirect('penggunaan');
            } else {
                $this->load->view('penggunaan');
            }
        } else {
            redirect('penggunaan');
        }
    }

    /**
     * Mengubah data penggunaan listrik
     *
     * @param int $id ID Penggunaan
     */
    public function update($id)
    {
        if ($this->session->userdata('role') === 'admin') {
            if ($this->input->post()) {
                $data = array(
                    'id_pelanggan' => $this->input->post('id_pelanggan'),
                    'meter_awal' => $this->input->post('meter_awal'),
                    'meter_akhir' => $this->input->post('meter_akhir')
                );
                $date = explode('-', $this->input->post('bulan') ?? '');
                $data['bulan'] = $date[1];
                $data['tahun'] = $date[0];

                $this->Penggunaan_model->update_penggunaan($id, $data);
                redirect('penggunaan');
            } else {
                $data['penggunaan'] = $this->Penggunaan_model->get_penggunaan($id);
                $this->load->view('penggunaan/update', $data);
            }
        } else {
            redirect('penggunaan');
        }
    }

    /**
     * Menghapus data penggunaan listrik
     *
     * @param int $id ID Penggunaan
     */
    public function delete($id)
    {
        if ($this->session->userdata('role') === 'admin') {
            $this->Penggunaan_model->delete_penggunaan($id);
            redirect('penggunaan');
        } else {
            redirect('penggunaan');
        }
    }
}
