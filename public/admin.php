<?php
session_start();
$allowedRoles = ['admin', 'tour_manager', 'guide'];
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], $allowedRoles)) {
    die("Bạn không có quyền truy cập vào khu vực hỗ trợ khách hàng.");
}

require_once "../controllers/AdminController.php";
// 🔥 NHÚNG THÊM ChatController
require_once "../controllers/ChatController.php";
require_once '../config/helpers.php';
$controller = new AdminController();
// 🔥 KHỞI TẠO ChatController
$chatController = new ChatController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create':
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'toggle':
        $controller->toggle();
        break;
    case 'reset':
        $controller->reset();
        break;

    // =======================================================
   // =======================================================
    // 🔥 CÁC CASE DÀNH CHO CHAT (SỬA Ở ĐÂY)
    // =======================================================
    case 'chat':
        $controller->chat(); 
        break;

    // Đổi hết $chatController thành $controller
    case 'getSessions':
        $controller->getSessions();
        break;

    case 'getHistory':
        $controller->getHistory();
        break;

    case 'sendMessage':
        $controller->sendMessage();
        break;

    case 'markAsRead':
        $controller->markAsRead();
        break;
        
    case 'deleteSession':
        $controller->deleteSession();
        break;
    
    default:
        $controller->index();

}