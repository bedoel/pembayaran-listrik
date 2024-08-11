<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tagihan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tagihan_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('Penggunaan_model');
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

        $data['title'] = 'Tagihan';

        if ($this->session->userdata('role') === 'admin') {
            $data['tagihan'] = $this->Tagihan_model->get_all_tagihan();
            foreach ($data['tagihan'] as &$tagihan) {
                $tagihan['total_pembayaran'] = $tagihan['tarifperkwh'] * $tagihan['jumlah_meter'];
            }
        } else {
            $data['tagihan'] = $this->Tagihan_model->get_all_tagihan_by_id();
            foreach ($data['tagihan'] as &$tagihan) {
                $tagihan['total_pembayaran'] = $tagihan['tarifperkwh'] * $tagihan['jumlah_meter'];
            }
        }

        foreach ($data['tagihan'] as &$tagihan) {
            $tagihan['bulan'] = $this->get_month_name($tagihan['bulan']);
        }
        $this->load->view('templates/auth_header', $data);
        $this->load->view('tagihan/index', $data);
        $this->load->view('templates/auth_footer');
    }

    public function update_status($id)
    {
        if ($this->session->userdata('role') === 'admin') {
            $status = $this->input->post('status');

            $this->Tagihan_model->update_status($id, $status);

            if ($status == 'Lunas') {
                $this->session->set_flashdata('success', 'Tagihan telah dilunasi dan pembayaran telah dibuat.');
            } else {
                $this->session->set_flashdata('success', 'Status tagihan telah diperbarui.');
            }

            redirect('tagihan');
        } else {
            redirect('tagihan');
        }
    }
}
