<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Controller user yang mengelola user page
class User extends CI_Controller
{
    // Method construct memanggil helper, dan model
    public function __construct()
    {
        // Extends ke construct parentnya
        parent::__construct();

        // Memanggil helper checkLogin
        checkLogin();

        // Memanggil model User_model
        $this->load->model('User_model', 'user');
    }

    public function index()
    {
        // mencari data user berdasarkan email yang dikirim oleh session
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();

        $data['title'] = 'Profile';

        $this->load->view('templates/header', $data); // Mengirimkan data user dan title
        $this->load->view('templates/sidebar', $data); // Mengirimkan data user
        $this->load->view('templates/topbar', $data); // Mengirimkan data user
        $this->load->view('user/index', $data); // Mengirimkan data user
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        // mencari data user berdasarakan email yang dikirimkan oleh session
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();

        $data['title'] = 'Edit Profile';

        // Set rules untuk form edit nama
        $this->form_validation->set_rules('name', 'Full name', 'required|trim');

        // Cek validasi rules
        if ($this->form_validation->run() == FALSE) {
            // Jika salah, tampilkan halaman edit
            $this->load->view('templates/header', $data); // Mengirimkan data user dan title
            $this->load->view('templates/sidebar', $data); // Mengirimkan data user
            $this->load->view('templates/topbar', $data); // Mengirimkan data user
            $this->load->view('user/edit', $data); // Mengirimkan data user
            $this->load->view('templates/footer');
        } else {
            // Jika berhasil, tangkap nama dan email yang diinputkan
            $nameUpdate = htmlspecialchars($this->input->post('name', true));
            $emailUpdate = htmlspecialchars($this->input->post('email', true));

            // Tangkap nama file yang akan diupload gaess
            $uploadImage = $_FILES['image']['name'];

            // Cek jika ada gambar yang akan diupload
            if ($uploadImage) {
                // Jika ada, maka tentukan aturan file yang di uploadnya
                $config['allowed_types'] = 'gif|jpg|png'; // Aturan file yang dibolehkan
                $config['max_size']     = '2048'; // Aturan max size file
                $config['upload_path'] = './assets/img/profile/'; // Aturan file akan di save dimana

                // panggil libary uploadnya
                $this->load->library('upload', $config);

                // Cek apakah upload filenya berhaseel?
                if ($this->upload->do_upload('image')) {
                    // Jika berhasil, cek gambar lama
                    $oldImage = $data['user']['imageUser'];

                    // Cek apakah gambar lama tidak sama dengan default.jpg
                    if ($oldImage != 'default.jpg') {
                        // Jika tidak sama, hapus oldImage
                        unlink(FCPATH . 'assets/img/profile/' . $oldImage);
                    }

                    // jika sama, tangkap nama file baru nya
                    $newImage = $this->upload->data('file_name');

                    // maka set imagenya berdasarkan newImage
                    $this->user->editProfileWithImage($nameUpdate, $emailUpdate, $newImage);
                } else {
                    // Jika gagal, maka tampilkan pesan error
                    echo $this->upload->display_errors();
                }
            }

            // Update data user yang baru
            $this->user->editProfile($nameUpdate, $emailUpdate);


            // Tampilkan pesan berhasil
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your profile has been updated.</div>');

            // Redirect ke halaman login
            redirect('user');
        }
    }

