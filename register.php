<?php
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);
$udid = $input['udid'] ?? '';
$discord_id = $input['discord_id'] ?? '';

$data = json_decode(file_get_contents('users.json'), true);

foreach ($data['users'] as $user) {
    if ($user['udid'] === $udid) {
        echo json_encode(["message" => "already_registered"]);
        exit;
    }
}

$data['users'][] = [
    "udid" => $udid,
    "discord_id" => $discord_id,
    "status" => "pending"
];
file_put_contents('users.json', json_encode($data, JSON_PRETTY_PRINT));

echo json_encode(["message" => "registered"]);