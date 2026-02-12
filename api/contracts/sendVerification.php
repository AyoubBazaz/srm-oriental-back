<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

require_once("../../config/db.php");
require_once("../../config/twilio.php");

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

$n_contrat = $data['n_contrat'] ?? '';
$n_tlf = $data['n_tlf'] ?? '';

if (empty($n_contrat) || empty($n_tlf)) {
    echo json_encode(["status" => "error", "message" => "Champs manquants"]);
    exit;
}

$code = (string) rand(1000, 9999);

$stmt = $pdo->prepare("UPDATE contracts SET n_tlf1=?, verification_code=?, verified=0 WHERE n_contrat=?");
$stmt->execute([$n_tlf, $code, $n_contrat]);

if ($stmt->rowCount() === 0) {
    echo json_encode(["status" => "error", "message" => "Contrat introuvable"]);
    exit;
}

$message = "SRM L'Oriental - Votre code de vérification: {$code}";
$to = twilio_normalize_phone($n_tlf);
$smsResult = twilio_send_sms($to, $message, $twilioConfig);
$waResult = twilio_send_whatsapp($to, $message, $twilioConfig);

if (!$smsResult['success'] && !$waResult['success']) {
    $err = $smsResult['error'] ?? $waResult['error'] ?? 'Unknown';
    $hint = (stripos($err, 'verified') !== false || stripos($err, 'Permission') !== false)
        ? ' Sur compte Twilio trial, ajoutez ce numéro dans Console → Verified Caller IDs.'
        : '';
    echo json_encode([
        "status" => "error",
        "message" => "Échec envoi SMS: " . $err . $hint,
        "sms_error" => $smsResult['error'] ?? null,
        "whatsapp_error" => $waResult['error'] ?? null,
    ]);
    exit;
}

echo json_encode(["status" => "success", "message" => "Code envoyé par SMS"]);
