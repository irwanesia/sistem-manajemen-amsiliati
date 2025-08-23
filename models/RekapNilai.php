<?php

require_once __DIR__ . '/../config/database.php';

class RekapNilai
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM rekap_nilai";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM rekap_nilai WHERE id_rekap = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM rekap_nilai WHERE id_rekap = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $id_santri, $id_tahun, $total_nilai, $rata_rata)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE rekap_nilai SET id_santri = ?, id_tahun = ?, total_nilai = ?, rata_rata = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_santri, $id_tahun, $total_nilai, $rata_rata, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO rekap_nilai (id_santri, id_tahun, total_nilai, rata_rata)) VALUES (?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_santri, $id_tahun, $total_nilai, $rata_rata]);
        }
    }

}
