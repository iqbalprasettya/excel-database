<?php

namespace App\Controllers;

use App\Models\DataExcelModel;
use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class FileController extends Controller
{
    public function index()
    {
        $dataModel = new DataExcelModel();
        $data['allData'] = $dataModel->findAll();

        return view('upload_files', $data);
    }
    public function export()
    {
        return view('export_files');
    }


    public function upload()
    {
        $file = $this->request->getFile('file');

        // Validasi file
        $allowedMimeTypes = [
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xlsx
            'application/vnd.ms-excel', // .xls
        ];

        $maxFileSize = 5 * 1024 * 1024; // 5MB

        if (!$file->isValid()) {
            return redirect()->to('/')->with('error', 'File is not valid');
        }

        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            return redirect()->to('/')->with('error', 'Invalid file type. Only .xlsx and .xls files are allowed.');
        }

        if ($file->getSize() > $maxFileSize) {
            return redirect()->to('/')->with('error', 'File size exceeds the maximum limit of 5MB.');
        }

        if ($file->isValid() && !$file->hasMoved()) {
            $filePath = $file->getTempName();
            $reader = new Xlsx();
            $spreadsheet = $reader->load($filePath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $dataModel = new DataExcelModel();
            $duplicateIds = [];

            // Skip the first row (header)
            foreach (array_slice($sheetData, 1) as $row) {
                $data = [
                    'NO_BUKTI_POTONG' => $row[0],
                    'NAMA_PENERIMA_PENGHASILAN' => $row[1],
                    'ID_SISTEM' => $row[2],
                    'NIK' => $row[3],
                    'TAHUN' => $row[4],
                    'BULAN' => $row[5],
                ];

                $existingData = $dataModel->find($data['NO_BUKTI_POTONG']);

                if ($existingData) {
                    // Collect duplicate ID
                    $duplicateIds[] = $data['NO_BUKTI_POTONG'];
                } else {
                    $dataModel->insert($data);
                }
            }

            if (!empty($duplicateIds)) {
                $message = 'Data could not be processed due to duplicate IDs: <b>' . implode(', ', $duplicateIds) . '</b>';
                return redirect()->to('/')->with('error', $message);
            }

            return redirect()->to('/')->with('message', 'Data has been uploaded successfully');
        }

        return redirect()->to('/')->with('error', 'Failed to upload data');
    }

    public function prosesSemuaData()
    {
        $dataModel = new DataExcelModel();
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $allData = $dataModel->where('Bulan', $bulan)->where('Tahun', $tahun)->findAll();

        // 
        if (empty($allData)) {
            return redirect()->back()->with('error', "No data found for the selected month and year.");
        }

        $sourcePath = realpath(ROOTPATH . '../file-pdf/') . DIRECTORY_SEPARATOR;
        $destinationBasePath = realpath(ROOTPATH . 'upload/') . DIRECTORY_SEPARATOR;
        $messages = [];

        foreach ($allData as $data) {
            $idSistem = $data['ID_SISTEM'];
            $nik = $data['NIK'];
            $destinationPath = $destinationBasePath . $nik . DIRECTORY_SEPARATOR;

            if (!is_dir($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $allFiles = scandir($sourcePath);
            // dd($allFiles);
            $matchedFiles = [];
            foreach ($allFiles as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
                    $fileParts = explode('_', pathinfo($file, PATHINFO_FILENAME));
                    if (count($fileParts) > 1 && $fileParts[1] === $idSistem) {
                        $matchedFiles[] = $file;
                    }
                }
            }

            if (!empty($matchedFiles)) {
                foreach ($matchedFiles as $fileName) {
                    $filePath = $sourcePath . $fileName;
                    if (copy($filePath, $destinationPath . $fileName)) {
                        $messages[] = "File <b>$fileName</b> successfully copied to <b>$nik</b> folder";
                    } else {
                        $messages[] = "Failed to move file <b>$fileName</b>";
                    }
                }
            } else {
                $messages[] = "No matching files found for ID SISTEM: <b>$idSistem</b>";
            }
        }

        return redirect()->to('/export')->with('message', implode('<br>', $messages));
    }
}
