<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tarif_test extends CI_Controller
{

    public function setUp(): void
    {
        // Muat CodeIgniter dan model
        $this->CI = &get_instance();
        $this->CI->load->model('Tarif_model');
        $this->CI->load->library('session');
    }

    public function testDelete()
    {
        // Menyiapkan data tarif untuk dihapus
        $tarif_id = 1; // Pastikan ID ini ada di database Anda atau sesuaikan dengan data yang ada

        // Mocking model
        $this->CI->load->library('unit_test');
        $this->CI->load->model('Tarif_model');

        $this->CI->Tarif_model = $this->getMockBuilder('Tarif_model')
            ->setMethods(['delete'])
            ->getMock();

        // Mengatur pengembalian metode delete
        $this->CI->Tarif_model->expects($this->once())
            ->method('delete')
            ->with($this->equalTo($tarif_id))
            ->willReturn(true); // Menganggap delete berhasil

        // Simulasi permintaan HTTP
        $_POST['id'] = $tarif_id;

        // Panggil metode delete
        $this->CI->delete($tarif_id);

        // Periksa apakah flashdata diatur dengan benar
        $flashdata = $this->CI->session->flashdata('success');
        $this->assertEquals('Tarif berhasil dihapus.', $flashdata);
    }
}
