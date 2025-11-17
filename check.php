<?php
header('Content-Type: application/json');
$udid = $_GET['udid'] ?? '';
$data = json_decode(file_get_contents('users.json'), true);

foreach ($data['users'] as $user) {
    if ($user['udid'] === $udid) {
        echo json_encode(["status" => $user['status']]);
        exit;
    }
}

echo json_encode(["status" => "not_found"]);