<?php

require_once __DIR__ . '/../config/database.php';

class KepalaKamar
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT kk.*, k.nama_kamar, a.nama_asrama FROM kepala_kamar kk
                  JOIN kamar k ON kk.id_kamar = k.id_kamar
                  JOIN asrama a ON k.id_asrama = a.id_asrama";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM kepala_kamar WHERE id_kepala_kamar = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM kepala_kamar WHERE id_kepala_kamar = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $id_kamar, $nama_kepala, $no_hp, $tgl_diangkat)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE kepala_kamar SET id_kamar = ?, nama_kepala = ?, no_hp = ?, tanggal_diangkat = ? WHERE id_kepala_kamar = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_kamar, $nama_kepala, $no_hp, $tgl_diangkat, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO kepala_kamar (id_kamar, nama_kepala, no_hp, tanggal_diangkat) VALUES (?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$id_kamar, $nama_kepala, $no_hp, $tgl_diangkat]);
        }
    }

}
