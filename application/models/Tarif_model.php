<?php
class Tarif_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_all_tarif()
    {
        $query = $this->db->get('tarif');
        return $query->result_array();
    }

    public function edit($id)
    {
        $query = $this->db->get_where('tarif', array('id_tarif' => $id));
        return $query->row_array();
    }

    public function update($id, $data)
    {
        $this->db->where('id_tarif', $id);
        return $this->db->update('tarif', $data);
    }

    public function tambah($data)
    {
        $start_time = microtime(true);
        $start_memory = memory_get_usage();

        $result = $this->db->insert('tarif', $data);

        $end_time = microtime(true);
        $end_memory = memory_get_usage();

        // Hitung waktu eksekusi dan penggunaan memori
        $execution_time = $end_time - $start_time;
        $memory_used = $end_memory - $start_memory;

        // Cetak hasil profiling
        echo "Execution time of tambah: {$execution_time} seconds<br>";
        echo "Memory used by tambah: {$memory_used} bytes<br>";

        return $result;
    }

    public function delete($id)
    {
        return $this->db->delete('tarif', array('id_tarif' => $id));
    }
}
