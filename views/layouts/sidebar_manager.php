<?php
// --- BỔ SUNG LOGIC CHỌN ROUTER DỰA TRÊN ROLE ---
$role = $_SESSION['user']['role'] ?? '';
$userName = $_SESSION['user']['full_name'] ?? 'Quản trị viên';

// Xác định file router và tên hiển thị chức vụ
if ($role === 'admin') {
    $baseRouter = 'admin.php';
    $displayRole = 'Admin System';
} else {
    $baseRouter = 'manager.php';
    $displayRole = 'Tour Manager';
}

$activeMenu = $activeMenu ?? 'dashboard';
?>
<style>
    /* --- CSS CHỈ DÀNH RIÊNG CHO SIDEBAR --- */
    .admin-sidebar {
        /* Dùng fallback color phòng trường hợp trang thiếu biến :root */
        background: var(--admin-surface, #ffffff);
        border-radius: 20px;
        border: 1px solid var(--admin-border, #e2e8f0);
        padding: 24px 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        height: 100%;
        z-index: 10;
    }

    .admin-profile {
        text-align: center;
        padding-bottom: 20px;
        border-bottom: 1px dashed var(--admin-border, #e2e8f0);
        margin-bottom: 20px;
    }

    .admin-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--admin-primary, #0194f3), #00d2ff);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 800;
        margin: 0 auto 15px;
        box-shadow: 0 4px 10px rgba(1, 148, 243, 0.3);
    }

    .admin-menu {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .admin-menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 12px;
        color: var(--admin-text-muted, #475569);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .admin-menu-item i {
        font-size: 1.25rem;
        transition: 0.2s;
    }

    .admin-menu-item:hover {
        background-color: var(--admin-bg, #f1f5f9);
        color: var(--admin-text-main, #0f172a);
    }

    .admin-menu-item.active {
        background-color: var(--admin-primary-light, #eef7ff);
        color: var(--admin-primary, #0194f3);
    }

    .admin-menu-item.active i {
        color: var(--admin-primary, #0194f3);
    }
</style>

<div class="col-lg-3">
    <div class="admin-sidebar sticky-top" style="top: 100px;">
        <div class="admin-profile">
            <div class="admin-avatar">
                <?= mb_strtoupper(mb_substr($userName ?? 'A', 0, 1, 'UTF-8')) ?>
            </div>
            <h5 class="fw-bold mb-1 text-dark">
                <?php
                // Ưu tiên 1: Biến truyền từ Controller
                // Ưu tiên 2: Tên từ Session (Tên thật của bạn)
                // Ưu tiên 3: Chữ mặc định
                echo htmlspecialchars($userName ?? $_SESSION['user']['full_name'] ?? 'Quản trị viên');
                ?>
            </h5>
            <span class="badge bg-light text-primary border border-primary">Admin System</span>
        </div>

        <div class="admin-menu">
            <?php $activeMenu = $activeMenu ?? 'dashboard'; // Mặc định là dashboard nếu không khai báo ?>

            <a href="/manager.php?action=dashboard"
                class="admin-menu-item <?= ($activeMenu === 'dashboard') ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> Tổng quan
            </a>
            <a href="/manager.php?action=tours"
                class="admin-menu-item <?= ($activeMenu === 'tours') ? 'active' : '' ?>">
                <i class="bi bi-map"></i> Quản lý Tour
            </a>
            <a href="/manager.php?action=departures"
                class="admin-menu-item <?= ($activeMenu === 'departures') ? 'active' : '' ?>">
                <i class="bi bi-calendar2-week"></i> Vận hành & Lịch trình
            </a>
            <a href="/manager.php?action=bookings"
                class="admin-menu-item <?= ($activeMenu === 'bookings') ? 'active' : '' ?>">
                <i class="bi bi-receipt-cutoff"></i> Đơn đặt (Bookings)
            </a>
            <a href="/manager.php?action=partners"
                class="admin-menu-item <?= ($activeMenu === 'partners') ? 'active' : '' ?>">
                <i class="bi bi-buildings"></i> Đối tác dịch vụ
            </a>
            <a href="/manager.php?action=blogs"
                class="admin-menu-item <?= ($activeMenu === 'blogs') ? 'active' : '' ?>">
                <i class="bi bi-journal-text"></i> Quản lý Bài viết
            </a>
            <a href="<?= $baseRouter ?>?action=chat"
                class="admin-menu-item <?= ($activeMenu === 'chat') ? 'active' : '' ?>">
                <i class="bi bi-chat-left-dots-fill"></i> Tin nhắn hỗ trợ
                <!-- BỔ SUNG SPAN NÀY DÀNH CHO SỐ LƯỢNG CHƯA ĐỌC -->
                <span id="sidebar-chat-badge" class="badge bg-danger ms-auto d-none" style="font-size: 0.75rem; border-radius: 50px; padding: 4px 8px;">0</span>
            </a>
            <a href="/manager.php?action=report"
                class="admin-menu-item <?= ($activeMenu === 'report') ? 'active' : '' ?>">
                <i class="bi bi-graph-up-arrow"></i> Báo cáo doanh thu
            </a>
        </div>
    </div>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<div class="toast-container position-fixed bottom-0 end-0 p-4" style="z-index: 9999;">
    <div id="bookingToast" class="toast align-items-center text-white border-0 shadow-lg"
        style="background-color: #10b981; border-radius: 12px;" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex p-2">
            <div class="toast-body fw-bold fs-6" id="toastMessage">
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    // Bật log để debug
    Pusher.logToConsole = true;

    var pusher = new Pusher('dfb02b6665ceae1b4add', {
        cluster: 'ap1' 
    });

    // 1. KÊNH THÔNG BÁO ĐẶT TOUR
    var adminChannel = pusher.subscribe('admin-channel');
    adminChannel.bind('new-booking', function (data) {
        document.getElementById('toastMessage').innerText = data.message;
        const toast = new bootstrap.Toast(document.getElementById('bookingToast'), { delay: 10000 });
        toast.show();
    });

    // ========================================================
    // 2. KÊNH THÔNG BÁO TIN NHẮN (BỔ SUNG)
    // ========================================================
    var chatChannel = pusher.subscribe('live-chat');
    chatChannel.bind('new-message', function (data) {
        // Chỉ hiện thông báo nếu người gửi là khách hàng (customer)
        if (data.sender_type === 'customer') {
            
            // Hiện Toast thông báo có tin nhắn mới (Bạn có thể đổi màu background của toast nếu thích)
            document.getElementById('toastMessage').innerText = "💬 Tin nhắn mới từ " + data.sender_name + ": " + data.message;
            const toast = new bootstrap.Toast(document.getElementById('bookingToast'), { delay: 5000 });
            toast.show();

            // Cập nhật lại số lượng badge đỏ trên Sidebar
            updateSidebarChatBadge();
        }
    });

    // Hàm gọi API lấy tổng số tin nhắn chưa đọc
    function updateSidebarChatBadge() {
        // Tự động nhận diện đang ở admin hay manager
        let apiUrl = '<?= $baseRouter ?>'; 
        
        fetch(apiUrl + '?action=getTotalUnread')
            .then(res => res.json())
            .then(data => {
                const badge = document.getElementById('sidebar-chat-badge');
                if (data.total > 0) {
                    badge.innerText = data.total;
                    badge.classList.remove('d-none'); // Hiện cục đỏ lên
                } else {
                    badge.classList.add('d-none'); // Ẩn cục đỏ đi nếu không có
                }
            })
            .catch(err => console.error("Lỗi lấy badge chat:", err));
    }

    // Tự động gọi hàm này ngay khi load trang (dù đang ở trang Tổng quan hay Booking...)
    document.addEventListener("DOMContentLoaded", function() {
        updateSidebarChatBadge();
    });

</script>