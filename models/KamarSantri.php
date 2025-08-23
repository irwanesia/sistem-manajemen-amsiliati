<?php

require_once __DIR__ . '/../config/database.php';

class KamarSantri
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM kamar_santri";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findAllWithJoin()
    {
        global $pdo;
        $query = "SELECT 
                    ks.*,
                    s.nama AS nama_santri,
                    k.nama_kamar,
                    k.id_kamar,
                    a.nama_asrama,
                    a.id_asrama
                FROM kamar_santri ks
                JOIN santri s ON ks.id_santri=s.id_santri
                JOIN kamar k ON ks.id_kamar=k.id_kamar
                JOIN asrama a ON k.id_asrama=a.id_asrama
                ";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM kamar_santri WHERE id_kamar_santri = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM kamar_santri WHERE id_kamar_santri = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $id_santri, $id_kamar, $tgl_masuk, $tgl_keluar = null)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE kamar_santri SET id_santri = ?, id_kamar = ?, tanggal_masuk = ?, tanggal_keluar = ? WHERE id_kamar_santri = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_santri, $id_kamar, $tgl_masuk, $tgl_keluar, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO kamar_santri (id_santri, id_kamar, tanggal_masuk, tanggal_keluar) VALUES (?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_santri, $id_kamar, $tgl_masuk, $tgl_keluar]);
        }
    }

}
