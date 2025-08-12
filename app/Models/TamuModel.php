<?php

namespace App\Models;

use CodeIgniter\Model;

class TamuModel extends Model
{
    protected $table      = '"adminDashboard"."tamu"';  
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'nama', 'dari', 'jam_datang', 'asal', 
        'no_telp', 'jenis_kelamin', 'keperluan', 
        'foto_data', 'created_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; 
    
    // Override untuk mendefinisikan return type
    protected $returnType = 'array';
    
    // Validasi rules
    protected $validationRules = [
        'nama'          => 'required|min_length[3]|max_length[100]',
        'dari'          => 'required|min_length[3]|max_length[100]',
        'asal'          => 'required|min_length[5]|max_length[200]',
        'no_telp'       => 'required|regex_match[/^[0-9]{10,15}$/]',
        'jenis_kelamin' => 'required|in_list[Laki-laki,Perempuan]',
        'keperluan'     => 'required|min_length[5]',
        'jam_datang'    => 'required',
        'foto_data'     => 'required'
    ];
    
    protected $validationMessages = [
        'nama' => [
            'required'    => 'Nama harus diisi',
            'min_length'  => 'Nama minimal 3 karakter',
            'max_length'  => 'Nama maksimal 100 karakter'
        ],
        'dari' => [
            'required'    => 'Asal instansi harus diisi',
            'min_length'  => 'Asal instansi minimal 3 karakter',
            'max_length'  => 'Asal instansi maksimal 100 karakter'
        ],
        'no_telp' => [
            'required'    => 'Nomor telepon harus diisi',
            'regex_match' => 'Nomor telepon harus berupa angka 10-15 digit'
        ],
        'jenis_kelamin' => [
            'required'    => 'Jenis kelamin harus dipilih',
            'in_list'     => 'Jenis kelamin tidak valid'
        ],
        'keperluan' => [
            'required'    => 'Keperluan harus diisi',
            'min_length'  => 'Keperluan minimal 5 karakter'
        ],
        'foto_data' => [
            'required'    => 'Foto tamu harus diambil'
        ]
    ];
}