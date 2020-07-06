<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Controller admin yang menglola admin page
class Admin extends CI_Controller
{
    // Method construct yang memanggil semua yang diperlukan
    public function __construct()
    {
        // Memanggil construct parentnya
        parent::__construct();

        // Memanggil helper check login
        checkLogin();

        // Memanggil model Admin_model
        $this->load->model('Admin_model', 'admin');
    }

    public function ajaxOverview()
    {
        echo json_encode($this->admin->getEarningPermonth());
    }

    public function ajaxIO()
    {
        echo json_encode($this->admin->getIncomeOutcomePercentage());
    }

    // Method default, yang menampilkan halaman utama ADMIN
    public function index()
    {
        // Mencari data user berdasarkan email yang dikirim oleh session
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();
        $data['earningMonthly'] = $this->admin->getEarningMonthly();
        $data['balance'] = $this->admin->getbalance();
        $data['incomeMonthly'] = $this->admin->getIncomeMonthly();
        $data['outcomeMonthly'] = $this->admin->getOutcomeMonthly();

        $data['title'] = 'Dashboard';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer', $data);
    }

    // Method untuk menampilkan role yang tersedia
    public function role()
    {
        // Mencari data user berdasarkan email yang dikirimkan oleh user
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();

        // Mencari semua data role yang tersedia
        $data['role'] = $this->admin->getRole();
        $data['title'] = 'Role';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function setrole()
    {
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('failadd', 'Role');
            redirect('admin/role');
        } else {
            $role = $this->input->post('role');
            
            $data = [
                'role' => $role
            ];
            
            $this->admin->setRole($data);

            $this->session->set_flashdata('succadd', 'Role');
            redirect('admin/role');
        }
    }

    public function deleteRole($id)
    {
        $this->admin->deleteRole($id);

        $this->session->set_flashdata('succdelete', 'Role');
        redirect('admin/role');
    }

    // Method untuk menampilkan role mana yang memiliki akses apa saja
    public function roleAccess($role_id)
    {
        // Mencari data user berdasarkan email yang dikirimkan oleh user
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();

        // Cari user berdasarkan id yang dikirimkan dan cari semua menu
        $data['role'] = $this->admin->getRoleById($role_id);
        $data['menu'] = $this->admin->getMenu();
        $data['title'] = 'Role Access';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/roleaccess', $data);
        $this->load->view('templates/footer');
    }

    // Method untuk mengelola role bisa memiliki akses apa saja
    public function changeAccess()
    {
        // Tangkap data yang dikirimkan sama ajax
        $role_id = $this->input->post('roleId');
        $menu_id = $this->input->post('menuId');

        // siapkan data untuk dikirim ke query
        $data = [
            'idRole' => $role_id,
            'idMenu' => $menu_id,
        ];

        // Tamgkap data yang dikirimkan dari user_access_menu
        $result = $this->admin->getAccess($data);

        // Cek apakah data yang dikirimkan ada atau tidak
        if ($result < 1) {
            // Jika tidak, maka insert data yang dikirimkan ke user_access_menu
            $this->admin->setAccess($data);
        } else {
            // Jika ada, maka hapus data yang dikirimkan dari user_access_menu
            $this->admin->dropAccess($data);
        }

        // Tampilkan pesan access berhasil di ubah
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access changed!.</div>');
    }
}
