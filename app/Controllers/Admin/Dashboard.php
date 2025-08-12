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
            'tamu' => $this->tamuModel->orderBy('jam_datang', 'DESC')->findAll(10)
        ];

        return view('admin/dashboard', $data);
    }

    public function detail($id)
    {
        $tamu = $this->tamuModel->find($id);
        
        if (!$tamu) {
            return redirect()->back()->with('message', 'Data tamu tidak ditemukan')->with('message_type', 'danger');
        }

        $data = [
            'title' => 'Detail Tamu',
            'tamu' => $tamu
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

    public function print($id)
    {
        $tamu = $this->tamuModel->find($id);
        
        if (!$tamu) {
            return redirect()->back()->with('message', 'Data tamu tidak ditemukan')->with('message_type', 'danger');
        }

        $data = [
            'title' => 'Cetak Data Tamu',
            'tamu' => $tamu
        ];

        return view('admin/print', $data);
    }

    public function export()
    {
        $format = $this->request->getPost('format');
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');

        // Query data
        $builder = $this->tamuModel;
        
        if (!empty($startDate)) {
            $builder->where('DATE(created_at) >=', $startDate);
        }
        
        if (!empty($endDate)) {
            $builder->where('DATE(created_at) <=', $endDate);
        }

        $data = $builder->orderBy('jam_datang', 'DESC')->findAll();

        if ($format === 'excel') {
            return $this->exportExcel($data);
        } elseif ($format === 'pdf') {
            return $this->exportPDF($data);
        } elseif ($format === 'csv') {
            return $this->exportCSV($data);
        }

        return redirect()->back()->with('message', 'Format export tidak valid')->with('message_type', 'danger');
    }

    private function exportExcel($data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama');
        $sheet->setCellValue('C1', 'Asal Instansi');
        $sheet->setCellValue('D1', 'Alamat');
        $sheet->setCellValue('E1', 'No. Telp');
        $sheet->setCellValue('F1', 'Jenis Kelamin');
        $sheet->setCellValue('G1', 'Jam Datang');
        $sheet->setCellValue('H1', 'Keperluan');

        // Data
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A'.$row, $row-1);
            $sheet->setCellValue('B'.$row, $item['nama']);
            $sheet->setCellValue('C'.$row, $item['dari']);
            $sheet->setCellValue('D'.$row, $item['asal']);
            $sheet->setCellValue('E'.$row, $item['no_telp']);
            $sheet->setCellValue('F'.$row, $item['jenis_kelamin']);
            $sheet->setCellValue('G'.$row, date('d/m/Y H:i', strtotime($item['jam_datang'])));
            $sheet->setCellValue('H'.$row, $item['keperluan']);
            $row++;
        }

        // Auto size columns
        foreach(range('A','H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="data_tamu.xlsx"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
        exit;
    }

    private function exportPDF($data)
    {
        $html = view('admin/export_pdf', ['data' => $data]);
        
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        $dompdf->stream('data_tamu.pdf', ['Attachment' => true]);
        exit;
    }

    private function exportCSV($data)
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="data_tamu.csv"');
        
        $output = fopen('php://output', 'w');
        
        // Header
        fputcsv($output, [
            'No', 'Nama', 'Asal Instansi', 'Alamat', 
            'No. Telp', 'Jenis Kelamin', 'Jam Datang', 'Keperluan'
        ]);
        
        // Data
        $no = 1;
        foreach ($data as $item) {
            fputcsv($output, [
                $no++,
                $item['nama'],
                $item['dari'],
                $item['asal'],
                $item['no_telp'],
                $item['jenis_kelamin'],
                date('d/m/Y H:i', strtotime($item['jam_datang'])),
                $item['keperluan']
            ]);
        }
        
        fclose($output);
        exit;
    }
}