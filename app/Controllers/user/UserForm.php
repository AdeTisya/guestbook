<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class UserForm extends BaseController
{
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
        'nama' => 'required|min_length[3]|max_length[100]',
        'dari' => 'required|min_length[3]|max_length[100]',
        'no_telp' => 'required|numeric|min_length[10]|max_length[15]',
        'foto_data' => 'required',
        'asal' => 'required|min_length[5]|max_length[200]',
        'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
        'keperluan' => 'required|min_length[10]|max_length[500]',
        'jam_datang' => 'required'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    try {
        $model = new \App\Models\TamuModel();
        
        $jamDatangRaw = $this->request->getPost('jam_datang');
        $jamDatangFormatted = null;
        if ($jamDatangRaw) {
            $timestamp = strtotime(str_replace('/', '-', $jamDatangRaw));
            if ($timestamp !== false) {
                $jamDatangFormatted = date('Y-m-d H:i:s', $timestamp);
            } else {
                $jamDatangFormatted = null;
            }
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'dari' => $this->request->getPost('dari'),
            'jam_datang' => $jamDatangFormatted,
            'asal' => $this->request->getPost('asal'),
            'no_telp' => $this->request->getPost('no_telp'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'keperluan' => $this->request->getPost('keperluan'),
            'foto_data' => $this->request->getPost('foto_data')
        ];

        $model->insert($data);
        
        return redirect()->to('/user/form')->with('message', 'Data berhasil disimpan!')->with('message_type', 'success');
        
    } catch (\Exception $e) {
        log_message('error', $e->getMessage());
        return redirect()->back()->withInput()->with('message', 'Terjadi kesalahan: ' . $e->getMessage())->with('message_type', 'danger');
    }
}

// Fungsi untuk kompresi gambar base64
private function compressBase64Image($base64, $quality = 75)
{
    $img = imagecreatefromstring(base64_decode(explode(',', $base64)[1]));
    ob_start();
    imagejpeg($img, null, $quality);
    $compressed = ob_get_clean();
    imagedestroy($img);
    return 'data:image/jpeg;base64,' . base64_encode($compressed);
}
}