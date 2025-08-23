<?php

require_once __DIR__ . '/../config/database.php';

class Users
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT u.*, us.nama_ustadzah FROM users u
                  LEFT JOIN ustadzah us ON u.id_ustadzah = us.id_ustadzah
                  ORDER BY u.id_user DESC";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM users WHERE id_user = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function findByUsername($usernama)
    {
        global $pdo;
        $query = "SELECT * FROM users WHERE username = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$usernama]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM users WHERE id = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function change_password($id, $password)
    {
        global $pdo;

        $query = "UPDATE users SET password = ? WHERE id_user = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$password, $id]);
    }

    public function save($id = null, $id_ust = null, $nama, $username, $password = null, $role)
    {
        global $pdo;

        if ($id) {
            // Jika $password atau foto tidak diisi, update data tanpa password dan foto
            if ($password) {
                // Update data dengan password
                $query = "UPDATE users SET id_ustadzah = ?, nama_lengkap = ?, username = ?, `password` = ?, `role` = ? WHERE id_user = ?";
                $statement = $pdo->prepare($query);
                return $statement->execute([$id_ust, $nama, $username, $password, $role, $id]);
            } else {
                // Update data tanpa password
                $query = "UPDATE users SET id_ustadzah = ?, nama_lengkap = ?, username = ?, `role` = ? WHERE id_user = ?";
                $statement = $pdo->prepare($query);
                return $statement->execute([$id_ust, $nama, $username, $role, $id]);
            }
        } else {
            // Insert data baru
            $query = "INSERT INTO users (id_ustadzah, nama_lengkap, username, `password`, `role`) VALUES (?, ?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_ust, $nama, $username, $password, $role]);
        }
    }
}
