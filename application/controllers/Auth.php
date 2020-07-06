<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Controller auth, mengelola authentikasi user (registrasi, login, etc)
class Auth extends CI_Controller
{
    // Method construct, untuk memanggil form validation
    public function __construct()
    {
        // Memanggil construct milik parent
        parent::__construct();

        // Memanggil model Auth_model
        $this->load->model('Auth_model', 'auth');
    }

    // Method login
    public function index()
    {
        // Cek apakah si user lagi login atau nga
        if ($this->session->userdata('email')) {
            // Jika lagi login, kembalikan ke user page
            redirect('user');
        }

        $data['title'] = 'Login';

        // Set rules untuk form login, cek email valid dan required
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        // Cek apakah validasi from berhasil
        if ($this->form_validation->run() == FALSE) {
            // Jika gagal, back to form login
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // Jika berhasil, jalankan method _login()
            $this->_login();
        }
    }

    // Method lanjutan dari method index
    private function _login()
    {
        // Tangkap input email dan password dari form login
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // Cari user berdasarkan email yang di input, via model
        $user = $this->auth->getUserByEmail($email);

        // Cek, apakah user nya ada
        if ($user) {
            // Jika ada, cek apakah aktif?
            if ($user['isActive'] == 1) {
                // Jika aktif, cek kesesuaian password
                if (password_verify($password, $user['passwordUser'])) {
                    // jika sesuai, tangkap data user yang mau dimasukan kedalam session
                    $data = [
                        'email' => $user['emailUser'],
                        'idRole' => $user['idRole']
                    ];

                    // Set session user
                    $this->session->set_userdata($data);

                    // Cek role user
                    if ($user['idRole'] == 1) {
                        // Jika id role = 1, arahkan ke admin page
                        redirect('admin');
                    } else {
                        // Jika id role != 1, arahkan ke user page
                        redirect('user');
                    }
                } else {
                    // Jika tidak sesuai, tampilkan pesan kesalahan
                    $this->session->set_flashdata('wpass', 'password');
                    redirect('auth');
                }
            } else {
                // Jika tidak aktif, tampilkan pesan kesalahan
                $this->session->set_flashdata('aemail', $email);
                redirect('auth');
            }
        } else {
            // Jika tidak ada, tampilkan pesan kesalahan
            $this->session->set_flashdata('wemail', $email);
            redirect('auth');
        }
    }

