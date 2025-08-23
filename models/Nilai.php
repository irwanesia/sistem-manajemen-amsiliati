<?php

require_once __DIR__ . '/../config/database.php';

class Nilai
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM nilai";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM nilai WHERE id_nilai = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM nilai WHERE id_nilai = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $kelas_jilid_id, $nilai_angka, $predikat, $status_lulus, $catatan, $tanggal_penilaian)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE nilai SET kelas_jilid_id = ?, nilai_angka = ?, predikat = ?, status_lulus = ?, catatan = ?, tanggal_penilaian  = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$kelas_jilid_id, $nilai_angka, $predikat, $status_lulus, $catatan, $tanggal_penilaian, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO nilai (kelas_jilid_id, nilai_angka, predikat, status_lulus, catatan, tanggal_penilaian) VALUES (?, ?, ?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$kelas_jilid_id, $nilai_angka, $predikat, $status_lulus, $catatan, $tanggal_penilaian]);
        }
    }

}
