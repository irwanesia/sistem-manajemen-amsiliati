<?php

// Misalkan file index.php berada di src dan database.php berada di satu level di atas src
require_once __DIR__ . '/../config/database.php';

require('../models/Users.php');
require('../models/Log.php');

// Pastikan method yang digunakan adalah POST
if (isset($_POST['submit'])):
    $ustadzah_id = $_POST['ustadzah_id'] ?? null;;
    $nama = $_POST['nama'] ?? '';
    $username = $_POST['username'];
    $password = $_POST['password1'];
    $password2 = $_POST['password2'];
    $role = $_POST['role'];

    // Cek Username (Hanya dilakukan jika validasi lainnya lulus)
    $user = new Users();
    $userExists = $user->findByUsername($username);
    // Mulai Validasi
    if (!empty($userExists)) {
        $message = urlencode('Username sudah digunakan');
    } elseif (!$username) {
        $message = urlencode('Username tidak boleh kosong');
    } elseif (!$password) {
        $message = urlencode('Password tidak boleh kosong');
    } elseif ($password != $password2) {
        $message = urlencode('Password harus sama keduanya');
    } elseif (!$nama) {
        $message = urlencode('Nama tidak boleh kosong');
    } elseif (!$role) {
        $message = urlencode('Role tidak boleh kosong');
    }

    // Jika ada pesan error, langsung redirect dan tampilkan pesan
    if (isset($message)) {
        header("Location: ../users&message={$message}");
        exit;
    }

    $hash_pass = password_hash($password, PASSWORD_DEFAULT);
    $user->save(null, $ustadzah_id, $nama, $username, $hash_pass, $role);

    $log = new Log();
    $user_id =  $_POST['user_id'];
    $aktivitas =  $_POST['nama'] . " menambah data user";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Setelah berhasil menyimpan, tampilkan pesan sukses
    $message = urlencode("Data berhasil disimpan!");
    header("Location: ../users&message={$message}");
    exit;

endif;

if (isset($_POST['update'])) {
    $id = $_POST['id_user'];
    $ustadzah_id = $_POST['ustadzah_id'] ?? null; 
    $nama = $_POST['nama'] ?? '';
    $username = $_POST['username'];
    $password = $_POST['password1'];
    $password2 = $_POST['password2'];
    $role = $_POST['role'];

    // Inisialisasi kelas Users
    $user = new Users();

    // Cek Username, pastikan jika username diubah, tidak ada yang sama
    $userExists = $user->findByUsername($username);

    // Mulai Validasi
    if ($userExists && $userExists['id_user'] != $id) {
        // Jika username sudah ada dan bukan milik user yang sedang di-update
        $message = urlencode('Username sudah digunakan');
    } elseif (!$username) {
        $message = urlencode('Username tidak boleh kosong');
    } elseif ($password && $password != $password2) {
        // Validasi password, hanya jika user mengisi password
        $message = urlencode('Password harus sama keduanya');
    } elseif (!$nama) {
        $message = urlencode('Nama tidak boleh kosong');
    } elseif (!$role) {
        $message = urlencode('Role tidak boleh kosong');
    }

    // Jika ada pesan error, langsung redirect dan tampilkan pesan
    if (isset($message)) {
        header("Location: ../users&message={$message}");
        exit;
    }
    // Jika password diisi, lakukan hashing, jika tidak, biarkan password tetap
    if ($password) {
        $pass = password_hash($password, PASSWORD_BCRYPT);
        $user->save($id, $ustadzah_id, $nama, $username, $pass, $role);
    } else {
        $user->save($id, $ustadzah_id, $nama, $username, $userExists['password'], $role);
    }

    $log = new Log();
    $user_id =  $_POST['user_id'];
    $aktivitas =  $_POST['nama'] . " mengubah data user";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Setelah berhasil menyimpan, tampilkan pesan sukses update
    $message = urlencode("Data berhasil diupdate!");
    header("Location: ../users&message={$message}");
    exit;
}

