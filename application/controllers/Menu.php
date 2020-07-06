<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Controller menu yang menglola menu page
class Menu extends CI_Controller
{
    // Method construct untuk memanggil model, dan check session login
    public function __construct()
    {
        // memanggil construct milik parent
        parent::__construct();

        // memanggil helpers check login
        checkLogin();

        // memanggil Menu_model
        $this->load->model('Menu_model', 'menu');
    }

    // Method untuk menampilkan semua data menu, dan add menu
    public function index()
    {
        // Tangkap data user berdasarkan email yang dikirimkan oleh session
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();

        // Tangkap semua data menu, via models menu
        $data['menu'] = $this->menu->getMenu();
        $data['title'] = 'Menu Management';

        // Set rules untuk form tambah menu baru
        $this->form_validation->set_rules('menu', 'Menu', 'required|trim');

        // Cek rules validation
        if ($this->form_validation->run() == FALSE) {
            // Jika gagal, kembalikan ke menu page
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            // Jika berhasil, tangkap input menu baru
            $newMenu = htmlspecialchars($this->input->post('menu', true));

            // Insert menu baru, via models menu
            $data = ['namaMenu' => $newMenu];
            $this->menu->setMenu($data);

            // Jika insert berhasil, tampilkan pesan berhasil dan redirect ke menu page
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('menu');
        }
    }

    // Method untuk menampilkan semua data sub menu, dan add sub menu
    public function subMenu()
    {
        // Tangkap data user berdasarkan email yang dikirim dari session
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();

        // Tangkap data sub menu dan menu, via model
        $data['submenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->menu->getMenu();

        $data['title'] = 'Submenu Management';

        // Set rules untuk form tambah sub menu baru
        $this->form_validation->set_rules('judulSubmenu', 'Title', 'required|trim');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required|trim');
        $this->form_validation->set_rules('urlSubmenu', 'URL', 'required|trim');
        $this->form_validation->set_rules('iconSubmenu', 'Icon', 'required|trim');
        $this->form_validation->set_rules('judulSubmenu', 'Title', 'required|trim');

        // Cek rules validation
        if ($this->form_validation->run() == FALSE) {
            // Jika gagal, tampilkan halaman sub menu
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            // Jika berhasil, tangkap data yang di input dari form
            $data = [
                'idMenu' => htmlspecialchars($this->input->post('menu_id', true)),
                'judulSubMenu' => htmlspecialchars($this->input->post('judulSubmenu', true)),
                'urlSubMenu' => htmlspecialchars($this->input->post('urlSubmenu', true)),
                'iconSubMenu' => htmlspecialchars($this->input->post('iconSubmenu', true)),
                'isActiveMenu' => htmlspecialchars($this->input->post('isActive', true))
            ];

            // Insert sub menu baru berdasarkan data yang dikirimkan, via model
            $this->menu->setSubmenu($data);

            // Jika insert  berhasil tampilkan pesan berhasil, dan redirect ke halaman submenu
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Submenu added!</div>');
            redirect('menu/submenu');
        }
    }

    // Method untuk menangkap menu by id untuk form edit berdasarkan idJson dari ajax
    public function getMenuEdit()
    {
        // tangkap id yang dikirimkan oleh ajax
        $id = $_POST['idJson'];

        // tangkap menu by id sebagai json, via model
        echo json_encode($this->menu->getMenuById($id));
    }

    // Method untuk menangkap sub menu by id untuk form edit berdasarkan idJson dari ajax
    public function getSubmenuEdit()
    {
        // tangkap id yang dikirimkan oleh ajax
        $id = $_POST['idJson'];

        // tangkap sub menu by id sebagai json, via model
        echo json_encode($this->menu->getSubmenuById($id));
    }

    // Method untuk mengelola edit menu
    public function menuEdit()
    {
        // Tangkap data user berdasarkan email yang dikirimkan oleh session
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();

        // Tangkap semua data menu yang tersedia, via model
        $data['menu'] = $this->menu->getMenu();

        $data['title'] = 'Menu Management';

        // Set rules untuk form edit menu
        $this->form_validation->set_rules('menu', 'Menu', 'required|trim');

        // cek rules validation
        if ($this->form_validation->run() == FALSE) {
            // Jika gagal, tampilkan halaman menu
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            // Jika berhasil, tangkap data menu baru yang di input
            $menuEdited = htmlspecialchars($this->input->post('menu', true));

            // Update data menu yang dengan menu yang sudah diedit, via model
            $data = ['namaMenu' => $menuEdited];
            $this->menu->updateMenu($data);

            // Jika berhasil di update, tampilkan pesan berhasil dan redirect ke menu page
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu has been updated!</div>');
            redirect('menu');
        }
    }

    // Method untuk mengelola edit sub menu
    public function submenuEdit()
    {
        // Tangkap data user berdasarkan email yang dikirimkan oleh session
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();

        // Tangkap data sub menu dan menu, via model
        $data['submenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->menu->getMenu();

        $data['title'] = 'Submenu Management';

        // Set rules untuk form edit sub menu
        $this->form_validation->set_rules('judulSubmenu', 'Title', 'required|trim');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required|trim');
        $this->form_validation->set_rules('urlSubmenu', 'URL', 'required|trim');
        $this->form_validation->set_rules('iconSubmenu', 'Icon', 'required|trim');
        $this->form_validation->set_rules('judulSubmenu', 'Title', 'required|trim');

        // Cek validasi rules
        if ($this->form_validation->run() == FALSE) {
            // Jika gagal, tampilkan submenu page
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer', $data);
        } else {
            // Jika berhasil, tangkap data yang di input via form edit
            $idMenuEdit = htmlspecialchars($this->input->post('menu_id', true));
            $judulSubmenuEdit = htmlspecialchars($this->input->post('judulSubmenu', true));
            $urlSubmenuEdit = htmlspecialchars($this->input->post('urlSubmenu', true));
            $iconSubmenuEdit = htmlspecialchars($this->input->post('iconSubmenu', true));
            $isActiveMenuEdit = htmlspecialchars($this->input->post('isActive', true));

            // Set data yang akan di edit
            $data = [
                'idMenu' => $idMenuEdit,
                'judulSubMenu' => $judulSubmenuEdit,
                'urlSubMenu' => $urlSubmenuEdit,
                'iconSubMenu' => $iconSubmenuEdit,
                'isActiveMenu' => $isActiveMenuEdit
            ];

            // Edit data sub menu, via model
            $this->menu->updateSubmenu($data);

            // Jika berhasil, tampilkan pesan berhasil dan redirect ke halaman submenu
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sub menu has been updated!</div>');
            redirect('menu/submenu');
        }
    }

    // Method untuk menghapus menu, berdasarkan $id yang dikirimkan oleh URLs
    public function menuDelete($id)
    {
        // delete menu berdasarkan id yang dikirimkan URLs, via model
        $this->menu->deleteMenu($id);

        // Jika berhasil, tampilkan pesan berhasil dan redirect ke halaman menu
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Menu has been deleted!</div>');
        redirect('menu');
    }

    // Method untuk menghapus sub menu, berdasarkan $id yang dikirimkan oleh URLs
    public function subMenuDelete($id)
    {
        // delete sub menu berdasarkan id  yang dikirimkan URLs, via model
        $this->menu->deleteSubmenu($id);

        // Jika berhasil, tampilkan pesan berhasil dan redirect ke halaman sub menu
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Submenu has been deleted!</div>');
        redirect('menu/submenu');
    }
}
