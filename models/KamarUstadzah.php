<?php

require_once __DIR__ . '/../config/database.php';

class KamarUstadzah
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM kamar_ustadzah";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM kamar_ustadzah WHERE id_kamar_ustadzah = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function findByIdUstadzah($id)
    {
        global $pdo;
        $query = "SELECT id_kamar_ustadzah FROM kamar_ustadzah WHERE id_ustadzah = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }


    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM kamar_ustadzah WHERE id_kamar_ustadzah = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $id_ustadzah, $id_kamar, $tgl_masuk, $tgl_keluar = null)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE kamar_ustadzah SET id_kamar = ?, tanggal_masuk = ?, tanggal_keluar = ? WHERE id_ustadzah = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_kamar, $tgl_masuk, $tgl_keluar, $id_ustadzah]);
        } else {
            // Insert new data
            $query = "INSERT INTO kamar_ustadzah (id_ustadzah, id_kamar, tanggal_masuk, tanggal_keluar) VALUES (?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_ustadzah, $id_kamar, $tgl_masuk, $tgl_keluar]);
        }
    }

}
