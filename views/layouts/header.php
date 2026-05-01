<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>TravelVN</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Tùy chỉnh Navbar mang phong cách Traveloka */
        .navbar-custom {
            background-color: #66CCFF;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .navbar-brand {
            color: #0194f3 !important;
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .nav-link-custom {
            color: #434343 !important;
            font-weight: 500;
            padding: 8px 16px !important;
            transition: color 0.3s;
        }

        .nav-link-custom:hover {
            color: #0194f3 !important;
        }

        /* Nút Đăng nhập */
        .btn-login {
            color: #0194f3;
            border: 1px solid #0194f3;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 20px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-login:hover {
            background-color: #f0f8ff;
            color: #007bc2;
        }

        /* Nút Đăng ký */
        .btn-register {
            background-color: #0194f3;
            color: white;
            font-weight: 600;
            border-radius: 8px;
            padding: 8px 20px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-register:hover {
            background-color: #007bc2;
            color: white;
        }

        /* Nút User Dropdown */
        .user-dropdown-toggle {
            background-color: #f4f6f9;
            color: #0194f3 !important;
            font-weight: 600;
            border-radius: 20px;
            padding: 6px 16px !important;
            border: 1px solid #e0e0e0;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light navbar-custom sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <i class="bi bi-globe-americas me-2"></i> TravelVN
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-toggle="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">

                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="index.php?action=tours">
                            <i class="bi bi-map me-1"></i> Khám phá Tours
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="index.php?action=blogs">
                            <i class="bi bi-map me-1"></i> Bài viết
                        </a>
                    </li>
                    <li class="nav-item me-3">
                        <?php
                        $role = $_SESSION['user']['role'] ?? 'customer';
                        $supportLink = 'javascript:void(0);'; 
                        $onClick = 'toggleChat()'; 
                        
                        if ($role == 'admin') {
                            $supportLink = 'admin.php?action=chat';
                            $onClick = '';
                        } elseif ($role == 'tour_manager') {
                            $supportLink = 'manager.php?action=chat';
                            $onClick = '';
                        } elseif ($role == 'guide') {
                            $supportLink = 'guide.php?action=chat';
                            $onClick = '';
                        }
                        ?>
                        <a class="nav-link nav-link-custom" href="<?= $supportLink ?>" onclick="<?= $onClick ?>">
                            <i class="bi bi-headset me-1"></i> Hỗ trợ
                            <!-- BỔ SUNG BADGE SỐ ĐẾM Ở ĐÂY -->
                            <span id="customer-chat-badge" class="badge bg-danger rounded-pill ms-1 d-none" style="font-size: 0.7rem;">0</span>
                        </a>
                    </li>
                    
                    <?php if (isset($_SESSION['user'])): ?>

                        <?php if ($_SESSION['user']['role'] == 'tour_manager'): ?>
                            <li class="nav-item">
                                <a class="nav-link nav-link-custom fw-semibold text-warning"
                                    href="manager.php?action=dashboard">
                                    <i class="bi bi-gear-fill me-1"></i> Quản lý
                                </a>
                            </li>

                        <?php elseif ($_SESSION['user']['role'] == 'guide'): ?>
                            <li class="nav-item">
                                <a class="nav-link nav-link-custom fw-semibold text-success" href="guide.php?action=schedule">
                                    <i class="bi bi-briefcase-fill me-1"></i> Công
                                    việc
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-danger fw-bold" href="#" role="button"
                                    data-bs-toggle="dropdown">
                                    <i class="bi bi-shield-lock-fill me-1"></i> Admin
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow">
                                    <li>
                                        <a class="dropdown-item" href="admin.php">
                                            <i class="bi bi-people me-2"></i> Quản lý User
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="manager.php?action=dashboard">
                                            <i class="bi bi-briefcase me-2"></i> Quản lý Tour
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                    <?php endif; ?>

                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle user-dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i>
                                <?= htmlspecialchars($_SESSION['user']['full_name'] ?? 'Người dùng') ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item py-2" href="index.php?action=profile"><i
                                            class="bi bi-person me-2"></i>Tài khoản của tôi</a></li>
                                <li><a class="dropdown-item py-2" href="index.php?action=myBookings"><i
                                            class="bi bi-bag-check me-2"></i>Chuyến đi của tôi </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item py-2 text-danger" href="index.php?action=logout"><i
                                            class="bi bi-box-arrow-right me-2"></i>Đăng xuất</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item d-flex gap-2 mt-3 mt-lg-0">
                            <a class="btn-login" href="index.php?action=login">Đăng nhập</a>
                            <a class="btn-register" href="index.php?action=register">Đăng ký</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>
<!-- Load thư viện Pusher nếu file này chưa có -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    // 1. Hàm gọi API lấy số lượng tin nhắn chưa đọc
    function updateCustomerChatBadge() {
        fetch('index.php?action=getCustomerUnreadCount')
            .then(res => res.json())
            .then(data => {
                const badge = document.getElementById('customer-chat-badge');
                if (badge) {
                    if (data.total > 0) {
                        badge.innerText = data.total;
                        badge.classList.remove('d-none');
                    } else {
                        badge.classList.add('d-none');
                    }
                }
            })
            .catch(err => console.error("Lỗi lấy badge chat:", err));
    }

    // 2. Hàm xử lý khi khách hàng bấm vào nút "Hỗ trợ"
    function toggleChat() {
        // GIẢ SỬ: Bạn đang dùng một the div có id="chat-container" làm khung chat
        // và muốn ẩn/hiện nó khi bấm nút. Hãy sửa id này cho đúng với code HTML của bạn nhé!
        const chatBox = document.getElementById('chat-container'); 
        if (chatBox) {
            chatBox.classList.toggle('d-none');
        }

        // Báo cho Server biết khách đã mở xem tin nhắn để đánh dấu "đã đọc"
        fetch('index.php?action=markAsRead', { method: 'POST' })
            .then(response => response.json())
            .then(data => {
                // Nếu update thành công, lập tức ẩn cái badge đỏ đi
                if (data.status === 'success') {
                    const badge = document.getElementById('customer-chat-badge');
                    if (badge) {
                        badge.classList.add('d-none');
                        badge.innerText = '0';
                    }
                }
            })
            .catch(error => console.error('Lỗi khi đánh dấu đã đọc:', error));
    }

    // 3. Khởi tạo khi trang tải xong
    document.addEventListener("DOMContentLoaded", function() {
        // Load số lượng ban đầu
        updateCustomerChatBadge();
        
        // Cài đặt Pusher để nghe tin nhắn realtime
        var pusher = new Pusher('dfb02b6665ceae1b4add', { cluster: 'ap1' });
        var chatChannel = pusher.subscribe('live-chat');
        
        chatChannel.bind('new-message', function (data) {
            // Nếu có tin nhắn mới từ Admin, kiểm tra và cập nhật lại số trên badge
            if (data.sender_type !== 'customer') {
                updateCustomerChatBadge();
            }
        });
    });
</script>
    <div class="main-content">