    // Method registrasi
    public function registration()
    {
        // Cek apakah si user lagi login atau nga
        if ($this->session->userdata('email')) {
            // Jika lagi login, kembalikan ke user page
            redirect('user');
        }

        // Set rules untuk setiap input
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.emailUser]', ['is_unique' => 'Email has already registered!']);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', ['matches' => 'Password is not match!', 'min_length' => 'Password is too short!']);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        // Cek, apakah validasi form nya berhasil
        if ($this->form_validation->run() == FALSE) {
            // Jika gagal, kembali ke form registration
            $data['title'] = 'Registration Users';

            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            // Jika berhasil, tangkap data yang di input
            $emailRegister = htmlspecialchars($this->input->post('email', true));
            $nameRegister = htmlspecialchars($this->input->post('name', true));
            $passwordRegister = $this->input->post('password1');

            // Siapkan data yang akan di register
            $data = [
                'namaUser' => $nameRegister,
                'emailUser' => $emailRegister,
                'imageUser' => 'default.jpg',
                'passwordUser' => password_hash($passwordRegister, PASSWORD_DEFAULT),
                'idRole' => 2,
                'idTeam' => 0,
                'isOwner' => 0,
                'isActive' => 0,
                'dateCreated' => time()
            ];

            // Buat token untuk verifikasi email
            $token = base64_encode(random_bytes(32));

            // Siapkan data yang akan di insert ke user_token
            $user_token = [
                'email' => $emailRegister,
                'token' => $token,
                'date_created' => time()
            ];

            // Insert data user baru dan insert token untuk verifikasi email, via model
            $this->auth->setUser($data);
            $this->auth->setToken($user_token);

            // Setelah di insert, maka jalankan method _sendEmail untuk mengirimkan email verifkasi
            $this->_sendEmail($token, 'verify', $emailRegister);

            // Jika berhasil, tampilkan pesan berhasil dan redirect ke halaman login
            $this->session->set_flashdata('regsucs', $emailRegister);
            redirect('auth');
        }
    }

    // Method untuk mengirimkan email
    private function _sendEmail($token, $type, $email)
    {
        // Config standar untuk sendEmail menggunakan GMAIL
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'badcodebutgoodjoke@gmail.com',
            'smtp_pass' => 'Rangga@123',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        // Load library email beserta configurasinya
        $this->load->library('email', $config);
        $this->email->initialize($config);

        // Email nya nanti mau dikirim oleh siapa
        $this->email->from('badcodebutgoodjoke@gmail.com', 'Bad Code Society');

        // Email nya nanti mau dikirim ke siapa
        $this->email->to($email);

        // Jika tipenya verify tentukan subject dan messagenya
        if ($type == 'verify') {
            // Subject emailnya apa
            $this->email->subject('Account Verification');

            // Isi emailnya apa
            $this->email->message('Click this link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . $email . '&token=' . urlencode($token) . '">Activate</a>.');
        } else if ($type == 'forgot') {
            // Jika tipenya forgot, Subject emailnya apa
            $this->email->subject('Reset Password');

            // Isi emailnya apa
            $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $email . '&token=' . urlencode($token) . '">Reset password</a>.');
        }

        // Cek apakah emailnya berhasil dikirm
        if ($this->email->send()) {
            // Jika berhasil return true
            return true;
        } else {
            // Jika gagal tampilkan errornya
            echo $this->email->print_debugger();
            die;
        }
    }

    // Method verifkasi email, melalui link yang dikirimkan oleh sendEmail
    public function verify()
    {
        // Tangkap email dan token dari URLs yang dikirimkan dari _sendEmail
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        // cari email dari table user berdasarkan email yang dikirmkan melalui URLs, via model
        $user = $this->auth->getUserByEmail($email);

        // Cek apakah usernya ada
        if ($user) {
            // Jika ada, cari token berdasarkan token yang dikirimkan melalui URLs, via model
            $user_token = $this->auth->getTokenByToken($token);

            // Cek, apakah token ketemu
            if ($user_token) {
                // Jika ketemu, cek apakah tokennya expired selama 24 jam
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    // Jika blm expired, update user menjadi active dan hapus tokennya, via model
                    $this->auth->emailIsVerify($email);

                    // Tampilkan pesan berhasil dan redirect ke halaman login
                    $this->session->set_flashdata('stoken', $email);
                    redirect('auth');
                } else {
                    // Jika expired, maka hapus data user dan tokennya berdasarkan email yang dikirimkan, via model
                    $this->auth->verifyTokenIsExpired($email);

                    // Tampilkan pesan token expired, dan redirect ke halaman login
                    $this->session->set_flashdata('etoken', 'token');
                    redirect('auth');
                }
            } else {
                // Jika tokennya ga ketemu, tampilkan pesan error dan redirect ke halaman login
                $this->session->set_flashdata('wtoken', 'Activation');
                redirect('auth');
            }
        } else {
            // Jika usernya ga ada, tampilkan pesan email salah
            $this->session->set_flashdata('wemail', $email);
            redirect('auth');
        }
    }

    // Method untuk lupa password, yang akan mengirimkan token ke email user
    public function forgotPassword()
    {
        // Set rules untuk form forgot password
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');

        // Cek validasi rules nya
        if ($this->form_validation->run() == FALSE) {
            // Jika gagal, back to form forgot password
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
        } else {
            // Jika berhasil, tangkap email yang di input
            $email = $this->input->post('email');

            // Cari user aktif yang emailnya sesuai dengan email yang dikirimkan, via model
            $user = $this->auth->getActiveUserByEmail($email);

            // Cek apakah usernya ada
            if ($user) {
                // Jika ada, buat token
                $token = base64_encode(random_bytes(32));

                // Siapkan data untuk, insert token
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                // Insert data token yang sudah di generate untuk email forgot password
                $this->auth->setToken($user_token);
                $this->_sendEmail($token, 'forgot', $email);

                // Tampilkan pesan email terikirim
                $this->session->set_flashdata('sforgot', 'Please check your email to reset your password.');
                redirect('auth/forgotpassword');
            } else {
                // Jika ga ada, Tampilkan pesan usernya ga ada
                $this->session->set_flashdata('wforgot', $email);
                redirect('auth/forgotpassword');
            }
        }
    }

    // Method untuk link yang dikirimkan di email forgot password
    public function resetPassword()
    {
        // Tangkap email dan token yang dikirimkan oleh URLs
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        // Cari user berdasarkan email yang dikirimkan
        $user = $this->auth->getUserByEmail($email);

        // Cek apakah usernya ada
        if ($user) {
            // Jika ada, maka cari tokennya
            $user_token = $this->auth->getTokenByToken($token);

            // Cek apakah tokennya ada
            if ($user_token) {
                // Jika ada, cek apakah tokennya expired atau blm 24 Jam
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    // Jika blm expired, buat session reset_email yang menyimpan email dan jalankan method changePassword
                    $this->session->set_userdata('reset_email', $email);
                    $this->changePassword();
                } else {
                    // Jika expired, hapus data user dari table token, via model
                    $this->auth->forgotTokenIsExpired($email);

                    // Tampilkan pesan token expired
                    $this->session->set_flashdata('extoken', 'Reset Password');
                    redirect('auth');
                }
            } else {
                // Jika ga ada, tampilkan pesan token invalid
                $this->session->set_flashdata('wtoken', 'Reset Password');
                redirect('auth');
            }
        } else {
            // Jika ga ada, tampilkan pesan user tidak ditemukan
            $this->session->set_flashdata('wemail', $email);
            redirect('auth');
        }
    }

    // Method untuk menjalankan ganti password sesuai data dari resetPassword
    public function changePassword()
    {
        // cek apakah session reset_email sudah dibuat
        if (!$this->session->userdata('reset_email')) {
            // Jika blm, lempar ke login
            redirect('auth');
        }

        // set rules untuk change password
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|min_length[3]|matches[password1]');

        // cek validasi rules nya
        if ($this->form_validation->run() == FALSE) {
            // Jika gagal, back to form change password
            $data['title'] = 'Change Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth_footer');
        } else {
            // Jika berhasil, tangkap dan hash password yang di input
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

            // ambil email dari session reset_email
            $email = $this->session->userdata('reset_email');

            // ganti password user berdasarkan password yang dikirimkan dan hapus tokennya, via model
            $this->auth->changePassword($email, $password);
            $this->auth->forgotTokenIsExpired($email);

            // hapus sessionnya apabila password berhasil di ganti
            $this->session->unset_userdata('reset_email');

            // Tampilkan pesan ganti password berhasil
            $this->session->set_flashdata('sreset', 'Reset Password');
            redirect('auth');
        }
    }

    // Method logout
    public function logout()
    {
        // unset session yang ada
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('idRole');

        // Tampilkan pesan logout berhasil
        $this->session->set_flashdata('logout', 'Logout');
        redirect('auth');
    }

    // Method untuk menampilkan forbidden page
    public function blocked()
    {
        // Mengambil data user berdasarkan email yang dikirimkan oleh session
        $email = $this->session->userdata('email');
        $data['user'] = $this->db->get_where('user', ['emailUser' => $email])->row_array();

        // Mencari menu yang ada, via model
        $data['menu'] = $this->auth->getMenu();
        $data['title'] = 'Access Forbidden';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('auth/blocked', $data);
        $this->load->view('templates/footer');
    }
}
