<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\LoginLogModel;

class Login extends BaseController
{
    public function index()
    {
        return view('auth/login', ['cssFile' => 'login.css']);
    }


    public function eseclogin()
    {
        // ==============================================
        // TAHAP 1: VALIDASI INPUT
        // ==============================================

        
        // $rules = [
        //     'ganti_dengan_name_inputan' => [
        //         'label' => 'ganti_label_bebas',
        //         'rules' => 'required|max_length[100]',
        //     ]
        // ];
        
        // Rules(aturan) validasi untuk form login
        $rules = [
            'credential' => [
                'label' => 'Email atau Username',
                'rules' => 'required|max_length[100]',
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required', 
            ],
        ];

        //==================AKHIR VALIDASI---->

        //Jka validasi di variabel $rules itu salah maka ! jika false atau null bukan hal benar
        if (!$this->validate($rules)) {
            //ini jika salah---->
            //return mengembalikan nilai dan menghentikan esekusi coding,,,,
            //var_dump();
            //exit();

            // Kembalikan response JSON dengan error validasi
            return $this->response->setJSON([
                'status' => false,
                'message' => $this->validator->getErrors()['credential'] ?? $this->validator->getErrors()['password'],
                'csrf_baru' => csrf_hash(), // Generate CSRF token baru
            ]);
        }


        // ==============================================
        // TAHAP 2: VERIFIKASI USER DAN PASSWORD
        // ==============================================

        // Ambil data dari form
        $email = $this->request->getPost('credential');
        $password = $this->request->getPost('password');


        //kita ambil data user dulu dari database ===>
        
        $userModel = new UserModel();
        $user = $userModel->getDataUserByEmail($email); // Cari user berdasarkan email
        //=======>  
        //masuk cek data---> 
        // Jika user tidak ditemukan atau password tidak cocok
        //arti dari || or semua harus benar maka true jika salah satu salah maka false. 
        //contoh jika ada true dan false maka dianggap false dan jika ada true dan true maka true.
        if (!$user || !password_verify($password, $user['password_hash'])) {
            //masukan data user yang mencoba login ke dalam tabel log
            $LoginLogModel = new LoginLogModel();
            $LoginLogModel->save([
                'user_id'         => $user['id'] ?? null,
                'ip_address'      => $this->request->getIPAddress(),
                'user_agent'      => $this->request->getUserAgent()->getAgentString(),
                'is_success'      => false,
                'credential_used' => $email,
            ]);


            // Buat Variabel untuk mencatat tanggal terakhir si user berhasil Login
            $TanggalBerhasilLoginTerakhir = $LoginLogModel->where(['ip_address' => $this->request->getIPAddress(), 'is_success' => true])->orderBy('id', 'DESC')->first()['login_at'] ?? '1970-01-01';
            //Hitung Jumlah User Gagal Login dihitung dari terakhir dia berhasil login
            $JumlahKegagalanLogin = $LoginLogModel->where(['ip_address' => $this->request->getIPAddress(), 'is_success' => false, 'login_at >' => $TanggalBerhasilLoginTerakhir])->countAllResults();

             // Kembalikan response error
            return $this->response->setJSON([
                'status'        => false,
                'message'       => 'Email atau Password Salah !',
                'failed_count'  => $JumlahKegagalanLogin,
                'csrf_baru' => csrf_hash()
            ]);
        }


        // ==============================================
        // TAHAP 3: CEK STATUS AKUN AKTIF
        // ==============================================
        // Periksa apakah key 'is_aktif' ada sebelum mengaksesnya
        $aktif_user = isset($user['is_aktif']) ? $user['is_aktif'] : 0;
        if ($aktif_user != 1) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                'csrf_baru' => csrf_hash()
            ]);
        }

        // ==============================================
        // TAHAP 4: LOGIN BERHASIL
        // ==============================================
        //TAHAP BERHASIL MELALUI TAHAP CEKING DATA---MAKA BOLEH LOGIN 
        //KITA SET SESI
        $session = session();
        $sessionData = [
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'nama_lengkap' => $user['nama_lengkap'],
            'isLoggedIn' => true,
        ];
        $session->set($sessionData);

        //SET SESI SELESAI
        //MASUKKAN DATA KE TABEL USER,UNTUK MENANDAI JIKA BERHASIL LOGIN
        $LoginLogModel = new LoginLogModel();
        $LoginLogModel->save([
            'user_id'    => $user['id'],
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'is_success' => true,
            'credential_used' => $email,
        ]);

        //RETURN UNTUK MENGEMBALIKAN DATA DAN MENGHENTIKAN JALANNYA PROSES
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Login Berhasil!',
            'redirect_url' => base_url('admin'),
            'csrf_baru' => csrf_hash()
        ]);
    }

     // Method untuk menampilkan halaman locked (ketika IP diblokir)
    public function locked()
    {
        // Ambil data lock dari session
        // Jika tidak ada data lock, redirect ke halaman login
        if (!session()->has('lock_data')) {
            return redirect()->to(base_url('login'));
        }
        
        // Ambil data lock dari session
        $lockData = session()->get('lock_data');

         // data untuk view(untuk ditaplikkan ke user di halaman locked)
        session()->remove('lock_data');
        $data['message'] = $lockData['message'] ?? 'Terlalu banyak percobaan login.';
        $data['expiration_time'] = $lockData['expiration_time'] ?? null;

        // Tampilkan view auth/locked
        return view('auth/locked', $data);
    }

    public function logout()
    {
        $session = session();
        
        // Hapus semua data session
        $session->destroy();
        
        // Redirect ke halaman login
        return redirect()->to('/login')->with('message', 'Anda telah berhasil logout');
    }
}
