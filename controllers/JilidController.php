<?php

// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Jilid.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $nama_jilid = $_POST['nama_jilid'];
    $deskripsi = $_POST['deskripsi'];
    
    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class jilid
    $jilid = new jilid();
    $jilid->save(null, $nama_jilid, $deskripsi);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menambah data jilid";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);
    
    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../jilid&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id_jilid'];
    $nama_jilid = $_POST['nama_jilid'];
    $deskripsi = $_POST['deskripsi'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class jilid
    $jilid = new jilid();
    $jilid->save($id, $nama_jilid, $deskripsi);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah data jilid";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../jilid&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id_jilid'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class jilid
    $jilid = new jilid();
    $jilid->delete($id);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menghapus data jilid";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../jilid&message={$message}");
    exit;
}
