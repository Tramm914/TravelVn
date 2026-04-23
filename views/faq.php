<?php include 'layouts/header.php'; ?>

<style>
    .page-banner { background: linear-gradient(rgba(1,148,243,0.85), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=1200&q=80') center/cover; color: white; padding: 80px 0; text-align: center; margin-bottom: 40px; }
    .accordion-button:not(.collapsed) { background-color: #ceefff; color: #0194f3; font-weight: bold; }
</style>

<div class="page-banner">
    <div class="container">
        <h1 class="display-5 fw-bold">Câu Hỏi Thường Gặp (FAQ)</h1>
        <p class="lead">Giải đáp mọi thắc mắc của bạn về dịch vụ tại TravelVN</p>
    </div>
</div>

<div class="container mb-5" style="max-width: 800px;">
    <div class="accordion shadow-sm" id="accordionFAQ">
        
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                    Tôi có thể thanh toán bằng những hình thức nào?
                </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#accordionFAQ">
                <div class="accordion-body text-muted">
                    TravelVN hỗ trợ 2 hình thức thanh toán chính: <strong>Chuyển khoản quét mã QR (VietQR)</strong> hệ thống sẽ tự động gạch nợ ngay lập tức, và <strong>Thanh toán tiền mặt (COD)</strong> tại văn phòng công ty.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                    Tôi lỡ quét mã QR nhưng hệ thống chưa báo thành công?
                </button>
            </h2>
            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                <div class="accordion-body text-muted">
                    Đừng lo lắng! Nếu bạn đã trừ tiền mà web chưa cập nhật, có thể do lỗi mạng tạm thời. Hệ thống lưu vết webhook của chúng tôi sẽ tự động đối soát trong vòng 5 phút. Bạn cũng có thể liên hệ Hotline 1900 1234 đọc mã giao dịch để nhân viên mở khóa đơn ngay.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                    Giá tour trên web đã bao gồm vé máy bay chưa?
                </button>
            </h2>
            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                <div class="accordion-body text-muted">
                    Tùy thuộc vào từng tour. Các tour có ghi "Đã bao gồm vé máy bay khứ hồi" trong phần thông tin chi tiết thì giá đã trọn gói. Nếu không có ghi chú, giá đó chỉ là giá Land Tour (Xe di chuyển, khách sạn, ăn uống, vé tham quan).
                </div>
            </div>
        </div>

    </div>
</div>

<?php include 'layouts/footer.php'; ?>