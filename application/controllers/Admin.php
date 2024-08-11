<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Level_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->library('session');
        if (!$this->session->userdata('username')) {
            redirect('auth/login');
        }
        if ($this->session->userdata('role') != 'admin') {
            redirect('dashboard');
        }
    }

    /**
     * @return [type]
     */
    public function index()
    {
        $data['title'] = 'Admin';
        $data['admin'] = $this->User_model->get_all_user();
        $data['level'] = $this->Level_model->get_all_level();
        $this->load->view('templates/auth_header', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/auth_footer');
    }

    /**
     * @return [type]
     */
    public function tambah()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('nama_admin', 'Nama Admin', 'required');
        $this->form_validation->set_rules('id_level', 'Level', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', 'Gagal menambahkan admin. Pastikan semua field terisi dengan benar.');
            $this->load->view('admin');
        } else {
            $data = array(
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                'nama_admin' => $this->input->post('nama_admin'),
                'id_level' => $this->input->post('id_level')
            );
            if ($this->User_model->tambah($data)) {
                $this->session->set_flashdata('success', 'Admin berhasil ditambahkan.');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan Admin.');
            }
            redirect('admin');
        }
    }

    /**
     * @param mixed $id
     * 
     * @return [type]
     */
    public function edit($id)
    {
        if ($this->session->userdata('level') === 'Administrator') {
            $data['title'] = 'Edit Admin';
            $data['admin'] = $this->User_model->edit($id);
            $data['level'] = $this->Level_model->get_all_Level();
            $this->load->view('templates/auth_header', $data);
            $this->load->view('admin/edit', $data);
            $this->load->view('templates/auth_footer');
        } else {
            redirect('admin');
        }
    }

    /**
     * @param mixed $id
     * 
     * @return [type]
     */
    public function update($id)
    {
        if ($this->session->userdata('level') === 'Administrator') {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('nama_admin', 'Nama Admin', 'required');
            $this->form_validation->set_rules('id_level', 'Level', 'required');

            if ($this->form_validation->run() === FALSE) {
                $this->edit($id);
            } else {
                $data = array(
                    'username' => $this->input->post('username'),
                    'nama_admin' => $this->input->post('nama_admin'),
                    'id_level' => $this->input->post('id_level')
                );
                // Jika password baru diisi, hash dan tambahkan ke data
                $password = $this->input->post('password');
                if (!empty($password)) {
                    $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                $this->load->model('User_model');

                if ($this->User_model->update($id, $data)) {
                    $this->session->set_flashdata('success', 'Data admin berhasil diperbarui.');
                } else {
                    $this->session->set_flashdata('error', 'Gagal memperbarui data admin.');
                }

                redirect('admin');
            }
        } else {
            redirect('admin');
        }
    }

    /**
     * @param mixed $id
     * 
     * @return [type]
     */
    public function delete($id)
    {
        if ($this->session->userdata('level') === 'Administrator') {
            $this->User_model->delete_admin($id);
            redirect('admin');
        } else {
            redirect('admin');
        }
    }
}
