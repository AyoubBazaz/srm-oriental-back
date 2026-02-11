<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

require_once("../../config/db.php");

$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Aucune donnée reçue"]);
    exit;
}

$identifier = $data['username'] ?? '';
$password = $data['password'] ?? '';

if (empty($identifier) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Champs manquants"]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
$stmt->execute([$identifier, $identifier]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["status" => "error", "message" => "Utilisateur introuvable"]);
    exit;
}

if ($user['password'] !== $password) {
    echo json_encode(["status" => "error", "message" => "Mot de passe incorrect"]);
    exit;
}

echo json_encode([
    "status" => "success",
    "user" => [
        "id" => $user['id'],
        "role" => $user['role'],
        "name" => $user['name'],
        "email" => $user['email'],
    ]
]);
