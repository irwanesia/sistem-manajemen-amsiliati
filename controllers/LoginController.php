<?php
session_start(); // Tambahkan session_start di bagian paling atas
// Misalkan file index.php berada di src dan database.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Users.php');
require('../models/Log.php');


if (isset($_POST['login'])) {
    // $errors = array();
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validasi
    if (!$username) {
        $message = 'Username tidak boleh kosong';
    }
    if (!$password) {
        $message = 'Password tidak boleh kosong';
    }

    // Jika ada pesan error, langsung redirect dan tampilkan pesan
    // if (isset($message)) {
    //     header("Location: ../login.php?message={$message}");
    //     exit;
    // }

    if (empty($message)) {
        // $data = get_username($username);
        // Siapkan query
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");

        // Bind parameter agar aman dari SQL injection
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        // Eksekusi query
        $stmt->execute();

        // Menghitung jumlah baris yang ditemukan
        $cek = $stmt->rowCount();

        // Ambil data dari query
        $data = $stmt->fetch(PDO::FETCH_ASSOC);


        // Cek apakah data ditemukan
        if ($cek > 0) {
            // Lakukan sesuatu dengan $data
            $hashed_password = password_verify($password, $data['password']);
            if ($hashed_password) {
                $_SESSION["user_id"] = $data["id_user"];
                $_SESSION["username"] = $data["username"];
                $_SESSION["role"] = $data["role"];
                $_SESSION["nama"] = $data["nama_lengkap"];
                $_SESSION["id_ustadzah"] = $data["id_ustadzah"];
                $_SESSION['logged_in'] = true;
                $log = new Log();
                $user_id = $data["id_user"];
                $aktivitas = $data["nama_lengkap"] . " melakukan login ke sistem";
                $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
                $log->save($user_id, $aktivitas, $tanggal);

                header("Location: ../dashboard");
            } else {
                $message = 'Password salah!';
                header("Location: ../login.php?message={$message}");
                exit;
            }
        } else {
            $message = 'Username salah!';
            header("Location: ../login.php?message={$message}");
            exit;
        }
    }
}
