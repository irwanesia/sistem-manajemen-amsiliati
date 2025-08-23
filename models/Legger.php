<?php

require_once __DIR__ . '/../config/database.php';

class Legger
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM legger";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM legger WHERE id_legger = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }


    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM legger WHERE id_legger = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $id_santri, $id_tahun, $hasil_akhir, $nilai_total)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE legger SET id_santri = ?, id_tahun = ?, hasil_akhir = ?, nilai_total = ? WHERE id_legger = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_santri, $id_tahun, $hasil_akhir, $nilai_total, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO legger (id_santri, id_tahun, hasil_akhir, nilai_total) VALUES (?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_santri, $id_tahun, $hasil_akhir, $nilai_total]);
        }
    }
}
