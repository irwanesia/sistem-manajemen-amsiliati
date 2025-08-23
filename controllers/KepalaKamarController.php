<?php

// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/KepalaKamar.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $id_kamar = $_POST['id_kamar'];
    $nama_kepala = $_POST['nama_kepala'];
    $no_hp = $_POST['no_hp'];
    $tgl_diangkat = $_POST['tanggal_diangkat'];
    
    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class kamar
    $kepkamar = new KepalaKamar();
    $kepkamar->save(null, $id_kamar, $nama_kepala, $no_hp, $tgl_diangkat);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menambah data kepala kamar";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);
    
    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../kepala-kmr&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id_kepala_kamar'];
    $id_kamar = $_POST['id_kamar'];
    $nama_kepala = $_POST['nama_kepala'];
    $no_hp = $_POST['no_hp'];
    $tgl_diangkat = $_POST['tanggal_diangkat'];

    // Simpan data menggunakan method save dari class kamar
    $kepkamar = new KepalaKamar();
    $kepkamar->save($id, $id_kamar, $nama_kepala, $no_hp, $tgl_diangkat);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah data kepala kamar";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../kepala-kmr&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id_kepala_kamar'];

    // Simpan data menggunakan method save dari class kamar
    $kepkamar = new KepalaKamar();
    $kepkamar->delete($id);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menghapus data kepala kamar";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../kepala-kmr&message={$message}");
    exit;
}
