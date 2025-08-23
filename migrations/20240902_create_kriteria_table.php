<?php
// Contoh nama file: 20240901_create_kriteria_table.php

$migration = [
    'up' => function (PDO $pdo) {
        $sql = "
            CREATE TABLE `kriteria` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `kode` varchar(10) NOT NULL,
                `nama_kriteria` varchar(50) NOT NULL,
                `type` enum('Benefit','Cost') NOT NULL,
                `bobot` float NOT NULL,
                `tipe_penilaian` tinyint(1) DEFAULT NULL,
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB
        ";
        $pdo->exec($sql);
    },

    'insert' => function (PDO $pdo) {
        $kode = ['C1', 'C2', 'C3', 'C4', 'C5'];
        $nama_kriteria = ["kriteria 1", "kriteria 2", "kriteria 3", "kriteria 4", "kriteria 5"];
        $type = "Benefit";
        $bobot = [0.25, 0.3, 0.15, 0.1, 0.2];
        $tipe = 0;

        foreach ($nama_kriteria as $index => $kriteria) {
            $sql = "INSERT INTO `kriteria` (`kode`, `nama_kriteria`, `type`, `bobot`, `tipe_penilaian`) 
                VALUES (:kode, :nama_kriteria, :type, :bobot, :tipe_penilaian)";

            try {
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':kode', $kode[$index]);
                $stmt->bindParam(':nama_kriteria', $kriteria);
                $stmt->bindParam(':type', $type);
                $stmt->bindParam(':bobot', $bobot[$index]);
                $stmt->bindParam(':tipe_penilaian', $tipe);

                if ($stmt->execute()) {
                    echo "Data inserted successfully!";
                } else {
                    echo "Data insert failed!";
                    print_r($stmt->errorInfo()); // Debug jika insert gagal
                }
            } catch (PDOException $e) {
                echo 'Insert Error: ' . $e->getMessage();
            }
        }
    },

    'down' => function (PDO $pdo) {
        $sql = "DROP TABLE kriteria;";
        $pdo->exec($sql);
    }
];

return $migration;
