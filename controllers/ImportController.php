<?php
// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
// include 'vendor/autoload.php';
include '../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

if ($_FILES['import_excel']['name'] != '') {
    $allowed_extension = array('xls', 'csv', 'xlsx');
    $file_array = explode(".", $_FILES['import_excel']['name']);
    $file_extension = end($file_array);

    if (in_array($file_extension, $allowed_extension)) {
        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($_FILES['import_excel']['tmp_name']);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
        $spreadsheet = $reader->load($_FILES['import_excel']['tmp_name']);
        $data = $spreadsheet->getActiveSheet()->toArray();

        foreach ($data as $row) {
            $insert_data = array(
                ':first_name'   => $row[0],
                ':last_name'    => $row[1],
                ':created_at'   => $row[2],
                ':updated_at'   => $row[3],
            );
            $query = "INSERT INTO sample_datas (first_name, last_name, created_at, updated_at) VALUES (:first_name, :last_name, :created_at, :updated_at)";

            $statement = $pdo->prepare($query);
            $statement->execute($insert_data);
        }
        $message = urlencode("Data imported successfully!");
        header("Location: ../excel&message={$message}");
        exit;
    } else {
        $message = urlencode("Invalid file format. Only .xls, .csv, .xlsx files are allowed.");
        header("Location: ../excel&message={$message}");
        exit;
    }
} else {
    $message = urlencode("Please select file.");
    header("Location: ../excel&message={$message}");
    exit;
}
