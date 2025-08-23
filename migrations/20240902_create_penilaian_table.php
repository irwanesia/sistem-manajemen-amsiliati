<?php
// Contoh nama file: 20240901_create_penilaian_table.php


//                 KEY `fk_penilaian_alternatif` (`id_alternatif`),
//                 KEY `fk_penilaian_kriteria` (`id_kriteria`),
//                 KEY `fk_penilaian_sub_kriteria` (`id_sub_kriteria`),
//                 CONSTRAINT `fk_penilaian_alternatif` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
//                 CONSTRAINT `fk_penilaian_kriteria` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
//                 CONSTRAINT `fk_penilaian_sub_kriteria` FOREIGN KEY (`id_sub_kriteria`) REFERENCES `sub_kriteria` (`id`)

$migration = [
    'up' => function (PDO $pdo) {
        $sql = "
            CREATE TABLE `penilaian` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `id_alternatif` int(11) NOT NULL,
                `id_kriteria` int(11) NOT NULL,
                `id_sub_kriteria` int(11) NOT NULL,
                `nilai` float NOT NULL,
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB
        ";
        $pdo->exec($sql);
    },

    'down' => function (PDO $pdo) {
        $sql = "DROP TABLE penilaian;";
        $pdo->exec($sql);
    }
];

return $migration;
