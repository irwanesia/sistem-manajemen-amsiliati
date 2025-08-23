<?php

// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/TahunAjaran.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $tahun = $_POST['tahun'];
    $semester = $_POST['semester'];
    $is_aktif = $_POST['is_aktif'];
    
    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class tahunAjaran
    $tahunAjaran = new TahunAjaran();
    $tahunAjaran->save(null, $tahun, $semester, $is_aktif);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menambah data tahun ajaran {$tahun} Semester {$semester}";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);
    
    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../tahun-ajaran&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id_tahun'];
    $tahun = $_POST['tahun'];
    $semester = $_POST['semester'];
    $is_aktif = $_POST['is_aktif'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class tahunAjaran
    $tahunAjaran = new TahunAjaran();
    $tahunAjaran->save($id, $tahun, $semester, $is_aktif);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah data tahun ajaran {$tahun} Semester {$semester}";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../tahun-ajaran&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id_tahun'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class tahunAjaran
    $tahunAjaran = new TahunAjaran();
    $tahunAjaran->delete($id);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menghapus data tahun ajaran dengan ID {$id}";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../tahun-ajaran&message={$message}");
    exit;
}
