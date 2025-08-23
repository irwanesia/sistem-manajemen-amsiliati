<?php

// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Kelas.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $id_santri = $_POST['id_santri'];
    $id_jilid = $_POST['id_jilid'];
    $id_tahun = $_POST['id_tahun'];
    $tgl_mulai = date('Y-m-d');

    // Simpan data menggunakan method save dari class kelas
    $kelas = new Kelas();
    $kelas->save(null, $id_santri, $id_jilid, $id_tahun, $tgl_mulai);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menambah data kelas jilid";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);
    
    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../kelas&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id_kelas_jilid'];
    $id_santri = $_POST['id_santri'];
    $id_jilid = $_POST['id_jilid'];
    $id_tahun = $_POST['id_tahun'];
    $tgl_mulai = date('Y-m-d');

    // Simpan data menggunakan method save dari class kelas
    $kelas = new Kelas();
    $kelas->save($id, $id_santri, $id_jilid, $id_tahun, $tgl_mulai);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah data kelas jilid";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../kelas&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id_kelas_jilid'];

    // Simpan data menggunakan method save dari class kelas
    $kelas = new Kelas();
    $kelas->delete($id);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menghapus data kelas jilid";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../kelas&message={$message}");
    exit;
}
