<?php

// Deklarasi namespace untuk filter ini
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\LoginLogModel;
use App\Models\IpBlockModel;

class FilterCekPercobaanLogin implements FilterInterface
{
    /**
     * @param RequestInterface|\CodeIgniter\HTTP\IncomingRequest $request
     */


    //Method before yang akan dijalankan sebelum controller
    public function before(RequestInterface $request, $arguments = null)
    {
        //load model
        //Inisialisasi Model dan Variabel
        // Model untuk mencatat log login
        $logModel = new LoginLogModel();
        // Inisialisasi IpBlockModel untuk memeriksa IP yang diblokir
        $IpBlockModel = new IpBlockModel();
        // Ambil alamat IP pengguna dari request
        $ipAddress = $request->getIPAddress();
        // Inisialisasi response untuk mengirimkan JSON response
        $response = service('response');



        // ==============================================
        // TAHAP 1: CEK APAKAH IP PENGGUNA SUDAH DIBLOKIR
        // ==============================================

        // Memeriksa apakah IP ($ipAddress) pengguna sudah ada di tabel blockip
        if ($IpBlockModel->isIpBlocked($ipAddress)) {
            //jika IP diblokir tampilkan pesan yang kita set ke dalam setFlashdata
            session()->setFlashdata('lock_message', 'Alamat IP Anda telah diblokir secara permanen.');

            // Cek apakah request berasal dari AJAX
            if ($request->isAJAX()) {
                //JIKA DIA NGAKSES LEWAT PERMINTAAN AJAX MAKA
                //KITA AKAN ARAHIN KE HALAMAN LOCKED DENGAN PESAN PERMANENT = 'lock_type' = 'permanent'
                return $response->setJSON(['lock_type' => 'permanent', 'redirect_url' => base_url('locked')]);
            } else {
                //kalau dia ngakses baseurl tidak melalui ajax maka, redirect langsung ke halaman locked
                return redirect()->to(base_url('locked'));
            }
        }




        //KALAU TIDAK ADA DATA DI TABEL IP BLOCK MAKA LANJUT-->
        // ======================================================
        // TAHAP 2: CEK HISTORY PERCOBAAN LOGIN YANG GAGAL
        // ======================================================

        //AMBIL DATA TERAHIR KALI DIA LOGIN TERUS SUKSES, mengambil dari IP--->AMBIL SATU BARIS DATA TERAHIR
        $lastSuccess = $logModel->where(['ip_address' => $ipAddress, 'is_success' => true])->orderBy('id', 'DESC')->first();
        //AMBIL DATA 1 KOLOM DALAM SATU ROW yang berhasil login terakhir === DATA LOGIN_AT ATAU TANGGAL NYA AJAH...
        $lastSuccessTime = $lastSuccess ? $lastSuccess['login_at'] : '1970-01-01 00:00:00';

        // Membuat array klausa WHERE untuk mencari percobaan login gagal setelah login sukses terakhir
        $whereClauses = [
            'ip_address' => $ipAddress,  // Filter berdasarkan IP
            'is_success' => false, // Hanya ambil yang gagal
            'login_at >' => $lastSuccessTime // Setelah login sukses terakhir
        ];

        // Mencari semua percobaan login gagal setelah login sukses terakhir
        $failedAttempts = $logModel->where($whereClauses)
            ->orderBy('id', 'ASC') 
            ->findAll();

        //HITUNG JUMLAH DATA GAGAL LOGIN
        $failedCount = count($failedAttempts);

        //SIAPKAN VARIABEL UNTUK PESAN TERKUNCI
        $lockMessage = '';

        //Flag untuk menentukan apakah harus memblokir, KITA BIKIN VARIABEL SHOULDLOCK KITA ISI DEFAULT FALSE
        $shouldLock = false;





        // ======================================================
        // TAHAP 3: LOGIKA PEMBLOKIRAN BERDASARKAN PERCOBAAN GAGAL
        // ======================================================

        /// Jika percobaan gagal >= 15 kali
        if ($failedCount >= 15) {
            //KITA HITUNG PERCOBAAN GAGAL LEBI DARI 15 GAK,KALAU IYA MAKA==>
            //KITA MASUKKAN DATA IP PENGGUNA YANG GAGAL LOGIN 15 X KE DB TABEL IPBLOCKED--->
            // Blokir IP secara permanen
            $IpBlockModel->save([
                'ip_address' => $ipAddress,
                'reason'     => 'Gagal login >= 15 kali secara beruntun.'
            ]);
            $lockMessage = 'Alamat IP Anda telah diblokir secara permanen karena terlalu banyak percobaan login.';
            $shouldLock = true;
        // Jika percobaan gagal >= 10 kali
        } elseif ($failedCount >= 10) {
            // Ambil waktu percobaan gagal ke-10
            //BUAT VARIABEL tenthFailTime = UNTUK MENAMPUNG JAM ATAU WAKTU DI KOLOM LOGIN_AT
            $tenthFailTime = strtotime($failedAttempts[9]['login_at']);

            //KITA SET WAKTU TUNGGUNYA 10 MENIT ITU 600 UNTUK TRIAL SAYA SENGAJA KASIH 9 UNTUK 9 DETIK
            if (time() - $tenthFailTime < 9) {
                //HITUNG MUNDUR --- DARI WAKTU YANG DITENTUKAN
                $lockMessage = 'Anda telah gagal login 10 kali. Silakan coba lagi dalam 10 menit.';
                $shouldLock = true;
            }

            // Jika percobaan gagal >= 5 kali
        } elseif ($failedCount >= 5) {
            // Ambil waktu percobaan gagal ke-5
            $fifthFailTime = strtotime($failedAttempts[4]['login_at']);
            // Cek apakah 5 percobaan gagal terjadi dalam 6 detik terakhir (untuk testing)
            //AMBIL WAKTU DARI LOGIN_AT
            if (time() - $fifthFailTime < 6) {
                //HITUNG MUNDUR --- DARI WAKTU YANG DITENTUKAN
                $lockMessage = 'Anda telah gagal login 5 kali. Silakan coba lagi dalam 1 menit.';
                $shouldLock = true;
            }
        }

        // ======================================================
        // TAHAP 4: PROSES PEMBLOKIRAN JIKA DIBUTUHKAN
        // ======================================================
        //INI SAYA BUAT UNTUK MENAMPILKAN PESAN GAGAL LOGIN DI HALAMAN LOGIN
        //DAN UNTUK MENAMPILKAN HITUNGAN MUNDUR WAKTU TUNGGU UNTUK LOGIN KEMBALI
        if ($shouldLock) {
            //JIKA TRUE MAKA =>
            // Menentukan waktu expiry lock berdasarkan jumlah percobaan gagal
            if ($failedCount >= 10) {
                $lockExpiryTime = strtotime($failedAttempts[9]['login_at']) + 9;
            } else {
                $lockExpiryTime = strtotime($failedAttempts[4]['login_at']) + 6;
            }

            // Menyimpan data lock ke session
            $lockData = [
                'message' => $lockMessage,
                'expiration_time' => $lockExpiryTime
            ];
            session()->set('lock_data', $lockData);

            // Response berdasarkan tipe request (AJAX atau bukan)
            if ($request->isAJAX()) {
                return $response->setJSON(['lock_type' => 'timed', 'redirect_url' => base_url('locked')]);
            } else {
                return redirect()->to(base_url('locked'));
            }
        }
        // Jika semua kondisi di atas tidak terpenuhi, tidak ada yang dilakukan
        // dan request akan dilanjutkan ke controller
    }

    /**
     * Method after yang dijalankan setelah controller
     * Tidak diimplementasikan dalam kasus ini
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
