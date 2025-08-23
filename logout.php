<?php
require_once __DIR__ . '/config/database.php';
session_start();
session_destroy();

header("Location: login.php?message=Anda berhasil logout");
exit;
