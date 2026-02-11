<?php
header("Content-Type: application/json");
require_once("../../config/db.php");

$raw = file_get_contents("php://input");
$data = json_decode($raw,true);

$n_contrat = $data['n_contrat'] ?? '';
$n_tlf = $data['n_tlf'] ?? '';

if(empty($n_contrat) || empty($n_tlf)){
    echo json_encode(["status"=>"error","message"=>"Champs manquants"]);
    exit;
}

// إنشاء رمز تحقق عشوائي
$code = rand(1000,9999);

$stmt = $pdo->prepare("UPDATE contracts SET n_tlf1=?, verification_code=?, verified=0 WHERE n_contrat=?");
$stmt->execute([$n_tlf,$code,$n_contrat]);

// هنا يمكنك إضافة WhatsApp / SMS API لإرسال $code
// مثال: Twilio أو أي خدمة

echo json_encode(["status"=>"success","message"=>"Code envoyé","code"=>$code]);
