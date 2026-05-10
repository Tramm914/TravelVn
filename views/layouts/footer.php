</div>
<style>
    /* --- PREMIUM FOOTER --- */
    .footer-custom {
        background-color: #ceefff;
        border-top: 1px solid #e2e8f0;
        color: #475569;
        font-family: 'Inter', 'Segoe UI', sans-serif;
        margin-top: 60px;
    }

    .footer-top {
        padding: 60px 0 40px;
    }

    .footer-brand {
        font-size: 1.8rem;
        font-weight: 800;
        color: #0194f3;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .footer-title {
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 20px;
        font-size: 1.15rem;
    }

    .footer-links,
    .footer-contact {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li,
    .footer-contact li {
        margin-bottom: 15px;
    }

    .footer-links a {
        color: #64748b;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .footer-links a:hover {
        color: #0194f3;
        transform: translateX(5px);
    }

    .footer-contact li {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        line-height: 1.6;
    }

    .footer-contact i {
        color: #0194f3;
        font-size: 1.2rem;
        margin-top: 2px;
    }

    /* Social Icons */
    .social-links {
        display: flex;
        gap: 12px;
        margin-top: 25px;
    }

    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e2e8f0;
        color: #475569;
        text-decoration: none;
        transition: 0.3s;
        font-size: 1.1rem;
    }

    .social-icon:hover {
        background-color: #0194f3;
        color: white;
        transform: translateY(-4px);
        box-shadow: 0 4px 10px rgba(1, 148, 243, 0.3);
    }

    /* Footer Bottom */
    .footer-bottom {
        background-color: #e2f8ff;
        padding: 20px 0;
        font-size: 0.95rem;
        border-top: 1px solid #e2e8f0;
    }

    .payment-methods {
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .payment-methods i {
        font-size: 1.8rem;
        color: #94a3b8;
        transition: 0.3s;
    }

    .payment-methods i:hover {
        color: #0194f3;
    }

    /* ================= CSS KHUNG CHAT ================= */
    .chat-widget {
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 1050;
    }

    .chat-button {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0194f3, #00d2ff);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(1, 148, 243, 0.4);
        font-size: 26px;
        cursor: pointer;
        transition: transform 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat-button:hover {
        transform: scale(1.1);
    }

    .chat-panel {
        display: none;
        width: 340px;
        height: 450px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        flex-direction: column;
        position: absolute;
        bottom: 75px;
        right: 0;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }

    .chat-header {
        background: #0194f3;
        color: white;
        padding: 16px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-body {
        flex: 1;
        padding: 16px;
        overflow-y: auto;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .chat-footer {
        padding: 12px;
        border-top: 1px solid #e2e8f0;
        background: white;
    }

    .chat-footer form {
        display: flex;
        gap: 8px;
        margin: 0;
    }

    .chat-input {
        flex: 1;
        border: 1px solid #cbd5e1;
        border-radius: 20px;
        padding: 10px 16px;
        outline: none;
        transition: border-color 0.2s;
    }

    .chat-input:focus {
        border-color: #0194f3;
    }

    .chat-submit {
        background: #0194f3;
        color: white;
        border: none;
        border-radius: 50%;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .msg-bubble {
        max-width: 80%;
        padding: 10px 14px;
        border-radius: 16px;
        font-size: 0.95rem;
        line-height: 1.4;
        word-wrap: break-word;
    }

    .msg-customer {
        background: #0194f3;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }

    .msg-admin {
        background: #e2e8f0;
        color: #0f172a;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
    }
</style>

<footer class="footer-custom">
    <div class="footer-top">
        <div class="container">
            <div class="row g-5">

                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <i class="bi bi-globe-americas"></i> TravelVN
                    </div>
                    <p class="text-muted pe-lg-4" style="line-height: 1.7;">
                        TravelVN tự hào là nền tảng đặt tour du lịch hàng đầu, mang đến cho bạn những trải nghiệm khám
                        phá thế giới tuyệt vời với chi phí tối ưu và dịch vụ tận tâm nhất.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-icon" title="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon" title="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon" title="YouTube"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="social-icon" title="TikTok"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-title">Về TravelVN</h5>
                    <ul class="footer-links">
                        <li><a href="index.php?action=about">Giới thiệu</a></li>
                        <li><a href="index.php?action=careers">Tuyển dụng</a></li>
                        <li><a href="index.php?action=blogs">Tin tức du lịch</a></li>
                        <li><a href="index.php?action=affiliate">Chương trình đại lý</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Hỗ trợ khách hàng</h5>
                    <ul class="footer-links">
                        <li><a href="index.php?action=guide">Hướng dẫn đặt tour</a></li>
                        <li><a href="index.php?action=faq">Câu hỏi thường gặp (FAQ)</a></li>
                        <li><a href="index.php?action=policy">Chính sách hoàn/hủy</a></li>
                        <li><a href="index.php?action=policy">Quy chế hoạt động</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Thông tin liên hệ</h5>
                    <ul class="footer-contact">
                        <li>
    <i class="bi bi-geo-alt-fill"></i>
    <a href="https://www.google.com/maps/search/?api=1&query=123+Nguyễn+Văn+Bảo,+Quận+Gò Vấp,+TP.HCM"
   target="_blank"
   rel="noopener noreferrer"
   style="text-decoration: none; color: inherit;">
    Tòa nhà TravelVN, 12 Nguyễn Văn Bảo, quận Gò Vấp, TP.HCM
</a>
</li>
                        <li>
                            <i class="bi bi-telephone-fill"></i>
                            <span>Hotline: <strong>1900 1234</strong><br><small>(Hỗ trợ 24/7)</small></span>
                        </li>
                        <li>
                            <i class="bi bi-envelope-fill"></i>
                            <span>support@travelvn.com</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
            <p class="mb-3 mb-md-0 fw-medium">© 2026 TravelVN. Đã đăng ký bản quyền.</p>
            <div class="payment-methods">
                <i class="bi bi-credit-card-fill" title="Thẻ tín dụng"></i>
                <i class="bi bi-cash-coin" title="Tiền mặt"></i>
                <i class="bi bi-qr-code-scan" title="Quét mã QR"></i>
                <i class="bi bi-wallet-fill" title="Ví điện tử"></i>
            </div>
        </div>
    </div>
</footer>

<div class="chat-widget">
    <div class="chat-panel" id="chatPanel">
        <div class="chat-header">
            <span><i class="bi bi-headset me-2"></i>Hỗ trợ TravelVN</span>
            <i class="bi bi-x-lg" style="cursor:pointer" onclick="toggleChat()"></i>
        </div>
        <div class="chat-body" id="chatBody">
            <div class="text-center text-muted small mt-2 mb-3">Chào mừng bạn đến với TravelVN. Chúng tôi có thể giúp gì
                cho bạn?</div>
        </div>
        <div class="chat-footer">
    <form id="chatForm" onsubmit="sendChatMessage(event)">
        <!-- Input ẩn để lưu ID tour khách đang tham gia/hỏi -->
        <input type="hidden" id="chatDepartureId" value="<?php echo $_GET['departure_id'] ?? ''; ?>">
        
        <input type="text" id="chatInput" class="chat-input" placeholder="Nhập tin nhắn..." required
            autocomplete="off">
        <button type="submit" class="chat-submit"><i class="bi bi-send-fill"></i></button>
    </form>
</div>
    </div>

    <?php
    // 1. Lấy tên file hiện tại (index.php, admin.php, v.v.)
    $currentPage = basename($_SERVER['PHP_SELF']);

    // 2. Lấy action hiện tại (login, register, v.v.)
    $currentAction = $_GET['action'] ?? '';

    // 3. Danh sách các "vùng cấm" không cho hiện bong bóng chat
    $excludedPages = ['admin.php', 'manager.php', 'guide.php'];
    $excludedActions = ['login', 'register'];

    // 4. Chỉ hiển thị nếu KHÔNG thuộc danh sách cấm
    if (!in_array($currentPage, $excludedPages) && !in_array($currentAction, $excludedActions)):
        ?>

        <div class="chat-widget" id="chatWidget">
            <!-- 🔥 BỔ SUNG: Class position-relative để gắn số đếm góc trên -->
            <button class="chat-button position-relative" onclick="toggleChat()">
                <i class="bi bi-chat-dots-fill"></i>
                <!-- 🔥 BỔ SUNG: Chấm đỏ trên nút bong bóng -->
                <span id="bubble-chat-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" style="font-size: 0.7rem; border: 2px solid white;">0</span>
            </button>
        </div>

    <?php endif; ?>
</div>

<!-- Load thư viện Pusher 1 lần duy nhất -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script>
    const chatPanel = document.getElementById('chatPanel');
    const chatBody = document.getElementById('chatBody');
    const chatInput = document.getElementById('chatInput');
    let isChatOpen = false;
    let mySessionId = ''; // Biến để lưu ID phiên chat của khách hàng

    // Lấy Session ID hiện tại của khách từ Server khi load trang
    fetch('index.php?action=getHistory')
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                mySessionId = data[0].session_id; // Lấy session_id từ tin nhắn đầu tiên
            }
        });


    // 1. Hàm gọi API lấy số lượng tin nhắn chưa đọc
    function updateCustomerChatBadge() {
        fetch('index.php?action=getCustomerUnreadCount')
            .then(res => res.json())
            .then(data => {
                const navBadge = document.getElementById('customer-chat-badge');
                const bubbleBadge = document.getElementById('bubble-chat-badge'); 
                
                if (data.total > 0) {
                    if (navBadge) { navBadge.innerText = data.total; navBadge.classList.remove('d-none'); }
                    if (bubbleBadge) { bubbleBadge.innerText = data.total; bubbleBadge.classList.remove('d-none'); }
                } else {
                    if (navBadge) navBadge.classList.add('d-none');
                    if (bubbleBadge) bubbleBadge.classList.add('d-none');
                }
            })
            .catch(err => console.error("Lỗi lấy badge chat:", err));
    }

    // 2. Hàm mở/đóng khung chat
    function toggleChat() {
        isChatOpen = !isChatOpen;
        chatPanel.style.display = isChatOpen ? 'flex' : 'none';
        
        if (isChatOpen) {
            loadChatHistory();

            // Đánh dấu đã đọc
            fetch('index.php?action=markAsRead', { method: 'POST' })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const navBadge = document.getElementById('customer-chat-badge');
                        const bubbleBadge = document.getElementById('bubble-chat-badge');
                        if (navBadge) { navBadge.classList.add('d-none'); navBadge.innerText = '0'; }
                        if (bubbleBadge) { bubbleBadge.classList.add('d-none'); bubbleBadge.innerText = '0'; }
                    }
                })
                .catch(error => console.error('Lỗi khi đánh dấu đã đọc:', error));
        }
    }

    // 3. Hàm in tin nhắn ra màn hình
    function appendMessage(type, text) {
        const div = document.createElement('div');
        div.className = `msg-bubble msg-${type}`;
        div.innerText = text;
        chatBody.appendChild(div);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    // 4. Hàm load lịch sử
    function loadChatHistory() {
        fetch('index.php?action=getHistory')
            .then(response => response.json())
            .then(data => {
                chatBody.innerHTML = '<div class="text-center text-muted small mt-2 mb-3">Bắt đầu trò chuyện với TravelVN</div>';
                data.forEach(msg => {
                    appendMessage(msg.sender_type, msg.message);
                });
            });
    }

    /// 5. Hàm gửi tin nhắn
    function sendChatMessage(e) {
        e.preventDefault();
        const msg = chatInput.value.trim();
        // Lấy giá trị departure_id
        const departureId = document.getElementById('chatDepartureId') ? document.getElementById('chatDepartureId').value : '';

        if (!msg) return;

        appendMessage('customer', msg); // Vẽ ngay lập tức
        chatInput.value = '';

        const formData = new FormData();
        formData.append('message', msg);
        formData.append('sender_type', 'customer');
        
        // 🔥 SỬA Ở ĐÂY: Chỉ gửi departure_id nếu nó có giá trị (tránh lỗi Database)
        if (departureId !== '') {
            formData.append('departure_id', departureId);
        }

        fetch('index.php?action=sendMessage', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                // Xử lý khi tin nhắn gửi thành công
                if (mySessionId === '' && data.status === 'success') {
                     fetch('index.php?action=getHistory')
                        .then(res => res.json())
                        .then(history => {
                            if (history.length > 0) {
                                mySessionId = history[0].session_id; // Cập nhật Session
                                
                                // Vẽ lại toàn bộ tin nhắn để hiển thị tin nhắn của Bot vừa tạo
                                chatBody.innerHTML = '<div class="text-center text-muted small mt-2 mb-3">Bắt đầu trò chuyện với TravelVN</div>';
                                history.forEach(m => appendMessage(m.sender_type, m.message));
                            }
                        });
                }
            })
            .catch(err => {
                console.error("Lỗi khi gửi tin nhắn:", err);
            });
    }
    // ==========================================
    // 6. KHỞI TẠO PUSHER VỚI KEY MỚI
    // ==========================================
    document.addEventListener("DOMContentLoaded", function() {
        updateCustomerChatBadge(); // Lấy số chưa đọc ban đầu

        // Bổ sung thêm forceTLS: true để đảm bảo luôn Real-time ổn định trên host Render
        var chatPusher = new Pusher('e5405b1b2139fed6f8bc', { 
            cluster: 'ap1',
            forceTLS: true
        });

        var chatChannel = chatPusher.subscribe('live-chat');

        chatChannel.bind('new-message', function (data) {
            // Kiểm tra xem tin nhắn trả về CÓ ĐÚNG là tin của khách hàng hiện tại không
            if (data.session_id === mySessionId && data.sender_type !== 'customer') {
                
                // Nếu đang mở khung chat -> In tin nhắn ra và báo đã đọc
                if (isChatOpen) {
                    appendMessage('admin', data.message);
                    fetch('index.php?action=markAsRead', { method: 'POST' });
                } else {
                    // Nếu đang đóng khung chat -> Cộng số đỏ lên 1
                    updateCustomerChatBadge(); 
                }
            }
        });
    });

    // Chạy ngầm quét đơn hàng quá hạn (Mỗi 15 giây)
    setInterval(function() {
        fetch('index.php?action=triggerCleanup')
            .then(response => response.json())
            .catch(error => console.log('Cleanup background task running...'));
    }, 15000); 
</script>
</body>
<script>
    // Kiểm tra xem input ẩn có tồn tại không và gán giá trị departure_id vào
    document.addEventListener("DOMContentLoaded", function() {
        const chatDepInput = document.getElementById('chatDepartureId');
        if (chatDepInput) {
            // Thay $booking['departure_id'] bằng đúng tên biến bạn đang dùng ở trang này nhé
            chatDepInput.value = '<?= $booking['departure_id'] ?? '' ?>';
        }
    });
</script>
</html>