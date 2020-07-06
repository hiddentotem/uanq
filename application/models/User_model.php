<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Controller admin yang menglola admin page
class User_model extends CI_Model
{
    public function editProfileWithImage($nameUpdate, $emailUpdate, $newImage = 'default.jpg')
    {
        $this->db->set('imageUser', $newImage);
        $this->db->set('namaUser', $nameUpdate);
        $this->db->where('emailUser', $emailUpdate);
        $this->db->update('user');
    }

    public function editProfile($nameUpdate, $emailUpdate)
    {
        $this->db->set('namaUser', $nameUpdate);
        $this->db->where('emailUser', $emailUpdate);
        $this->db->update('user');
    }

    // Earning n stuff
    public function setEarning($data)
    {
        $this->db->insert('earnings', $data);
    }

    public function getEarning()
    {
        $email = $this->session->userdata('email');
        $date = date('Y-m-d');
        return $this->db->order_by('idEarning', 'DESC')->get_where('earnings', ['email' => $email, 'dateCreated' => $date])->result_array();
    }

    public function getDate()
    {
        return date('l, d M Y');
    }

    public function getEarningById($id)
    {
        return $this->db->get_where('earnings', ['idEarning' => $id])->row_array();
    }

    public function getBalance()
    {
        $email = $this->session->userdata('email');
        $result = $this->db->query("SELECT SUM(income-outcome) as balance FROM earnings WHERE email = '$email'")->row();

        return $result->balance;
    }

    public function getTodayIncome()
    {
        $date = date('Y-m-d');
        $email = $this->session->userdata('email');
        $this->db->select_sum('income');
        $result = $this->db->get_where('earnings', ['email' => $email, 'dateCreated' => $date])->row();

        return $result->income;
    }

    public function getTodayOutcome()
    {
        $date = date('Y-m-d');
        $email = $this->session->userdata('email');
        $this->db->select_sum('outcome');
        $result = $this->db->get_where('earnings', ['email' => $email, 'dateCreated' => $date])->row();

        return $result->outcome;
    }

    public function getEarningByDate()
    {
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $email = $this->session->userdata('email');

        $this->db->where('email', $email);
        $this->db->where("dateCreated BETWEEN '$startDate' AND '$endDate'");
        $this->db->order_by('idEarning', 'DESC');
        return $this->db->get('earnings')->result_array();
    }

    public function getBalanceByDate()
    {
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $email = $this->session->userdata('email');

        $result = $this->db->query("SELECT SUM(income-outcome) as balance FROM earnings WHERE email = '$email' AND dateCreated BETWEEN '$startDate' AND '$endDate'")->row();

        return $result->balance;
    }

    public function getIncomeByDate()
    {
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $email = $this->session->userdata('email');

        $this->db->select_sum('income');
        $this->db->where('email', $email);
        $this->db->where("dateCreated BETWEEN '$startDate' AND '$endDate'");
        $result =  $this->db->get('earnings')->row();

        return $result->income;
    }

    public function getOutcomeByDate()
    {
        $startDate = $this->input->post('startDate');
        $endDate = $this->input->post('endDate');
        $email = $this->session->userdata('email');

        $this->db->select_sum('outcome');
        $this->db->where('email', $email);
        $this->db->where("dateCreated BETWEEN '$startDate' AND '$endDate'");
        $result =  $this->db->get('earnings')->row();

        return $result->outcome;
    }

    public function deleteEarningById($id)
    {
        $this->db->delete('earnings', ['idEarning' => $id]);
    }

    public function editEarning($data)
    {
        // tangkap id yang dikirimkan oleh form
        $id = $this->input->post('idEarning');

        // Update sub menu baru berdasarkan data yang dikirimkan
        $this->db->where('idEarning', $id);
        $this->db->update('earnings', $data);
    }


    // Teams
    public function getBisnis()
    {
        $email = $this->session->userdata('email');
        return $this->db->get_where('teams', ['emailOwner' => $email])->row_array();
    }

    public function getCrew()
    {
        $email = $this->session->userdata('email');
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
