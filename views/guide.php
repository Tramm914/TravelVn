<?php include 'layouts/header.php'; ?>

<style>
    .page-banner { background: linear-gradient(rgba(1,148,243,0.85), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=1200&q=80') center/cover; color: white; padding: 80px 0; text-align: center; margin-bottom: 40px; }
    .step-box { padding: 30px; text-align: center; border: 1px solid #e2e8f0; border-radius: 15px; margin-bottom: 20px; }
    .step-icon { font-size: 3rem; color: #0194f3; margin-bottom: 15px; }
</style>

<div class="page-banner">
    <div class="container">
        <h1 class="display-5 fw-bold">Hướng Dẫn Đặt Tour</h1>
        <p class="lead">Chỉ với 4 bước đơn giản để bắt đầu hành trình của bạn</p>
    </div>
</div>

<div class="container mb-5" style="max-width: 1000px;">
    <div class="row g-4">
        <div class="col-md-3 col-6">
            <div class="step-box h-100">
                <i class="bi bi-search step-icon"></i>
                <h5 class="fw-bold">Bước 1</h5>
                <p class="text-muted small">Tìm kiếm và chọn tour phù hợp với điểm đến, thời gian.</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="step-box h-100">
                <i class="bi bi-pencil-square step-icon"></i>
                <h5 class="fw-bold">Bước 2</h5>
                <p class="text-muted small">Điền thông tin khách hàng, số lượng người tham gia.</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="step-box h-100">
                <i class="bi bi-credit-card step-icon"></i>
                <h5 class="fw-bold">Bước 3</h5>
                <p class="text-muted small">Thanh toán an toàn qua quét mã QR (VietQR) hoặc COD.</p>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="step-box h-100">
                <i class="bi bi-send-check step-icon"></i>
                <h5 class="fw-bold">Bước 4</h5>
                <p class="text-muted small">Nhận vé điện tử qua Email và chuẩn bị xách balo lên đi!</p>
            </div>
        </div>
    </div>
    <div class="text-center mt-5">
        <a href="index.php?action=tours" class="btn btn-primary btn-lg rounded-pill px-5">Khám phá Tour ngay</a>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>