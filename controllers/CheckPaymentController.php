<?php
require_once __DIR__ . '/../config/database.php';

class CheckPaymentController {
    public function check() {
        $db = (new Database())->connect();

        $id = $_GET['payment_id'];

        $stmt = $db->prepare("SELECT payment_status FROM payments WHERE payment_id = ?");
        $stmt->execute([$id]);

        echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    }
}