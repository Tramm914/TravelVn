<?php
require_once "../config/database.php";
require_once "../models/User.php";

class AdminController
{
    private $user;
    private $db; // Khai báo thêm biến $db để dùng cho các truy vấn Chat

    public function __construct()
    {
        $this->db = (new Database())->connect(); // Gán kết nối DB
        $this->user = new User($this->db);
    }

    public function index()
    {
        $users = $this->user->getAllUsers();
        include "../views/admin/users.php";
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->createUser($_POST);
            header("Location: admin.php");
            exit();
        }
        include "../views/admin/create_user.php";
    }

    public function edit()
    {
        $id = $_GET['id'];
        $user = $this->user->getUserById($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->user->updateUser($id, $_POST);
            header("Location: admin.php");
            exit();
        }

        include "../views/admin/edit_user.php";
    }

    public function delete()
    {
        if ($_SESSION['user']['id'] == $_GET['id']) {
            die("Không thể xóa chính mình");
        }

        $this->user->deleteUser($_GET['id']);
        header("Location: admin.php");
    }

    public function toggle()
    {
        $this->user->toggleStatus($_GET['id']);
        header("Location: admin.php");
    }

    public function reset()
    {
        $this->user->resetPassword($_GET['id']);
        header("Location: admin.php");
    }

    // ==========================================
    // PHẦN XỬ LÝ GIAO DIỆN CHAT
    // ==========================================
    public function chat()
    {
        // Khai báo biến này để Sidebar biết đang ở mục nào mà sáng lên
        $activeMenu = 'chat';
        // Trỏ thẳng về file giao diện quản lý chat mà mình đã tạo
        require_once __DIR__ . '/../views/admin/chat_manage.php';
    }

    // ==========================================
    // CÁC API DÀNH CHO TÍNH NĂNG CHAT (AJAX FETCH)
    // ==========================================

    // 1. Lấy danh sách các cuộc trò chuyện (Có đếm số tin nhắn chưa đọc)
    public function getSessions()
    {
        $query = "
            SELECT 
                s.session_id, 
                s.sender_name, 
                s.created_at,
                (SELECT message FROM chat_messages WHERE session_id = s.session_id ORDER BY created_at DESC LIMIT 1) as message,
                (SELECT COUNT(*) FROM chat_messages WHERE session_id = s.session_id AND sender_type = 'customer' AND is_read = 0) AS unread_count
            FROM chat_sessions s
            ORDER BY s.updated_at DESC
        ";
        $stmt = $this->db->query($query);
        $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($sessions);
        exit;
    }

    // 2. Lấy lịch sử tin nhắn của 1 phiên chat cụ thể
    public function getHistory()
    {
        $sessionId = $_GET['session_id'] ?? '';
        if ($sessionId) {
            $stmt = $this->db->prepare("SELECT * FROM chat_messages WHERE session_id = ? ORDER BY created_at ASC");
            $stmt->execute([$sessionId]);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        } else {
            echo json_encode([]);
        }
        exit;
    }

    // 3. Gửi tin nhắn từ Admin cho Khách
    public function sendMessage()
    {
        $sessionId = $_POST['session_id'] ?? '';
        $message = $_POST['message'] ?? '';
        $senderType = $_POST['sender_type'] ?? 'admin';

        if ($sessionId && $message) {
            // Lưu tin nhắn (Mặc định admin gửi thì coi như đã đọc)
            $stmt = $this->db->prepare("INSERT INTO chat_messages (session_id, sender_type, message, created_at, is_read) VALUES (?, ?, ?, NOW(), 1)");
            $stmt->execute([$sessionId, $senderType, $message]);

            // Cập nhật thời gian update của phiên chat để nó nhảy lên đầu danh sách
            $stmtUpdate = $this->db->prepare("UPDATE chat_sessions SET updated_at = NOW() WHERE session_id = ?");
            $stmtUpdate->execute([$sessionId]);

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Thiếu dữ liệu']);
        }
        exit;
    }

    // 4. Đánh dấu tất cả tin nhắn của Khách trong phiên này là ĐÃ ĐỌC
    public function markAsRead()
    {
        $sessionId = $_GET['session_id'] ?? '';
        if ($sessionId) {
            $stmt = $this->db->prepare("UPDATE chat_messages SET is_read = 1 WHERE session_id = ? AND sender_type = 'customer'");
            $stmt->execute([$sessionId]);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    // 5. Xóa toàn bộ cuộc trò chuyện
    public function deleteSession()
    {
        $sessionId = $_POST['session_id'] ?? '';
        if ($sessionId) {
            // Xóa tin nhắn trước (khóa ngoại) rồi xóa session
            $this->db->prepare("DELETE FROM chat_messages WHERE session_id = ?")->execute([$sessionId]);
            $this->db->prepare("DELETE FROM chat_sessions WHERE session_id = ?")->execute([$sessionId]);
            
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }
}
?>