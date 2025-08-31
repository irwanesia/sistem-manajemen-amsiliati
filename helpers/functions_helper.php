<?php
include 'vendor/autoload.php';

require_once __DIR__ . '/../config/database.php';
require('./models/Absensi.php');
require('./models/Asrama.php');
require('./models/EvaluasiSantri.php');
require('./models/Jilid.php');
require('./models/Kamar.php');
require('./models/KamarSantri.php');
require('./models/Kenaikan.php');
require('./models/KepalaKamar.php');
require('./models/LaporanTriwulan.php');
require('./models/Legger.php');
require('./models/Log.php');
require('./models/Kelas.php');
require('./models/Nilai.php');
require('./models/Pendaftar.php');
require('./models/Materi.php');
require('./models/RekapNilai.php');
require('./models/Santri.php');
require('./models/TahunAjaran.php');
require('./models/Users.php');
require('./models/Ustadzah.php');
require('./models/Skor.php');

// santri 
if (!function_exists('get_santri')) {
    function get_santri()
    {
        $santri = new Santri();
        $santri_data = $santri->findAll();
        return $santri_data;
    }
}

if (!function_exists('get_santri_by_id')) {
    function get_santri_by_id($id)
    {
        $santri = new Santri();
        $santri_data = $santri->findById($id);
        return $santri_data;
    }
}
if (!function_exists('get_santri_by_id_jilid')) {
    function get_santri_by_id_jilid($id_jilid, $thn)
    {
        $santri = new Jilid();
        $santri_data = $santri->findSantriByJilidId($id_jilid, $thn);
        return $santri_data;
    }
}
if (!function_exists('get_santri_by_ustadzah')) {
    function get_santri_by_ustadzah($id)
    {
        $santri = new Santri();
        $santri_data = $santri->findSantriByUstadzah($id);
        return $santri_data;
    }
}

if (!function_exists('get_delete_santri')) {
    function get_delete_santri($id)
    {
        $santri = new santri();
        $santri_data = $santri->delete($id);
        return $santri_data;
    }
}

// ====================== Kamar, Asrama, Kepala Kamar ========================
if (!function_exists('get_asrama')) {
    function get_asrama()
    {
        $asrama = new asrama();
        $asrama_data = $asrama->findAll();
        return $asrama_data;
    }
}

if (!function_exists('get_kamar')) {
    function get_kamar()
    {
        $kamar = new Kamar();
        $kamar_data = $kamar->findAll();
        return $kamar_data;
    }
}

if (!function_exists('get_kamar_by_id')) {
    function get_kamar_by_id($id)
    {
        $kamar = new Kamar();
        $kamar_data = $kamar->findById($id);
        return $kamar_data;
    }
}

if (!function_exists('get_kamar_by_id_asrama')) {
    function get_kamar_by_id_asrama($id)
    {
        $kamar = new Kamar();
        $kamar_data = $kamar->findByIdAsrama($id);
        return $kamar_data;
    }
}

if (!function_exists('get_asrama_kamar')) {
    function get_asrama_kamar()
    {
        $asrama = new Asrama();
        $asrama_data = $asrama->findKamarAsramaAll();
        return $asrama_data;
    }
}

// kepala kamar
if (!function_exists('get_kepala_kamar')) {
    function get_kepala_kamar()
    {
        $kepala_kamar = new KepalaKamar();
        $kepala_kamar_data = $kepala_kamar->findAll();
        return $kepala_kamar_data;
    }
}

// get asrama santri
if (!function_exists('get_kamar_santri')) {
    function get_kamar_santri()
    {
        $kmr_santri = new KamarSantri();
        $kmr_santri_data = $kmr_santri->findAllWithJoin();
        return $kmr_santri_data;
    }
}


// ================ Kelas ========================
if (!function_exists('get_kelas')) {
    function get_kelas()
    {
        $kelas = new Kelas();
        $kelas_data = $kelas->findAll();
        return $kelas_data;
    }
}
if (!function_exists('get_kelas_jilid')) {
    function get_kelas_jilid()
    {
        $kelas = new Kelas();
        $kelas_data = $kelas->findAllWithJoin();
        return $kelas_data;
    }
}

if (!function_exists('get_kelas_santri')) {
    function get_kelas_santri($jilid_id)
    {
        $kelas = new Kelas();
        $kelas_data = $kelas->findKelasByJilidUstadzah($jilid_id);
        return $kelas_data;
    }
}

// ================ Materi ========================
if (!function_exists('get_materi')) {
    function get_materi()
    {
        $materi = new Materi();
        $materi_data = $materi->findAll();
        return $materi_data;
    }
}

