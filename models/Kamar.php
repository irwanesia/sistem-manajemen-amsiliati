<?php

require_once __DIR__ . '/../config/database.php';

class Kamar
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT k.*, a.nama_asrama FROM kamar k JOIN asrama a ON k.id_asrama = a.id_asrama";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findByIdAsrama($id)
    {
        global $pdo;
        $query = "SELECT id_kamar, nama_kamar FROM kamar WHERE id_asrama = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM kamar WHERE id_kamar = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM kamar WHERE id_kamar = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $id_asrama, $nama_kamar, $ket = null)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE kamar SET id_asrama = ?, nama_kamar = ?, keterangan = ? WHERE id_kamar = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_asrama, $nama_kamar, $ket, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO kamar (id_asrama, nama_kamar, keterangan) VALUES (?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_asrama, $nama_kamar, $ket]);
        }
    }

}
