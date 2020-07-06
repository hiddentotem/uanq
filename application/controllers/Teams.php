<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Controller admin yang menglola admin page
class Teams extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        checkLogin();

        $this->load->model('Teams_model', 'team');
    }

    public function index()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();
        $data['bisnis'] = $this->team->getBisnis();
        $data['crew'] = $this->team->getCrew();
        $data['title'] = 'Teams';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('teams/index', $data);
        $this->load->view('templates/footer', $data);
    }
}