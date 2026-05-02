<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../vendor/autoload.php';

class ChatController
{
    private $db;
    private $pusher;

    public function __construct()
    {
        $this->db = (new Database())->connect();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $this->pusher = new Pusher\Pusher(
            'e5405b1b2139fed6f8bc',
            '2f482d4b39a5f0acd508',
            '2149497',
            $options
        );
    }

    // 1. Gửi tin nhắn
    public function sendMessage()
{
    header('Content-Type: application/json');

    $message = $_POST['message'] ?? '';
    $senderType = $_SESSION['user']['role'] ?? 'customer';
    $senderName = $_SESSION['user']['full_name'] ?? 'Khách vãng lai';
    $departureId = $_POST['departure_id'] ?? null;

    // =========================
    // XÁC ĐỊNH SESSION CHAT
    // =========================
    if ($senderType === 'customer') {

        // Nếu khách đã đăng nhập
        if (isset($_SESSION['user']['user_id'])) {

            $sessionId = 'user_' . $_SESSION['user']['user_id'];

        } else {

            // Khách vãng lai
            if (!isset($_SESSION['chat_session_id'])) {
                $_SESSION['chat_session_id'] = uniqid('chat_');
            }

            $sessionId = $_SESSION['chat_session_id'];
        }

    } else {

        // Admin / Guide / Manager
        $sessionId = $_POST['session_id'] ?? '';
    }

    // =========================
    // KIỂM TRA DỮ LIỆU
    // =========================
    if (!empty($message) && !empty($sessionId)) {

        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $currentTime = date('Y-m-d H:i:s');

        // =========================
        // LƯU TIN NHẮN KHÁCH / ADMIN
        // =========================
        $stmt = $this->db->prepare("
            INSERT INTO chat_messages 
            (session_id, sender_type, sender_name, message, departure_id, created_at) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $sessionId,
            $senderType,
            $senderName,
            $message,
            $departureId,
            $currentTime
        ]);

        // =========================
        // PUSH REALTIME
        // =========================
        $data = [
            'session_id' => $sessionId,
            'sender_type' => $senderType,
            'sender_name' => $senderName,
            'departure_id' => $departureId,
            'message' => htmlspecialchars($message),
            'time' => date('H:i')
        ];

        $this->pusher->trigger('live-chat', 'new-message', $data);

        // ==================================================
        // AUTO REPLY CHO TIN NHẮN ĐẦU TIÊN CỦA KHÁCH
        // ==================================================
        if ($senderType === 'customer') {

            $checkStmt = $this->db->prepare("
                SELECT COUNT(*) as total
                FROM chat_messages
                WHERE session_id = ?
            ");

            $checkStmt->execute([$sessionId]);

            $count = $checkStmt->fetch(PDO::FETCH_ASSOC);

            // Nếu chỉ có đúng 1 tin nhắn => tin đầu tiên
            if ($count['total'] == 1) {

                $autoReply = "🤖 Xin chào! TravelVN đã nhận được tin nhắn của bạn. Nhân viên sẽ phản hồi sớm nhất ❤️";

                $botTime = date('Y-m-d H:i:s');

                // Lưu bot message
                $botStmt = $this->db->prepare("
                    INSERT INTO chat_messages
                    (session_id, sender_type, sender_name, message, departure_id, created_at)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");

                $botStmt->execute([
                    $sessionId,
                    'admin',
                    'TravelVN Bot',
                    $autoReply,
                    $departureId,
                    $botTime
                ]);

                // PUSH BOT MESSAGE REALTIME
                $this->pusher->trigger('live-chat', 'new-message', [
                    'session_id' => $sessionId,
                    'sender_type' => 'admin',
                    'sender_name' => 'TravelVN Bot',
                    'message' => $autoReply,
                    'time' => date('H:i')
                ]);
            }
        }

        echo json_encode(['status' => 'success']);
    }

    exit;
}
    // 2. Lấy danh sách phiên chat
    public function getSessions()
    {
        header('Content-Type: application/json');
        $role = $_SESSION['user']['role'] ?? '';
        $userId = $_SESSION['user']['user_id'] ?? $_SESSION['user']['id'] ?? 0;

        if ($role === 'admin' || $role === 'tour_manager') {
            // ĐÃ SỬA LỖI Ở ĐÂY: Xóa điều kiện OR m1.departure_id = ''
            $sql = "SELECT 
                        m1.session_id, 
                        (SELECT sender_name FROM chat_messages WHERE session_id = m1.session_id ORDER BY message_id ASC LIMIT 1) AS sender_name, 
                        m1.message, 
                        m1.created_at,
                        (SELECT COUNT(*) FROM chat_messages WHERE session_id = m1.session_id AND is_read = 0 AND sender_type = 'customer') AS unread_count
                    FROM chat_messages m1
                    JOIN (SELECT MAX(message_id) as last_id FROM chat_messages GROUP BY session_id) m2 
                    ON m1.message_id = m2.last_id
                    WHERE m1.departure_id IS NULL OR m1.departure_id = 0
                    ORDER BY m1.created_at DESC";
            $stmt = $this->db->query($sql);

        } else if ($role === 'guide') {
            $sql = "SELECT 
                        m1.session_id, 
                        (SELECT sender_name FROM chat_messages WHERE session_id = m1.session_id ORDER BY message_id ASC LIMIT 1) AS sender_name, 
                        m1.message, 
                        m1.created_at,
                        t.tour_name, 
                        (SELECT COUNT(*) FROM chat_messages WHERE session_id = m1.session_id AND is_read = 0 AND sender_type = 'customer') AS unread_count
                    FROM chat_messages m1
                    JOIN (SELECT MAX(message_id) as last_id FROM chat_messages GROUP BY session_id) m2 ON m1.message_id = m2.last_id
                    JOIN departures d ON m1.departure_id = d.departure_id
                    JOIN tours t ON d.tour_id = t.tour_id
                    JOIN departure_guides dg ON d.departure_id = dg.departure_id
                    WHERE dg.guide_id = ?
                    ORDER BY m1.created_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$userId]);
        } else {
            echo json_encode([]);
            exit;
        }

        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    // Hàm đánh dấu đã đọc
    public function markAsRead()
    {
        header('Content-Type: application/json');
        $role = $_SESSION['user']['role'] ?? 'customer';
        
        if ($role === 'customer') {
            if (isset($_SESSION['user']['user_id'])) {
                $sessionId = 'user_' . $_SESSION['user']['user_id'];
            } else {
                $sessionId = $_SESSION['chat_session_id'] ?? '';
            }
            
            if (!empty($sessionId)) {
                $stmt = $this->db->prepare("UPDATE chat_messages SET is_read = 1 WHERE session_id = ? AND sender_type != 'customer'");
                $stmt->execute([$sessionId]);
            }
        } else {
            $sessionId = $_GET['session_id'] ?? $_POST['session_id'] ?? '';
            if (!empty($sessionId)) {
                $stmt = $this->db->prepare("UPDATE chat_messages SET is_read = 1 WHERE session_id = ? AND sender_type = 'customer'");
                $stmt->execute([$sessionId]);
            }
        }
        
        echo json_encode(['status' => 'success']);
        exit;
    }

