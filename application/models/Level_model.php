<?php
class Level_model extends CI_Model
{

    public function __construct()
    {
        $this->load->database();
    }

    public function get_all_Level()
    {
        $query = $this->db->get('level');
        return $query->result_array();
    }
}
