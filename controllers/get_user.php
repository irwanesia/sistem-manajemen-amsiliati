<?php
require_once __DIR__ . '/../config/database.php';
header('Content-Type: application/json');
require('../models/Absensi.php');

if(isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $absensi = new Absensi();
  $user = $absensi->findById($id); // Fungsi Anda yang mengambil data user dari database
  echo json_encode($user);
}
?>