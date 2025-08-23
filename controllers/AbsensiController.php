<?php

// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Absensi.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $thn = $_POST['tahun_ajaran_id'] ?? null;// Perbaikan penggunaan null
    $jilid = $_POST['jilid_id'] ?? null;// Perbaikan penggunaan null
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d'); // Default ke hari ini jika tidak ada tanggal
    $statusList = $_POST['status'] ?? [];
    // var_dump($keterangan);
    // die();
    $absensi = new Absensi();
    
    foreach ($statusList as $kelasJilidId => $status) {
        $kelasJilidId = intval($kelasJilidId);
        $status = htmlspecialchars($status);
        $keterangan = $_POST['keterangan'][$kelasJilidId];
        // Simpan data absensi
        $absensi->save(null, $kelasJilidId, $tanggal, $status, $keterangan);
    }

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menambah data absensi";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../absensi?tahun={$thn}&tanggal={$tanggal}&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    // ambil parameter url tahun dan jilid
    $thn = $_POST['tahun_ajaran_id'] ?? null;// Perbaikan penggunaan null
    $jilid = $_POST['jilid_id'] ?? null;// Perbaikan penggunaan null

    $statusList = $_POST['status'] ?? [];
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d'); // Default ke hari ini jika tidak ada tanggal
    
    $absensi = new Absensi();

    foreach ($statusList as $kelasJilidId => $status) {
        $kelasJilidId = intval($kelasJilidId);
        $status = htmlspecialchars($status);
        $keterangan = $_POST['keterangan'][$kelasJilidId];

        // Cek apakah data absensi sudah ada untuk kelas_jilid_id dan tanggal ini
        $existing = $absensi->findByKelasJilidAndTanggal($kelasJilidId, $tanggal);

        if ($existing) {
            // Jika sudah ada, update
            $absensi->updateStatus($existing['id_absensi'], $status, $keterangan);
        } else {
            // Jika belum ada, insert baru
            $absensi->save(null, $kelasJilidId, $tanggal, $status, $keterangan);
        }
    }

    // Logging
    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah data absensi";
    $tanggalLog = date('Y-m-d H:i:s');
    $log->save($user_id, $aktivitas, $tanggalLog);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data absensi berhasil diperbarui!");
    header("Location: ../absensi?tahun={$thn}&tanggal={$tanggal}&message={$message}");
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
