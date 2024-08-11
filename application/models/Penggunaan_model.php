<?php

/**
 * Model Penggunaan
 * Mengelola operasi basis data untuk penggunaan listrik
 */
class Penggunaan_model extends CI_Model
{

    /**
     * Constructor
     * Memuat basis data
     */
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Mendapatkan data penggunaan listrik
     *
     * @param int|bool $id_pelanggan ID Pelanggan
     * @return array Data penggunaan listrik
     */
    public function get_penggunaan($id_pelanggan = FALSE)
    {
        if ($id_pelanggan === FALSE) {
            $query = $this->db->get('penggunaan');
            return $query->result_array();
        }

        $query = $this->db->get_where('penggunaan', array('id_pelanggan' => $id_pelanggan));
        return $query->result_array();
    }

    /**
     * Menambah data penggunaan listrik
     *
     * @param array $data Data penggunaan listrik
     * @return bool Status insert
     */
    public function tambah($data)
    {
        return $this->db->insert('penggunaan', $data);
    }

    /**
     * Mengubah data penggunaan listrik
     *
     * @param int $id ID Penggunaan
     * @param array $data Data penggunaan listrik
     * @return bool Status update
     */
    public function update_penggunaan($id, $data)
    {
        $this->db->where('id_penggunaan', $id);
        return $this->db->update('penggunaan', $data);
    }

    /**
     * Menghapus data penggunaan listrik
     *
     * @param int $id ID Penggunaan
     * @return bool Status delete
     */
    public function delete_penggunaan($id)
    {
        $this->db->where('id_penggunaan', $id);
        return $this->db->delete('penggunaan');
    }

    public function get_all_penggunaan()
    {
        $this->db->select('penggunaan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'penggunaan.id_pelanggan = pelanggan.id_pelanggan', 'left'); // Menggunakan LEFT JOIN jika tidak semua pelanggan memiliki tagihan
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_penggunaan_by_id()
    {
        $this->db->select('penggunaan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'penggunaan.id_pelanggan = pelanggan.id_pelanggan', 'left'); // Menggunakan LEFT JOIN jika tidak semua pelanggan memiliki tagihan
        $this->db->where('penggunaan.id_pelanggan', $this->session->userdata('id_pelanggan'));
        $query = $this->db->get();
        return $query->result_array();
    }

    public function edit($id)
    {
        $this->db->select('penggunaan.*, pelanggan.nama_pelanggan');
        $this->db->from('penggunaan');
        $this->db->join('pelanggan', 'penggunaan.id_pelanggan = pelanggan.id_pelanggan');
        $this->db->where('penggunaan.id_penggunaan', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
}