if (!function_exists('get_materi_by_jilid')) {
    function get_materi_by_jilid($jilid_id)
    {
        $materi = new Materi();
        $materi_data = $materi->findByJilid($jilid_id);
        return $materi_data['nama_materi'] ?? null; // Mengembalikan nama materi atau 'Semua Materi' jika tidak ditemukan
    }
}

if (!function_exists('get_materi_by_jilid_ustadzah')) {
    function get_materi_by_jilid_ustadzah($jilid_id)
    {
        $materi = new Materi();
        $materi_data = $materi->findByJilidAll($jilid_id);
        return $materi_data; // Mengembalikan nama materi atau 'Semua Materi' jika tidak ditemukan
    }
}

// ================ Absensi Santri ========================
if (!function_exists('get_absensi_for_ustadzah')) {
    function get_absensi_for_ustadzah($tahun, $id_ustadzah, $tgl)
    {
        $absensi = new Absensi();
        $absensi_data = $absensi->getSantriWithAbsensiByTahunTanggal($tahun, $id_ustadzah, $tgl);
        return $absensi_data;
    }
}

if (!function_exists('get_absensi')) {
    function get_absensi($tahun, $jilid)
    {
        $absensi = new Absensi();
        $absensi_data = $absensi->getAbsensiByTahunAndJilid($tahun, $jilid);
        return $absensi_data;
    }
}

// get status absensi
if (!function_exists('get_status_absensi')) {
    function get_status_absensi($kelasJilidId, $tgl)
    {
        $absensi = new Absensi();
        $status = $absensi->findByKelasJilid($kelasJilidId, $tgl);
        return $status; // Mengembalikan status atau null jika tidak ada
    }
}

// cek absensi berdasarkan kelas_jilid_id dan tanggal
if (!function_exists('cekAbsensi')) {
    function cekAbsensi($kelasJilidId, $tanggal)
    {
        $absensi = new Absensi();
        $absensi_data = $absensi->cekDataTanggal($kelasJilidId, $tanggal);
        return $absensi_data;
    }
}   

if (!function_exists('cekAbsensiForUstadzah')) {
    function cekAbsensiForUstadzah($ustadzah_id, $tanggal)
    {
        $absensi = new Absensi();
        $absensi_data = $absensi->cekDataTanggal($ustadzah_id, $tanggal);
        return $absensi_data;
    }
}   

// get rekap absensi
if (!function_exists('get_rekap_absensi_for_ustadzah')) {
    function get_rekap_absensi_for_ustadzah($id_ustadzah, $id_tahun_ajaran)
    {
        $absensi = new Absensi();
        $rekap_data = $absensi->getRekapAbsenByUstadzah($id_ustadzah, $id_tahun_ajaran);
        return $rekap_data;
    }
}

// ================ Data Skor ========================
if (!function_exists('get_skor_by_ustadzah')) {
    function get_skor_by_ustadzah($tahun, $id_ustadzah)
    {
        $skor = new Skor();
        $skor_data = $skor->getSantriWithSkorByTahun($tahun, $id_ustadzah);
        return $skor_data;
    }
}

// cek absensi berdasarkan kelas_jilid_id dan tanggal
if (!function_exists('cekSkor')) {
    function cekSkor($kelasJilidId, $tanggal)
    {
        $skor = new Skor();
        $skor_data = $skor->cekSkorTanggal($kelasJilidId, $tanggal);
        return $skor_data;
    }
} 


if (!function_exists('get_data_skor')) {
    function get_data_skor($kelasJilidId, $tgl)
    {
        $skor = new Skor();
        $status = $skor->findDataSkor($kelasJilidId, $tgl);
        return $status; // Mengembalikan status atau null jika tidak ada
    }
}

if (!function_exists('get_rekap_skor')) {
    function get_rekap_skor($kelas_jilid_id, $thn_id, $tgl)
    {
        $skor = new Skor();
        $status = $skor->getRekapSkor($kelas_jilid_id, $thn_id, $tgl);
        return $status; // Mengembalikan status atau null jika tidak ada
    }
}

// ================ Tahun Ajaran ========================
if (!function_exists('get_tahun_ajaran')) {
    function get_tahun_ajaran()
    {
        $tahun_ajaran = new TahunAjaran();
        $tahun_ajaran_data = $tahun_ajaran->findAll();
        return $tahun_ajaran_data;
    }
}

