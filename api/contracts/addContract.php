<?php
header("Content-Type: application/json");
require_once("../../config/db.php");

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

$required = ['agence','n_client','n_contrat','nom','prenom','cin','n_tlf1','n_tlf2'];
foreach($required as $field){
    if(empty($data[$field])){
        echo json_encode(["status"=>"error","message"=>"Champ manquant: $field"]);
        exit;
    }
}

$stmt = $pdo->prepare("INSERT INTO contracts (agence,n_client,n_contrat,nom,prenom,cin,n_tlf1,n_tlf2) VALUES (?,?,?,?,?,?,?,?)");
$stmt->execute([
    $data['agence'], $data['n_client'], $data['n_contrat'],
    $data['nom'], $data['prenom'], $data['cin'],
    $data['n_tlf1'], $data['n_tlf2']
]);

echo json_encode(["status"=>"success","message"=>"Contrat ajouté"]);
