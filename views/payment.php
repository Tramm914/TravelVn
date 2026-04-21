<?php 
// Kiểm tra nếu Controller chưa truyền dữ liệu sang thì báo lỗi
if (empty($payment)) {
    echo "<div class='text-center mt-5'><h3>Không tìm thấy giao dịch thanh toán</h3></div>";
    exit;
}
include 'layouts/header.php'; 
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

    .btn-confirm {
        background-color: var(--success-color);
        color: white;
        font-weight: 700;
        border-radius: 12px;
        padding: 14px;
        font-size: 1.1rem;
        width: 100%;
        border: none;
        transition: 0.3s;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    .btn-confirm:hover {
        background-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
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
                    <img src="<?= $qr_url ?>" alt="QR Code Payment">
                </div>
<div class="text-center mt-3 text-warning fw-bold">
    Đang chờ thanh toán...
</div>
                <div class="mb-4">
                    <div class="info-row">
                        <span class="info-label">Khách hàng</span>
                        <span class="info-value"><?= htmlspecialchars($payment['customer_name']) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Ngân hàng</span>
                        <span class="info-value">TP Bank</span>
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

                

                <p class="instruction">
                    <i class="bi bi-info-circle me-1"></i> Hệ thống sẽ tự động duyệt sau khi nhận được tiền (từ 1 - 5
                    phút).
                </p>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="index.php?action=myBookings" class="text-decoration-none text-muted"><i class="bi bi-arrow-left me-1"></i> Quay
                lại danh sách đơn</a>
        </div>
    </div>
</div>

<script>
    function copyText(elementId, isAmount = false) {
        let textToCopy = document.getElementById(elementId).innerText;

        // Nếu là số tiền, loại bỏ dấu phẩy trước khi copy để dán vào app ngân hàng không bị lỗi
        if (isAmount) {
            textToCopy = textToCopy.replace(/,/g, '');
        }

        navigator.clipboard.writeText(textToCopy).then(() => {
            alert('Đã sao chép: ' + textToCopy);
        }).catch(err => {
            console.error('Lỗi sao chép: ', err);
        });
    }
</script>
<script>
let isPaid = false;

setInterval(() => {
    if (isPaid) return;

    fetch("index.php?action=checkPayment&payment_id=<?= $payment_id ?>")
        .then(res => res.json())
        .then(data => {
            if (data.payment_status === 'paid') {
                isPaid = true;
                showSuccess();
            }
        });
}, 3000);

function showSuccess() {
    // Tạo overlay
    const overlay = document.createElement("div");
    overlay.style.position = "fixed";
    overlay.style.top = 0;
    overlay.style.left = 0;
    overlay.style.width = "100%";
    overlay.style.height = "100%";
    overlay.style.background = "rgba(0,0,0,0.5)";
    overlay.style.display = "flex";
    overlay.style.alignItems = "center";
    overlay.style.justifyContent = "center";
    overlay.style.zIndex = 9999;

    // Box thông báo
    const box = document.createElement("div");
    box.style.background = "#fff";
    box.style.padding = "30px";
    box.style.borderRadius = "20px";
    box.style.textAlign = "center";
    box.style.boxShadow = "0 10px 30px rgba(0,0,0,0.2)";
    box.style.animation = "fadeIn 0.4s ease";

    box.innerHTML = `
        <div style="font-size:50px;color:#10b981;">✔</div>
        <h3 style="margin:10px 0;color:#2c3e50;">Thanh toán thành công</h3>
        <p style="color:#64748b;">Đang chuyển về trang đơn hàng...</p>
    `;

    overlay.appendChild(box);
    document.body.appendChild(overlay);

    // Redirect sau 2s
    setTimeout(() => {
        window.location.href = "index.php?action=myBookings";
    }, 2000);
}
</script>

<style>
@keyframes fadeIn {
    from {
        transform: scale(0.8);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}
</style>
<?php include 'layouts/footer.php'; ?>