if (!function_exists('get_tahun_groupBy')) {
    function get_tahun_groupBy()
    {
        $tahun_ajaran = new TahunAjaran();
        $tahun_ajaran_data = $tahun_ajaran->findTahun();
        return $tahun_ajaran_data;
    }
}

if (!function_exists('get_tahun_ajaran_by_id')) {
    function get_tahun_ajaran_by_id($id)
    {
        $tahun_ajaran = new TahunAjaran();
        $tahun_ajaran_data = $tahun_ajaran->findById($id);
        return $tahun_ajaran_data;
    }
}

// ================ Pendaftar ========================
if (!function_exists('get_pendaftar')) {
    function get_pendaftar()
    {
        $pendaftar = new Pendaftar();
        $pendaftar_data = $pendaftar->findAll();
        return $pendaftar_data;
    }
}

// ================ Ustadzah ========================
// ustadzah
if (!function_exists('get_ustadzah')) {
    function get_ustadzah()
    {
        $ustadzah = new Ustadzah();
        $ustadzah_data = $ustadzah->findAll();

        // Memeriksa jika data ustadzah kosong
        if (empty($ustadzah_data)) {
            return []; // Mengembalikan array kosong jika tidak ada ustadzah
        }

        return $ustadzah_data;
    }
}

if (!function_exists('get_ustadzah_kamar')) {
    function get_ustadzah_kamar()
    {
        $ustadzah = new Ustadzah();
        $ustadzah_data = $ustadzah->findAllWithJoin();

        // Memeriksa jika data ustadzah kosong
        if (empty($ustadzah_data)) {
            return []; // Mengembalikan array kosong jika tidak ada ustadzah
        }

        return $ustadzah_data;
    }
}

// get nama ustadzah by id
if (!function_exists('get_nama_ustadzah_by_id')) {
    function get_nama_ustadzah_by_id($id)
    {
        $ustadzah = new Ustadzah();
        $ustadzah_data = $ustadzah->findById($id);
        return $ustadzah_data['nama_ustadzah'] ?? ''; // Mengembalikan nama ustadzah atau string kosong jika tidak ditemukan
    }
}

if (!function_exists('get_ustadzah_by_id')) {
    function get_ustadzah_by_id($id)
    {
        $ustadzah = new Ustadzah();
        $ustadzah_data = $ustadzah->findById($id);
        return $ustadzah_data;
    }
}

if (!function_exists('get_nama_ustadzah_by_jilidId')) {
    function get_nama_ustadzah_by_jilidId($id)
    {
        $ustadzah = new Ustadzah();
        $ustadzah_data = $ustadzah->findNamaUstadzahByIdJilid($id);
        return $ustadzah_data['nama_ustadzah'];
    }
}

if (!function_exists('get_delete_ustadzah')) {
    function get_delete_ustadzah($id)
    {
        $ustadzah = new Ustadzah();
        $ustadzah_data = $ustadzah->delete($id);
        return $ustadzah_data;
    }
}

// ==================== Jilid ========================
// Jilid
if (!function_exists('get_jilid')) {
    function get_jilid()
    {
        $jilid = new Jilid();
        $jilid_data = $jilid->findAll();
        return $jilid_data;
    }
}

if (!function_exists('get_jilid_by_id')) {
    function get_jilid_by_id($id)
    {
        $jilid = new Jilid();
        $jilid_data = $jilid->findById($id);
        return $jilid_data;
    }
}

if (!function_exists('get_jilid_by_jilidId')) {
    function get_jilid_by_jilidId($id)
    {
        $jilid = new Jilid();
        $jilid_data = $jilid->findJilidByJilidId($id);
        return $jilid_data;
    }
}

// get hasil jilid
// Kirim data dalam format JSON
// buatkan dalam function
if (!function_exists('get_data_json')) {
    function get_data_json()
    {
        header('Content-Type: application/json');
        echo json_encode(get_status_count());
        exit;
    }
}


// ================ skor dan poin/nilai akhir semester ========================
// get skor
if (!function_exists('get_skor')) {
    function get_skor($thn_id, $materi_id)
    {
        $skor = new Skor();
        if ($thn_id && $materi_id) {
            $skor_data = $skor->findSkor($thn_id, $materi_id);
            return $skor_data;
        }
    }
}

if (!function_exists('get_poin')) {
    function get_poin($thn_id)
    {
        $poin = new Skor();
        if ($thn_id) {
            $poin_data = $poin->findNilaiAkhir($thn_id);
            return $poin_data;
        }
    }
}

