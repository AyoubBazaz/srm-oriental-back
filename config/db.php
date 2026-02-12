<?php
$host = "127.0.0.1";
$dbname = "react_contracts_db"; // ← اسم قاعدة البيانات
$username = "root";
$password = "Ayoub@123";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erreur connexion DB"]);
    exit;
}
