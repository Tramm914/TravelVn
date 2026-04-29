<?php include __DIR__ . '/layouts/header.php'; ?>

<style>
    :root {
        --primary-color: #0194f3;
        --secondary-color: #f8fafc;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
        --warning-color: #f59e0b;
        --success-color: #10b981;
    }

    body {
        background-color: #f1f5f9;
        font-family: 'Inter', sans-serif;
    }

    .detail-container {
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 15px;
    }

    /* BREADCRUMB */
    .breadcrumb-custom {
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 25px;
    }
    .breadcrumb-custom a { color: var(--text-muted); text-decoration: none; }
    .breadcrumb-custom a:hover { color: var(--primary-color); }
    .breadcrumb-custom span { color: var(--text-main); font-weight: 700; }

    /* BOX TRẮNG CHUNG */
    .content-box {
        background: white;
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        padding: 30px;
        margin-bottom: 25px;
    }

    /* HEADER ĐƠN HÀNG */
    .order-header { text-align: center; margin-bottom: 30px; border-bottom: 1px dashed var(--border-color); padding-bottom: 25px;}
    .order-icon { font-size: 3.5rem; line-height: 1; margin-bottom: 15px; }
    .order-icon.success { color: var(--success-color); }
    .order-icon.warning { color: var(--warning-color); }
    .order-title { font-weight: 800; font-size: 1.8rem; color: var(--text-main); margin-bottom: 10px; }
    .order-id-badge { background: var(--secondary-color); border: 1px solid var(--border-color); padding: 8px 20px; border-radius: 50px; font-weight: 700; color: var(--text-muted); display: inline-block; font-size: 1rem;}

    /* LƯỚI THÔNG TIN */
    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
    .info-section-title { font-weight: 800; font-size: 1.1rem; color: var(--primary-color); margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
    .info-item { margin-bottom: 15px; }
    .info-item label { display: block; color: var(--text-muted); font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; text-transform: uppercase; }
    .info-item div { font-weight: 700; color: var(--text-main); font-size: 1.05rem; }

    /* TỔNG TIỀN */
    .payment-box { background: #fffbeb; border: 1px solid #fde68a; border-radius: 16px; padding: 25px; display: flex; justify-content: space-between; align-items: center; margin-top: 20px; }
    .payment-box.paid { background: #ecfdf5; border-color: #a7f3d0; }
    .pay-label { font-weight: 700; color: var(--text-main); font-size: 1.1rem; margin-bottom: 5px; }
    .pay-status-badge { display: inline-block; padding: 5px 12px; border-radius: 8px; font-size: 0.85rem; font-weight: 700; }
    .pay-status-badge.unpaid { background: #fef3c7; color: #d97706; }
    .pay-status-badge.paid { background: #d1fae5; color: #059669; }
    .pay-amount { font-size: 2rem; font-weight: 800; color: #ea580c; }
    .payment-box.paid .pay-amount { color: #059669; }

    /* VÉ ĐIỆN TỬ (QR CODE) - BÊN PHẢI */
    .e-ticket-card {
        background: white;
        border-radius: 20px;
        border: 2px dashed var(--primary-color);
        padding: 30px 20px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(1, 148, 243, 0.1);
        position: relative;
        overflow: hidden;
    }
    /* Hiệu ứng cắt viền vé */
    .e-ticket-card::before, .e-ticket-card::after {
        content: ""; position: absolute; width: 30px; height: 30px; background: #f1f5f9; border-radius: 50%; top: 50%; transform: translateY(-50%); border: 1px solid var(--border-color);
    }
    .e-ticket-card::before { left: -16px; border-left: none; }
    .e-ticket-card::after { right: -16px; border-right: none; }

    .qr-wrapper { background: white; padding: 15px; border-radius: 16px; border: 1px solid var(--border-color); display: inline-block; margin-bottom: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .qr-wrapper img { width: 180px; height: 180px; }
    .ticket-title { font-weight: 800; color: var(--primary-color); font-size: 1.2rem; margin-bottom: 5px; }
    .ticket-desc { color: var(--text-muted); font-size: 0.9rem; line-height: 1.5; margin: 0; padding: 0 10px;}

    /* TOUR THUMBNAIL */
    .tour-preview { border-radius: 20px; overflow: hidden; position: relative; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .tour-preview img { width: 100%; height: 200px; object-fit: cover; }
    .tour-location { position: absolute; bottom: 15px; left: 15px; background: rgba(0,0,0,0.7); color: white; padding: 6px 15px; border-radius: 50px; font-weight: 600; font-size: 0.9rem; backdrop-filter: blur(5px);}

    /* THÔNG TIN HỖ TRỢ */
    .support-box { background: white; border-radius: 20px; padding: 25px; border: 1px solid var(--border-color); }
    .support-title { font-weight: 800; margin-bottom: 20px; font-size: 1.1rem; }
    .support-item { display: flex; gap: 15px; margin-bottom: 15px; align-items: center; }
    .support-item i { font-size: 1.5rem; color: var(--primary-color); }
    .support-item div p { margin: 0; font-size: 0.85rem; color: var(--text-muted); }
    .support-item div strong { font-size: 1.05rem; color: var(--text-main); }

    @media (max-width: 768px) {
        .info-grid { grid-template-columns: 1fr; gap: 15px; }
        .payment-box { flex-direction: column; text-align: center; gap: 15px; }
    }
</style>

<div class="detail-container">
    
    <div class="breadcrumb-custom">
        <a href="index.php">Trang chủ</a> / 
        <a href="index.php?action=myBookings">Chuyến đi của tôi</a> / 
        <span>Chi tiết đơn hàng</span>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="content-box">
                <div class="order-header">
                    <?php if ($booking['status'] == 'confirmed' || $booking['status'] == 'completed'): ?>
                        <div class="order-icon success"><i class="bi bi-check-circle-fill"></i></div>
                        <h2 class="order-title">Đã xác nhận đơn đặt tour!</h2>
                    <?php else: ?>
                        <div class="order-icon warning"><i class="bi bi-exclamation-circle-fill"></i></div>
                        <h2 class="order-title">Đã ghi nhận đơn đặt tour!</h2>
                    <?php endif; ?>
                    <div class="order-id-badge">Mã đơn hàng: #<?= str_pad($booking['booking_id'], 6, '0', STR_PAD_LEFT) ?></div>
                </div>

                <div class="info-grid">
                    <div>
                        <h4 class="info-section-title"><i class="bi bi-person-vcard"></i> Thông tin liên hệ</h4>
                        <div class="info-item">
                            <label>Người đặt</label>
                            <div><?= htmlspecialchars($booking['customer_name']) ?></div>
                        </div>
                        <div class="info-item">
                            <label>Số điện thoại</label>
                            <div><?= htmlspecialchars($booking['phone']) ?></div>
                        </div>
                        <div class="info-item">
                            <label>Email</label>
                            <div><?= htmlspecialchars($booking['email'] ?? $booking['account_email'] ?? 'Không cung cấp') ?></div>
                        </div>
                        <div class="info-item">
                            <label>Số khách</label>
                            <div><?= $booking['number_of_people'] ?> người</div>
                        </div>
                    </div>

                    <div>
                        <h4 class="info-section-title"><i class="bi bi-map"></i> Chi tiết dịch vụ</h4>
                        <div class="info-item">
                            <label>Tên Tour</label>
                            <div class="text-primary"><?= htmlspecialchars($booking['tour_name']) ?></div>
                        </div>
                        <div class="info-item">
                            <label>Ngày khởi hành</label>
                            <div><?= date('d/m/Y', strtotime($booking['start_date'])) ?></div>
                        </div>
                        <div class="info-item">
                            <label>Điểm đón / Tập trung</label>
                            <div><i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= htmlspecialchars($booking['pickup_address'] ?? 'Đang cập nhật') ?></div>
                        </div>
                        <div class="info-item">
                            <label>Trạng thái đơn</label>
                            <div>
                                <?php 
                                    $s = $booking['status'];
                                    if($s == 'pending') echo '<span class="badge bg-warning text-dark">Chờ xử lý</span>';
                                    elseif($s == 'confirmed') echo '<span class="badge bg-success">Đã xác nhận</span>';
                                    elseif($s == 'checked_in') echo '<span class="badge bg-info text-dark">Đã Check-in</span>';
                                    elseif($s == 'completed') echo '<span class="badge bg-primary">Hoàn tất</span>';
                                    else echo '<span class="badge bg-danger">Đã hủy</span>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php 
                    $isPaid = ($booking['payment_status'] === 'paid');
                ?>
                <div class="payment-box <?= $isPaid ? 'paid' : '' ?>">
                    <div>
                        <div class="pay-label">Tổng thanh toán</div>
                        <?php if ($isPaid): ?>
                            <span class="pay-status-badge paid"><i class="bi bi-shield-check me-1"></i> Đã thanh toán</span>
                        <?php else: ?>
                            <span class="pay-status-badge unpaid"><i class="bi bi-exclamation-circle me-1"></i> Chưa thanh toán</span>
                        <?php endif; ?>
                    </div>
                    <div class="pay-amount">
                        <?= number_format($booking['total_price']) ?> <span style="font-size: 1.2rem;">đ</span>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-4 pt-3 border-top">
                    <a href="index.php?action=myBookings" class="btn btn-outline-secondary fw-bold px-4 py-2" style="border-radius: 12px;">Quản lý đơn</a>
                    <?php if (!$isPaid && $booking['status'] !== 'cancelled'): ?>
                        <a href="index.php?action=payment&booking_id=<?= encode_id($booking['booking_id']) ?>" class="btn btn-primary fw-bold px-4 py-2" style="border-radius: 12px;">Thanh toán ngay</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="tour-preview">
                <img src="<?= !empty($booking['image']) ? '/uploads/' . $booking['image'] : 'https://images.unsplash.com/photo-1501785888041-af3ef285b470' ?>" alt="Tour">
                <div class="tour-location"><i class="bi bi-geo-alt-fill text-danger"></i> <?= htmlspecialchars($booking['destination'] ?? 'Việt Nam') ?></div>
            </div>

            <?php if ($booking['status'] !== 'cancelled'): ?>
            <div class="e-ticket-card mb-4">
                <h4 class="ticket-title">MÃ CHECK-IN (E-TICKET)</h4>
                
                <div class="qr-wrapper">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=<?= $booking['booking_id'] ?>" alt="QR Code">
                </div>
                
                <p class="ticket-desc">
                    Vui lòng xuất trình mã QR này cho Hướng dẫn viên vào ngày khởi hành để tiến hành Check-in tự động.
                </p>
            </div>
            <?php endif; ?>

            <div class="support-box">
                <h5 class="support-title">Cần sự trợ giúp?</h5>
                <div class="support-item">
                    <i class="bi bi-headset"></i>
                    <div>
                        <p>Hotline 24/7</p>
                        <strong>1900 1234</strong>
                    </div>
                </div>
                <div class="support-item mb-0">
                    <i class="bi bi-envelope-at"></i>
                    <div>
                        <p>Email hỗ trợ</p>
                        <strong>support@travelvn.com</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>