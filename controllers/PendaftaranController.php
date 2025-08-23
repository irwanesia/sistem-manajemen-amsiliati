<?php

// Misalkan file index.php berada di src dan database.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Pendaftar.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $nama = $_POST['nama_lengkap'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tanggal_lahir'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $tgl_daftar = $_POST['tanggal_daftar'];

    // Simpan data menggunakan method save dari class pendaftar
    $pendaftar = new Pendaftar();
    $pendaftar->save(null, $nama, $tempat_lahir, $tgl_lahir, $jk, $alamat, $no_hp, $tgl_daftar);

    $log = new Log();
    $user_id =  $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menambah data pendaftar";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../pendaftaran&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id_pendaftar'];
    $nama = $_POST['nama_lengkap'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tanggal_lahir'];
    $jk = $_POST['jk'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $tgl_daftar = $_POST['tanggal_daftar'];

    // Simpan data menggunakan method save dari class pendaftar
    $pendaftar = new Pendaftar();
    $pendaftar->save($id, $nama, $tempat_lahir, $tgl_lahir, $jk, $alamat, $no_hp, $tgl_daftar);

    $log = new Log();
    $user_id =  $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah data pendaftar";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../pendaftaran&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id_pendaftar'];

    // Simpan data menggunakan method save dari class pendaftar
    $pendaftar = new Pendaftar();
    $pendaftar->delete($id);

    $log = new Log();
    $user_id =  $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menghapus data pendaftar";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../pendaftaran&message={$message}");
    exit;
}
