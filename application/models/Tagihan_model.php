<?php
class Tagihan_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_all_tagihan()
    {
        $this->db->select('tagihan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, tarif.tarifperkwh');
        $this->db->from('tagihan');
        $this->db->join('pelanggan', 'tagihan.id_pelanggan = pelanggan.id_pelanggan', 'left'); // Menggunakan LEFT JOIN jika tidak semua pelanggan memiliki tagihan
        $this->db->join('tarif', 'pelanggan.id_tarif = tarif.id_tarif', 'left'); // Menggunakan LEFT JOIN jika tidak semua pelanggan memiliki tagihan
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_tagihan_by_id()
    {
        $this->db->select('tagihan.*, pelanggan.nama_pelanggan, pelanggan.nomor_kwh, tarif.tarifperkwh');
        $this->db->from('tagihan');
        $this->db->join('pelanggan', 'tagihan.id_pelanggan = pelanggan.id_pelanggan', 'left'); // Menggunakan LEFT JOIN jika tidak semua pelanggan memiliki tagihan
        $this->db->join('tarif', 'pelanggan.id_tarif = tarif.id_tarif', 'left'); // Menggunakan LEFT JOIN jika tidak semua pelanggan memiliki tagihan
        $this->db->where('tagihan.id_pelanggan', $this->session->userdata('id_pelanggan'));
        $query = $this->db->get();
        return $query->result_array();
    }


    public function update($id, $data)
    {
        $this->db->where('id_tagihan', $id);
        return $this->db->update('tagihan', $data);
    }

    public function update_status($id, $status)
    {
        $this->db->where('id_tagihan', $id);
        $this->db->update('tagihan', ['status' => $status]);

        if ($status == 'Lunas') {
            $this->create_pembayaran($id);
        } elseif ($status == 'Belum Bayar') {
            // Jika status tagihan menjadi 'Belum Lunas', hapus pembayaran terkait
            $this->delete_pembayaran($id);
        }
    }

    private function create_pembayaran($id_tagihan)
    {
        // Ambil data tagihan berdasarkan ID
        $tagihan = $this->db->get_where('tagihan', ['id_tagihan' => $id_tagihan])->row_array();

        if ($tagihan) {
            // Ambil daya pelanggan
            $pelanggan = $this->db->get_where('pelanggan', ['id_pelanggan' => $tagihan['id_pelanggan']])->row_array();

            if ($pelanggan) {
                // Ambil ID Tarif dari Tagihan
                $id_tarif = $pelanggan['id_tarif'];

                // Ambil tarif per kWh berdasarkan ID Tarif
                $tarif = $this->db->get_where('tarif', ['id_tarif' => $id_tarif])->row_array();

                if ($tarif) {
                    $tarif_per_kwh = $tarif['tarifperkwh']; // Tarif per kWh
                    // Hitung total tagihan
                    $jumlah_meter = $tagihan['jumlah_meter'];

                    $total_tagihan = $jumlah_meter * $tarif_per_kwh; // Hitung total tagihan

                    $data = [
                        'id_tagihan' => $tagihan['id_tagihan'],
                        'id_pelanggan' => $tagihan['id_pelanggan'],
                        'tanggal_pembayaran' => date('Y-m-d H:i:s'),
                        'bulan_bayar' => $tagihan['bulan'],
                        'biaya_admin' => 2500, // Contoh biaya admin tetap
                        'total_bayar' => $total_tagihan + 2500, // Total bayar termasuk biaya admin
                        'id_user' => $this->session->userdata('id_user'), // Sesuaikan jika ada kolom id_user
                        'nama_admin_copy' => $this->session->userdata('nama'), // Sesuaikan jika ada kolom id_user

                    ];

                    return $this->db->insert('pembayaran', $data);
                }
            }
        }
    }

    private function delete_pembayaran($id_tagihan)
    {
        // Hapus data pembayaran berdasarkan ID tagihan
        $this->db->where('id_tagihan', $id_tagihan);
        return $this->db->delete('pembayaran');
    }
}
