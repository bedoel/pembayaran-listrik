<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->library('session');
        if (!$this->session->userdata('username')) {
            redirect('auth/login');
        }
        $this->load->library('session');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->session->userdata('username');
        $data['tarif'] = $this->Dashboard_model->count_tarif();

        if ($this->session->userdata('role') === 'admin') {
            $data['penggunaan'] = $this->Dashboard_model->count_penggunaan();
            $data['tagihan'] = $this->Dashboard_model->count_tagihan();
            $data['pembayaran'] = $this->Dashboard_model->count_pembayaran();
        } else {
            $data['penggunaan'] = $this->Dashboard_model->count_penggunaan_by_pelanggan($this->session->userdata('id_pelanggan'));
            $data['tagihan'] = $this->Dashboard_model->count_tagihan_by_pelanggan($this->session->userdata('id_pelanggan'));
            $data['pembayaran'] = $this->Dashboard_model->count_pembayaran_by_pelanggan($this->session->userdata('id_pelanggan'));
        }
        $this->load->view('templates/auth_header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/auth_footer');
    }
}
