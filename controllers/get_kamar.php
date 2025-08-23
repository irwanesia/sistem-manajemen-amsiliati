<?php
// controllers/get_kamar.php
require_once __DIR__ . '/../config/database.php';

// Pastikan tidak ada output sebelum header
if (ob_get_length()) ob_clean();

header('Content-Type: application/json');

require_once __DIR__ . '/../models/Kamar.php';

// Ambil id_asrama dari parameter GET
$id_asrama = isset($_GET['id_asrama']) ? intval($_GET['id_asrama']) : 0;

try {
    if ($id_asrama > 0) {
        $kamar = new Kamar();
        $dataKamar = $kamar->findByIdAsrama($id_asrama);
        
        // Pastikan data adalah array
        if (!is_array($dataKamar)) {
            $dataKamar = [];
        }
        
        echo json_encode([
            'success' => true,
            'data' => $dataKamar
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'ID Asrama tidak valid',
            'data' => []
        ]);
    }
} catch (Exception $e) {
    // Log error untuk debugging
    error_log("Error in get_kamar.php: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan server',
        'data' => []
    ]);
}

// Pastikan tidak ada output setelahnya
exit();
?>