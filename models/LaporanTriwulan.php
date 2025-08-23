<?php

require_once __DIR__ . '/../config/database.php';

class LaporanTriwulan
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM laporan_triwulan";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM laporan_triwulan WHERE id_laporan = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }


    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM laporan_triwulan WHERE id_laporan = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $id_santri, $sms_id, $isi_laporan, $tgl_buat)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE laporan_triwulan SET id_santri = ?, semester_id = ?, isi_laporan = ?, tanggal_buat = ? WHERE id_laporan = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_santri, $sms_id, $isi_laporan, $tgl_buat, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO laporan_triwulan (id_santri, semester_id, isi_laporan, tanggal_buat) VALUES (?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_santri, $sms_id, $isi_laporan, $tgl_buat]);
        }
    }
}
