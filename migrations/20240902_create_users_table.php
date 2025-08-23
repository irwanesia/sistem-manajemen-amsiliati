<?php
// Contoh nama file: 20240901_create_users_table.php

$migration = [
    'up' => function (PDO $pdo) {
        $sql = "
            CREATE TABLE `users` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `foto` varchar(255) NOT NULL,
                `nama` varchar(150) NOT NULL,
                `username` varchar(50) NOT NULL,
                `password` varchar(255) NOT NULL,
                `role` char(1) NOT NULL,
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB
        ";
        $pdo->exec($sql);
    },

    'insert' => function (PDO $pdo) {
        $foto = "foto.png";
        $nama = "admin";
        $user = "admin";
        $pass = "123";

        // Hash password menggunakan password_hash()
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        $role = "1";

        $sql = "INSERT INTO `users` (`foto`, `nama`, `username`, `password`, `role`) 
                VALUES (:foto, :nama, :username, :password, :role)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':foto', $foto);
            $stmt->bindParam(':nama', $nama);
            $stmt->bindParam(':username', $user);
            $stmt->bindParam(':password', $hashed_pass);
            $stmt->bindParam(':role', $role);

            if ($stmt->execute()) {
                echo "Data inserted successfully!";
            } else {
                echo "Data insert failed!";
                print_r($stmt->errorInfo()); // Debug jika insert gagal
            }
        } catch (PDOException $e) {
            echo 'Insert Error: ' . $e->getMessage();
        }
    },

    'down' => function (PDO $pdo) {
        $sql = "DROP TABLE users;";
        $pdo->exec($sql);
    }
];

return $migration;
