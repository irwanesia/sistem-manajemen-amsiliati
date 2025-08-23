<?php

require_once __DIR__ . '/../config/database.php';

class Kenaikan
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM kenaikan";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM kenaikan WHERE id_kenaikan = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }


    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM kenaikan WHERE id_kenaikan = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }
    
    public function save($id = null, $id_santri, $dari_jilid, $ke_jilid, $tanggal_kenaikan)
    {
        global $pdo;
        try {
            if ($id) {
                // Update existing data
                $query = "UPDATE kenaikan SET id_santri = ?, dari_jilid = ?, ke_jilid = ?, tanggal_kenaikan WHERE id_kenaikan = ?";
                $statement = $pdo->prepare($query);
                return $statement->execute([$id_santri, $dari_jilid, $ke_jilid, $tanggal_kenaikan, $id]);
            } else {
                // Insert new data
                $query = "INSERT INTO kenaikan (id_santri, dari_jilid, ke_jilid, tanggal_kenaikan) VALUES (?, ?, ?, ?)";
                $statement = $pdo->prepare($query);
                return $statement->execute([$id_santri, $dari_jilid, $ke_jilid, $tanggal_kenaikan, $id]);
            }
        } catch (Exception $e) {
            // Tangani error
            // Anda bisa mencetak error atau melakukan log
            error_log($e->getMessage());
            return false;
        }
    }
}
