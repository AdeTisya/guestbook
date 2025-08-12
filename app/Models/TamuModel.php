<?php

namespace App\Models;

use CodeIgniter\Model;

class TamuModel extends Model
{
protected $table      = 'adminDashboard.tamu'; 
protected $primaryKey = 'id';
protected $allowedFields = [
    'nama', 'dari', 'jam_datang', 'asal', 
    'no_telp', 'jenis_kelamin', 'keperluan' , 
    'foto_data', 'created_at'  
];
protected $useTimestamps = true;
protected $createdField  = 'created_at';
protected $updatedField  = ''; 
}