    // 3. Lấy lịch sử tin nhắn
    public function getHistory()
    {
        header('Content-Type: application/json');
        $role = $_SESSION['user']['role'] ?? 'customer';

        if ($role === 'customer') {
            if (isset($_SESSION['user']['user_id'])) {
                $sessionId = 'user_' . $_SESSION['user']['user_id'];
            } else {
                $sessionId = $_SESSION['chat_session_id'] ?? '';
            }
        } else {
            $sessionId = $_GET['session_id'] ?? '';
        }

        if (empty($sessionId)) {
            echo json_encode([]);
            exit;
        }

        $stmt = $this->db->prepare("SELECT * FROM chat_messages WHERE session_id = ? ORDER BY created_at ASC");
        $stmt->execute([$sessionId]);
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        exit;
    }

    // Xóa toàn bộ lịch sử của một cuộc trò chuyện
    public function deleteSession()
    {
        header('Content-Type: application/json');
        $sessionId = $_POST['session_id'] ?? '';

        if (!empty($sessionId)) {
            $stmt = $this->db->prepare("DELETE FROM chat_messages WHERE session_id = ?");
            if ($stmt->execute([$sessionId])) {
                echo json_encode(['status' => 'success']);
                exit;
            }
        }
        echo json_encode(['status' => 'error']);
        exit;
    }

    // Đếm tổng tin nhắn chưa đọc để hiển thị lên Sidebar
    public function getTotalUnread()
    {
        header('Content-Type: application/json');
        
        // ĐÃ SỬA LỖI Ở ĐÂY: Xóa điều kiện OR departure_id = ''
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM chat_messages WHERE is_read = 0 AND sender_type = 'customer' AND (departure_id IS NULL OR departure_id = 0)");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode(['total' => $result['total'] ?? 0]);
        exit;
    }

    // Đếm số tin nhắn Admin gửi mà Khách chưa đọc
    public function getCustomerUnreadCount()
    {
        header('Content-Type: application/json');
        
        if (isset($_SESSION['user']['user_id'])) {
            $sessionId = 'user_' . $_SESSION['user']['user_id'];
        } else {
            $sessionId = $_SESSION['chat_session_id'] ?? '';
        }

        if (empty($sessionId)) {
            echo json_encode(['total' => 0]);
            exit;
        }

        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM chat_messages WHERE session_id = ? AND is_read = 0 AND sender_type != 'customer'");
        $stmt->execute([$sessionId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo json_encode(['total' => $result['total'] ?? 0]);
        exit;
    }
}