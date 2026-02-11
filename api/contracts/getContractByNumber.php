<?php
header("Content-Type: application/json");
require_once("../../config/db.php");

$raw = file_get_contents("php://input");
$data = json_decode($raw,true);

$n_contrat = $data['n_contrat'] ?? '';

if(empty($n_contrat)){
    echo json_encode(["status"=>"error","message"=>"Numéro de contrat manquant"]);
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM contracts WHERE n_contrat=?");
$stmt->execute([$n_contrat]);
$contract = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$contract){
    echo json_encode(["status"=>"error","message"=>"Contrat introuvable"]);
    exit;
}

echo json_encode(["status"=>"success","contract"=>$contract]);
