<?php

// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Kamar.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $id_asrama = $_POST['id_asrama'];
    $nama_kamar = $_POST['nama_kamar'];
    $keterangan = $_POST['keterangan'];
    
    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class kamar
    $kamar = new Kamar();
    $kamar->save(null, $id_asrama, $nama_kamar, $keterangan);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menambah data kamar";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);
    
    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../kamar&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id_kamar'];
    $id_asrama = $_POST['id_asrama'];
    $nama_kamar = $_POST['nama_kamar'];
    $keterangan = $_POST['keterangan'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class kamar
    $kamar = new Kamar();
    $kamar->save($id, $id_asrama, $nama_kamar, $keterangan);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah data kamar";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../kamar&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class kamar
    $kamar = new Kamar();
    $kamar->delete($id);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menghapus data kamar";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../kamar&message={$message}");
    exit;
}
