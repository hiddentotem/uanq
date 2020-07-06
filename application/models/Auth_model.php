<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Controller admin yang menglola admin page
class Auth_model extends CI_Model
{
    // Method mendapatkan semua menu
    public function getMenu()
    {
        return $this->db->get('user_menu')->result_array();
    }

    // Method untuk mencari user aktif berdasarkan email
    public function getActiveUserByEmail($email)
    {
        return $this->db->get_where('user', ['emailUser' => $email, 'isActive' => 1])->row_array();
    }

    // Method untuk mencari user by email
    public function getUserByEmail($email)
    {
        // Return user yang memiliki email
        return $this->db->get_where('user', ['emailUser' => $email])->row_array();
    }

    // Method untuk mencari token by token
    public function getTokenByToken($token)
    {
        return $this->db->get_where('user_token', ['token' => $token])->row_array();
    }

    // Method untuk insert user
    public function setUser($data)
    {
        $this->db->insert('user', $data);
    }

    // Method untuk insert user_token
    public function setToken($data)
    {
        $this->db->insert('user_token', $data);
    }

    // Method untuk mengubah user menjadi verify by email
    public function emailIsVerify($email)
    {
        // Update user is active berdasarkan email yang dikirimkan
        $this->db->set('isActive', 1);
        $this->db->where('emailUser', $email);
        $this->db->update('user');

        // dan hapus token yang sudah digunakan
        $this->db->delete('user_token', ['email' => $email]);
    }

    // Method untuk menangani token verify yang expired
    public function verifyTokenIsExpired($email)
    {
        // Jika expired, hapus data user dari table user dan token berdasarkan email yang dikirimkan
        $this->db->delete('user', ['emailUser' => $email]);
        $this->db->delete('user_token', ['email' => $email]);
    }

    // Method untuk menangani token forgot yang expired
    public function forgotTokenIsExpired($email)
    {
        // Jika expired, hapus data token dari user_token berdasarkan email yang dikirimkan
        $this->db->delete('user_token', ['email' => $email]);
    }

    // Method untuk mengganti password berdasarkan email dan password yang dikirimkan
    public function changePassword($email, $password)
    {
        // Update passwordUser where email = $email dari table user
        $this->db->set('passwordUser', $password);
        $this->db->where('emailUser', $email);
        $this->db->update('user');
    }
}
