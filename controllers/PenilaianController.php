<?php

// Misalkan file index.php berada di src dan database.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Penilaian.php');
require('../models/HasilPenilaian.php');
require('../models/kriteria.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['input'])) {
    // Ambil data dari form
    $id_alternatif = $_POST['id_alternatif'] ?? null;
    $id_kriteria = $_POST['id_kriteria'] ?? null;
    $id_sub_kriteria = $_POST['id_sub_kriteria'] ?? null;
    $nilai = $_POST['nilai'] ?? null;

    // var_dump($nilai)
    $penilaian = new penilaian();
    $kriteria = new Kriteria();


    $index_sub = 0;   // Indeks untuk sub kriteria (pilihan select)
    $index_nilai = 0; // Indeks untuk nilai langsung (input angka)

    foreach ($id_kriteria as $key) {
        $data = $kriteria->findById($key);

        if ($data) { // Pastikan data ditemukan
            if ($data['tipe_penilaian'] == 1) {
                // Jika menggunakan pilihan sub-kriteria
                $penilaian->save($id_alternatif, $key, $id_sub_kriteria[$index_sub] ?? null, null);
                $index_sub++; // Hanya naik jika pakai sub-kriteria
            } else {
                // Jika menggunakan input langsung
                $penilaian->save($id_alternatif, $key, null, $nilai[$index_nilai] ?? null);
                $index_nilai++; // Hanya naik jika pakai nilai langsung
            }
        } else {
            echo "Kriteria dengan ID $key tidak ditemukan.";
        }
    }

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " melakukan penilaian alternatif";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../penilaian&message={$message}");
    exit;
}

if (isset($_POST['update'])) {
    // Ambil data dari form
    $id_alternatif = $_POST['id_alternatif'] ?? null;
    $id_kriteria = $_POST['id_kriteria'] ?? null;
    $id_sub_kriteria = $_POST['id_sub_kriteria'] ?? null;
    $nilai = $_POST['nilai'] ?? null;

    $penilaian = new penilaian();
    $kriteria = new Kriteria();


    $index_sub = 0;   // Indeks untuk sub kriteria (pilihan select)
    $index_nilai = 0; // Indeks untuk nilai langsung (input angka)

    foreach ($id_kriteria as $key) {
        $data = $kriteria->findById($key);

        if ($data) { // Pastikan data ditemukan
            if ($data['tipe_penilaian'] == 1) {
                // Jika menggunakan pilihan sub-kriteria
                $penilaian->save($id_alternatif, $key, $id_sub_kriteria[$index_sub] ?? null, null);
                $index_sub++; // Hanya naik jika pakai sub-kriteria
            } else {
                // Jika menggunakan input langsung
                $penilaian->save($id_alternatif, $key, null, $nilai[$index_nilai] ?? null);
                $index_nilai++; // Hanya naik jika pakai nilai langsung
            }
        } else {
            echo "Kriteria dengan ID $key tidak ditemukan.";
        }
    }

    $log = new Log();
    $user_id = $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " mengubah penilaian alternatif";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan sukses
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../penilaian&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class kriteria
    $penilaian = new penilaian();
    $penilaian->deleteByIdAlternatif($id);

    $log = new Log();
    $user_id =  $_POST['user_id'];
    $aktivitas = $_POST['nama'] . " menghapus data penilaian";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../penilaian&message={$message}");
    exit;
}
