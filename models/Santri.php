<?php

require_once __DIR__ . '/../config/database.php';

class Santri
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM santri";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM santri WHERE id_santri = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetchAll();
    }

    public function findByNis($nis)
    {
        global $pdo;
        $query = "SELECT COUNT(*) FROM santri WHERE nis = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$nis]);
        return $statement->fetchAll();
    }

    public function findSantriByUstadzah($id)
    {
        global $pdo;
        $query = "SELECT s.id_santri, s.nama
                FROM santri s 
                JOIN kelas_jilid k ON s.id_santri = k.santri_id
                WHERE k.ustadzah_id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetchAll();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM santri WHERE id_santri = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $nis, $nama, $tempat_lhr, $tanggal_lahir, $jenis_kelamin, $alamat, $status_aktif)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE santri SET nis = ?, nama = ?, tempat_lahir = ?, tanggal_lahir = ?, jenis_kelamin = ?, alamat = ?, status_aktif = ? WHERE id_santri = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$nis, $nama, $tempat_lhr, $tanggal_lahir, $jenis_kelamin, $alamat, $status_aktif, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO santri (nis, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, status_aktif) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$nis, $nama, $tempat_lhr, $tanggal_lahir, $jenis_kelamin, $alamat, $status_aktif]);
        }
    }
    
}
