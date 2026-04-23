<?php include 'layouts/header.php'; ?>

<style>
    .page-banner { background: linear-gradient(rgba(1,148,243,0.85), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200&q=80') center/cover; color: white; padding: 80px 0; text-align: center; margin-bottom: 40px; }
    .job-card { border: 1px solid #e2e8f0; border-radius: 12px; transition: 0.3s; height: 100%; }
    .job-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); border-color: #0194f3; }
</style>

<div class="page-banner">
    <div class="container">
        <h1 class="display-5 fw-bold">Gia nhập đội ngũ TravelVN</h1>
        <p class="lead">Cùng chúng tôi kiến tạo những hành trình hạnh phúc</p>
    </div>
</div>

<div class="container mb-5" style="max-width: 1000px;">
    <div class="text-center mb-5">
        <h3 class="fw-bold" style="color: #0194f3;">Tại sao chọn TravelVN?</h3>
        <p class="text-muted">Môi trường trẻ trung, năng động, bảo hiểm đầy đủ và đặc biệt: Đi du lịch miễn phí hàng năm!</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card job-card p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="fw-bold mb-0">Hướng Dẫn Viên Du Lịch Nội Địa</h5>
                    <span class="badge bg-success">Toàn thời gian</span>
                </div>
                <p class="text-muted small"><i class="bi bi-geo-alt"></i> TP. Hồ Chí Minh | <i class="bi bi-currency-dollar"></i> 10 - 15 Triệu + Thưởng</p>
                <p class="text-secondary">Yêu cầu có thẻ HDV nội địa, nhiệt tình, hoạt ngôn và có khả năng xử lý tình huống tốt trên tour.</p>
                <a href="mailto:hr@travelvn.com" class="btn btn-outline-primary mt-auto">Ứng tuyển ngay</a>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card job-card p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="fw-bold mb-0">Lập Trình Viên PHP (Laravel/MVC)</h5>
                    <span class="badge bg-primary">Full-stack</span>
                </div>
                <p class="text-muted small"><i class="bi bi-geo-alt"></i> Làm việc từ xa | <i class="bi bi-currency-dollar"></i> Thỏa thuận</p>
                <p class="text-secondary">Tham gia phát triển hệ thống ERP quản lý tour, tích hợp cổng thanh toán SePay, VNPay. Yêu cầu nắm vững mô hình MVC.</p>
                <a href="mailto:hr@travelvn.com" class="btn btn-outline-primary mt-auto">Ứng tuyển ngay</a>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>