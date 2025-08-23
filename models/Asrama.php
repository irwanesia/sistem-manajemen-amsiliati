<?php

require_once __DIR__ . '/../config/database.php';

class Asrama
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM asrama";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findKamarAsramaAll()
    {
        global $pdo;
        $query = "SELECT 
                    a.nama_asrama,
                    k.nama_kamar,
                    k.id_kamar
                FROM asrama a
                JOIN kamar k ON a.id_asrama=k.id_asrama";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM asrama WHERE id_asrama = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM asrama WHERE id_asrama = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $nama_asrama, $ket = null)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE asrama SET nama_asrama = ?, keterangan = ? WHERE id_asrama = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$nama_asrama, $ket, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO asrama (nama_asrama, keterangan) VALUES (?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$nama_asrama, $ket]);
        }
    }

}
