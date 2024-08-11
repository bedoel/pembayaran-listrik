<?php
class User_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_user($username)
    {
        $this->db->select('user.*, level.nama_level');
        $this->db->from('user');
        $this->db->join('level', 'user.id_level = level.id_level');
        $this->db->where('username', $username);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_all_user()
    {
        $this->db->select('user.*, level.nama_level');
        $this->db->from('user');
        $this->db->join('level', 'user.id_level = level.id_level');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function tambah($data)
    {
        return $this->db->insert('user', $data);
    }

    public function edit($id)
    {
        $this->db->select('u.*, l.*');
        $this->db->from('user u');
        $this->db->join('level l', 'u.id_level = l.id_level');
        $this->db->where('u.id_user', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update($id, $data)
    {
        $this->db->where('id_user', $id);
        return $this->db->update('user', $data);
    }

    public function delete_admin($id)
    {
        $this->db->where('id_user', $id);
        return $this->db->delete('user');
    }
}
