<?php
// --- 1. LOGIC TÍNH TOÁN TIẾN ĐỘ THỰC TẾ (CHẠY THẬT) ---
$totalPax = 0;
$checkedInPax = 0;

if (!empty($bookings)) {
    foreach ($bookings as $b) {
        // Cộng dồn tổng số khách đặt (Dựa trên số người trong mỗi đơn)
        $totalPax += (int)$b['number_of_people'];
        
        // Kiểm tra trạng thái đã check-in hay chưa (Dùng trim để tránh lỗi khoảng trắng)
        if (isset($b['status']) && trim($b['status']) === 'checked_in') {
            $checkedInPax += (int)$b['number_of_people'];
        }
    }
}

// Tính phần trăm làm tròn
$progress = ($totalPax > 0) ? round(($checkedInPax / $totalPax) * 100) : 0;
// Đường dẫn ảnh tour
$imgUrl = !empty($departure['image']) ? '/uploads/' . $departure['image'] : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800';
?>

<?php include __DIR__ . '/../layouts/header.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --app-primary: #0ea5e9;
        --app-primary-bg: #e0f2fe;
        --app-success: #10b981;
        --app-success-bg: #d1fae5;
        --app-warning: #f59e0b;
        --app-warning-bg: #fef3c7;
        --app-danger: #ef4444;
        --app-danger-bg: #fee2e2;
        --app-bg: #f8fafc;
        --app-card: #ffffff;
        --app-text: #0f172a;
        --app-muted: #64748b;
        --app-border: #e2e8f0;
        --font-main: 'Plus Jakarta Sans', sans-serif;
    }

    body { background-color: var(--app-bg); font-family: var(--font-main); color: var(--app-text); }

    /* --- THANH TIẾN TRÌNH CHẠY THẬT --- */
    .progress-container-custom {
        width: 100%; height: 10px; background: #e2e8f0; border-radius: 10px; margin-top: 12px; overflow: hidden;
    }
    .progress-bar-fill-custom {
        height: 100%; background: var(--app-success);
        width: <?= $progress ?>%;
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 0 10px rgba(16, 185, 129, 0.3);
    }

    /* --- GIỮ NGUYÊN STYLE BAN ĐẦU --- */
    .hero-banner { height: 280px; background-size: cover; background-position: center; position: relative; }
    .hero-overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.2));
        padding: 0 5%; display: flex; flex-direction: column; justify-content: center;
    }
    .hero-title { color: white; font-weight: 800; font-size: 2.2rem; margin-top: 20px;}
    .hero-meta { color: #cbd5e1; font-weight: 500; font-size: 1.05rem; display: flex; gap: 20px;}
    .hero-meta i { color: var(--app-primary); margin-right: 5px;}
    .top-stats-container { margin-top: -50px; position: relative; z-index: 10; padding: 0 5%;}
    .stat-card {
        background: var(--app-card); border-radius: 16px; padding: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05); border: 1px solid rgba(255,255,255,0.8);
        display: flex; flex-direction: column; justify-content: center; gap: 5px; height: 100%;
    }
    .stat-header-flex { display: flex; align-items: center; gap: 15px; }
    .stat-icon {
        width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 800;
    }
    .stat-info h6 { color: var(--app-muted); font-size: 0.9rem; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;}
    .stat-info h4 { color: var(--app-text); font-size: 1.2rem; font-weight: 800; margin: 0;}
    .status-select { border: 2px solid var(--app-border); border-radius: 10px; font-weight: 700; color: var(--app-primary); padding: 8px 12px;}
    .btn-update { background: var(--app-text); color: white; font-weight: 700; border-radius: 10px; padding: 8px 15px; border: none; transition: 0.2s;}
    .btn-update:hover { background: var(--app-primary); }

    .main-container { padding: 30px 5%; }
    .ui-box { 
        background: var(--app-card); border-radius: 20px; padding: 25px; 
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02); border: 1px solid var(--app-border); 
        margin-bottom: 25px; height: fit-content; 
    }
    .box-header { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; border-bottom: 1px dashed var(--app-border); padding-bottom: 15px;}
    .box-header i { font-size: 1.4rem; color: var(--app-primary); }
    .box-header h5 { font-weight: 800; margin: 0; color: var(--app-text); font-size: 1.2rem;}

    .timeline { border-left: 2px solid #e2e8f0; padding-left: 25px; margin-left: 10px; }
    .timeline-item { position: relative; margin-bottom: 25px; }
    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-item::before {
        content: ""; position: absolute; left: -31px; top: 2px;
        width: 10px; height: 10px; border-radius: 50%; background: white; border: 3px solid var(--app-primary);
    }
    .timeline-item strong { display: block; color: var(--app-text); font-weight: 700; margin-bottom: 5px; font-size: 1.05rem;}
    .timeline-item span { color: var(--app-muted); line-height: 1.6; }

    .service-tag { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 15px;}
    .service-tag i { font-size: 1.2rem; margin-top: 2px;}
    .service-tag p { margin: 0; font-size: 0.95rem; color: var(--app-muted); line-height: 1.5; white-space: pre-wrap;}

    .pax-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 15px; }
    .pax-card { 
        background: var(--app-bg); border: 1px solid var(--app-border); border-radius: 16px; padding: 18px; 
        display: flex; flex-direction: column; justify-content: space-between; transition: 0.2s;
    }
    .pax-card:hover { border-color: #cbd5e1; background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.04); transform: translateY(-3px);}
    .pax-card.is-checked { border-left: 5px solid var(--app-success); background: #f0fdf4; }
    .pax-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;}
    .pax-info h6 { font-weight: 800; font-size: 1.1rem; margin-bottom: 5px; color: var(--app-text);}
    .pax-info p { margin: 0; font-size: 0.9rem; color: var(--app-muted); display: flex; align-items: center; gap: 5px;}
    .pax-qty { background: var(--app-warning-bg); color: var(--app-warning); padding: 5px 10px; border-radius: 8px; font-weight: 700; font-size: 0.9rem;}
    .btn-checkin { background: var(--app-success); color: white; border: none; padding: 10px; border-radius: 10px; font-weight: 700; width: 100%; transition: 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;}
    .btn-checkin:hover { background: #047857; }
    .status-checked { background: var(--app-success-bg); color: var(--app-success); padding: 10px; border-radius: 10px; font-weight: 700; text-align: center; width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px;}
    /* --- BẢNG ĐIỂM DANH CHUYÊN NGHIỆP --- */
    .table-wrapper {
        background: var(--app-card);
        border-radius: 16px;
        border: 1px solid var(--app-border);
        overflow: hidden;
    }
    .table-custom { margin-bottom: 0; width: 100%; border-collapse: collapse; }
    .table-custom thead th {
        background-color: var(--app-muted-bg);
        color: var(--app-muted);
        font-weight: 700; font-size: 0.85rem; text-transform: uppercase;
        padding: 16px; border-bottom: 2px solid var(--app-border); white-space: nowrap;
    }
    .table-custom tbody td {
        padding: 16px; vertical-align: middle; border-bottom: 1px solid var(--app-border);
        color: var(--app-text); font-size: 0.95rem;
    }
    .table-custom tbody tr:hover { background-color: #f8fafc; }
    
    .status-pill {
        display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px;
        border-radius: 50px; font-size: 0.85rem; font-weight: 600;
    }
    .pill-pending { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .pill-success { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    
    .btn-action-table { padding: 8px 16px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; transition: 0.2s; }
</style>

<div class="hero-banner" style="background-image: url('<?= $imgUrl ?>');">
    <div class="hero-overlay">
        <h1 class="hero-title"><?= htmlspecialchars($departure['tour_name'] ?? 'Chưa cập nhật tên tour') ?></h1>
        <div class="hero-meta">
            <span><i class="bi bi-geo-alt-fill"></i> <?= htmlspecialchars($departure['destination'] ?? '--') ?></span>
            <span><i class="bi bi-calendar-event"></i>
                <?= !empty($departure['start_date']) ? date('d/m/Y', strtotime($departure['start_date'])) : '--' ?> -
                <?= !empty($departure['end_date']) ? date('d/m/Y', strtotime($departure['end_date'])) : '--' ?></span>
        </div>
    </div>
</div>

<?php if (isset($departure['status']) && $departure['status'] === 'completed'): ?>
    <div class="container mt-3">
        <div class="p-3 text-center rounded-4 shadow-sm" style="background: linear-gradient(135deg, #10b981, #059669); color: white;">
            <h5 class="mb-1 fw-bold"><i class="bi bi-trophy-fill me-2"></i> TOUR NÀY ĐÃ HOÀN THÀNH XUẤT SẮC</h5>
            <p class="mb-0 opacity-75 small">Chức năng đánh giá đã được mở cho tất cả hành khách.</p>
        </div>
    </div>
<?php endif; ?>

<div class="top-stats-container">
    <div class="row g-3">
        <div class="col-lg-4 col-md-6">
            <div class="stat-card">
                <div class="stat-header-flex">
                    <div class="stat-icon" style="background: var(--app-primary-bg); color: var(--app-primary);"><?= $progress ?>%</div>
                    <div class="stat-info">
                        <h6>Tiến độ điểm danh</h6>
                        <h4><?= $checkedInPax ?> / <?= $totalPax ?> khách</h4>
                    </div>
                </div>
                <div class="progress-container-custom">
                    <div class="progress-bar-fill-custom"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="stat-card">
                <div class="stat-header-flex">
                    <div class="stat-icon" style="background: var(--app-warning-bg); color: var(--app-warning);"><i class="bi bi-building"></i></div>
                    <div class="stat-info">
                        <h6>Khách sạn lưu trú</h6>
                        <h4><?= htmlspecialchars($departure['hotel'] ?? 'Đang cập nhật') ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12">
            <div class="stat-card">
                <form method="POST" action="guide.php?action=updateStatus" class="w-100">
                    <input type="hidden" name="departure_id" value="<?= $departure['departure_id'] ?>">
                    <h6 class="text-muted fw-bold mb-2" style="font-size: 0.9rem; text-transform: uppercase;">Trạng thái Tour</h6>
                    <div class="d-flex gap-2">
                        <select name="status" class="form-select status-select flex-grow-1">
                            <option value="upcoming" <?= ($departure['status'] == 'upcoming') ? 'selected' : '' ?>>Chờ khởi hành</option>
                            <option value="ongoing" <?= ($departure['status'] == 'ongoing') ? 'selected' : '' ?>>Đang diễn ra</option>
                            <option value="completed" <?= ($departure['status'] == 'completed') ? 'selected' : '' ?>>Đã hoàn thành</option>
                        </select>
                        <button type="submit" class="btn-update">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="main-container">
    <div class="row g-4">
        <div class="col-xl-4 col-lg-5">
            <div class="ui-box">
                <div class="box-header"><i class="bi bi-map-fill text-warning"></i><h5>Lịch trình Tour</h5></div>
                <div class="timeline">
                    <?php
                    $itineraryText = $departure['itinerary'] ?? '';
                    if (empty($itineraryText)) {
                        echo "<p class='text-muted'>Chưa có thông tin lịch trình.</p>";
                    } else {
                        $days = explode('|', $itineraryText);
                        foreach ($days as $day):
                            $day = trim($day);
                            if (empty($day)) continue;
                            $parts = explode(':', $day, 2);
                            ?>
                            <div class="timeline-item">
                                <?php if (count($parts) == 2): ?>
                                    <strong><?= htmlspecialchars(trim($parts[0])) ?></strong>
                                    <span><?= htmlspecialchars(trim($parts[1])) ?></span>
                                <?php else: ?>
                                    <span><?= htmlspecialchars($day) ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; } ?>
                </div>
            </div>

            <div class="ui-box">
                <div class="box-header"><i class="bi bi-bag-check-fill text-primary"></i><h5>Thông tin Dịch vụ</h5></div>
                <div class="service-tag">
                    <i class="bi bi-check-circle-fill text-success"></i>
                    <div><strong class="text-success d-block mb-1">Bao gồm</strong><p><?= htmlspecialchars($departure['include_service'] ?? 'Chưa cập nhật') ?></p></div>
                </div>
                <div class="service-tag mt-4">
                    <i class="bi bi-x-circle-fill text-danger"></i>
                    <div><strong class="text-danger d-block mb-1">Không bao gồm</strong><p><?= htmlspecialchars($departure['exclude_service'] ?? 'Chưa cập nhật') ?></p></div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="ui-box">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3" style="border-style: dashed !important; border-color: var(--app-border) !important;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-people-fill text-success fs-4"></i>
                        <h5 class="fw-bold m-0 text-dark">Danh sách (<?= count($bookings) ?> đơn)</h5>
                    </div>
                    <div class="d-flex gap-2 flex-wrap justify-content-end">
                        <button id="btn-scan-qr" class="btn btn-primary btn-sm fw-bold" style="border-radius: 8px;">
                            <i class="bi bi-qr-code-scan"></i> Quét QR
                        </button>
                        <button onclick="exportTableToExcel('attendanceTable', 'Danh_Sach_Khach_<?= $departure['departure_id'] ?>')" class="btn btn-outline-success btn-sm fw-bold" style="border-radius: 8px;">
                            <i class="bi bi-file-earmark-excel"></i> Xuất Excel
                        </button>
                        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm fw-bold d-none d-md-block" style="border-radius: 8px;">
                            <i class="bi bi-printer"></i> In DS
                        </button>
                    </div>
                </div>

                <div id="qr-reader-container" class="mb-4 d-none">
                    <div class="p-3 bg-light border rounded-3 text-center">
                        <h6 class="fw-bold text-primary mb-2"><i class="bi bi-camera-video me-1"></i> Camera Check-in</h6>
                        <p class="text-muted small mb-3">Đưa mã QR trên vé của khách hàng vào khung hình</p>
                        <div id="qr-reader" style="width: 100%; max-width: 500px; margin: 0 auto; border-radius: 12px; overflow: hidden;"></div>
                        <button id="btn-close-qr" class="btn btn-sm btn-outline-danger mt-3 px-4 rounded-pill">Đóng Camera</button>
                    </div>
                    <form id="qr-submit-form" method="POST" action="guide.php?action=checkin" class="d-none">
                        <input type="hidden" name="booking_id" id="scanned_booking_id" value="">
                    </form>
                </div>

                <?php if (empty($bookings)): ?>
                    <div class="text-center p-5 border rounded-4 bg-light" style="border-style: dashed !important;">
                        <i class="bi bi-person-x text-muted fs-1 mb-2 d-block"></i>
                        <span class="text-muted fw-medium">Chưa có hành khách nào đặt tour này.</span>
                    </div>
                <?php else: ?>
                    <div class="table-wrapper table-responsive">
                        <table class="table table-custom" id="attendanceTable">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">STT</th>
                                    <th width="30%">Khách hàng</th>
                                    <th width="15%" class="text-center">SL (Pax)</th>
                                    <th width="25%" class="text-center">Trạng thái</th>
                                    <th width="25%" class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $stt = 1; foreach ($bookings as $b): ?>
                                    <tr>
                                        <td class="text-center fw-bold text-muted"><?= $stt++ ?></td>
                                        <td>
                                            <div class="fw-bold text-dark fs-6"><?= htmlspecialchars($b['customer_name']) ?></div>
                                            <div class="text-muted mt-1" style="font-size: 0.85rem;">
                                                <i class="bi bi-telephone-fill me-1"></i><?= htmlspecialchars($b['phone']) ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-dark border px-3 py-2 fs-6"><?= $b['number_of_people'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($b['status'] == 'checked_in'): ?>
                                                <span class="status-pill pill-success">
                                                    <i class="bi bi-check-circle-fill"></i> Có mặt
                                                </span>
                                            <?php else: ?>
                                                <span class="status-pill pill-pending">
                                                    <i class="bi bi-clock-history"></i> Chờ check-in
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button type="button" class="btn btn-outline-info btn-action-table px-2"
                                                        title="Xem chi tiết"
                                                        onclick="showCustomerDetails(this)"
                                                        data-name="<?= htmlspecialchars($b['customer_name'] ?? 'Không rõ') ?>"
                                                        data-phone="<?= htmlspecialchars($b['phone'] ?? 'Không có') ?>"
                                                        data-email="<?= htmlspecialchars($b['email'] ?? 'Không có') ?>"
                                                        data-pax="<?= $b['number_of_people'] ?? 0 ?>"
                                                        data-note="<?= htmlspecialchars($b['note'] ?? 'Không có ghi chú') ?>"
                                                        data-totalprice="<?= isset($b['total_price']) ? number_format($b['total_price']) : 0 ?> VNĐ">
                                                    <i class="bi bi-info-circle"></i>
                                                </button>

                                                <?php if ($b['status'] != 'checked_in'): ?>
                                                    <form method="POST" action="guide.php?action=checkin" class="m-0">
                                                        <input type="hidden" name="booking_id" value="<?= $b['booking_id'] ?>">
                                                        <button type="submit" class="btn btn-success btn-action-table px-2" title="Check-in">
                                                            <i class="bi bi-qr-code-scan"></i> <span class="d-none d-md-inline ms-1">Check-in</span>
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic small d-flex align-items-center">
                                                        <i class="bi bi-check2-all text-success fs-5"></i>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

<div class="modal fade" id="customerDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-person-vcard text-primary me-2"></i>Thông tin hành khách</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <h6 class="fw-bold text-primary mb-1 fs-5" id="detail-name">...</h6>
                    <p class="text-muted small mb-0"><i class="bi bi-telephone-fill me-1"></i> <span id="detail-phone">...</span></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <span class="text-muted">Email liên hệ:</span>
                        <strong id="detail-email">...</strong>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <span class="text-muted">Số lượng tham gia:</span>
                        <strong id="detail-pax" class="text-dark">...</strong>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-center">
                        <span class="text-muted">Tổng thanh toán:</span>
                        <strong id="detail-total" class="text-danger fs-5">...</strong>
                    </li>
                    <li class="list-group-item px-0 d-flex flex-column align-items-start border-bottom-0">
                        <span class="text-muted d-block mb-2">Ghi chú đặc biệt:</span>
                        <p class="mb-0 bg-light p-2 rounded-2 w-100" style="font-size: 0.9rem; border: 1px dashed #e2e8f0;" id="detail-note">...</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

<?php if (isset($_SESSION['show_complete_alert'])): ?>
    <script>
        Swal.fire({
            title: 'Chốt Tour Thành Công!',
            text: 'Toàn bộ dữ liệu đoàn đã được lưu trữ. Khách hàng đã có thể gửi đánh giá!',
            icon: 'success',
            confirmButtonText: 'Tuyệt vời',
            confirmButtonColor: '#10b981',
            backdrop: `rgba(16, 185, 129, 0.15)`
        });
    </script>
    <?php unset($_SESSION['show_complete_alert']); ?>
<?php endif; ?>
<script>
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    
    // Sao chép bảng để xóa cột "Thao tác" (cột số 5) khi xuất Excel
    var tableClone = tableSelect.cloneNode(true);
    for (var i = 0; i < tableClone.rows.length; i++) {
        tableClone.rows[i].deleteCell(-1); 
    }

    var tableHTML = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta charset="utf-8"></head><body><table>' + tableClone.innerHTML + '</table></body></html>';
    
    filename = filename ? filename + '.xls' : 'Danh_Sach_Khach.xls';
    
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], { type: dataType });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        downloadLink.href = 'data:' + dataType + ', ' + encodeURIComponent(tableHTML);
        downloadLink.download = filename;
        downloadLink.click();
    }
}
</script>
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    // --- 1. LOGIC XEM CHI TIẾT (NÚT INFO) ---
    function showCustomerDetails(button) {
        document.getElementById('detail-name').innerText = button.getAttribute('data-name');
        document.getElementById('detail-phone').innerText = button.getAttribute('data-phone');
        document.getElementById('detail-email').innerText = button.getAttribute('data-email');
        document.getElementById('detail-pax').innerText = button.getAttribute('data-pax') + " pax";
        document.getElementById('detail-total').innerText = button.getAttribute('data-totalprice');
        document.getElementById('detail-note').innerText = button.getAttribute('data-note');

        var myModal = new bootstrap.Modal(document.getElementById('customerDetailModal'));
        myModal.show();
    }

    // --- 2. LOGIC QUÉT MÃ QR BẰNG CAMERA ---
    document.addEventListener("DOMContentLoaded", function() {
        const btnScanQR = document.getElementById('btn-scan-qr');
        const btnCloseQR = document.getElementById('btn-close-qr');
        const qrContainer = document.getElementById('qr-reader-container');
        const formSubmitQR = document.getElementById('qr-submit-form');
        const inputBookingId = document.getElementById('scanned_booking_id');
        
        let html5QrcodeScanner = null;

        // Bật Camera
        btnScanQR.addEventListener('click', function() {
            qrContainer.classList.remove('d-none'); // Hiện khung camera
            btnScanQR.classList.add('d-none'); // Ẩn nút quét đi

            // Cấu hình máy quét
            html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", 
                { fps: 10, qrbox: {width: 250, height: 250} },
                false
            );
            
            // Xử lý khi quét thành công
            html5QrcodeScanner.render(function(decodedText, decodedResult) {
                // Tắt máy quét ngay lập tức để tránh quét 2 lần
                html5QrcodeScanner.clear();
                
                // Điền mã QR (Thường là booking_id) vào form và Submit
                inputBookingId.value = decodedText;
                
                Swal.fire({
                    title: 'Đang xử lý...',
                    text: 'Mã vé: ' + decodedText,
                    icon: 'info',
                    showConfirmButton: false,
                    timer: 1500
                });

                setTimeout(() => {
                    formSubmitQR.submit(); // Gửi thẳng lên Server
                }, 1000);

            }, function(errorMessage) {
                // Bỏ qua lỗi quét (khi chưa lọt đúng khung)
            });
        });

        // Tắt Camera
        btnCloseQR.addEventListener('click', function() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }
            qrContainer.classList.add('d-none');
            btnScanQR.classList.remove('d-none');
        });
    });

    // --- 3. XUẤT EXCEL (Giữ nguyên của bạn) ---
    function exportTableToExcel(tableID, filename = ''){
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableClone = tableSelect.cloneNode(true);
        for (var i = 0; i < tableClone.rows.length; i++) { tableClone.rows[i].deleteCell(-1); }
        var tableHTML = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><meta charset="utf-8"></head><body><table>' + tableClone.innerHTML + '</table></body></html>';
        filename = filename ? filename + '.xls' : 'Danh_Sach_Khach.xls';
        var downloadLink = document.createElement("a");
        document.body.appendChild(downloadLink);
        if(navigator.msSaveOrOpenBlob){
            navigator.msSaveOrOpenBlob( new Blob(['\ufeff', tableHTML], { type: dataType }), filename);
        }else{
            downloadLink.href = 'data:' + dataType + ', ' + encodeURIComponent(tableHTML);
            downloadLink.download = filename; downloadLink.click();
        }
    }
</script>
<?php include __DIR__ . '/../layouts/footer.php'; ?>