// ==================== Kenaikan ========================
if (!function_exists('get_kenaikan_jilid')) {
    function get_kenaikan_jilid($jilid_id, $thn_id)
    {
        $kenaikan = new Kenaikan();
        $kenaikan_data = $kenaikan->getKenaikanJilidByTahun($jilid_id, $thn_id);
        return $kenaikan_data;
    }
}


if (!function_exists('cekKenaikanData')) {
    function cekKenaikanData($kelasJilidId)
    {
        $kenaikan = new Kenaikan();
        $kenaikan_data = $kenaikan->cekDataKenaikan($kelasJilidId);
        return $kenaikan_data;
    }
} 

// ==================== legger ========================
if (!function_exists('get_legger')) {
    function get_legger($jilid_id, $thn_id)
    {
        $legger = new Skor();
        $legger_data = $legger->findLegger($jilid_id, $thn_id);
        return $legger_data;
    }
}


// ================ Users ========================
if (!function_exists('get_users')) {
    function get_users()
    {
        $users = new Users();
        $users_data = $users->findAll();
        return $users_data;
    }
}

// get user by id
if (!function_exists('get_user_by_id')) {
    function get_user_by_id($id)
    {
        $users = new Users();
        $user_data = $users->findById($id);
        return $user_data;
    }
}

// get delete user by id
if (!function_exists('get_delete_user')) {
    function get_delete_user($id)
    {
        $user = new Users();
        $user_data = $user->delete($id);
        return $user_data;
    }
}

// get user by username
if (!function_exists('get_username')) {
    function get_username($username)
    {
        $users = new Users();
        $user_data = $users->findByUsername($username);
        return $user_data;
    }
}

// cek login
if (!function_exists('cek_login')) {
    function cek_login($role = array())
    {

        if (isset($_SESSION['id']) && isset($_SESSION['role']) && in_array($_SESSION['role'], $role)) {
            // do nothing
        } else {
            // redirect_to("login.php");
            header("Location: ../login.php");
        }
    }
}

if (!function_exists('get_role')) {
    function get_role($role)
    {
        if ($role == 'Admin') {
            return 'Admin';
        } else if ($role == 'Koordinator') {
            return 'Koordinator';
        } else if ($role == 'Wali Kelas') {
            return 'Wali Kelas';
        } else if ($role == 'Ustadzah') {
            return '-';
        } else {
            return 'User';
        }
    } 
}


// get log
if (!function_exists('get_log')) {
    function get_log()
    {
        $log = new log();
        $log_data = $log->findAll();
        return $log_data;
    }
}

// time stamp atau time ago
if (!function_exists('time_ago')) {
    function time_ago($timestamp)
    {
        // Ubah string timestamp menjadi objek DateTime
        $datetime = new DateTime($timestamp);
        $now = new DateTime(); // Waktu saat ini

        // Hitung perbedaan waktu
        $interval = $now->diff($datetime);

        // Tentukan apakah waktu itu di masa lalu atau masa depan
        if ($interval->invert == 0) {
            return "Di masa depan";
        }

        // Cek perbedaan waktu dan kembalikan format yang sesuai
        if ($interval->y >= 1) {
            return $interval->y . ' tahun yang lalu';
        } elseif ($interval->m >= 1) {
            return $interval->m . ' bulan yang lalu';
        } elseif ($interval->d >= 1) {
            return $interval->d . ' hari yang lalu';
        } elseif ($interval->h >= 1) {
            return $interval->h . ' jam yang lalu';
        } elseif ($interval->i >= 1) {
            return $interval->i . ' menit yang lalu';
        } else {
            return 'Baru saja';
        }
    }

    // Contoh penggunaan
    // $timestamp = '2024-09-19 04:56:34';
    // echo time_ago($timestamp);
}

// ======== membuat fungsi format decimal =========
if (!function_exists('format_decimal')) {
    function format_decimal($angka)
    {
        $parts = explode('.', (string) $angka);
        if (count($parts) > 1 && strlen($parts[1]) > 3) {
            // Jika angka setelah koma lebih dari 3 digit, batasi jadi 3
            return number_format($angka, 3);
        }
        return $angka; // Jika desimalnya sudah pendek, biarkan apa adanya
    }
}


// format tanggal excel
// Fungsi untuk mengkonversi format tanggal Excel ke format database
function convertExcelDateToDbFormat($excelDate) {
    // Jika format sudah YYYY-MM-DD, langsung return
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $excelDate)) {
        return $excelDate;
    }
    
    // Coba berbagai format tanggal
    try {
        // Format DD/MM/YYYY
        if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $excelDate)) {
            $date = DateTime::createFromFormat('d/m/Y', $excelDate);
            return $date->format('Y-m-d');
        }
        // Format MM/DD/YYYY
        elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $excelDate)) {
            $date = DateTime::createFromFormat('m/d/Y', $excelDate);
            return $date->format('Y-m-d');
        }
        // Format lain atau nilai kosong
        else {
            return null; // atau return '1900-01-01' untuk default
        }
    } catch (Exception $e) {
        return null;
    }
}

