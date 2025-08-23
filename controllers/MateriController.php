<?php

// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Materi.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $id_jilid = $_POST['id_jilid'];
    $nama_materi = $_POST['nama_materi'];
    $deskripsi = $_POST['deskripsi'];
    $urutan = $_POST['urutan'];
    $status = $_POST['aktif'];
    
    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class materi
    $materi = new materi();
    $materi->save(null, $id_jilid, $nama_materi, $deskripsi, $urutan, $status);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menambah data materi";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);
    
    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../materi&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id_materi'];
    $id_jilid = $_POST['id_jilid'];
    $nama_materi = $_POST['nama_materi'];
    $deskripsi = $_POST['deskripsi'];
    $urutan = $_POST['urutan'];
    $status = $_POST['aktif'];

    // Simpan data menggunakan method save dari class materi
    $materi = new materi();
    $materi->save($id, $id_jilid, $nama_materi, $deskripsi, $urutan, $status);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah data materi";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../materi&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id_materi'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class materi
    $materi = new Materi();
    $materi->delete($id);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menghapus data materi";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../materi&message={$message}");
    exit;
}
