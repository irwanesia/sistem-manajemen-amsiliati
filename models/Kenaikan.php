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

    public function getKenaikanJilidByTahun($jilidID, $tahun)
    {
        global $pdo;
        $query = "SELECT s.nis, s.nama, r.nama_asrama, j.id_jilid, j.nama_jilid, u.nama_ustadzah,
                    k.id_kelas_jilid, s.id_santri, ka.nama_kamar
                FROM kelas_jilid k
                JOIN santri s ON k.santri_id = s.id_santri
                JOIN kamar ka ON s.kamar_id = ka.id_kamar
                JOIN asrama r ON ka.id_asrama = r.id_asrama
                JOIN jilid j ON k.jilid_id = j.id_jilid
                JOIN ustadzah u ON j.id_ustadzah = u.id_ustadzah
                JOIN tahun_ajaran ta ON k.tahun_ajaran_id = ta.id_tahun
                WHERE k.jilid_id = ? AND ta.id_tahun = ? AND s.status_aktif = 1
                ORDER BY s.nama";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$jilidID, $tahun]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cekDataKenaikan($kelasJilidId) {
        global $pdo;
        // Cek apakah data absensi sudah ada untuk kelas_jilid_id dan tanggal ini
        $kjd = intval($kelasJilidId);
        $kelasJilidId = htmlspecialchars($kelasJilidId);
        // Query untuk mengecek data
        $query = "SELECT COUNT(*) as total FROM kenaikan WHERE id_kelas_jilid = :kelas_jilid_id";
        $statement = $pdo->prepare($query);
        $statement->execute(['kelas_jilid_id' => $kjd]);
        return $statement->fetch(PDO::FETCH_ASSOC);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] > 0;
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
    
    public function save($id = null, $id_kelas_jilid, $dari_jilid, $ke_jilid, $tanggal_kenaikan)
    {
        global $pdo;
        try {
            if ($id) {
                // Update existing data
                $query = "UPDATE kenaikan SET id_kelas_jilid = ?, dari_jilid = ?, ke_jilid = ?, tanggal_kenaikan WHERE id_kenaikan = ?";
                $statement = $pdo->prepare($query);
                return $statement->execute([$id_kelas_jilid, $dari_jilid, $ke_jilid, $tanggal_kenaikan, $id]);
            } else {
                // Insert new data
                $query = "INSERT INTO kenaikan (id_kelas_jilid, dari_jilid, ke_jilid, tanggal_kenaikan) VALUES (?, ?, ?, ?)";
                $statement = $pdo->prepare($query);
                return $statement->execute([$id_kelas_jilid, $dari_jilid, $ke_jilid, $tanggal_kenaikan, $id]);
            }
        } catch (Exception $e) {
            // Tangani error
            // Anda bisa mencetak error atau melakukan log
            error_log($e->getMessage());
            return false;
        }
    }
}
