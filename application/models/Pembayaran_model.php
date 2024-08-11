<?php
class Pembayaran_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_all_pembayaran()
    {
        $this->db->select('pembayaran.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, tagihan.bulan, user.nama_admin');
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'pembayaran.id_tagihan = tagihan.id_tagihan', 'left'); // Menghubungkan tabel pembayaran dengan tagihan
        $this->db->join('pelanggan', 'tagihan.id_pelanggan = pelanggan.id_pelanggan', 'left'); // Menghubungkan tabel tagihan dengan pelanggan
        $this->db->join('user', 'pembayaran.id_user = user.id_user', 'left'); // Menghubungkan tabel pembayaran dengan user
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_pembayaran_by_id()
    {
        $this->db->select('pembayaran.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, tagihan.bulan, user.nama_admin');
        $this->db->from('pembayaran');
        $this->db->join('tagihan', 'pembayaran.id_tagihan = tagihan.id_tagihan', 'left'); // Menghubungkan tabel pembayaran dengan tagihan
        $this->db->join('pelanggan', 'tagihan.id_pelanggan = pelanggan.id_pelanggan', 'left'); // Menghubungkan tabel tagihan dengan pelanggan
        $this->db->join('user', 'pembayaran.id_user = user.id_user', 'left'); // Menghubungkan tabel pembayaran dengan user
        $this->db->where('pembayaran.id_pelanggan', $this->session->userdata('id_pelanggan'));
        $query = $this->db->get();
        return $query->result_array();
    }
}
