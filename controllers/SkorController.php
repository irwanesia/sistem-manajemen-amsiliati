<?php

// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Skor.php');
require('../models/Kelas.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])) {
    $thn = $_POST['tahun_ajaran_id'] ?? null;// Perbaikan penggunaan null
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d'); // Default ke hari ini jika tidak ada tanggal
    $skorAwalList = $_POST['skorAwal'];
    // var_dump($skorAwalList);
    // die();
    $skor = new Skor();

    foreach ($skorAwalList as $kelasJilidId => $skorAwal) {
        $kelasJilidId = intval($kelasJilidId);
        $skorAwal = !empty($skorAwal) ? intval($skorAwal) : null;
        $skorAkhir = !empty($_POST['skorAkhir'][$kelasJilidId]) ? intval($_POST['skorAkhir'][$kelasJilidId]) : null;
        $kategori = $_POST['kategori'][$kelasJilidId] ?? '';
        $keterangan = $_POST['keterangan'][$kelasJilidId] ?? '';

        $skor->save(null, $kelasJilidId, null, $tanggal, $skorAwal, $skorAkhir, $kategori, $keterangan);
    }

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menambah data skor";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../skor?tahun={$thn}&tanggal={$tanggal}&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    // ambil parameter url tahun dan jilid
    $thn = $_POST['tahun_ajaran_id'] ?? null;// Perbaikan penggunaan null
    $tanggal = $_POST['tanggal'] ?? date('Y-m-d'); // Default ke hari ini jika tidak ada tanggal
    $skorAwalList = $_POST['skorAwal'];
    // var_dump($skorAwalList);
    // die();
    $skor = new Skor();

    foreach ($skorAwalList as $kelasJilidId => $skorAwal) {
        $kelasJilidId = intval($kelasJilidId);
        $skorAkhir = $_POST['skorAkhir'][$kelasJilidId];
        $kategori = $_POST['kategori'][$kelasJilidId];
        $keterangan = $_POST['keterangan'][$kelasJilidId];
        

        // Cek apakah data skor sudah ada untuk kelas_jilid_id dan tanggal ini
        $existing = $skor->findBySkorJilidAndTanggal($kelasJilidId, $tanggal);

        if ($existing) {
            // Jika sudah ada, update
            $skor->updateSkor($existing['id_skor'], $skorAwal, $skorAkhir, $kategori, $keterangan);
        } else {
            // Jika belum ada, insert baru
            $skor->save(null, $kelasJilidId, null, $tanggal, $skorAwal, $skorAkhir, $kategori, $keterangan);
        }
    }
    
    // Simpan log aktivitas
    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah data skor";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../skor?tahun={$thn}&tanggal={$tanggal}&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id_skor'];
    $materi_id = $_POST['materi_id'];
    $tahun_ajaran = $_POST['tahun_ajaran'];

    // Simpan data menggunakan method save dari class skor
    $skor = new skor();
    $skor->delete($id);

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menghapus data skor";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../evaluasi-santri&action=skor?tahun={$tahun_ajaran}&materi={$materi_id}&message={$message}");
    exit;
}