function tanggalIndonesia($date) {
    // Array nama bulan dalam bahasa Indonesia
    $bulan = array(
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    );
    
    // Konversi nama bulan
    $tanggal = date("d F Y", strtotime($date));
    $tanggal = strtr($tanggal, $bulan);
    
    return $tanggal;
}


// membuat fungsi untuk mengecek session role, apakah dia sebagai admin dgn representasi angka 1 atau sebagai user dengan representasi 2
if (!function_exists('cek_session_role')) {
    function cek_session_role()
    {
        if ($_SESSION['role'] == "admin") {
            $display = '';
        } else {
            $display = 'd-none';
        }
        echo $display;
    }
}

// membuat function switch case untuk memberikan variable sub title
if (!function_exists('switch_case')) {
    function switch_case($page, $action)
    {
        // Set subtitle berdasarkan page dan action
        switch ($page) {
            case 'dashboard':
                $subtitle = 'Dashboard';
                break;
            case 'pendaftar':
                $subtitle = 'Data Pendaftar';
                break;
            case 'santri':
                $subtitle = 'Data Santri';
                break;
            case 'ustadzah':
                $subtitle = 'Data Ustadzah';
                break;
            case 'kamar':
                $subtitle = 'Data Kamar';
                break;
            case 'kepala-kmr':
                $subtitle = 'Data Kepala Kamar';
                break;
            case 'asrama':
                $subtitle = 'Data Asrama';
                break;
            case 'absensi':
                $subtitle = 'Absensi Santri';
                break;
            case 'jilid':
                $subtitle = 'Data Jilid';
                break;
            case 'kelas':
                $subtitle = 'Data Kelas Jilid';
                break;
            case 'skor':
                $subtitle = 'Data Skor Santri';
                break;
            case 'nilai':
                $subtitle = 'Data Nilai Santri';
                break;
            case 'tahun-ajaran':
                $subtitle = 'Data Tahun Ajaran';
                break;
            case 'evaluasi-santri':
                if ($action == 'rekap-absensi') {
                    $subtitle = 'Rekap Absensi Santri';
                } else if ($action == 'rekap-skor') {
                    $subtitle = 'Data Rekap Skor Santri';
                } else if ($action == 'nilai') {
                    $subtitle = 'Data Nilai Santri';
                }
                break;
            case 'laporan':
                if ($action == 'lap-data-santri') {
                    $subtitle = 'Laporan Data Santri';
                } else if ($action == 'lap-rekap-nilai'){
                    $subtitle = 'Laporan Rekap Nilai';
                } else if ($action == 'lap-evaluasi-santri'){
                    $subtitle = 'Laporan Evaluasi Santri';
                } else if ($action == 'lap-triwulan'){
                    $subtitle = 'Laporan Triwulan';
                } else if ($action == 'lap-legger'){
                    $subtitle = 'Laporan Legger';
                } else if ($action == 'cetak-lap-data-santri'){
                    $subtitle = 'Cetak Laporan Data Santri';
                } else if($action == 'cetak-lap-rekap-nilai'){
                    $subtitle = 'Cetak Laporan Rekap Nilai';
                } else if($action == 'cetak-lap-evaluasi-santri'){
                    $subtitle = 'Cetak Laporan Evaluasi Santri';
                } else if($action == 'cetak-lap-triwulan'){
                    $subtitle = 'Cetak Laporan Triwulan';
                } else if($action == 'cetak-lap-legger'){
                    $subtitle = 'Cetak Laporan Legger';
                } else {
                    // Jika action tidak dikenali, gunakan default
                    if (empty($action)) {
                        $subtitle = 'Laporan';
                    } else {
                        $subtitle = 'Laporan Tidak Dikenal';
                    }
                }
                break;
            case 'users':
                if ($action == 'change_password') {
                    $subtitle = 'Ubah Password';
                } elseif ($action == 'setting') {
                    $subtitle = 'Setting User';
                } else {
                    $subtitle = 'Users';
                }
                break;
                // Tambahkan case lain sesuai dengan halaman yang ada
            default:
                $subtitle = 'Halaman Tidak Ditemukan';
        }

        return $subtitle;
    }
}
