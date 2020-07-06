<?php defined('BASEPATH') or exit('No direct script access allowed');

// Controller admin yang menglola admin page
class Teams_model extends CI_Model
{
    public function __construct()
    {
        $this->user = $this->session->userdata('email');
    }

    public function getBisnis()
    {
        $email = $this->user;
        return $this->db->get_where('teams', ['emailOwner' => $email])->row_array();
    }

    public function getCrew()
    {
        $email = $this->user;
        return $this->db->get_where('crew', ['email' => $email])->result_array();
    }

    public function getUserByEmail($email)
    {
        return $this->db->get_where('user', ['emailUser' => $email])->row_array();
    }

    public function createTeam($data)
    {
        $this->db->insert('teams', $data);
    }
}