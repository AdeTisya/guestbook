<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TamuModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends BaseController
{
    protected $tamuModel;

    public function __construct()
    {
        $this->tamuModel = new TamuModel();
    }

    public function index()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');
        $startDate = date("Y-m-01");
        $endDate = date("Y-m-t 23:59:59");

        $data = [
            'title' => 'Dashboard Admin',
            'totalTamu' => $this->tamuModel->countAll(),
            'tamuHariIni' => $this->tamuModel->where('DATE(created_at)', date('Y-m-d'))->countAllResults(),
            'tamuBulanIni' => $this->tamuModel->where('created_at >=', $startDate)
                                              ->where('created_at <=', $endDate)
                                              ->countAllResults(),
            'tamuPerempuan' => $this->tamuModel->where('jenis_kelamin', 'Perempuan')->countAllResults(),
            'tamu' => $this->tamuModel->orderBy('jam_datang', 'DESC')->findAll(10),
            'cssFile' => 'admin.css'
        ];

        return view('admin/dashboard', $data );
    }

    public function detail($id)
    {
        $tamu = $this->tamuModel->find($id);
        
        if (!$tamu) {
            return redirect()->back()->with('message', 'Data tamu tidak ditemukan')->with('message_type', 'danger');
        }

        $data = [
            'title' => 'Detail Tamu',
            'tamu' => $tamu,
            'cssFile' => 'admin.css'
        ];

        return view('admin/detail', $data);
    }

    public function delete($id)
    {
        if ($this->tamuModel->delete($id)) {
            return redirect()->to('/admin')->with('message', 'Data tamu berhasil dihapus')->with('message_type', 'success');
        } else {
            return redirect()->back()->with('message', 'Gagal menghapus data tamu')->with('message_type', 'danger');
        }
    }
}
