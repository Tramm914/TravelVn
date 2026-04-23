<?php
// 1. Phải có dòng này ở ĐẦU TIÊN để nhận diện người dùng đã đăng nhập hay chưa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Nhúng các file Controller
require_once '../controllers/TourController.php';
require_once '../controllers/PaymentController.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/ReviewController.php';

// 3. Lấy hành động từ URL
$action = $_GET['action'] ?? 'home';

// =================================================================
// BƯỚC MỚI: XỬ LÝ CÁC TRANG TĨNH (STATIC PAGES) TỪ FOOTER
// =================================================================
switch ($action) {
    case 'about':
    case 'careers':
    case 'blog':
    case 'affiliate':
    case 'guide':
    case 'faq':
    case 'policy':
        // Gọi thẳng file giao diện trong thư mục views
        require_once "../views/{$action}.php";
        exit; // Lệnh exit rất quan trọng: Nó dừng hệ thống tại đây, không chạy xuống phần Controller bên dưới nữa
}
// =================================================================


// 4. Phân luồng Controller cho các trang có xử lý Database
if ($action === 'payment' || $action === 'confirmPayment' || $action === 'webhook' || $action === 'checkPaymentStatus') {
    $c = new PaymentController();
} elseif ($action === 'login' || $action === 'register' || $action === 'logout' || $action === 'profile' || $action === 'updateProfile' || $action === 'updatePassword') {
    $c = new AuthController();
} elseif ($action === 'submitReview') {
    $c = new ReviewController();
} else {
    // Các action: home, tours, detail, booking, confirmBooking, myBookings, bookingDetail
    $c = new TourController();
}

// 5. Kiểm tra hàm có tồn tại không
if (!method_exists($c, $action)) {
    die("404 - Không tìm thấy hành động: " . htmlspecialchars($action) . " trong " . get_class($c));
}

// 6. Chạy hàm
$c->$action();
?>