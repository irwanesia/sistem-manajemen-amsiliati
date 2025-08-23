<?php

require_once __DIR__ . '/../config/database.php';

class Absensi
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT * FROM absensi";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findByKelasJilid($kelasJilidId, $tgl)
    {
        global $pdo;
        $query = "SELECT `status`, keterangan FROM absensi WHERE kelas_jilid_id = ? AND tanggal = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$kelasJilidId, $tgl]);
        return $statement->fetch();
    }

    public function getRekapAbsenByUstadzah($id_ustadzah, $id_tahun_ajaran)
    {
        global $pdo;
        // Ambil data rekap absen berdasarkan ustadzah dan tahun ajaran
        $query = "SELECT
                    s.id_santri,
                    s.nama AS nama_santri,
                    j.id_jilid,
                    j.nama_jilid,
                    u.id_ustadzah,
                    u.nama_ustadzah,
                    r.nama_asrama,
                    ka.nama_kamar,
                COALESCE(tp.total_pertemuan, 0) AS total_pertemuan,
                SUM(CASE WHEN a.status IN ('H','Hadir') THEN 1 ELSE 0 END) AS total_hadir,
                SUM(CASE WHEN a.status IN ('I','Izin') THEN 1 ELSE 0 END) AS total_izin,
                SUM(CASE WHEN a.status IN ('A','Alfa') THEN 1 ELSE 0 END) AS total_alfa,
                SUM(CASE WHEN a.status IN ('T','Terlambat') THEN 1 ELSE 0 END) AS total_terlambat,
                SUM(CASE WHEN a.status IN ('S','Sakit') THEN 1 ELSE 0 END) AS total_sakit
                FROM kelas_jilid k
                JOIN santri s ON k.santri_id = s.id_santri
                JOIN kamar ka ON s.kamar_id = ka.id_kamar
                JOIN asrama r ON ka.id_asrama = r.id_asrama
                JOIN jilid j ON k.jilid_id = j.id_jilid
                JOIN ustadzah u ON j.id_ustadzah = u.id_ustadzah

                /* absensi per siswa (boleh null jika belum ada absensi sama sekali) */
                LEFT JOIN absensi a ON a.kelas_jilid_id = k.id_kelas_jilid

                /* derived: hitung total pertemuan unik untuk kombinasi jilid+tahun+ustadzah */
                LEFT JOIN (
                SELECT kj2.jilid_id, kj2.tahun_ajaran_id, j2.id_ustadzah,
                        COUNT(DISTINCT a2.tanggal) AS total_pertemuan
                FROM kelas_jilid kj2
                JOIN absensi a2 ON a2.kelas_jilid_id = kj2.id_kelas_jilid
                JOIN jilid j2 ON kj2.jilid_id = j2.id_jilid
                GROUP BY kj2.jilid_id, kj2.tahun_ajaran_id, j2.id_ustadzah
                ) tp ON tp.jilid_id = k.jilid_id
                    AND tp.tahun_ajaran_id = k.tahun_ajaran_id
                    AND tp.id_ustadzah = j.id_ustadzah

                WHERE j.id_ustadzah = ?
                AND k.tahun_ajaran_id = ?
                AND s.status_aktif = 1

                GROUP BY s.id_santri, s.nama, j.id_jilid, j.nama_jilid, u.id_ustadzah, u.nama_ustadzah, tp.total_pertemuan
                ORDER BY s.nama";
        $statement = $pdo->prepare($query);
        $statement->execute([$id_ustadzah, $id_tahun_ajaran]);
        return $statement->fetchAll();
    }


    // get absensi data untuk ustadzah
    public function getSantriWithAbsensiByTahunTanggal($tahun, $ustadzahId, $tanggal)
    {
        global $pdo;
        $query = "SELECT s.nama, r.nama_asrama, j.nama_jilid, u.nama_ustadzah,
                        k.id_kelas_jilid, s.id_santri, ka.nama_kamar,
                        a.id_absensi, a.status
                FROM kelas_jilid k
                JOIN santri s ON k.santri_id = s.id_santri
                JOIN kamar ka ON s.kamar_id = ka.id_kamar
                JOIN asrama r ON ka.id_asrama = r.id_asrama
                JOIN jilid j ON k.jilid_id = j.id_jilid
                JOIN ustadzah u ON j.id_ustadzah = u.id_ustadzah
                JOIN tahun_ajaran ta ON k.tahun_ajaran_id = ta.id_tahun
                LEFT JOIN absensi a ON a.kelas_jilid_id = k.id_kelas_jilid AND a.tanggal = ?
                WHERE ta.id_tahun = ? AND j.id_ustadzah = ? AND s.status_aktif = 1
                ORDER BY s.nama";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$tanggal, $tahun, $ustadzahId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAbsensiByTahunForUstadzah($tahun, $ustadzahId)
    {
        global $pdo;
        $query = "SELECT s.nama, r.nama_asrama, j.nama_jilid, u.nama_ustadzah, k.*, ta.tahun
                FROM kelas_jilid k
                JOIN santri s ON k.santri_id = s.id_santri
                JOIN kamar ka ON s.kamar_id = ka.id_kamar
                JOIN asrama r ON ka.id_asrama = r.id_asrama
                JOIN jilid j ON k.jilid_id = j.id_jilid
                JOIN ustadzah u ON k.ustadzah_id = u.id_ustadzah
                JOIN tahun_ajaran ta ON k.tahun_ajaran_id = ta.id_tahun
                WHERE ta.id_tahun = ? 
                AND k.ustadzah_id = ? 
                AND s.status_aktif = 1";
        $statement = $pdo->prepare($query);
        $statement->execute([$tahun, $ustadzahId]);
        return $statement->fetchAll();
    }


    // get kelas by tahun and jilid untuk admin
    public function getAbsensiByTahunAndJilid($tahun, $jilid)
    {
        global $pdo;
        $query = "SELECT s.nama, r.nama_asrama, j.nama_jilid, u.nama_ustadzah, k.*, ta.tahun FROM kelas_jilid k
                  JOIN santri s ON k.santri_id = s.id_santri
                  JOIN kamar ka ON s.kamar_id = ka.id_kamar
                  JOIN asrama r ON ka.id_asrama = r.id_asrama
                  JOIN jilid j ON k.jilid_id = j.id_jilid
                  JOIN ustadzah u ON k.ustadzah_id = u.id_ustadzah
                  JOIN tahun_ajaran ta ON k.tahun_ajaran_id = ta.id_tahun
                  WHERE ta.id_tahun = ? AND j.id_jilid = ? AND s.status_aktif = 1";
        $statement = $pdo->prepare($query);
        $statement->execute([$tahun, $jilid]);
        return $statement->fetchAll();
    }

    public function findByKelasJilidAndTanggal($kelasJilidId, $tanggal) {
        global $pdo;
        // Cek apakah data absensi sudah ada untuk kelas_jilid_id dan tanggal ini
        $kelasJilidId = intval($kelasJilidId);
        $tanggal = htmlspecialchars($tanggal);
        $query = "SELECT * FROM absensi WHERE kelas_jilid_id = :kelas_jilid_id AND tanggal = :tanggal LIMIT 1";
        $statement = $pdo->prepare($query);
        $statement->execute(['kelas_jilid_id' => $kelasJilidId, 'tanggal' => $tanggal]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id_absensi, $status, $ket) {
        global $pdo;
        // Update status absensi berdasarkan id_absensi
        $id_absensi = intval($id_absensi);
        $status = htmlspecialchars($status);
        if (!in_array($status, ['H', 'I', 'A', 'T', 'S'])) {
            throw new InvalidArgumentException("Status tidak valid");
        }
        // Update query
        $query = "UPDATE absensi SET status = :status, keterangan = :keterangan WHERE id_absensi = :id_absensi";
        $statement = $pdo->prepare($query);
        return $statement->execute(['status' => $status, 'keterangan' => $ket, 'id_absensi' => $id_absensi]);
    }

    public function cekDataTanggal($tanggal, $kelasJilidId) {
        global $pdo;
        // Cek apakah data absensi sudah ada untuk kelas_jilid_id dan tanggal ini
        $kjd = intval($kelasJilidId);
        $tanggal = htmlspecialchars($tanggal);
        // Query untuk mengecek data
        $query = "SELECT COUNT(*) as total FROM absensi WHERE tanggal = :tanggal AND kelas_jilid_id = :kelas_jilid_id";
        $statement = $pdo->prepare($query);
        $statement->execute(['tanggal' => $tanggal, 'kelas_jilid_id' => $kjd]);
        return $statement->fetch(PDO::FETCH_ASSOC);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] > 0;
    }

    public function cekDataAbsensiUstadzah($tanggal, $kelasJilidId) {
        global $pdo;
        // Cek apakah data absensi sudah ada untuk kelas_jilid_id dan tanggal ini
        $kjd = intval($kelasJilidId);
        $tanggal = htmlspecialchars($tanggal);
        // Query untuk mengecek data
        $query = "SELECT COUNT(*) as total FROM absensi WHERE tanggal = :tanggal AND kelas_jilid_id = :kelas_jilid_id";
        $statement = $pdo->prepare($query);
        $statement->execute(['tanggal' => $tanggal, 'kelas_jilid_id' => $kjd]);
        // return $statement->fetch(PDO::FETCH_ASSOC);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] > 0;
    }

    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM absensi WHERE id_absensi = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM absensi WHERE id_absensi = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function save($id = null, $kelas_jilid_id, $tanggal, $status, $ket = null)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE absensi SET kelas_jilid_id = ?, tanggal = ?, `status` = ?, keterangan = ? WHERE id_absensi = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$kelas_jilid_id, $tanggal, $status, $ket, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO absensi (kelas_jilid_id, tanggal, `status`, keterangan) VALUES (?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$kelas_jilid_id, $tanggal, $status, $ket]);
        }
    }

}
