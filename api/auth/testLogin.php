<?php

$data = [
    "email" => "admin@mail.com",
    "password" => "1234"
];

$options = [
    "http" => [
        "header"  => "Content-Type: application/json",
        "method"  => "POST",
        "content" => json_encode($data),
    ]
];

$context  = stream_context_create($options);
$result = file_get_contents("http://localhost:8080/backend/api/auth/login.php", false, $context);

echo $result;
