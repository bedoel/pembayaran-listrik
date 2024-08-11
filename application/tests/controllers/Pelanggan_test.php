<?php

class Pelanggan_test extends CI_Controller
{
    private $CI;

    public function setUp(): void
    {
        $this->CI = &get_instance();
        $this->CI->load->model('Pelanggan_model');
        $this->CI->load->library('unit_test');
        $this->CI->load->database();
    }

    public function testIndex()
    {
        $output = $this->request('GET', 'pelanggan/index');
        $this->assertContains('<title>Pelanggan</title>', $output);
    }

    public function testTambah()
    {
        $_POST = array(
            'username' => 'testuser',
            'password' => 'password',
            'nama_pelanggan' => 'Test User',
            'alamat' => 'Test Address',
            'id_tarif' => 1
        );

        $this->CI->Pelanggan->tambah();

        $this->CI->db->where('username', 'testuser');
        $query = $this->CI->db->get('pelanggan');
        $result = $query->row();

        $this->assertNotEmpty($result);
        $this->assertEquals('Test User', $result->nama_pelanggan);
    }

    public function testDelete()
    {
        // Menambahkan data dummy
        $this->CI->db->insert('pelanggan', array(
            'username' => 'deleteuser',
            'password' => password_hash('password', PASSWORD_BCRYPT),
            'nama_pelanggan' => 'Delete User',
            'alamat' => 'Delete Address',
            'id_tarif' => 1
        ));
        $id = $this->CI->db->insert_id();

        // Menghapus data
        $this->CI->Pelanggan->delete($id);

        // Mengecek jika data terhapus
        $this->CI->db->where('id_pelanggan', $id);
        $query = $this->CI->db->get('pelanggan');
        $result = $query->row();

        $this->assertEmpty($result);
    }

    private function request($method, $url)
    {
        $CI = &get_instance();
        $CI->load->library('curl');
        return $CI->curl->$method($url);
    }
}
