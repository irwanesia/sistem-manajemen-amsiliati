<?php

require_once __DIR__ . '/../config/database.php';

class Materi
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT m.*, j.nama_jilid FROM materi m
                  JOIN jilid j ON m.id_jilid = j.id_jilid";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findByJilid($jilid_id)
    {
        global $pdo;
        $query = "SELECT * FROM materi WHERE id_jilid = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$jilid_id]);
        return $statement->fetch();
    }
    
    public function findByJilidAll($jilid_id)
    {
        global $pdo;
        $query = "SELECT * FROM materi WHERE id_jilid = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$jilid_id]);
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM materi WHERE id_materi = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM materi WHERE id_materi = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $id_jilid, $nama_materi, $deskripsi = null, $urutan, $aktif)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE materi SET id_jilid = ?, nama_materi = ?, deskripsi = ?, urutan = ?, aktif = ? WHERE id_materi = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_jilid, $nama_materi, $deskripsi, $urutan, $aktif, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO materi (id_jilid, nama_materi, deskripsi, urutan, aktif) VALUES (?, ?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_jilid, $nama_materi, $deskripsi, $urutan, $aktif]);
        }
    }

}
