<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pelanggan_model');
        $this->load->model('Tarif_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->library('form_validation');
        if (!$this->session->userdata('username')) {
            redirect('auth/login');
        }
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard');
        }
    }

    public function index()
    {
        $data['title'] = 'Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->get_all_pelanggan();
        $data['tarif'] = $this->Tarif_model->get_all_tarif();
        $this->load->view('templates/auth_header', $data);
        $this->load->view('pelanggan/index', $data);
        $this->load->view('templates/auth_footer');
    }


    public function tambah()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('id_tarif', 'Tarif', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal menambahkan pelanggan. Pastikan semua field terisi dengan benar.');
            $this->load->view('pelanggan');
        } else {
            $data = array(
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'nomor_kwh' => random_int(1000000000, 9999999999),
                'nama_pelanggan' => $this->input->post('nama_pelanggan'),
                'alamat' => $this->input->post('alamat'),
                'id_tarif' => $this->input->post('id_tarif')
            );
            if ($this->Pelanggan_model->tambah($data)) {
                $this->session->set_flashdata('success', 'Pelanggan berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan pelanggan.');
            }
            redirect('pelanggan');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Pelanggan';
        $data['pelanggan'] = $this->Pelanggan_model->edit($id);
        $data['tarif'] = $this->Tarif_model->get_all_tarif();
        $this->load->view('templates/auth_header', $data);
        $this->load->view('pelanggan/edit', $data);
        $this->load->view('templates/auth_footer');
    }

    public function update($id)
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('id_tarif', 'Tarif', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $data = array(
                'username' => $this->input->post('username'),
                'nama_pelanggan' => $this->input->post('nama_pelanggan'),
                'alamat' => $this->input->post('alamat'),
                'id_tarif' => $this->input->post('id_tarif')
            );
            // Jika password baru diisi, hash dan tambahkan ke data
            $password = $this->input->post('password');
            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            $this->load->model('Pelanggan_model');

            if ($this->Pelanggan_model->update($id, $data)) {
                $this->session->set_flashdata('success', 'Data pelanggan berhasil diperbarui.');
            } else {
                $this->session->set_flashdata('error', 'Gagal memperbarui data pelanggan.');
            }

            redirect('pelanggan');
        }
    }

    public function delete($id)
    {
        $this->Pelanggan_model->delete_pelanggan($id);
        redirect('pelanggan');
    }
}
