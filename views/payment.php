<?php
// Kiểm tra nếu Controller chưa truyền dữ liệu sang thì báo lỗi
if (empty($payment)) {
    echo "<div class='text-center mt-5'><h3>Không tìm thấy giao dịch thanh toán</h3></div>";
    exit;
}
include 'layouts/header.php';

// 1. Lấy ID thanh toán
$payment_id = $payment['payment_id'] ?? $_GET['payment_id'] ?? 0;

// 2. KHAI BÁO THÔNG TIN TẠO MÃ QR (Đã thêm vào đây để tự động chạy)
$bank_id = "TPBank"; 
$account_no = "00000419627";
$account_name = "DOAN THI TRAM"; // Tên in trên thẻ
$amount = $payment['amount'] ?? 0;
$info = "THANHTOAN" . $payment_id;

// 3. Nối chuỗi tạo link ảnh QR của VietQR
$qr_url = "https://img.vietqr.io/image/" . $bank_id . "-" . $account_no . "-compact2.png";
$qr_url .= "?amount=" . $amount;
$qr_url .= "&addInfo=" . $info;
$qr_url .= "&accountName=" . urlencode($account_name);
?>

<style>
    :root {
        --primary-color: #0194f3;
        --accent-color: #ff5e1f;
        --success-color: #10b981;
        --text-main: #2c3e50;
    }

    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }

    .payment-container {
        max-width: 500px;
        margin: 40px auto;
    }

    .payment-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }

    .payment-header {
        background: linear-gradient(135deg, var(--primary-color), #00d2ff);
        color: white;
        padding: 25px 20px;
        text-align: center;
    }

    .payment-header h3 {
        margin: 0;
        font-weight: 700;
        font-size: 1.5rem;
    }

    .payment-header p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .payment-body {
        padding: 30px;
    }

    .qr-wrapper {
        background: #f8f9fa;
        border: 2px dashed #cbd5e1;
        border-radius: 16px;
        padding: 15px;
        text-align: center;
        margin: 0 auto 25px;
        width: 250px;
        position: relative;
    }

    .qr-wrapper img {
        width: 100%;
        border-radius: 10px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px dashed #e2e8f0;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: #64748b;
        font-size: 0.95rem;
    }

    .info-value {
        font-weight: 700;
        color: var(--text-main);
        font-size: 1rem;
        text-align: right;
    }

    .info-value.amount {
        font-size: 1.3rem;
        color: var(--accent-color);
    }

    .btn-copy {
        background: none;
        border: none;
        color: var(--primary-color);
        cursor: pointer;
        padding: 0 0 0 8px;
        font-size: 1.1rem;
        transition: 0.2s;
    }

    .btn-copy:hover {
        color: var(--text-main);
    }

    .instruction {
        font-size: 0.9rem;
        color: #64748b;
        text-align: center;
        margin-top: 20px;
    }
</style>

<div class="container">
    <div class="payment-container">
        <div class="payment-card">

            <div class="payment-header">
                <h3>Thanh toán đơn hàng</h3>
                <p>Mã giao dịch: <strong>#<?= htmlspecialchars($payment['transaction_code'] ?? $payment_id) ?></strong>
                </p>
            </div>

            <div class="payment-body">

                <div class="text-center mb-3 fw-bold text-dark">
                    Quét mã QR bằng ứng dụng ngân hàng
                </div>
                <div class="qr-wrapper shadow-sm">
                    <img src="<?= htmlspecialchars($qr_url) ?>" alt="QR Code Payment">
                </div>

                <div class="mb-4">
                    <div class="info-row">
                        <span class="info-label">Khách hàng</span>
                        <span class="info-value"><?= htmlspecialchars($payment['customer_name'] ?? 'Khách hàng') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Ngân hàng</span>
                        <span class="info-value">TPBank</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Số tài khoản</span>
                        <span class="info-value">
                            <span id="copy-account"><?= htmlspecialchars($account_no) ?></span>
                            <button class="btn-copy" onclick="copyText('copy-account')" title="Sao chép"><i
                                    class="bi bi-clipboard"></i></button>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Số tiền</span>
                        <span class="info-value amount">
                            <span id="copy-amount"><?= number_format($amount) ?></span> VNĐ
                            <button class="btn-copy" onclick="copyText('copy-amount', true)" title="Sao chép"><i
                                    class="bi bi-clipboard"></i></button>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Nội dung</span>
                        <span class="info-value text-primary">
                            <span id="copy-info"><?= htmlspecialchars($info) ?></span>
                            <button class="btn-copy" onclick="copyText('copy-info')" title="Sao chép"><i
                                    class="bi bi-clipboard"></i></button>
                        </span>
                    </div>
                </div>

                <div class="text-center mt-4 border-top pt-3">
                    <h5 class="text-danger fw-bold mb-3">
                        Vui lòng thanh toán trong: <span id="countdown-timer">15:00</span>
                    </h5>

                    <div id="payment-waiting" class="mb-3">
                        <div class="spinner-border text-primary" role="status" style="width: 2rem; height: 2rem;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-primary fw-bold">Hệ thống đang tự động chờ nhận tiền...</p>
                        <p class="text-muted small">Trang sẽ tự động chuyển hướng ngay khi nhận được thanh toán.</p>
                    </div>
                </div>

            </div>
        </div>

        <div class="text-center mt-3">
            <a href="index.php?action=myBookings" class="text-decoration-none text-muted"><i
                    class="bi bi-arrow-left me-1"></i> Quay
                lại danh sách đơn</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. Hàm sao chép văn bản (Giữ nguyên)
    function copyText(elementId, isAmount = false) {
        let textToCopy = document.getElementById(elementId).innerText;
        if (isAmount) {
            textToCopy = textToCopy.replace(/,/g, '');
        }
        navigator.clipboard.writeText(textToCopy).then(() => {
            // Thay thế luôn alert copy bằng Toast nhỏ gọn ở góc màn hình
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Đã sao chép!',
                showConfirmButton: false,
                timer: 1500
            });
        }).catch(err => {
            console.error('Lỗi sao chép: ', err);
        });
    }

    // 2. Lấy ID thanh toán từ PHP
    const currentPaymentId = <?= json_encode($payment_id) ?>;

    // 3. Hàm kiểm tra trạng thái tự động (Polling)
    function checkStatus() {
        fetch(`index.php?action=checkPaymentStatus&payment_id=${currentPaymentId}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'paid') {
                    // Xóa vòng lặp khi thành công
                    clearInterval(pollingInterval);
                    localStorage.removeItem(STORAGE_KEY);
                    
                    // Giao diện thông báo chuyên nghiệp mới
                    Swal.fire({
                        title: 'Thanh toán thành công!',
                        text: 'Cảm ơn bạn đã tin tưởng TravelVN. Đơn đặt tour của bạn đã được xác nhận.',
                        icon: 'success',
                        confirmButtonText: 'Xem chi tiết đơn hàng <i class="bi bi-arrow-right"></i>',
                        confirmButtonColor: '#0194f3', // Màu xanh thương hiệu của bạn
                        allowOutsideClick: false // Khóa không cho bấm ra ngoài để ép chuyển trang
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'index.php?action=myBookings';
                        }
                    });
                }
            })
            .catch(error => console.log('Đang kết nối server...'));
    }

    // Thiết lập vòng lặp: Cứ mỗi 3 giây kiểm tra 1 lần
    const pollingInterval = setInterval(checkStatus, 3000);

    // 4. HÀM ĐẾM NGƯỢC THÔNG MINH (Giữ nguyên)
    const STORAGE_KEY = `payment_expire_${currentPaymentId}`;
    let expireTime = localStorage.getItem(STORAGE_KEY);

    if (!expireTime) {
        expireTime = Date.now() + (15 * 60 * 1000);
        localStorage.setItem(STORAGE_KEY, expireTime);
    }

    const timerDisplay = document.getElementById('countdown-timer');

    const countdown = setInterval(function () {
        let now = Date.now();
        let timeRemaining = Math.floor((expireTime - now) / 1000);

        if (timeRemaining <= 0) {
            clearInterval(countdown);
            clearInterval(pollingInterval);
            localStorage.removeItem(STORAGE_KEY);
            
            // Đổi luôn thông báo hết giờ cho đồng bộ
            Swal.fire({
                title: 'Hết thời gian thanh toán',
                text: 'Phiên thanh toán này đã hết hạn. Vui lòng thử đặt lại nhé!',
                icon: 'warning',
                confirmButtonText: 'Quay lại',
                confirmButtonColor: '#6c757d',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = 'index.php?action=myBookings';
            });
            return;
        }

        let minutes = Math.floor(timeRemaining / 60);
        let seconds = timeRemaining % 60;

        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        timerDisplay.textContent = minutes + ":" + seconds;
    }, 1000);
</script>

<?php include 'layouts/footer.php'; ?>