<?php 
    // Giả sử $detail là mảng chứa dữ liệu đơn hàng được query từ database
    $activeMenu = 'bookings';
    include __DIR__ . '/../layouts/header.php'; 
?>

<style>
    :root {
        --brand-primary: #0194f3;
        --brand-success: #12b76a;
        --bg-body: #f8fafc;
        --card-bg: #ffffff;
        --border-color: #e2e8f0;
        --text-dark: #0f172a;
        --text-gray: #64748b;
    }

    body { background-color: var(--bg-body); font-family: 'Inter', sans-serif; }
    .client-container { max-width: 1100px; margin: 40px auto; padding: 0 15px; }
    
    .status-header {
        text-align: center;
        padding: 40px 20px;
        background: var(--card-bg);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        margin-bottom: 30px;
    }
    .check-icon-wrapper {
        width: 80px;
        height: 80px;
        background: rgba(18, 183, 106, 0.1);
        color: var(--brand-success);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin: 0 auto 20px;
    }
    
    .detail-card {
        background: var(--card-bg);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .detail-card-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 15px;
    }

    /* Bảng chi tiết */
    .data-row { display: flex; justify-content: space-between; margin-bottom: 15px; }
    .data-label { color: var(--text-gray); font-size: 0.95rem; }
    .data-value { color: var(--text-dark); font-weight: 600; text-align: right; }
    
    /* Box QR Code */
    .qr-box {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
    }
    
    /* Stepper/Timeline */
    .stepper { display: flex; justify-content: space-between; margin-top: 30px; position: relative; }
    .stepper::before {
        content: ''; position: absolute; top: 15px; left: 0; right: 0; height: 2px;
        background: var(--border-color); z-index: 1;
    }
    .step { position: relative; z-index: 2; text-align: center; background: var(--card-bg); padding: 0 10px; }
    .step-icon {
        width: 32px; height: 32px; border-radius: 50%; background: var(--border-color); color: white;
        display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-weight: bold;
    }
    .step.active .step-icon { background: var(--brand-success); }
    .step-text { font-size: 0.85rem; color: var(--text-gray); font-weight: 500; }
    .step.active .step-text { color: var(--brand-success); font-weight: 700; }

    /* Total Price Box */
    .total-box {
        background: rgba(1, 148, 243, 0.05);
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }
</style>

