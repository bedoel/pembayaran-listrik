<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tarif extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Tarif_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('Penggunaan_model');
        $this->load->library('unit_test');
        if (!$this->session->userdata('username')) {
            redirect('auth/login');
        }
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard');
        }
    }

    public function index()
    {
        $data['title'] = 'Tarif';
        $data['tarif'] = $this->Tarif_model->get_all_tarif();
        $this->load->view('templates/auth_header', $data);
        $this->load->view('tarif/index', $data);
        $this->load->view('templates/auth_footer');
    }

    public function store()
    {
        $this->form_validation->set_rules('daya', 'Daya', 'required');
        $this->form_validation->set_rules('tarifperkwh', 'Tarif per kWh', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal menyimpan tarif. Pastikan semua field terisi dengan benar.');
            $this->load->view('tarif');
        } else {
            $data = array(
                'daya' => $this->input->post('daya'),
                'tarifperkwh' => $this->input->post('tarifperkwh')
            );

            if ($this->Tarif_model->tambah($data)) {
                $this->session->set_flashdata('success', 'Tarif berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan tarif.');
            }
            redirect('tarif');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Tarif';
        $data['tarif'] = $this->Tarif_model->edit($id);

        // $test = $data['tarif']['daya'];

        // $expected_result = 450;

        // $test_name = 'Data yang dibawa benar';

        // echo $this->unit->run($test, $expected_result, $test_name);

        $this->load->view('templates/auth_header', $data);
        $this->load->view('tarif/edit', $data);
        $this->load->view('templates/auth_footer');
    }

    public function update($id)
    {
        $data = array(
            'daya' => $this->input->post('daya'),
            'tarifperkwh' => $this->input->post('tarifperkwh')
        );
        if ($this->Tarif_model->update($id, $data)) {
            $this->session->set_flashdata('success', 'Tarif berhasil diedit.');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengedit tarif.');
        }
        redirect('tarif');
    }

    public function delete($id)
    {
        if ($this->Tarif_model->delete($id)) {
            $this->session->set_flashdata('success', 'Tarif berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus tarif.');
        }
        redirect('tarif');
    }
}
