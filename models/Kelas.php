<?php

require_once __DIR__ . '/../config/database.php';

class Kelas
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT s.nama, j.nama_jilid, u.nama_ustadzah, k.*, ta.tahun FROM kelas_jilid k
                  JOIN santri s ON k.santri_id = s.id_santri
                  JOIN jilid j ON k.jilid_id = j.id_jilid
                  JOIN ustadzah u ON j.id_ustadzah = u.id_ustadzah
                  JOIN tahun_ajaran ta ON k.tahun_ajaran_id = ta.id_tahun";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findAllWithJoin()
    {
        global $pdo;
        $query = "SELECT 
                    k.id_kelas_jilid,
                    k.jilid_id,
                    k.tahun_ajaran_id,
                    k.santri_id,
                    j.nama_jilid, 
                    u.nama_ustadzah, 
                    ta.tahun,
                    COUNT(s.id_santri) AS jumlah_santri
                FROM kelas_jilid k
                JOIN santri s ON k.santri_id = s.id_santri
                JOIN jilid j ON k.jilid_id = j.id_jilid
                JOIN ustadzah u ON j.id_ustadzah = u.id_ustadzah
                JOIN tahun_ajaran ta ON k.tahun_ajaran_id = ta.id_tahun
                GROUP BY j.nama_jilid, u.nama_ustadzah, ta.tahun
                ORDER BY j.nama_jilid ASC";
        
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }


    public function findKelasByJilidUstadzah($jilid_id)
    {
        global $pdo;
        $id_ustadzah = $_SESSION['id_ustadzah'];
        $query = "SELECT s.nama, j.nama_jilid, u.nama_ustadzah, k.*, ta.tahun FROM kelas_jilid k
                  JOIN santri s ON k.santri_id = s.id_santri
                  JOIN jilid j ON k.jilid_id = j.id_jilid
                  JOIN ustadzah u ON k.ustadzah_id = u.id_ustadzah
                  JOIN tahun_ajaran ta ON k.tahun_ajaran_id = ta.id_tahun
                  WHERE k.jilid_id = ? AND k.ustadzah_id = '$id_ustadzah'";
        $statement = $pdo->prepare($query);
        $statement->execute([$jilid_id]);
        return $statement->fetchAll();
    }

    
    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM kelas_jilid WHERE id_kelas_jilid = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM kelas_jilid WHERE id_kelas_jilid = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $santri_id, $jilid_id, $thn_ajaran_id, $tgl_mulai = null)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE kelas_jilid SET santri_id = ?, jilid_id = ?, tahun_ajaran_id = ?, tanggal_mulai = ? WHERE id_kelas_jilid = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$santri_id, $jilid_id, $thn_ajaran_id, $tgl_mulai, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO kelas_jilid (santri_id, jilid_id, tahun_ajaran_id, tanggal_mulai) VALUES (?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$santri_id, $jilid_id, $thn_ajaran_id, $tgl_mulai]);
        }
    }

}   
