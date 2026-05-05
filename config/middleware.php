<?php
if (session_status() === PHP_SESSION_NONE) session_start();

class Middleware {
    // Cấp 1: Chặn khách vãng lai (Bắt buộc đăng nhập)
    public static function auth() {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?action=login");
            exit();
        }
        // Kiểm tra nếu tài khoản bị khóa (Dựa trên AuthController của bạn)
        // Lưu ý: Nên query DB hoặc lưu status vào session để check
    }

    // Cấp 2: Chỉ dành cho Admin
    public static function adminOnly() {
        self::auth();
        if ($_SESSION['user']['role'] !== 'admin') {
            die("Truy cập bị từ chối: Quyền hạn Admin.");
        }
    }

    // Cấp 3: Dành cho Quản lý & Admin (ManagerController)
    public static function managerOnly() {
        self::auth();
        $role = $_SESSION['user']['role'];
        if ($role !== 'tour_manager' && $role !== 'admin') {
            die("Truy cập bị từ chối: Quyền hạn Quản lý.");
        }
    }

    // Cấp 4: Dành cho Hướng dẫn viên (GuideController)
    public static function guideOnly() {
        self::auth();
        if ($_SESSION['user']['role'] !== 'guide' && $_SESSION['user']['role'] !== 'admin') {
            die("Truy cập bị từ chối: Quyền hạn HDV.");
        }
    }
}