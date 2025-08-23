<?php

require_once('config/database.php');

// Periksa apakah tabel `migrations` sudah ada
$checkTableQuery = "SHOW TABLES LIKE 'migrations'";
$tableExists = $pdo->query($checkTableQuery)->rowCount() > 0;

if (!$tableExists) {
    // Buat tabel `migrations` jika belum ada
    $sql = "
        CREATE TABLE `migrations` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `migration` varchar(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB
    ";
    $pdo->exec($sql);
    echo "Tabel `migrations` berhasil dibuat.\n";
}

// Ambil semua migrasi yang telah dijalankan
$stmt = $pdo->query("SELECT migration FROM migrations");
$executedMigrations = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Cari file migrasi yang ada di folder migrations
// $migrationFiles = glob('*.php');
$migrationFiles = glob('migrations/*.php');

foreach ($migrationFiles as $file) {
    $migrationName = basename($file, '.php');

    if (!in_array($migrationName, $executedMigrations)) {
        $migration = require $file;

        // Jalankan 'up' untuk migrasi
        $migration['up']($pdo);

        // Jalankan insert data jika ada fungsi insert
        if (isset($migration['insert'])) {
            $migration['insert']($pdo);
        }

        // Catat migrasi di database
        $stmt = $pdo->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
        $stmt->execute(['migration' => $migrationName]);

        echo "Migrasi $migrationName berhasil dijalankan.\n";
    }
}

echo "Semua migrasi telah dijalankan.\n";
