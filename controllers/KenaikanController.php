<?php

// Misalkan file index.php berada di src dan config.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Kenaikan.php');
require('../models/Log.php');

if (isset($_POST['submit'])) {
    // Ambil variabel umum
    $id_kelas_jilid = $_POST['id_kelas_jilid'];
    $dari_jilid     = $_POST['dari_jilid'];
    $tahun          = $_POST['tahun_ajaran_id'];
    $user_id        = $_POST['user_id'];
    $nama           = $_POST['nama'];

    // Ambil array kenaikan
    $ke_jilid_list  = $_POST['ke_jilid'] ?? [];
    $tgl_list       = $_POST['tgl_kenaikan'] ?? [];

    if (empty($ke_jilid_list) || empty($tgl_list)) {
        $message = urlencode("Tidak ada data kenaikan yang dipilih!");
        header("Location: ../kenaikan?tahun={$tahun}&jilid={$dari_jilid}&error={$message}");
        exit;
    }

    $kenaikan = new Kenaikan();
    $log      = new Log();

    $berhasil = 0;
    $gagal    = 0;
    
    foreach ($ke_jilid_list as $id_kelas_jilid => $ke_jilid) {
        $tgl_kenaikan = $tgl_list[$id_kelas_jilid] ?? null;

        // Validasi minimal
        if (empty($ke_jilid) || empty($tgl_kenaikan)) {
            $gagal++;
            continue;
        }

        // Simpan data
        $result = $kenaikan->save(null, $id_kelas_jilid, $dari_jilid, $ke_jilid, $tgl_kenaikan);
        
        if ($result) {
            $berhasil++;
            $aktivitas = $nama . " menaikkan santri ke jilid $ke_jilid";
            $log->save($user_id, $aktivitas, date('Y-m-d H:i:s'));
        } else {
            $gagal++;
        }
    }
    
    var_dump($gagal);
    die();

    if ($berhasil > 0) {
        $message = urlencode("$berhasil data berhasil disimpan, $gagal gagal.");
        header("Location: ../kenaikan?tahun={$tahun}&jilid={$dari_jilid}&success={$message}");
    } else {
        $message = urlencode("Semua data gagal disimpan!");
        header("Location: ../kenaikan?tahun={$tahun}&jilid={$dari_jilid}&error={$message}");
    }
    exit;
}

