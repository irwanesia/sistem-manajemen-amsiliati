<?php

require_once __DIR__ . '/../config/database.php';

class Jilid
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT j.*, u.nama_ustadzah 
                FROM jilid j
                JOIN ustadzah u ON j.id_ustadzah=u.id_ustadzah";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findById($id_ustadzah)
    {
        global $pdo;
        $query = "SELECT j.*, ta.tahun, k.id_kelas_jilid
                FROM jilid j
                JOIN kelas_jilid k ON j.id_jilid = k.jilid_id
                JOIN tahun_ajaran ta ON k.tahun_ajaran_id = ta.id_tahun
                WHERE j.id_ustadzah = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id_ustadzah]);
        return $statement->fetch();
    }

    public function findJilidByJilidId($id_jilid)
    {
        global $pdo;
        $query = "SELECT * FROM jilid WHERE id_jilid = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id_jilid]);
        return $statement->fetch();
    }

    public function findSantriByJilidId($jilid_id, $thn)
    {
        global $pdo;
        $query = "SELECT s.nama, s.id_santri, k.id_kelas_jilid
                FROM kelas_jilid k
                JOIN santri s ON k.santri_id=s.id_santri
                WHERE k.jilid_id = ? AND k.tahun_ajaran_id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$jilid_id, $thn]);
        return $statement->fetchAll();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM jilid WHERE id_jilid = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $nama_jilid, $deskripsi)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE jilid SET nama_jilid = ?, deskripsi = ? WHERE id_jilid = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$nama_jilid, $deskripsi, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO jilid (nama_jilid, deskripsi) VALUES (?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$nama_jilid, $deskripsi]);
        }
    }

}