    public function changePassword()
    {
        // Mengambil email dari session
        $email = $this->session->userdata('email');

        // SELECT * FROM user WHERE emailUser = $email fecth_row
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();
        $data['title'] = 'Change Password';

        $this->form_validation->set_rules('currentPassword', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('newPassword1', 'New Password', 'required|trim|min_length[3]|matches[newPassword2]');
        $this->form_validation->set_rules('newPassword2', 'Repeat New Password', 'required|trim|min_length[3]|matches[newPassword1]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data); // Mengirimkan data user dan title
            $this->load->view('templates/sidebar', $data); // Mengirimkan data user
            $this->load->view('templates/topbar', $data); // Mengirimkan data user
            $this->load->view('user/changepassword', $data); // Mengirimkan data user
            $this->load->view('templates/footer', $data); // Mengirimkan data user
        } else {
            // Tangkap current password yang di input user
            $currentPassword = $this->input->post('currentPassword');
            $newPassword = $this->input->post('newPassword1');

            if (!password_verify($currentPassword, $data['user']['passwordUser'])) {
                // Tampilkan pesan berhasil
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Your current password is wrong.</div>');

                // Redirect ke halaman login
                redirect('user/changepassword');
            } else {
                if ($currentPassword == $newPassword) {
                    // Tampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password.</div>');

                    // Redirect ke halaman login
                    redirect('user/changepassword');
                } else {
                    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                    $this->db->set('passwordUser', $passwordHash);
                    $this->db->where('emailUser', $this->session->userdata('email'));
                    $this->db->update('user');

                    // Tampilkan pesan berhasil
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your password successfully changed.</div>');

                    // Redirect ke halaman login
                    redirect('user/changepassword');
                }
            }
        }
    }


    // Earnings
    public function earning()
    {
        // mencari data user berdasarkan email yang dikirim oleh session
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();
        $data['date'] = $this->user->getDate();
        $data['earnings'] = $this->user->getEarning();
        $data['balance'] = $this->user->getBalance();
        $data['sumIncome'] = $this->user->getTodayIncome();
        $data['sumOutcome'] = $this->user->getTodayOutcome();

        $data['title'] = 'Earnings';

        $this->form_validation->set_rules('judulTransaksi', 'Transaction', 'required|trim|max_length[35]');
        $this->form_validation->set_rules('incomeTransaksi', 'Income', 'required|trim');
        $this->form_validation->set_rules('outcomeTransaksi', 'Outcome', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data); // Mengirimkan data user dan title
            $this->load->view('templates/sidebar', $data); // Mengirimkan data user
            $this->load->view('templates/topbar', $data); // Mengirimkan data user
            $this->load->view('user/earning', $data); // Mengirimkan data user
            $this->load->view('templates/footer');
        } else {
            $judulTransaksi = $this->input->post('judulTransaksi');
            $incomeTransaksi = $this->input->post('incomeTransaksi');
            $outcomeTransaksi = $this->input->post('outcomeTransaksi');
            $dateCreated = $this->input->post('dateCreated');

            $data = [
                'email' => $email,
                'transaksi' => $judulTransaksi,
                'income' => $incomeTransaksi,
                'outcome' => $outcomeTransaksi,
                'dateCreated' => $dateCreated,
                'dateModified' => $dateCreated
            ];

            $this->user->setEarning($data);

            // Jika insert berhasil, tampilkan pesan berhasil dan redirect ke menu page
            $this->session->set_flashdata('searning', 'Add new');
            redirect('user/earning');
        }
    }

    public function earningSee()
    {
        // mencari data user berdasarkan email yang dikirim oleh session
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();
        $data['date'] = $this->input->post('startDate') . ' - ' . $this->input->post('endDate');
        $data['earnings'] = $this->user->getEarningByDate();
        $data['balance'] = $this->user->getBalanceByDate();
        $data['sumIncome'] = $this->user->getIncomeByDate();
        $data['sumOutcome'] = $this->user->getOutcomeByDate();

        $data['title'] = 'Earning';

        $this->form_validation->set_rules('judulTransaksi', 'Transaction', 'required|trim|max_length[35]');
        $this->form_validation->set_rules('incomeTransaksi', 'Income', 'required|trim');
        $this->form_validation->set_rules('outcomeTransaksi', 'Outcome', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header', $data); // Mengirimkan data user dan title
            $this->load->view('templates/sidebar', $data); // Mengirimkan data user
            $this->load->view('templates/topbar', $data); // Mengirimkan data user
            $this->load->view('user/seeEarning', $data); // Mengirimkan data user
            $this->load->view('templates/footer');
        } else {
            $judulTransaksi = $this->input->post('judulTransaksi');
            $incomeTransaksi = $this->input->post('incomeTransaksi');
            $outcomeTransaksi = $this->input->post('outcomeTransaksi');
            $dateCreated = $this->input->post('dateCreated');

            $data = [
                'transaksi' => $judulTransaksi,
                'income' => $incomeTransaksi,
                'outcome' => $outcomeTransaksi,
                'dateCreated' => $dateCreated,
                'dateModified' => $dateCreated
            ];

            $this->user->setEarning($data);

            // Jika insert berhasil, tampilkan pesan berhasil dan redirect ke menu page
            $this->session->set_flashdata('searning', 'Add new');
            redirect('user/earning');
        }
    }

