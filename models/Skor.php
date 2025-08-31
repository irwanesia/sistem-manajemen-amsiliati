<?php

require_once __DIR__ . '/../config/database.php';

class Skor
{
    public function findAll()
    {
        global $pdo;
        $query = "SELECT s.*, j.nama_jilid, m.nama_materi, sa.nama  FROM skor s
                  JOIN kelas_jilid k ON s.kelas_jilid_id = k.id_kelas_jilid
                  JOIN jilid j ON k.jilid_id = j.id_jilid
                  JOIN santri sa ON k.santri_id = sa.id_santri
                  JOIN materi m ON s.materi_id = m.id_materi";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findLegger($jilid_id, $tahun_id)
    {
        global $pdo;
        $query = "SELECT 
                    s.id_santri,
                    s.nis,
                    s.nama,
                    MAX(CASE WHEN sk.kategori = 'Ujian Tulis' THEN IFNULL(sk.skor_akhir, sk.skor_awal) END) AS nilai_tulis,
                    MAX(CASE WHEN sk.kategori = 'Ujian Lisan' THEN IFNULL(sk.skor_akhir, sk.skor_awal) END) AS nilai_lisan,
                    ROUND((
                        (MAX(CASE WHEN sk.kategori = 'Ujian Tulis' THEN IFNULL(sk.skor_akhir, sk.skor_awal) END) +
                        MAX(CASE WHEN sk.kategori = 'Ujian Lisan' THEN IFNULL(sk.skor_akhir, sk.skor_awal) END)
                        ) / 2
                    ), 2) AS rata_rata,
                    ta.tahun,
                    kj.tahun_ajaran_id,
                    kj.jilid_id
                FROM skor sk
                JOIN kelas_jilid kj ON sk.kelas_jilid_id = kj.id_kelas_jilid
                JOIN santri s ON kj.santri_id = s.id_santri
                JOIN tahun_ajaran ta ON kj.tahun_ajaran_id = ta.id_tahun
                WHERE kj.jilid_id = ?                   -- filter jilid
                AND ta.id_tahun = ?                     -- filter tahun ajaran
                GROUP BY s.id_santri, s.nama, s.nis, kj.jilid_id
                ORDER BY rata_rata DESC";
        $statement = $pdo->prepare($query);
        $statement->execute([$jilid_id, $tahun_id]);
        return $statement->fetchAll();
    }

    public function findDataSkor($kelasJilidId, $tgl)
    {
        global $pdo;
        $query = "SELECT skor_awal, skor_akhir, kategori, jumlah_sp, keterangan FROM skor WHERE kelas_jilid_id = ? AND tanggal = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$kelasJilidId, $tgl]);
        return $statement->fetch();
    }

    // poin berdasarkan jilid
    // SELECT s.id_skor, san.nama, kj.jilid_id, j.nama_jilid, s.poin, s.tanggal
    // FROM skor s
    // JOIN kelas_jilid kj ON s.kelas_jilid_id = kj.id_kelas_jilid
    // JOIN jilid j ON kj.jilid_id = j.id_jilid
    // JOIN santri san ON kj.santri_id = san.id_santri
    // WHERE kj.jilid_id = 2 -- misal jilid 2
    // AND san.id_santri = 1;
    public function getSantriWithSkorByTahun($tahun, $ustadzahId)
    {
        global $pdo;
        $query = "SELECT s.nama, r.nama_asrama, j.nama_jilid, u.nama_ustadzah,
                    k.id_kelas_jilid, s.id_santri, ka.nama_kamar
                FROM kelas_jilid k
                JOIN santri s ON k.santri_id = s.id_santri
                JOIN kamar ka ON s.kamar_id = ka.id_kamar
                JOIN asrama r ON ka.id_asrama = r.id_asrama
                JOIN jilid j ON k.jilid_id = j.id_jilid
                JOIN ustadzah u ON j.id_ustadzah = u.id_ustadzah
                JOIN tahun_ajaran ta ON k.tahun_ajaran_id = ta.id_tahun
                WHERE ta.id_tahun = ? AND j.id_ustadzah = ? AND s.status_aktif = 1
                ORDER BY s.nama";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$tahun, $ustadzahId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cekSkorTanggal($tanggal, $kelasJilidId) {
        global $pdo;
        // Cek apakah data absensi sudah ada untuk kelas_jilid_id dan tanggal ini
        $kjd = intval($kelasJilidId);
        $tanggal = htmlspecialchars($tanggal);
        // Query untuk mengecek data
        $query = "SELECT COUNT(*) as total FROM skor WHERE tanggal = :tanggal AND kelas_jilid_id = :kelas_jilid_id";
        $statement = $pdo->prepare($query);
        $statement->execute(['tanggal' => $tanggal, 'kelas_jilid_id' => $kjd]);
        return $statement->fetch(PDO::FETCH_ASSOC);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] > 0;
    }

