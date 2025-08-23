<?php

require_once __DIR__ . '/../config/database.php';

class Pendaftar
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM pendaftar";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM pendaftar WHERE id_pendaftar = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM pendaftar WHERE id_pendaftar = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $nama, $tempat_lahir, $tgl_lahir, $jk, $alamat, $no_hp, $tgl_daftar)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE pendaftar SET nama_lengkap = ?, tempat_lahir = ?, tanggal_lahir = ?, jenis_kelamin = ?, alamat = ?, no_hp = ?, tanggal_daftar = ? WHERE id_pendaftar = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$nama, $tempat_lahir, $tgl_lahir, $jk, $alamat, $no_hp, $tgl_daftar, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO pendaftar (nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, no_hp, tanggal_daftar) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$nama, $tempat_lahir, $tgl_lahir, $jk, $alamat, $no_hp, $tgl_daftar]);
        }
    }

}
