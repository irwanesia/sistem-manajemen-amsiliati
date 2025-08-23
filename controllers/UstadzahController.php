<?php

// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Ustadzah.php');
require('../models/KamarUstadzah.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $nama = $_POST['nama_ustadzah'];
    $id_kamar = $_POST['id_kamar'];
    $jabatan = $_POST['jabatan'];
    $tanggal_masuk = date('Y-m-d');

    // Simpan data menggunakan method save dari class ustadzah
    $ustadzah = new Ustadzah();
    $ustadzah->save(null, $nama, $jabatan, "-");

    // last id insert
    $last_insert_id = $pdo->lastInsertId();

    $kamar_ust = New KamarUstadzah();
    $kamar_ust->save(null, $last_insert_id, $id_kamar, $tanggal_masuk, "-");

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menambah data ustadzah";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../ustadzah&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id_ustadzah'];
    $nama = $_POST['nama_ustadzah'];
    $id_kamar = $_POST['id_kamar'];
    $jabatan = $_POST['jabatan'];
    $tanggal_masuk = date('Y-m-d');

    // ambil id_kamar_ustadzah berdasarkan id_ustadzah
    $kmr_ust = New KamarUstadzah();
    $kmr_ust->findByIdUstadzah($id);
    $id_kamar_ustadzah = $kmr_ust['id_kamar_ustadzah'];
    var_dump($kmr_ust['id_kamar_ustadzah']);
    die();
    // Simpan data menggunakan method save dari class ustadzah
    $ustadzah = new Ustadzah();
    $ustadzah->save($id, $nama, $jabatan, "-");

    $kamar_ust->save($id, $id_kamar_ustadzah, $id_kamar, $tanggal_masuk, "-");

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah data ustadzah";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../ustadzah&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id_ustadzah'];

    // Simpan data menggunakan method save dari class ustadzah
    $ustadzah = new Ustadzah();
    $ustadzah->delete($id);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menghapus data ustadzah";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../ustadzah&message={$message}");
    exit;
}
