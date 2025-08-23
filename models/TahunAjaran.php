<?php

require_once __DIR__ . '/../config/database.php';

class TahunAjaran
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM tahun_ajaran";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findTahun()
    {
        global $pdo;
        $query = "SELECT * FROM tahun_ajaran GROUP BY tahun";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM tahun_ajaran WHERE id_tahun = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM tahun_ajaran WHERE id_tahun = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id_tahun = null, $tahun, $semester, $is_aktif)
    {
        global $pdo;
        if ($id_tahun) {
            // Update existing data
            $query = "UPDATE tahun_ajaran SET tahun = ?, semester = ?, is_aktif = ? WHERE id_tahun = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$tahun, $semester, $is_aktif, $id_tahun]);
        } else {
            // Insert new data
            $query = "INSERT INTO tahun_ajaran (tahun, semester, is_aktif) VALUES (?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$tahun, $semester, $is_aktif]);
        }
    }

}
