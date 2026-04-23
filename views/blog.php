<?php include 'layouts/header.php'; ?>

<style>
    .blog-header {
        background-color: #f8fafc;
        padding: 60px 0;
        text-align: center;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 50px;
    }
    .blog-card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        height: 100%;
    }
    .blog-card:hover {
        transform: translateY(-5px);
    }
    .blog-img {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }
    .blog-date {
        font-size: 0.85rem;
        color: #94a3b8;
        margin-bottom: 10px;
    }
</style>

<div class="blog-header">
    <div class="container">
        <h1 class="fw-bold" style="color: #0194f3;">Cẩm nang du lịch</h1>
        <p class="text-muted">Khám phá những điểm đến mới lạ và mẹo du lịch hữu ích từ TravelVN</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card blog-card">
                <img src="https://images.unsplash.com/photo-1599839619722-39751411ea63?w=500&q=80" class="blog-img" alt="Blog 1">
                <div class="card-body p-4">
                    <div class="blog-date"><i class="bi bi-calendar3"></i> 24 Tháng 4, 2026</div>
                    <h5 class="card-title fw-bold">Top 5 bãi biển hoang sơ nhất Nam Trung Bộ nên đi mùa hè này</h5>
                    <p class="card-text text-muted">Rời xa sự ồn ào của phố thị, những bãi biển ẩn mình dưới đây sẽ mang lại cho bạn sự bình yên tuyệt đối...</p>
                    <a href="#" class="btn btn-outline-primary btn-sm rounded-pill mt-2">Đọc tiếp <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card blog-card">
                <img src="https://images.unsplash.com/photo-1528127269322-539801943592?w=500&q=80" class="blog-img" alt="Blog 2">
                <div class="card-body p-4">
                    <div class="blog-date"><i class="bi bi-calendar3"></i> 20 Tháng 4, 2026</div>
                    <h5 class="card-title fw-bold">Kinh nghiệm sắp xếp hành lý "chuẩn không cần chỉnh"</h5>
                    <p class="card-text text-muted">Bí quyết cuộn quần áo và tối ưu không gian vali giúp bạn mang cả thế giới mà không sợ quá ký...</p>
                    <a href="#" class="btn btn-outline-primary btn-sm rounded-pill mt-2">Đọc tiếp <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card blog-card">
                <img src="https://images.unsplash.com/photo-1559586616-361e18714958?w=500&q=80" class="blog-img" alt="Blog 3">
                <div class="card-body p-4">
                    <div class="blog-date"><i class="bi bi-calendar3"></i> 15 Tháng 4, 2026</div>
                    <h5 class="card-title fw-bold">Thưởng thức ẩm thực đường phố: Ăn gì để bụng luôn khỏe?</h5>
                    <p class="card-text text-muted">Cẩm nang khám phá ẩm thực địa phương một cách trọn vẹn nhưng vẫn đảm bảo an toàn cho dạ dày của bạn...</p>
                    <a href="#" class="btn btn-outline-primary btn-sm rounded-pill mt-2">Đọc tiếp <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>