    public function earningDelete($id)
    {
        $this->user->deleteEarningById($id);

        // Jika insert berhasil, tampilkan pesan berhasil dan redirect ke menu page
        $this->session->set_flashdata('delearning', 'Delete');
        redirect('user/earning');
    }

    public function earningGetAjax()
    {
        // tangkap id yang dikirimkan oleh ajax
        $id = $_POST['idJson'];

        // tangkap sub menu by id sebagai json, via model
        echo json_encode($this->user->getEarningById($id));
    }

    public function earningEdit()
    {
        $this->form_validation->set_rules('judulTransaksi', 'Transaction', 'required|trim|max_length[35]');
        $this->form_validation->set_rules('incomeTransaksi', 'Income', 'required|trim');
        $this->form_validation->set_rules('outcomeTransaksi', 'Outcome', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // Jika insert gagal, tampilkan pesan gagal dan redirect ke menu page
            $this->session->set_flashdata('edearningx', 'Failed');
            redirect('user/earning');
        } else {
            $judulTransaksi = $this->input->post('judulTransaksi');
            $incomeTransaksi = $this->input->post('incomeTransaksi');
            $outcomeTransaksi = $this->input->post('outcomeTransaksi');
            $dateCreated = $this->input->post('dateCreated');

            $data = [
                'transaksi' => $judulTransaksi,
                'income' => $incomeTransaksi,
                'outcome' => $outcomeTransaksi,
                'dateCreated' => $dateCreated,
                'dateModified' => date('Y-m-d')
            ];

            $this->user->editEarning($data);

            // Jika insert berhasil, tampilkan pesan berhasil dan redirect ke menu page
            $this->session->set_flashdata('edearning', 'Success');
            redirect('user/earning');
        }
    }



    // Teams
    public function teams()
    {
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();
        $data['bisnis'] = $this->user->getBisnis();
        $data['crew'] = $this->user->getCrew();
        $data['title'] = 'Teams';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/teams', $data);
        $this->load->view('templates/footer', $data);
    }

    public function addTeam()
    {
        $this->form_validation->set_rules('bisnis', 'Kategori', 'required|trim');
        $this->form_validation->set_rules('nama-team', 'Nama', 'required|trim');
        $this->form_validation->set_rules('is-active', 'Status', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // Jika insert gagal, tampilkan pesan gagal dan redirect ke menu page
            $this->session->set_flashdata('failadd', 'Team');
            redirect('user/teams');
        } else {
            $bisnisid = $this->input->post('bisnis');
            $namaTeam = $this->input->post('nama-team');
            $isActive = $this->input->post('is-active');
            $dateCreated = date('Y-m-d');
            $email = $this->session->userdata('email');

            $bisnis = $this->db->get_where('bisnis', ['idBisnis' => $bisnisid])->row_array();

            $data = [
                'idBisnis' => $bisnisid,
                'emailOwner' => $email,
                'namaTeam' => $namaTeam,
                'dateCreated' => $dateCreated,
                'dateModified' => 0,
                'status' => $isActive
            ];

            $this->user->createTeam($data);
            $idTeam = $this->db->insert_id();

            $updateUser = [
                'idRole' => $bisnis['idRole'],
                'idTeam' => $idTeam,
                'isOwner' => 1
            ];

            $this->db->where('emailUser', $email);
            $this->db->update('user', $updateUser);

            $updateCrew = [
                'idTeam' => $idTeam,
                'email' => $email,
                'jabatan' => 'Owner',
                'dateCreated' => $dateCreated,
                'dateModified' => 0,
                'status' => 1
            ];

            $this->db->insert('crew', $updateCrew);

            $dataCabang = [
                'email' => $email,
                'namaCabang' => 'Pusat',
                'alamatCabang' => 'Tattooine',
                'telpCabang' => '021-14045'
            ];

            $this->db->insert('cabang', $dataCabang);

            // Jika insert berhasil, tampilkan pesan berhasil dan redirect ke menu page
            $this->session->set_flashdata('succaddteam', $namaTeam);
            redirect('user/teams');
        }
    }

    public function ajaxCheckUser()
    {
        $user = $this->user->getUserByEmail($_POST['idJson']);

        if ($user) {
            if ($user['idTeam'] < 1) {
                $result = 'User available.';
            } else {
                $result = 'User already joined with team.';
            }
        } else {
            $result = 'User not found, please try another email.';
        }
        echo json_encode($result);
    }
}