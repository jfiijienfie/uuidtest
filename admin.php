<?php
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents('users.json'), true);

if ($method === 'GET') {
    echo json_encode($data);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$udid = $input['udid'] ?? '';

if ($method === 'PATCH') {
    foreach ($data['users'] as &$user) {
        if ($user['udid'] === $udid) {
            $user['status'] = $input['status'];
            file_put_contents('users.json', json_encode($data, JSON_PRETTY_PRINT));
            echo json_encode(["message" => "updated"]);
            exit;
        }
    }
}

if ($method === 'DELETE') {
    $data['users'] = array_filter($data['users'], function($u) use ($udid) {
        return $u['udid'] !== $udid;
    });
    file_put_contents('users.json', json_encode($data, JSON_PRETTY_PRINT));
    echo json_encode(["message" => "deleted"]);
}