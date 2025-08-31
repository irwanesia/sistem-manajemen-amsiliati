<?php

// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Santri.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama_santri'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $jk = $_POST['jk'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];

    // --- Cek apakah NIS sudah ada ---
    $santri = new Santri();
    $exists = $santri->findByNis($nis);

    if ($exists > 0) {
        // Jika NIS sudah ada, kirim pesan error
        $message = urlencode("NIS $nis sudah terdaftar, gunakan NIS lain!");
        header("Location: ../santri&error={$message}");
        exit;
    }

    // Jika tidak duplicate, lanjut simpan
    $santri->save(null, $nis, $nama, $tempat_lahir, $tgl_lahir, $jk, $alamat, $status);

    // Log aktivitas
    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menambah data santri";
    $tanggal = date('Y-m-d H:i:s');
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("✅ Data berhasil disimpan!");
    header("Location: ../santri&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    $id = $_POST['id_santri'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama_santri'];
    $jk = $_POST['jk'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tgl_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];

    // Simpan data menggunakan method save dari class santri
    $santri = new santri();
    $santri->save($id, $nis, $nama, $tempat_lahir, $tgl_lahir, $jk, $alamat, $status);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah data santri";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../santri&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id_santri'];

    // Simpan data menggunakan method save dari class santri
    $santri = new Santri();
    $santri->delete($id);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menghapus data santri";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../santri&message={$message}");
    exit;
}
