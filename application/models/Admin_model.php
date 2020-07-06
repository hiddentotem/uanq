<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Controller admin yang menglola admin page
class Admin_model extends CI_Model
{
    // Method untuk menampilkan semua role
    public function getRole()
    {
        return $this->db->get('user_role')->result_array();
    }

    // Method untuk menampilkan role berdasarkan id yang dikirimkan
    public function getRoleById($role_id)
    {
        return $this->db->get_where('user_role', ['idRole' => $role_id])->row_array();
    }

    // Method untuk menampilkan semua menu
    public function getMenu()
    {
        $this->db->where('idMenu !=', 1);
        return $this->db->get('user_menu')->result_array();
    }

    // Method untuk menampilkan akses berdasarkan data
    public function getAccess($data)
    {
        return $this->db->get_where('user_access_menu', $data)->num_rows();
    }

    public function getBalance()
    {
        $email = $this->session->userdata('email');
        $result = $this->db->query("SELECT SUM(income-outcome) as balance FROM earnings WHERE email = '$email'")->row();

        return $result->balance;
    }

    public function getEarningMonthly()
    {
        $year = date('Y');
        $month = date('m');

        $email = $this->session->userdata('email');
        $result = $this->db->query("SELECT SUM(income-outcome) as totalEarning FROM earnings WHERE email = '$email' AND MONTH(dateCreated) = $month AND YEAR(dateCreated) = $year")->row();

        return $result->totalEarning;
    }

    public function getIncomeMonthly()
    {
        $year = date('Y');
        $month = date('m');

        $email = $this->session->userdata('email');
        $result = $this->db->query("SELECT SUM(income) as totalIncome FROM earnings WHERE email = '$email' AND MONTH(dateCreated) = $month AND YEAR(dateCreated) = $year")->row();

        return $result->totalIncome;
    }

    public function getOutcomeMonthly()
    {
        $year = date('Y');
        $month = date('m');

        $email = $this->session->userdata('email');
        $result = $this->db->query("SELECT SUM(outcome) as totalOutcome FROM earnings WHERE email = '$email' AND MONTH(dateCreated) = $month AND YEAR(dateCreated) = $year")->row();

        return $result->totalOutcome;
    }

    public function getEarningPermonth()
    {
        $year = date('Y');

        $email = $this->session->userdata('email');
        $result = $this->db->query("SELECT `bulan`.`namaBulan`, SUM(`earnings`.`income` - `earnings`.`outcome`) as balance FROM `bulan` LEFT JOIN `earnings` ON `bulan`.`idBulan` = MONTH(`earnings`.`dateCreated`) WHERE `earnings`.`email` = '$email' AND YEAR(dateCreated) = $year GROUP BY MONTH(`earnings`.`dateCreated`) ORDER BY `bulan`.`idBulan`");

        return $result->result_array();
    }

    public function getIncomeOutcomePercentage()
    {
        $year = date('Y');
        $month = date('m');

        $email = $this->session->userdata('email');
        $result = $this->db->query("SELECT ROUND(SUM(totIncome / total*100), 2) as incomes, ROUND(SUM(totOutcome / total*100), 2) as outcomes FROM ( SELECT SUM(income) as totIncome, SUM(outcome) as totOutcome, SUM(outcome + income) as total FROM earnings WHERE email = '$email' AND MONTH(dateCreated) = $month AND YEAR(dateCreated) = $year) as sumary");

        return $result->result_array();
    }

    public function setRole($data)
    {
        $this->db->insert('user_role', $data);
    }

    public function deleteRole($id)
    {
        $this->db->where('idRole', $id);
        $this->db->delete('user_role');
    }

    // Method untuk menambahkan akses baru berdasarkan data
    public function setAccess($data)
    {
        $this->db->insert('user_access_menu', $data);
    }

    // Method untuk menghapus akses berdasarkan data
    public function dropAccess($data)
    {
        $this->db->delete('user_access_menu', $data);
    }
}
