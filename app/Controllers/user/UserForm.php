<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\TamuModel;

class UserForm extends BaseController
{
    protected $tamuModel;
    
    public function __construct()
    {
        $this->tamuModel = new TamuModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Buku Tamu Pemkab Gunungkidul',
            'genders' => ['Laki-laki', 'Perempuan'],
            'cssFile' => 'userform.css'
        ];
        
        return view('userside/userform', $data);
    }
    
    public function submitForm()
    {
        // Validation rules
        $rules = [
            'nama'          => 'required|min_length[3]|max_length[100]',
            'dari'          => 'required|min_length[3]|max_length[100]',
            'no_telp'       => 'required|regex_match[/^[0-9]{10,15}$/]',
            'foto_data'     => 'required',
            'asal'          => 'required|min_length[5]|max_length[200]',
            'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
            'keperluan'     => 'required|min_length[5]',
            'jam_datang'    => 'required'
        ];
        
        $messages = [
            'nama' => [
                'required'    => 'Nama harus diisi',
                'min_length'  => 'Nama minimal 3 karakter',
                'max_length'  => 'Nama maksimal 100 karakter'
            ],
            'dari' => [
                'required'    => 'Asal instansi harus diisi',
                'min_length'  => 'Asal instansi minimal 3 karakter'
            ],
            'no_telp' => [
                'required'    => 'Nomor telepon harus diisi',
                'regex_match' => 'Nomor telepon harus berupa angka 10-15 digit'
            ],
            'foto_data' => [
                'required' => 'Foto tamu harus diambil'
            ],
            'asal' => [
                'required'    => 'Alamat harus diisi',
                'min_length'  => 'Alamat minimal 5 karakter'
            ],
            'jenis_kelamin' => [
                'required' => 'Jenis kelamin harus dipilih',
                'in_list'  => 'Jenis kelamin tidak valid'
            ],
            'keperluan' => [
                'required'    => 'Keperluan harus diisi',
                'min_length'  => 'Keperluan minimal 5 karakter'
            ]
        ];
        
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()
                           ->withInput()
                           ->with('message', 'Data yang dimasukkan tidak valid')
                           ->with('message_type', 'danger')
                           ->with('errors', $this->validator->getErrors());
        }
        
        try {
            // Ambil data dari form
            $jamDatangRaw = $this->request->getPost('jam_datang');
            $jamDatangFormatted = $this->formatDateTime($jamDatangRaw);
            
            // Kompresi foto jika perlu
            $fotoData = $this->request->getPost('foto_data');
            if ($fotoData && strlen($fotoData) > 500000) { // Jika lebih dari 500KB
                $fotoData = $this->compressBase64Image($fotoData, 70);
            }
            
            $data = [
                'nama'          => trim($this->request->getPost('nama')),
                'dari'          => trim($this->request->getPost('dari')),
                'jam_datang'    => $jamDatangFormatted,
                'asal'          => trim($this->request->getPost('asal')),
                'no_telp'       => trim($this->request->getPost('no_telp')),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'keperluan'     => trim($this->request->getPost('keperluan')),
                'foto_data'     => $fotoData,
                'created_at'    => date('Y-m-d H:i:s')
            ];
            
            // Debug log
            log_message('info', 'Attempting to insert data: ' . json_encode($data));
            
            // Insert data ke database
            $insertResult = $this->tamuModel->insert($data);
            
            if ($insertResult) {
                log_message('info', 'Data successfully inserted with ID: ' . $insertResult);
                
                return redirect()->to('/user/form')
                               ->with('message', 'Data berhasil disimpan! Terima kasih atas kunjungan Anda.')
                               ->with('message_type', 'success');
            } else {
                // Jika insert gagal, tampilkan error
                $errors = $this->tamuModel->errors();
                log_message('error', 'Insert failed with errors: ' . json_encode($errors));
                
                return redirect()->back()
                               ->withInput()
                               ->with('message', 'Gagal menyimpan data: ' . implode(', ', $errors))
                               ->with('message_type', 'danger');
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Exception in submitForm: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                           ->withInput()
                           ->with('message', 'Terjadi kesalahan sistem: ' . $e->getMessage())
                           ->with('message_type', 'danger');
        }
    }
    
    /**
     * Format tanggal dan waktu dari format Indonesia ke database
     */
    private function formatDateTime($dateTimeString)
    {
        if (!$dateTimeString) {
            return date('Y-m-d H:i:s');
        }
        
        try {
            // Jika format DD/MM/YYYY HH:MM:SS
            if (preg_match('/(\d{2})\/(\d{2})\/(\d{4}) (\d{2}):(\d{2}):(\d{2})/', $dateTimeString, $matches)) {
                $day = $matches[1];
                $month = $matches[2];
                $year = $matches[3];
                $hour = $matches[4];
                $minute = $matches[5];
                $second = $matches[6];
                
                return "{$year}-{$month}-{$day} {$hour}:{$minute}:{$second}";
            }
            
            // Fallback: gunakan strtotime
            $timestamp = strtotime(str_replace('/', '-', $dateTimeString));
            if ($timestamp !== false) {
                return date('Y-m-d H:i:s', $timestamp);
            }
            
            // Jika semua gagal, gunakan waktu sekarang
            return date('Y-m-d H:i:s');
            
        } catch (\Exception $e) {
            log_message('error', 'DateTime formatting error: ' . $e->getMessage());
            return date('Y-m-d H:i:s');
        }
    }
    
    /**
     * Kompres gambar base64 untuk menghemat storage
     */
    private function compressBase64Image($base64, $quality = 75)
    {
        try {
            // Pastikan format base64 benar
            if (strpos($base64, 'data:image/') !== 0) {
                return $base64;
            }
            
            // Pisahkan header dan data
            $parts = explode(',', $base64);
            if (count($parts) !== 2) {
                return $base64;
            }
            
            $imageData = base64_decode($parts[1]);
            if (!$imageData) {
                return $base64;
            }
            
            // Buat image resource
            $img = imagecreatefromstring($imageData);
            if (!$img) {
                return $base64;
            }
            
            // Kompres sebagai JPEG
            ob_start();
            imagejpeg($img, null, $quality);
            $compressed = ob_get_clean();
            imagedestroy($img);
            
            return 'data:image/jpeg;base64,' . base64_encode($compressed);
            
        } catch (\Exception $e) {
            log_message('error', 'Image compression error: ' . $e->getMessage());
            return $base64;
        }
    }
}