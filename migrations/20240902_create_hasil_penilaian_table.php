<?php
// Contoh nama file: 20240901_create_hasil_penilaian_table.php

$migration = [
    'up' => function (PDO $pdo) {
        $sql = "
            	CREATE TABLE `hasil_penilaian` (
                `id_hasil_penilaian` int(11) NOT NULL AUTO_INCREMENT,
                `id_alternatif` int(11) NOT NULL,
                `id_responden` int(11) NOT NULL,
                `id_kriteria` int(11) NOT NULL,
                `nilai` float NOT NULL,
                `tanggal_penilaian` timestamp NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id_hasil_penilaian`)
                ) ENGINE=InnoDB
        ";
        $pdo->exec($sql);
    },

    'down' => function (PDO $pdo) {
        $sql = "DROP TABLE hasil_penilaian;";
        $pdo->exec($sql);
    }
];

return $migration;
