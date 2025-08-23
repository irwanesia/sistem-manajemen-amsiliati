<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=db_pengelolaan_manajemen", "root", "");
    // Set error mode ke exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Koneksi database berhasil!";
} catch (PDOException $e) {
    echo "Koneksi database gagal: " . $e->getMessage();
}
