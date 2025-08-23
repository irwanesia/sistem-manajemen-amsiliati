<?php

// Pastikan tidak ada output sebelum ini
if (headers_sent()) {
    die('Headers already sent');
}
// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

include 'vendor/autoload.php';
require_once "config/database.php";
require_once "helpers/functions_helper.php";

// Fungsi konversi tanggal Excel ke format database
function convertExcelDateToDbFormat($excelDate) {
    if (empty($excelDate)) {
        return null;
    }
    
    // Jika sudah format YYYY-MM-DD
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $excelDate)) {
        return $excelDate;
    }
    
    // Coba format DD/MM/YYYY
    $date = DateTime::createFromFormat('d/m/Y', $excelDate);
    if ($date) {
        return $date->format('Y-m-d');
    }
    
    // Coba format lain jika diperlukan
    $date = DateTime::createFromFormat('m/d/Y', $excelDate);
    if ($date) {
        return $date->format('Y-m-d');
    }
    
    // Coba parsing format apapun
    try {
        $date = new DateTime($excelDate);
        return $date->format('Y-m-d');
    } catch (Exception $e) {
        return null;
    }
}

$response = ['status' => 'error', 'message' => ''];

try {
    // Validasi file upload
    if (!isset($_FILES['import_excel']) || $_FILES['import_excel']['error'] != UPLOAD_ERR_OK) {
        throw new Exception('File upload error');
    }

    if ($_FILES['import_excel']['name'] != '') {
        $allowed_extension = array('xls', 'csv', 'xlsx');
        $file_array = explode(".", $_FILES['import_excel']['name']);
        $file_extension = strtolower(end($file_array));

        if (!in_array($file_extension, $allowed_extension)) {
            throw new Exception('Invalid file type. Only Excel files are allowed');
        }

        if (!is_uploaded_file($_FILES['import_excel']['tmp_name'])) {
            throw new Exception('File not uploaded properly');
        }

        // Baca file Excel
        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($_FILES['import_excel']['tmp_name']);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
        $spreadsheet = $reader->load($_FILES['import_excel']['tmp_name']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        if (count($sheetData) < 2) {
            throw new Exception('No data found in Excel file. Please check the file content');
        }

        // Mulai transaksi
        $pdo->beginTransaction();

        // Prepare statements
        $checkSantri = $pdo->prepare("SELECT id_santri FROM santri WHERE nis = ?");
        $insertSantri = $pdo->prepare("
            INSERT INTO santri (nis, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, kamar_id, status_aktif) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $updateSantri = $pdo->prepare("
            UPDATE santri 
            SET nama = ?, tempat_lahir = ?, tanggal_lahir = ?, jenis_kelamin = ?, alamat = ?, kamar_id = ?, status_aktif = ?
            WHERE nis = ?
        ");

        $successCount = 0;
        $skipCount = 0;
        $updateCount = 0;
        $errorLog = [];

        for ($i = 1; $i < count($sheetData); $i++) {
            if (empty($sheetData[$i][0])) {
                $skipCount++;
                continue;
            }

            $nis = trim($sheetData[$i][0]);
            $nama = trim($sheetData[$i][1]);
            $tempat_lahir = trim($sheetData[$i][2] ?? '');
            $tgl_lahir = trim($sheetData[$i][3] ?? '');
            $jenis_kelamin = strtoupper(trim($sheetData[$i][4] ?? 'L'));
            $alamat = trim($sheetData[$i][5] ?? '');
            $kamar_id = !empty(trim($sheetData[$i][6] ?? '')) ? intval(trim($sheetData[$i][6])) : null;
            $status_aktif = strtoupper(trim($sheetData[$i][7] ?? 'AKTIF'));

            // Validasi data wajib
            if (empty($nis) || empty($nama)) {
                $errorLog[] = "Baris $i: NIS atau Nama kosong";
                $skipCount++;
                continue;
            }

            // Konversi tanggal lahir
            $tanggal_lahir = convertExcelDateToDbFormat($tgl_lahir);
            if (empty($tanggal_lahir) && !empty($tgl_lahir)) {
                $errorLog[] = "Baris $i: Format tanggal tidak valid - '{$tgl_lahir}'";
            }

            // Validasi jenis kelamin
            if (!in_array($jenis_kelamin, ['P', 'L'])) {
                $jenis_kelamin = 'L';
                $errorLog[] = "Baris $i: Jenis kelamin tidak valid, diubah ke 'L'";
            }

            // Validasi status aktif
            $status = (strpos($status_aktif, 'AKTIF') !== false || $status_aktif === '1') ? 1 : 0;

            // Cek apakah santri sudah ada
            $checkSantri->execute([$nis]);
            $existingSantri = $checkSantri->fetchColumn();

            try {
                if ($existingSantri) {
                    $updateSantri->execute([
                        $nama,
                        $tempat_lahir,
                        $tanggal_lahir,
                        $jenis_kelamin,
                        $alamat,
                        $kamar_id,
                        $status,
                        $nis
                    ]);
                    $updateCount++;
                } else {
                    $insertSantri->execute([
                        $nis,
                        $nama,
                        $tempat_lahir,
                        $tanggal_lahir,
                        $jenis_kelamin,
                        $alamat,
                        $kamar_id,
                        $status
                    ]);
                    $successCount++;
                }
            } catch (PDOException $e) {
                $errorLog[] = "Baris $i: Gagal menyimpan - " . $e->getMessage();
                $skipCount++;
            }
        }

        $pdo->commit();
        
        $response['status'] = 'success';
        $response['message'] = sprintf(
            'Import selesai: %d data baru, %d data diupdate, %d data dilewati',
            $successCount,
            $updateCount,
            $skipCount
        );
        $response['details'] = [
            'added' => $successCount,
            'updated' => $updateCount,
            'skipped' => $skipCount
        ];
        
        if (!empty($errorLog)) {
            $response['warnings'] = $errorLog;
        }
    }
} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $response['message'] = 'Error: ' . $e->getMessage();
}

// Pastikan hanya output JSON
header('Content-Type: application/json');
echo json_encode($response);
exit;