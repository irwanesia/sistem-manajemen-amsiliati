<?php

require_once __DIR__ . '/../config/database.php';

class Ustadzah
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM ustadzah";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findAllWithJoin()
    {
        global $pdo;
        $query = "SELECT 
                    u.*,
                    k.nama_kamar,
                    k.id_kamar
                FROM ustadzah u
                JOIN kamar_ustadzah ku ON u.id_ustadzah=ku.id_ustadzah
                JOIN kamar k ON ku.id_kamar=k.id_kamar";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM ustadzah WHERE id_ustadzah = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function findNamaUstadzah($id)
    {
        global $pdo;
        $query = "SELECT nama_ustadzah FROM ustadzah WHERE id_ustadzah = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }
    
    public function findNamaUstadzahByIdJilid($id)
    {
        global $pdo;
        $query = "SELECT 
                    u.nama_ustadzah 
                FROM ustadzah u
                JOIN jilid j ON u.id_ustadzah = j.id_ustadzah
                WHERE j.id_jilid = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM ustadzah WHERE id_ustadzah = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $nama, $jabatan, $alamat)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE ustadzah SET nama_ustadzah = ?, jabatan = ?, alamat = ? WHERE id_ustadzah = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$nama, $jabatan, $alamat, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO ustadzah (nama_ustadzah, jabatan, alamat) VALUES (?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$nama, $jabatan, $alamat]);
        }
    }

}
