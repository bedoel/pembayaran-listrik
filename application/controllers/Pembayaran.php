<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pembayaran_model');
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

    public function index()
    {
        $data['title'] = 'Pembayaran';

        if ($this->session->userdata('role') === 'admin') {
            $data['pembayaran'] = $this->Pembayaran_model->get_all_pembayaran();
        } else {
            $data['pembayaran'] = $this->Pembayaran_model->get_all_pembayaran_by_id();
        }

        foreach ($data['pembayaran'] as &$pembayaran) {
            $pembayaran['bulan'] = $this->get_month_name($pembayaran['bulan']);
        }
        $this->load->view('templates/auth_header', $data);
        $this->load->view('pembayaran/index', $data);
        $this->load->view('templates/auth_footer');
    }
}
