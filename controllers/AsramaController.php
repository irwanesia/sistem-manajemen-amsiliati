<?php

// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Asrama.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $nama_asrama = $_POST['nama_asrama'];
    $keterangan = $_POST['keterangan'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class asrama
    $asrama = new Asrama();
    $asrama->save(null, $nama_asrama, $keterangan);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menambah data asrama";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../asrama&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id_asrama'];
    $nama_asrama = $_POST['nama_asrama'];
    $keterangan = $_POST['keterangan'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class asrama
    $asrama = new Asrama();
    $asrama->save($id, $nama_asrama, $keterangan);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah data asrama";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../asrama&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class asrama
    $asrama = new Asrama();
    $asrama->delete($id);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menghapus data asrama";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../asrama&message={$message}");
    exit;
}