    public function findBySkorJilidAndTanggal($kelasJilidId, $tanggal) {
        global $pdo;
        // Cek apakah data absensi sudah ada untuk kelas_jilid_id dan tanggal ini
        $kelasJilidId = intval($kelasJilidId);
        $tanggal = htmlspecialchars($tanggal);
        $query = "SELECT * FROM skor WHERE kelas_jilid_id = :kelas_jilid_id AND tanggal = :tanggal LIMIT 1";
        $statement = $pdo->prepare($query);
        $statement->execute(['kelas_jilid_id' => $kelasJilidId, 'tanggal' => $tanggal]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
    

    public function getSantriWithSkorByTahunTanggal($tahun, $ustadzahId, $tgl)
    {
        global $pdo;
        $query = "SELECT s.nama, r.nama_asrama, j.nama_jilid, u.nama_ustadzah,
                        k.id_kelas_jilid, s.id_santri, ka.nama_kamar,
                        sc.id_skor, sc.poin, sc.kategori, sc.keterangan
                    FROM kelas_jilid k
                    JOIN santri s ON k.santri_id = s.id_santri
                    JOIN kamar ka ON s.kamar_id = ka.id_kamar
                    JOIN asrama r ON ka.id_asrama = r.id_asrama
                    JOIN jilid j ON k.jilid_id = j.id_jilid
                    JOIN ustadzah u ON j.id_ustadzah = u.id_ustadzah
                    JOIN tahun_ajaran ta ON k.tahun_ajaran_id = ta.id_tahun
                    LEFT JOIN skor sc 
                        ON sc.kelas_jilid_id = k.id_kelas_jilid AND sc.tanggal = ?
                    WHERE ta.id_tahun = ? AND j.id_ustadzah = ? AND s.status_aktif = 1
                    ORDER BY s.nama";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$tahun, $ustadzahId, $tgl]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findSkor($thn_id, $materi_id)
    {
        global $pdo;
        $id_ustadzah = $_SESSION['id_ustadzah'];
        $query = "SELECT 
                    s.id_santri, 
                    s.nama, 
                    r.nama_asrama, 
                    j.nama_jilid, 
                    u.nama_ustadzah, 
                    u.id_ustadzah, 
                    k.*,
                    sk.*,
                    ta.tahun,
                    m.nama_materi 
                FROM kelas_jilid k
                JOIN santri s ON k.santri_id = s.id_santri
                JOIN kamar ka ON s.kamar_id = ka.id_kamar
                JOIN asrama r ON ka.id_asrama = r.id_asrama
                JOIN jilid j ON k.jilid_id = j.id_jilid
                JOIN materi m ON k.jilid_id = m.id_jilid
                JOIN ustadzah u ON k.ustadzah_id = u.id_ustadzah
                JOIN tahun_ajaran ta ON k.tahun_ajaran_id = ta.id_tahun
                JOIN skor sk ON (k.id_kelas_jilid = sk.kelas_jilid_id AND sk.materi_id = m.id_materi)
                WHERE ta.id_tahun = ? AND m.id_materi = ? AND k.ustadzah_id = '$id_ustadzah' AND s.status_aktif = 1";
        $statement = $pdo->prepare($query);
        $statement->execute([$thn_id, $materi_id]);
        return $statement->fetchAll();
    }

    // get rekap skor
    function getRekapSkor($jilid_id, $tahunAjaranId, $bulan) {
        global $pdo;
        $id_ustadzah = $_SESSION['id_ustadzah'];
        $sql = "SELECT 
                s.id_santri,
                s.nama,
                sk.jumlah_sp,
                MAX(sk.skor_awal) AS skor_awal,
                MAX(sk.skor_akhir) AS skor_akhir,
                SUM(CASE WHEN a.status='A' THEN 1 ELSE 0 END) AS total_A,
                SUM(CASE WHEN a.status='I' THEN 1 ELSE 0 END) AS total_I,
                SUM(CASE WHEN a.status='S' THEN 1 ELSE 0 END) AS total_S,
                SUM(CASE WHEN a.status='T' THEN 1 ELSE 0 END) AS total_T,
                GROUP_CONCAT(DAY(a.tanggal), ':', a.status ORDER BY a.tanggal) AS absensi_harian
            FROM kelas_jilid kj
            JOIN santri s ON s.id_santri = kj.santri_id
            JOIN jilid j ON j.id_jilid = kj.jilid_id
            LEFT JOIN skor sk 
                ON sk.kelas_jilid_id = kj.id_kelas_jilid
                AND DATE(sk.tanggal) = :tanggal_skor   -- filter skor di tanggal tertentu
            LEFT JOIN absensi a 
                ON a.kelas_jilid_id = kj.id_kelas_jilid
                AND MONTH(a.tanggal) = :bulan               -- filter absensi per bulan
            WHERE kj.jilid_id = :jilid_id
            AND kj.tahun_ajaran_id = :tahun_ajaran_id
            AND j.id_ustadzah = :id_ustadzah
            GROUP BY s.id_santri, s.nama
            ORDER BY s.nama";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':jilid_id' => $jilid_id,
            ':tahun_ajaran_id' => $tahunAjaranId,
            ':bulan' => $bulan,
            ':tanggal_skor' => $bulan,   // misalnya '2025-08-28'
            ':id_ustadzah' => $id_ustadzah
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // get poin/nilai akhir santri by ustadzah
    public function findNilaiAkhir($thn_id)
    {
        global $pdo;
        $id_ustadzah = $_SESSION['id_ustadzah'];
        $query = "SELECT 
                    -- COALESCE(AVG(s.skor_akhir), 0) AS nilai_rata2,
                    s.skor_akhir,
                    sa.nama as nama_santri,
                    j.nama_jilid,
                    n.*,
                    s.kategori
                FROM skor s
                JOIN kelas_jilid kj ON s.kelas_jilid_id = kj.id_kelas_jilid
                JOIN jilid j ON kj.jilid_id=j.id_jilid
                JOIN santri sa ON kj.santri_id = sa.id_santri
                LEFT JOIN nilai n ON kj.id_kelas_jilid=n.kelas_jilid_id
                WHERE j.id_ustadzah = '$id_ustadzah'
                AND kj.tahun_ajaran_id = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$thn_id]);
        return $statement->fetchAll();
    }


    public function findById($id)
    {
        global $pdo;
        $query = "SELECT * FROM skor WHERE id_skor = ?";
        $statement = $pdo->prepare($query);
        $statement->execute([$id]);
        return $statement->fetch();
    }

    public function delete($id)
    {
        global $pdo;
        $query = "DELETE FROM skor WHERE id_skor = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$id]);
    }

    public function updateSkor($id_skor, $skor_awal, $skor_akhir, $kategori, $jumlah_sp, $ket) {
        global $pdo;
        // Update status absensi berdasarkan id_skor
        $id_skor = intval($id_skor);
        // Update query
        $query = "UPDATE skor SET skor_awal = ?, skor_akhir = ?, kategori = ?, jumlah_sp = ?, keterangan = ? WHERE id_skor = ?";
        $statement = $pdo->prepare($query);
        return $statement->execute([$skor_awal, $skor_akhir, $kategori, $jumlah_sp, $ket, $id_skor]);
    }

    public function save($id = null, $kelas_jilid_id, $materi_id = null, $tgl, $skor_awal, $skor_akhir, $kategori, $jumlah_sp, $keterangan)
    {
        global $pdo;
        if ($id) {
            // Update existing data
            $query = "UPDATE skor SET kelas_jilid_id = ?, materi_id = ?, tanggal = ?, skor_awal = ?, skor_akhir = ?, kategori = ?, jumlah_sp = ?, keterangan  = ?";
            $statement = $pdo->prepare($query);
            return $statement->execute([$kelas_jilid_id, $materi_id, $tgl, $skor_awal, $skor_akhir, $kategori, $jumlah_sp, $kategori, $keterangan, $id]);
        } else {
            // Insert new data
            $query = "INSERT INTO skor (kelas_jilid_id, materi_id, tanggal, skor_awal, skor_akhir, kategori, jumlah_sp, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $statement = $pdo->prepare($query);
            return $statement->execute([$kelas_jilid_id, $materi_id, $tgl, $skor_awal, $skor_akhir, $kategori, $jumlah_sp, $keterangan]);
        }
    }

}
