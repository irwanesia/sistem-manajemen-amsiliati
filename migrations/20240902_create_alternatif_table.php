<?php
// Contoh nama file: 20240901_create_alternatif_table.php

$migration = [
    'up' => function (PDO $pdo) {
        $sql = "
            CREATE TABLE `alternatif` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `kode` varchar(100) NOT NULL,
                `nama_alternatif` varchar(100) NOT NULL,
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB
        ";
        $pdo->exec($sql);
    },

    'insert' => function (PDO $pdo) {
        $kode = ["A1", "A2", "A3"];
        $nama_alternatif = ["alternatif 1", "alternatif 2", "alternatif 3"];

        foreach ($nama_alternatif as $index => $alternatif) {
            $sql = "INSERT INTO `alternatif` (`kode`, `nama_alternatif`) 
                VALUES (:kode, :nama_alternatif)";

            try {
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':kode', $kode[$index]);
                $stmt->bindParam(':nama_alternatif', $alternatif);

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
        $sql = "DROP TABLE alternatif;";
        $pdo->exec($sql);
    }
];

return $migration;
