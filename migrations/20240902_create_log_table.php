<?php
// Contoh nama file: 20240901_create_kriteria_table.php

$migration = [
    'up' => function (PDO $pdo) {
        $sql = "
            	CREATE TABLE `log_aktivitas` (
                `id_log` int(11) NOT NULL AUTO_INCREMENT,
                `user_id` int(11) DEFAULT NULL,
                `aktivitas` varchar(255) DEFAULT NULL,
                `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id_log`)
                ) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
        ";
        $pdo->exec($sql);
    },

    'down' => function (PDO $pdo) {
        $sql = "DROP TABLE log_aktivitas;";
        $pdo->exec($sql);
    }
];

return $migration;
