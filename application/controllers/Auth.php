<?php
class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Pelanggan_model');
    }

    public function login()
    {
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Cek pengguna pada tabel user
            $user = $this->User_model->get_user($username);
            if ($user && password_verify($password, $user['password'])) {
                $session_data = array(
                    'id_user' => $user['id_user'],
                    'nama' => $user['nama_admin'],
                    'username' => $user['username'],
                    'level' => $user['nama_level'],
                    'role' => 'admin'
                );
                $this->session->set_userdata($session_data);
                redirect('dashboard');
            }

            // Cek pengguna pada tabel pelanggan
            $pelanggan = $this->Pelanggan_model->get_pelanggan_auth($username);
            if ($pelanggan  && password_verify($password, $pelanggan['password'])) {
                $session_data = array(
                    'id_pelanggan' => $pelanggan['id_pelanggan'],
                    'nama' => $pelanggan['nama_pelanggan'],
                    'username' => $pelanggan['username'],
                    'level' => 'pelanggan',
                    'role' => 'pelanggan'
                );
                $this->session->set_userdata($session_data);
                redirect('dashboard');
            }

            $this->session->set_flashdata('error', 'Username atau Password salah');
            redirect('auth/login');
        } else {
            $this->load->view('auth/login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
