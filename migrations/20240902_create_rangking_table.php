<?php
// Contoh nama file: 20240901_create_rangking_table.php

$migration = [
    'up' => function (PDO $pdo) {
        $sql = "
            CREATE TABLE `rangking` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `kode_rangking` varchar(255) DEFAULT NULL,
                `id_alternatif` int(11) NOT NULL,
                `nilai` float NOT NULL,
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`),
                KEY `fk_rangking_alternatif` (`id_alternatif`),
                CONSTRAINT `fk_rangking_alternatif` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB
        ";
        $pdo->exec($sql);
    },

    'down' => function (PDO $pdo) {
        $sql = "DROP TABLE rangking;";
        $pdo->exec($sql);
    }
];

return $migration;
