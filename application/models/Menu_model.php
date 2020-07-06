<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Controller admin yang menglola admin page
class Menu_model extends CI_Model
{
    // Method mendapatkan semua menu
    public function getMenu()
    {
        return $this->db->get('user_menu')->result_array();
    }

    // Method mendapatkan sub menu, dan nama menunya
    public function getSubMenu()
    {
        $query = "SELECT `user_sub_menu`.*, `user_menu`.`namaMenu`
                    FROM `user_sub_menu` JOIN `user_menu`
                    ON  `user_sub_menu`.`idMenu` = `user_menu`.`idMenu`
                    ORDER BY `user_sub_menu`.`idSubMenu`
                ";

        return $this->db->query($query)->result_array();
    }

    // Method insert menu baru, berdasarkan $data yang dikirimkan
    public function setMenu($data)
    {
        $this->db->insert('user_menu', $data);
    }

    // Method insert sub menu baru, berdasarkan $data yang dikirimkan
    public function setSubmenu($data)
    {
        $this->db->insert('user_sub_menu', $data);
    }

    // Method mendapatkan menu by id
    public function getMenuById($id)
    {
        return $this->db->get_where('user_menu', ['idMenu' => $id])->row_array();
    }

    // Method mendapatkan sub menu by id
    public function getSubmenuById($id)
    {
        return $this->db->get_where('user_sub_menu', ['idSubMenu' => $id])->row_array();
    }

    // Method update menu berdasarkan data yang dikirimkan
    public function updateMenu($data)
    {
        // tangkap id yang dikirimkan oleh form
        $id = $this->input->post('idMenu');

        // Update menu baru berdasarkan data yang dikirimkan
        $this->db->where('idMenu', $id);
        $this->db->update('user_menu', $data);
    }

    // Method update sub menu berdasarkan data yang dikirimkan
    public function updateSubmenu($data)
    {
        // tangkap id yang dikirimkan oleh form
        $id = $this->input->post('idSubmenu');

        // Update sub menu baru berdasarkan data yang dikirimkan
        $this->db->where('idSubMenu', $id);
        $this->db->update('user_sub_menu', $data);
    }

    // Method menghapus menu by id
    public function deleteMenu($id)
    {
        // Delete menu berdasarkan id yang dikirimkan oleh controller
        $this->db->delete('user_menu', ['idMenu' => $id]);
    }

    // Method menghapus sub menu by id
    public function deleteSubmenu($id)
    {
        // Delete sub menu berdasarkan id yang dikirimkan oleh controller
        $this->db->delete('user_sub_menu', ['idSubMenu' => $id]);
    }
}