if (isset($_POST['setting_user'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama_user'];
    $username = $_POST['username'];
    $password = $_POST['password1'];
    $password2 = $_POST['password2'];
    $role = $_POST['role'];

    // Inisialisasi kelas Users
    $user = new Users();

    // Cek Username, pastikan jika username diubah, tidak ada yang sama
    $userExists = $user->findByUsername($username);

    // Mulai Validasi
    if ($userExists && $userExists['id'] != $id) {
        // Jika username sudah ada dan bukan milik user yang sedang di-update
        $message = urlencode('Username sudah digunakan');
    } elseif (!$username) {
        $message = urlencode('Username tidak boleh kosong');
    } elseif ($password && $password != $password2) {
        // Validasi password, hanya jika user mengisi password
        $message = urlencode('Password harus sama keduanya');
    } elseif (!$nama) {
        $message = urlencode('Nama tidak boleh kosong');
    } elseif (!$role) {
        $message = urlencode('Role tidak boleh kosong');
    }

    // Jika ada pesan error, langsung redirect dan tampilkan pesan
    if (isset($message)) {
        header("Location: ../users&message={$message}");
        exit;
    }

    // proses upload
    $dataFile = $_FILES['file'];

    // Mendapatkan nama file asli dan ekstensinya
    $fileName = basename($dataFile['name']);
    if ($fileName == "") {
        $newFileName = null;
    } else {
        $fileTmpPath = $dataFile['tmp_name'];
        $fileSize = $dataFile['size'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Daftar ekstensi yang diperbolehkan
        $allowedExtensions = ['jpg', 'jpeg', 'png'];

        // Path untuk menyimpan file di folder assets/foto
        // dirname untuk naik 1 peringkat
        $uploadPath = dirname(__DIR__) . '/assets/foto/';
        // Pastikan direktori ini ada atau dibuat


        // Cek apakah ekstensi diperbolehkan
        if (in_array($fileExtension, $allowedExtensions)) {
            // Buat nama file acak
            $newFileName = uniqid() . '.' . $fileExtension;

            // Pindahkan file ke folder assets/foto
            if (move_uploaded_file($fileTmpPath, $uploadPath . $newFileName)) {
                echo "File berhasil diupload dengan nama $newFileName";
            } else {
                echo "Terjadi kesalahan saat mengupload file.";
            }
        } else {
            echo "Ekstensi file tidak diperbolehkan.";
        }
    }

    // Jika password diisi, lakukan hashing, jika tidak, biarkan password tetap
    if ($password && $newFileName) {
        $pass = password_hash($password, PASSWORD_BCRYPT);
        $user->save($id, $newFileName, $nama, $username, $pass, $role); // Simpan dengan password
    } elseif ($password) {
        $pass = password_hash($password, PASSWORD_BCRYPT);
        $user->save($id, null, $nama, $username, $pass, $role);
    } elseif ($newFileName) {
        $user->save($id, $newFileName, $nama, $username, null, $role);
    } else {
        $user->save($id, null, $nama, $username, null, $role);
    }

    $log = new Log();
    $user_id =  $_POST['user_id'];
    $aktivitas =  $_POST['nama'] . " setting ulang akun";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Setelah berhasil menyimpan, tampilkan pesan sukses update
    $message = urlencode("Data berhasil disetting!");
    header("Location: ../users&action=setting&id={$id}&message={$message}");
    exit;
}

if (isset($_POST['change_password'])) {
    $id = $_POST['id'];
    $password = $_POST['password1'];
    $password2 = $_POST['password2'];

    // Inisialisasi kelas Users
    $user = new Users();

    // Cek Username, pastikan jika username diubah, tidak ada yang sama
    $userExists = $user->findByUsername($username);

    // Mulai Validasi
    if ($password && $password != $password2) {
        // Validasi password, hanya jika user mengisi password
        $message = urlencode('Password harus sama keduanya');
    }

    // Jika ada pesan error, langsung redirect dan tampilkan pesan
    if (isset($message)) {
        header("Location: ../users&action=change_password&id={$id}&message={$message}");
        exit;
    }

    // Jika password diisi, lakukan hashing, jika tidak, biarkan password tetap
    $pass = password_hash($password, PASSWORD_BCRYPT);
    $user->change_password($id, $pass); // Simpan dengan password

    $log = new Log();
    $user_id =  $_POST['user_id'];
    $aktivitas =  $_POST['nama'] . " mengubah password akun!";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Setelah berhasil menyimpan, tampilkan pesan sukses update
    $message = urlencode("Password berhasil diubah!");
    header("Location: ../users&action=change_password&id={$id}&message={$message}");
    exit;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    // Validasi data jika diperlukan

    // Simpan data menggunakan method save dari class users
    $users = new users();
    $users->delete($id);

    $log = new Log();
    $user_id =  $_POST['user_id'];
    $aktivitas =  $_POST['nama'] . " menghapus data user";
    $tanggal = date('Y-m-d H:i:s'); // Perbaikan format tanggal
    $log->save($user_id, $aktivitas, $tanggal);

    // Redirect dengan pesan berhasil
    $message = urlencode("Data berhasil dihapus!");
    header("Location: ../users&message={$message}");
    exit;
}
