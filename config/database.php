<?php
// Update these settings after creating the database in phpMyAdmin.
$host = 'localhost';
$db = 'sims_db';
$user = 'root';
$pass = '';
try { $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]); }
catch (PDOException $e) { exit('Database connection failed. Check config/database.php'); }
