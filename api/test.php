<?php
include("../config/db.php");  // استدعاء ملف الاتصال
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

echo json_encode([
    "status" => "success",
    "message" => "Backend يعمل و الاتصال بقاعدة البيانات ناجح"
]);
