<?php
require_once __DIR__ . '/../config/database.php';

$db = (new Database())->connect();

$data = json_decode(file_get_contents("php://input"), true);

// Log
file_put_contents("sepay_log.txt", json_encode($data) . PHP_EOL, FILE_APPEND);

$content = $data['content'] ?? '';
$amount = (int)($data['transferAmount'] ?? 0);

// Lấy payment_id từ PAY24
preg_match('/PAY(\d+)/', $content, $matches);

if (!isset($matches[1])) {
    http_response_code(400);
    exit("Invalid content");
}

$payment_id = (int)$matches[1];

// ✅ BỎ CHECK amount + status (tránh fail)
$stmt = $db->prepare("SELECT * FROM payments WHERE payment_id = ?");
$stmt->execute([$payment_id]);

$payment = $stmt->fetch(PDO::FETCH_ASSOC);

if ($payment) {
    $update = $db->prepare("
        UPDATE payments 
        SET payment_status = 'paid'
        WHERE payment_id = ?
    ");
    $update->execute([$payment_id]);

    file_put_contents("sepay_log.txt", "UPDATED: PAY$payment_id\n", FILE_APPEND);
}

echo "OK";