<?php
// Contoh nama file: 20240901_create_sub_kriteria_table.php

$migration = [
    'up' => function (PDO $pdo) {
        $sql = "
            	CREATE TABLE `sub_kriteria` (
                    `id` int(11) NOT NULL AUTO_INCREMENT,
                    `id_kriteria` int(11) NOT NULL,
                    `nama` varchar(50) NOT NULL,
                    `nilai` float NOT NULL,
                    `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                    `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                    PRIMARY KEY (`id`),
                    KEY `fk_sub_kriteria_kriteria` (`id_kriteria`),
                    CONSTRAINT `fk_sub_kriteria_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
                ) ENGINE=InnoDB
        ";
        $pdo->exec($sql);
    },

    'down' => function (PDO $pdo) {
        $sql = "DROP TABLE sub_kriteria;";
        $pdo->exec($sql);
    }
];

return $migration;
