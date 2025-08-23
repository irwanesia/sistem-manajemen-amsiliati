<?php

// Misalkan file index.php berada di src dan database.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Subkriteria.php');
require('../models/kriteria.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $id_kriteria = $_POST['id_kriteria'];
    $nama = $_POST['subkriteria'];
    $nilai = $_POST['nilai'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class subkriteria
    $subkriteria = new subkriteria();
    $kriteria = new kriteria();
    $data = $kriteria->findById($id_kriteria);
    $subkriteria->save(null, $id_kriteria, $nama, $nilai);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas =  $_POST['nama'] . " menambah sub kriteria";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data {$data['nama_kriteria']} berhasil disimpan!");
    header("Location: ../sub-kriteria&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $id_kriteria = $_POST['id_kriteria'];
    $nama = $_POST['subkriteria'];
    $nilai = $_POST['nilai'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class subkriteria
    $subkriteria = new subkriteria();
    $kriteria = new kriteria();
    $data = $kriteria->findById($id_kriteria);
    $subkriteria->save($id, $id_kriteria, $nama, $nilai);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas =  $_POST['nama'] . " mengubah sub kriteria";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data {$data['nama_kriteria']} berhasil diupdate!");
    header("Location: ../sub-kriteria&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class subkriteria
    $subkriteria = new subkriteria();
    $subkriteria->delete($id);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas =  $_POST['nama'] . " menghapus sub kriteria";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../sub-kriteria&message={$message}");
    exit;
}
