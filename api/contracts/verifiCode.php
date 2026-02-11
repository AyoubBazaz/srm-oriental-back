<?php
header("Content-Type: application/json");
require_once("../../config/db.php");

$raw = file_get_contents("php://input");
$data = json_decode($raw,true);

$n_contrat = $data['n_contrat'] ?? '';
$code = $data['code'] ?? '';

if(empty($n_contrat) || empty($code)){
    echo json_encode(["status"=>"error","message"=>"Champs manquants"]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM contracts WHERE n_contrat=? AND verification_code=?");
$stmt->execute([$n_contrat,$code]);
$contract = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$contract){
    echo json_encode(["status"=>"error","message"=>"Code incorrect"]);
    exit;
}

$stmt = $pdo->prepare("UPDATE contracts SET verified=1 WHERE n_contrat=?");
$stmt->execute([$n_contrat]);

echo json_encode(["status"=>"success","message"=>"Numéro vérifié"]);
