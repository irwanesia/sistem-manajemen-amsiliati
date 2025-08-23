<?php

require_once __DIR__ . '/../config/database.php';

class Log
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM log_aktivitas ORDER BY tanggal DESC LIMIT 7";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM log_aktivitas WHERE id_log = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM log_aktivitas WHERE id_log = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($user_id, $aktivitas, $tanggal)
    {
        global $pdo;
        // Insert new data
        $query = "INSERT INTO log_aktivitas (user_id, aktivitas, tanggal) VALUES (?, ?, ?)";
        $statement = $pdo->prepare($query);
        return $statement->execute([$user_id, $aktivitas, $tanggal]);
    }
}
