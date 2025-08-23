<?php

require_once __DIR__ . '/../config/database.php';

class EvaluasiSantri
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM evaluasi_santri";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM evaluasi_santri WHERE id_evaluasi = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM evaluasi_santri WHERE id_evaluasi = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $id_santri, $periode, $hasil, $evaluasi_oleh, $tanggal)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE evaluasi_santri SET id_santri = ?, periode = ?, hasil_evaluasi = ?, evaluasi_oleh = ?, tanggal = ? WHERE id_evaluasi = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_santri, $periode, $hasil, $evaluasi_oleh, $tanggal, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO evaluasi_santri (id_santri, periode, hasil_evaluasi, evaluasi_oleh, tanggal) VALUES (?, ?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_santri, $periode, $hasil, $evaluasi_oleh, $tanggal]);
        }
    }

}
