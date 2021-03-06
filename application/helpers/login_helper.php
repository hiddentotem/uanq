<?php

// Fungsi helper untuk cek login, via session
function checkLogin()
{
    // get_instance untuk bisa menggunakan semua function dasar codeigniter
    $ci = get_instance();

    // cek apakah session email sudah ada
    if (!$ci->session->userdata('email')) {
        // jika blm, redirect ke halaman login
        redirect('auth');
    } else {
        // jika sudah, tampilkan halaman sesuai Role user, dan block access halaman user

        // tangkap idRole user yang login, dan tangkap user berusaha mengakses menu apa
        $role_id = $ci->session->userdata('idRole');
        $menu = $ci->uri->segment(1);

        // Cari nama menu yang berusaha di akses oleh user
        $queryUserMenu = $ci->db->get_where('user_menu', ['namaMenu' => $menu])->row_array();
        $menu_id = $queryUserMenu['idMenu'];

        // Cari hak akses user untuk menu yang di cari berdasarkan idMenu
        $queryUserAccess = $ci->db->get_where('user_access_menu', ['idRole' => $role_id, 'idMenu' => $menu_id]);

        // Lalu cek, apakah user memiliki akses untuk menu yang di akses
        if ($queryUserAccess->num_rows() < 1) {
            // Jika tidak, maka redirect ke halaman blocked
            redirect('auth/blocked');
        }
    }
}

// Fungsi yang menangkap role apa yang memiliki menu apa
function check_access($roleId, $menuId)
{
    // get instance untuk bisa menggunakan semua function codeigniter
    $ci = get_instance();

    // Tangkap idRole yang dikirim memiliki idMenu apa saja
    $result = $ci->db->get_where('user_access_menu', ['idRole' => $roleId, 'idMenu' => $menuId]);

    // Jika hasil dari query diatas memiliki hasil
    if ($result->num_rows() > 0) {
        // maka return attr checked untuk checkbox
        return "checked='checked'";
    }
}
