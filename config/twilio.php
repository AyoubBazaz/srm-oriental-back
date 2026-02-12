<?php
/**
 * Twilio helper: send SMS and WhatsApp via REST API (no Composer required).
 * Load credentials from twilio_config.php if present.
 */
$twilioConfig = [];
$configPath = __DIR__ . '/twilio_config.php';
if (file_exists($configPath)) {
    $twilioConfig = require $configPath;
} else {
    $twilioConfig = [
        'account_sid'   => getenv('TWILIO_ACCOUNT_SID') ?: '',
        'auth_token'    => getenv('TWILIO_AUTH_TOKEN') ?: '',
        'from_sms'      => getenv('TWILIO_FROM_SMS') ?: '',
        'from_whatsapp' => getenv('TWILIO_FROM_WHATSAPP') ?: 'whatsapp:+14155238886',
    ];
}

function twilio_send_sms(string $to, string $body, array $config): array {
    if (empty($config['account_sid']) || empty($config['auth_token']) || empty($config['from_sms'])) {
        return ['success' => false, 'error' => 'Twilio SMS not configured'];
    }
    $sid = $config['account_sid'];
    $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";
    $auth = base64_encode($config['account_sid'] . ':' . $config['auth_token']);
    $bodyParams = http_build_query([
        'To'   => $to,
        'From' => $config['from_sms'],
        'Body' => $body,
    ]);
    $ctx = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\nAuthorization: Basic {$auth}\r\n",
            'content' => $bodyParams,
        ],
    ]);
    $response = @file_get_contents($url, false, $ctx);
    if ($response === false) {
        return ['success' => false, 'error' => 'SMS request failed'];
    }
    $data = json_decode($response, true);
    if (!empty($data['sid'])) {
        return ['success' => true];
    }
    return ['success' => false, 'error' => $data['message'] ?? $response];
}

function twilio_send_whatsapp(string $to, string $body, array $config): array {
    if (empty($config['account_sid']) || empty($config['auth_token']) || empty($config['from_whatsapp'])) {
        return ['success' => false, 'error' => 'Twilio WhatsApp not configured'];
    }
    $sid = $config['account_sid'];
    $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";
    $auth = base64_encode($config['account_sid'] . ':' . $config['auth_token']);
    $toWhatsApp = (strpos($to, 'whatsapp:') === 0) ? $to : 'whatsapp:' . $to;
    $bodyParams = http_build_query([
        'To'   => $toWhatsApp,
        'From' => $config['from_whatsapp'],
        'Body' => $body,
    ]);
    $ctx = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\nAuthorization: Basic {$auth}\r\n",
            'content' => $bodyParams,
        ],
    ]);
    $response = @file_get_contents($url, false, $ctx);
    if ($response === false) {
        return ['success' => false, 'error' => 'WhatsApp request failed'];
    }
    $data = json_decode($response, true);
    if (!empty($data['sid'])) {
        return ['success' => true];
    }
    return ['success' => false, 'error' => $data['message'] ?? $response];
}

/**
 * Normalize phone to E.164 for Twilio (To = number that receives the SMS).
 * Examples: 0611223344 -> +212611223344, 8777804236 -> +18777804236, 212612345678 -> +212612345678
 */
function twilio_normalize_phone(string $phone): string {
    $phone = preg_replace('/\D/', '', $phone);
    if (strlen($phone) === 0) {
        return $phone;
    }
    // Morocco: 0xxxxxxxx (10 digits) or 6/7xxxxxxxx (9 digits) or 212...
    if (strlen($phone) === 10 && $phone[0] === '0') {
        return '+212' . substr($phone, 1);
    }
    if (strlen($phone) === 9 && in_array($phone[0], ['6', '7'], true)) {
        return '+212' . $phone;
    }
    if (substr($phone, 0, 3) === '212' && strlen($phone) >= 12) {
        return '+' . $phone;
    }
    // US/Canada: 1xxxxxxxxxx (11 digits) or xxxxxxxxxx (10 digits)
    if (strlen($phone) === 11 && $phone[0] === '1') {
        return '+' . $phone;
    }
    if (strlen($phone) === 10 && in_array($phone[0], ['2', '3', '4', '5', '6', '7', '8', '9'], true)) {
        return '+1' . $phone;
    }
    return '+' . $phone;
}
