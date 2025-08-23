<?php

// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/KamarSantri.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $id_santri = $_POST['id_santri'];
    $id_kamar = $_POST['id_kamar'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $tanggal_keluar = $_POST['tanggal_keluar'];

    // Simpan data menggunakan method save dari class kamar
    $kamar_santri = new KamarSantri();
    $kamar_santri->save(null, $id_santri, $id_kamar, $tanggal_masuk, $tanggal_keluar);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menambah data kamar santri";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);
    
    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../kamar-santri&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id_kamar_santri'];
    $id_santri = $_POST['id_santri'];
    $id_kamar = $_POST['id_kamar'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $tanggal_keluar = $_POST['tanggal_keluar'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class kamar
    $kamar_santri = new KamarSantri();
    $kamar_santri->save($id, $id_santri, $id_kamar, $tanggal_masuk, $tanggal_keluar);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah data kamar santri";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../kamar-santri&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id_kamar_santri'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class kamar
    $kamar_santri = new KamarSantri();
    $kamar_santri->delete($id);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menghapus data kamar santri";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../kamar-santri&message={$message}");
    exit;
}