<div class="client-container">
    <div class="status-header">
        <div class="check-icon-wrapper">
            <i class="bi bi-check-lg"></i>
        </div>
        <h2 class="fw-bold text-dark mb-2">Đặt tour & Thanh toán thành công!</h2>
        <p class="text-muted mb-0">Mã đơn hàng: <span class="fw-bold text-primary">#<?= str_pad($detail['booking_id'], 6, '0', STR_PAD_LEFT) ?></span> • Đặt lúc: <?= date('H:i - d/m/Y') ?></p>
        
        <div class="stepper col-md-8 mx-auto d-none d-md-flex">
            <div class="step active">
                <div class="step-icon"><i class="bi bi-check"></i></div>
                <div class="step-text">Đã đặt</div>
            </div>
            <div class="step active">
                <div class="step-icon"><i class="bi bi-check"></i></div>
                <div class="step-text">Thanh toán</div>
            </div>
            <div class="step <?= ($detail['status'] == 'confirmed') ? 'active' : '' ?>">
                <div class="step-icon"><?= ($detail['status'] == 'confirmed') ? '<i class="bi bi-check"></i>' : '3' ?></div>
                <div class="step-text"><?= ($detail['status'] == 'confirmed') ? 'Đã chốt tour' : 'Chờ xác nhận' ?></div>
            </div>
            <div class="step">
                <div class="step-icon">4</div>
                <div class="step-text">Khởi hành</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="detail-card">
                <div class="detail-card-title">
                    <i class="bi bi-geo-alt-fill text-primary"></i> Thông tin chuyến đi
                </div>
                <h5 class="fw-bold mb-3 text-primary"><?= htmlspecialchars($detail['tour_name']) ?></h5>
                
                <div class="row mb-4">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="d-flex gap-3">
                            <i class="bi bi-calendar-event fs-4 text-muted"></i>
                            <div>
                                <small class="text-muted d-block">Ngày khởi hành</small>
                                <span class="fw-bold"><?= date('d/m/Y', strtotime($detail['start_date'])) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex gap-3">
                            <i class="bi bi-people fs-4 text-muted"></i>
                            <div>
                                <small class="text-muted d-block">Số lượng khách</small>
                                <span class="fw-bold"><?= $detail['number_of_people'] ?> người</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info border-0 d-flex gap-3 align-items-center mb-0">
                    <i class="bi bi-info-circle-fill fs-4"></i>
                    <div>
                        <strong>Lưu ý:</strong> Hướng dẫn viên sẽ liên hệ với bạn trước 1 ngày khởi hành. Vui lòng giữ điện thoại.
                    </div>
                </div>
            </div>

            <div class="detail-card">
                <div class="detail-card-title">
                    <i class="bi bi-receipt text-primary"></i> Chi tiết thanh toán
                </div>
                
                <div class="data-row">
                    <div class="data-label">Phương thức thanh toán</div>
                    <div class="data-value"><?= strtoupper($detail['payment_method'] ?? 'Chuyển khoản / Cổng thanh toán') ?></div>
                </div>
                <div class="data-row">
                    <div class="data-label">Tình trạng</div>
                    <div class="data-value text-success"><i class="bi bi-patch-check-fill"></i> Đã thanh toán</div>
                </div>
                
                <hr class="text-muted">
                
                <div class="data-row">
                    <div class="data-label">Giá tour cơ bản (x<?= $detail['number_of_people'] ?>)</div>
                    <div class="data-value"><?= number_format($detail['total_price']) ?> đ</div>
                </div>
                <div class="data-row">
                    <div class="data-label">Phí hệ thống / Thuế</div>
                    <div class="data-value">0 đ</div>
                </div>

                <div class="total-box data-row mb-0 align-items-center">
                    <div class="data-label fw-bold text-dark fs-5">Tổng cộng</div>
                    <div class="data-value text-primary fs-3 fw-bold"><?= number_format($detail['total_price']) ?> đ</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="detail-card qr-box text-center">
                <h6 class="fw-bold mb-3">Vé Điện Tử (E-Ticket)</h6>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= 'TOUR-'.$detail['booking_id'] ?>" alt="QR Code" class="img-fluid rounded mb-3" width="150">
                <p class="small text-muted mb-3">Đưa mã QR này cho hướng dẫn viên khi tập trung để check-in nhanh chóng.</p>
                <button class="btn btn-outline-primary w-100 fw-bold"><i class="bi bi-download"></i> Tải vé PDF</button>
            </div>

            <div class="detail-card">
                <div class="detail-card-title">
                    <i class="bi bi-person-badge text-primary"></i> Thông tin liên hệ
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Họ và tên</small>
                    <span class="fw-bold text-dark"><?= htmlspecialchars($detail['customer_name']) ?></span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Số điện thoại</small>
                    <span class="fw-bold text-dark"><?= htmlspecialchars($detail['phone'] ?? '---') ?></span>
                </div>
                <div>
                    <small class="text-muted d-block">Email</small>
                    <span class="fw-bold text-dark"><?= htmlspecialchars($detail['email'] ?? '---') ?></span>
                </div>
            </div>

            <div class="detail-card bg-primary text-white border-0">
                <h6 class="fw-bold mb-3"><i class="bi bi-headset"></i> Cần hỗ trợ?</h6>
                <p class="small mb-3">Nếu bạn có thắc mắc hoặc cần thay đổi lịch trình, hãy liên hệ ngay với chúng tôi.</p>
                <div class="d-flex flex-column gap-2">
                    <a href="tel:19001234" class="btn btn-light w-100 fw-bold text-primary"><i class="bi bi-telephone-fill"></i> 1900 1234</a>
                </div>
            </div>

        </div>
    </div>
    
    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-primary btn-lg fw-bold px-5 rounded-pill shadow"><i class="bi bi-house-door"></i> Về trang chủ</a>
        <a href="index.php?action=tours" class="btn btn-link text-muted fw-bold text-decoration-none ms-3">Xem tour khác</a>
    </div>

</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>