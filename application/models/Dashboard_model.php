<?php
class Dashboard_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function count_penggunaan_by_pelanggan($id_pelanggan)
    {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->from('penggunaan');
        return $this->db->count_all_results();
    }
    public function count_tagihan_by_pelanggan($id_pelanggan)
    {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->from('tagihan');
        return $this->db->count_all_results();
    }
    public function count_pembayaran_by_pelanggan($id_pelanggan)
    {
        $this->db->where('id_pelanggan', $id_pelanggan);
        $this->db->from('pembayaran');
        return $this->db->count_all_results();
    }
    public function count_tarif()
    {
        $this->db->from('tarif');
        return $this->db->count_all_results();
    }
    public function count_penggunaan()
    {
        $this->db->from('penggunaan');
        return $this->db->count_all_results();
    }
    public function count_tagihan()
    {
        $this->db->from('tagihan');
        return $this->db->count_all_results();
    }
    public function count_pembayaran()
    {
        $this->db->from('pembayaran');
        return $this->db->count_all_results();
    }
}
