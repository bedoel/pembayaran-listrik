<?php
class Pelanggan_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    /**
     * @return [type]
     */
    public function get_all_pelanggan()
    {
        $this->db->select('pelanggan.*, tarif.daya, tarif.tarifperkwh');
        $this->db->from('pelanggan');
        $this->db->join('tarif', 'pelanggan.id_tarif = tarif.id_tarif', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * @return [type]
     */
    public function get_pelanggan()
    {
        $query = $this->db->get('pelanggan');
        return $query->result_array();
    }

    /**
     * @param mixed $username
     * 
     * @return [type]
     */
    public function get_pelanggan_auth($username)
    {
        $query = $this->db->get_where('pelanggan', ['username' => $username]);
        return $query->row_array();
    }

    /**
     * @param mixed $id
     * 
     * @return [type]
     */
    public function edit($id)
    {
        $this->db->select('p.*, t.daya, t.tarifperkwh');
        $this->db->from('pelanggan p');
        $this->db->join('tarif t', 'p.id_tarif = t.id_tarif', 'left');
        $this->db->where('p.id_pelanggan', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update($id, $data)
    {
        $this->db->where('id_pelanggan', $id);
        return $this->db->update('pelanggan', $data);
    }

    public function tambah($data)
    {
        return $this->db->insert('pelanggan', $data);
    }

    public function delete_pelanggan($id)
    {
        $this->db->where('id_pelanggan', $id);
        return $this->db->delete('pelanggan');
    }
}
