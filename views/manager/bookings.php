<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php
// TỔ CHỨC LẠI DỮ LIỆU: Nhóm các đơn đặt theo "Tên Tour + Ngày khởi hành"
$groupedBookings = [];
if (!empty($bookings)) {
    foreach ($bookings as $b) {
        // --- SỬA Ở ĐÂY: Dùng tour_name thay vì tour_id ---
        $tourName = $b['tour_name'] ?? 'Tour không xác định';
        $startDate = $b['start_date'] ?? '';
        
        // Tạo khóa nhóm: Tên tour + Ngày khởi hành
        $groupKey = md5($tourName . '_' . $startDate); // Dùng md5 để tạo key mảng an toàn
        
        if (!isset($groupedBookings[$groupKey])) {
            $groupedBookings[$groupKey] = [
                'tour_name' => $tourName,
                'start_date' => $startDate,
                'total_revenue' => 0,
                'total_bookings' => 0,
                'items' => []
            ];
        }
        
        $groupedBookings[$groupKey]['items'][] = $b;
        $groupedBookings[$groupKey]['total_bookings']++;
        
        // Chỉ cộng doanh thu những đơn đã duyệt/hoàn thành
        if ($b['status'] == 'confirmed' || $b['status'] == 'completed') {
            $groupedBookings[$groupKey]['total_revenue'] += $b['total_price'];
        }
    }
}
?>

<style>
    /* --- BIẾN MÀU & CẤU TRÚC CHUNG --- */
    :root {
        --admin-primary: #0194f3;
        --admin-success: #10b981;
        --admin-warning: #f59e0b;
        --admin-danger: #ef4444;
        --admin-info: #0ea5e9;
        --admin-bg: #f1f5f9; 
        --admin-surface: #ffffff;
        --admin-border: #e2e8f0;
        --admin-text-main: #0f172a; 
        --admin-text-muted: #64748b; 
    }

    body { background-color: var(--admin-bg); font-family: 'Inter', 'Segoe UI', sans-serif; }
    .admin-container { max-width: 1400px; margin: 40px auto; padding: 0 15px; }
    .admin-title { font-size: 1.8rem; font-weight: 800; color: var(--admin-text-main); margin-bottom: 5px; }
    
    /* BỘ LỌC CHUYÊN NGHIỆP */
    .filter-card {
        background: var(--admin-surface);
        border-radius: 16px;
        padding: 24px;
        border: 1px solid var(--admin-border);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        margin-bottom: 24px;
    }
    
    .filter-label { font-size: 0.85rem; font-weight: 700; color: var(--admin-text-muted); margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
    .form-control, .form-select { border-radius: 10px; border-color: var(--admin-border); padding: 10px 15px; box-shadow: none !important; transition: 0.2s; }
    .form-control:focus, .form-select:focus { border-color: var(--admin-primary); background-color: #f8fafc; }
    .input-group-text { border-radius: 10px; background-color: white; border-color: var(--admin-border); color: var(--admin-text-muted); }

    /* ACCORDION (NHÓM TOUR) */
    .tour-accordion .accordion-item {
        border: 1px solid var(--admin-border);
        border-radius: 16px !important;
        margin-bottom: 16px;
        background-color: white;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .tour-accordion .accordion-button {
        padding: 20px 24px;
        background-color: white;
        color: var(--admin-text-main);
        box-shadow: none !important;
    }
    .tour-accordion .accordion-button:not(.collapsed) {
        background-color: #f8fafc;
        border-bottom: 1px solid var(--admin-border);
    }
    .tour-group-title { font-size: 1.1rem; font-weight: 800; color: var(--admin-text-main); display: flex; align-items: center; gap: 10px; }
    .tour-group-meta { font-size: 0.9rem; color: var(--admin-text-muted); font-weight: 500; display: flex; gap: 20px; align-items: center; margin-top: 5px; }
    
    /* BẢNG CHI TIẾT TRONG ACCORDION */
    .table th {
        background-color: #f1f5f9; color: var(--admin-text-muted); font-weight: 700;
        text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; padding: 16px;
        border-bottom: none; white-space: nowrap;
    }
    .table td { padding: 16px; vertical-align: middle; color: var(--admin-text-main); border-bottom: 1px solid var(--admin-border); }
    .table tbody tr:last-child td { border-bottom: none; }
    .table tbody tr:hover { background-color: #f8fafc; }

    /* BADGE TRẠNG THÁI */
    .badge-status { padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 0.75rem; display: inline-block; min-width: 90px; text-align: center; }
    .status-pending { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .status-confirmed { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .status-cancelled { background: #fef2f2; color: #dc2626; border: 1px solid #fecdd3; }
    .status-refunded { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

    /* NÚT THAO TÁC */
    .action-group { display: flex; gap: 8px; justify-content: center; }
    .btn-icon {
        width: 34px; height: 34px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;
        font-size: 1rem; border: none; transition: 0.2s; background: white; color: var(--admin-text-muted); text-decoration: none; border: 1px solid var(--admin-border);
    }
    .btn-icon:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
    .btn-icon-info:hover { border-color: var(--admin-info); color: var(--admin-info); background: #e0f2fe; }
    .btn-icon-success:hover { border-color: var(--admin-success); color: var(--admin-success); background: #d1fae5; }
    .btn-icon-warning:hover { border-color: var(--admin-warning); color: var(--admin-warning); background: #fef3c7; }
    .btn-icon-danger:hover { border-color: var(--admin-danger); color: var(--admin-danger); background: #fee2e2; }
</style>

<div class="admin-container">
    <div class="row g-4">
        
        <?php 
            $activeMenu = 'bookings'; 
            include __DIR__ . '/../layouts/sidebar_manager.php'; 
        ?>

        <div class="col-lg-9">
            <div class="mb-4">
                <h1 class="admin-title">Quản Lý Đơn Đặt Tour</h1>
                <p class="text-muted mb-0 fw-medium">Phân loại chi tiết theo từng chuyến đi và quản lý bộ lọc chuyên sâu.</p>
            </div>

            <!-- BỘ LỌC TÌM KIẾM NÂNG CAO -->
            <div class="filter-card">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="filter-label">Tìm kiếm chung</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Mã đơn, Tên khách hàng..." onkeyup="filterData()">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="filter-label">Trạng thái đơn</label>
                        <select id="statusFilter" class="form-select" onchange="filterData()">
                            <option value="all">Tất cả trạng thái</option>
                            <option value="pending">⏳ Chờ duyệt</option>
                            <option value="confirmed">✅ Đã duyệt / Thành công</option>
                            <option value="cancelled">❌ Đã hủy</option>
                            <option value="refunded">🔄 Đã hoàn tiền</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="filter-label">Ngày đặt (Từ - Đến)</label>
                        <div class="input-group">
                            <input type="date" id="dateFrom" class="form-control" onchange="filterData()">
                            <span class="input-group-text bg-light text-muted px-2 border-start-0 border-end-0">đến</span>
                            <input type="date" id="dateTo" class="form-control" onchange="filterData()">
                        </div>
                    </div>
                </div>
            </div>

            <!-- DANH SÁCH TOUR ACCORDION -->
            <?php if (!empty($groupedBookings)): ?>
                <div class="accordion tour-accordion" id="tourAccordion">
                    
                    <?php $index = 0; foreach ($groupedBookings as $key => $group): $index++; ?>
                        <div class="accordion-item group-container">
                            <h2 class="accordion-header" id="heading_<?= $index ?>">
                                <button class="accordion-button <?= $index === 1 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?= $index ?>" aria-expanded="<?= $index === 1 ? 'true' : 'false' ?>">
                                    <div class="w-100 pe-3">
                                        <div class="tour-group-title">
                                            <i class="bi bi-map-fill text-primary"></i> <?= htmlspecialchars($group['tour_name']) ?>
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill ms-2" style="font-size: 0.8rem; font-weight: 700; border: 1px solid #bae6fd;">
                                                <?= $group['total_bookings'] ?> Đơn đặt
                                            </span>
                                        </div>
                                        <div class="tour-group-meta">
                                            <span><i class="bi bi-calendar3 me-1 text-warning"></i> Khởi hành: <strong><?= date('d/m/Y', strtotime($group['start_date'])) ?></strong></span>
                                            <span class="text-success"><i class="bi bi-cash-coin me-1"></i> Tạm tính: <strong><?= number_format($group['total_revenue']) ?> đ</strong> (Đã duyệt)</span>
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse_<?= $index ?>" class="accordion-collapse collapse <?= $index === 1 ? 'show' : '' ?>" data-bs-parent="#tourAccordion">
                                <div class="accordion-body p-0">
                                    <div class="table-responsive">
                                        <table class="table mb-0 align-middle">
                                            <thead>
                                                <tr>
                                                    <th width="12%" class="ps-4">Mã Đơn</th>
                                                    <th width="20%">Ngày đặt</th>
                                                    <th width="25%">Khách hàng</th>
                                                    <th width="15%" class="text-end">Tổng tiền</th>
                                                    <th width="13%" class="text-center">Trạng thái</th>
                                                    <th width="15%" class="text-center pe-4">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($group['items'] as $b): ?>
                                                    <tr class="booking-row" 
                                                        data-status="<?= $b['status'] ?>" 
                                                        data-date="<?= date('Y-m-d', strtotime($b['booking_date'])) ?>">
                                                        
                                                        <td class="ps-4">
                                                            <div class="fw-bold text-primary search-target">#<?= $b['booking_id'] ?></div>
                                                        </td>
                                                        
                                                        <td>
                                                            <div class="fw-medium text-dark"><?= date('d/m/Y', strtotime($b['booking_date'])) ?></div>
                                                            <div class="small text-muted"><?= date('H:i', strtotime($b['booking_date'])) ?></div>
                                                        </td>

                                                        <td>
                                                            <div class="fw-bold text-dark search-target"><?= htmlspecialchars($b['customer_name']) ?></div>
                                                            <div class="small text-muted mt-1"><i class="bi bi-people-fill me-1"></i><?= $b['number_of_people'] ?> khách</div>
                                                        </td>
                                                        
                                                        <td class="text-end">
                                                            <div class="fw-bold text-danger"><?= number_format($b['total_price']) ?> đ</div>
                                                        </td>

                                                        <td class="text-center">
                                                            <?php if ($b['status'] == 'pending'): ?>
                                                                <span class="badge-status status-pending">Chờ duyệt</span>
                                                            <?php elseif ($b['status'] == 'confirmed' || $b['status'] == 'completed'): ?>
                                                                <span class="badge-status status-confirmed">Đã duyệt</span>
                                                            <?php elseif ($b['status'] == 'cancelled'): ?>
                                                                <span class="badge-status status-cancelled">Đã hủy</span>
                                                            <?php elseif ($b['status'] == 'refunded'): ?>
                                                                <span class="badge-status status-refunded">Hoàn tiền</span>
                                                            <?php endif; ?>
                                                        </td>

                                                        <td class="text-center pe-4">
                                                            <div class="action-group">
                                                                <a href="manager.php?action=bookingDetail&id=<?= $b['booking_id'] ?>" class="btn-icon btn-icon-info" title="Xem chi tiết" data-bs-toggle="tooltip"><i class="bi bi-eye"></i></a>
                                                                
                                                                <?php if ($b['status'] == 'pending'): ?>
                                                                    <a href="manager.php?action=confirmBooking&id=<?= $b['booking_id'] ?>" class="btn-icon btn-icon-success" title="Duyệt đơn" data-bs-toggle="tooltip" onclick="return confirm('Xác nhận duyệt đơn này?')"><i class="bi bi-check-lg"></i></a>
                                                                <?php endif; ?>

                                                                <?php if ($b['status'] == 'confirmed'): ?>
                                                                    <a href="manager.php?action=refundBooking&id=<?= $b['booking_id'] ?>" class="btn-icon btn-icon-warning" title="Hoàn tiền" data-bs-toggle="tooltip" onclick="return confirm('Xác nhận hoàn tiền cho đơn này?')"><i class="bi bi-arrow-counterclockwise"></i></a>
                                                                <?php endif; ?>

                                                                <?php if ($b['status'] != 'cancelled' && $b['status'] != 'refunded'): ?>
                                                                    <a href="manager.php?action=cancelBooking&id=<?= $b['booking_id'] ?>" class="btn-icon btn-icon-danger" title="Hủy đơn" data-bs-toggle="tooltip" onclick="return confirm('Chắc chắn hủy đơn này?')"><i class="bi bi-x-lg"></i></a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                </div>
                
                <!-- Thông báo khi lọc không ra kết quả -->
                <div id="noDataMsg" class="text-center py-5 bg-white rounded-4 border d-none">
                    <i class="bi bi-search fs-1 d-block mb-3 text-secondary opacity-25"></i>
                    <h5 class="fw-bold text-dark">Không tìm thấy kết quả phù hợp</h5>
                    <p class="mb-0 text-muted">Vui lòng thay đổi bộ lọc tìm kiếm hoặc từ khóa.</p>
                </div>
                
            <?php else: ?>
                <div class="text-center py-5 bg-white rounded-4 border shadow-sm">
                    <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary opacity-25"></i>
                    <h5 class="fw-bold text-dark">Chưa có đơn đặt nào</h5>
                    <p class="mb-0 text-muted">Hệ thống chưa ghi nhận giao dịch nào từ khách hàng.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
    // Kích hoạt Tooltip của Bootstrap cho các nút chức năng
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // LỌC DỮ LIỆU BẰNG JAVASCRIPT
    function filterData() {
        // Lấy giá trị từ các ô input
        const searchText = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const dateFrom = document.getElementById('dateFrom').value;
        const dateTo = document.getElementById('dateTo').value;

        let visibleGroups = 0;
        const groups = document.querySelectorAll('.group-container');

        groups.forEach(group => {
            let visibleRowsInGroup = 0;
            const rows = group.querySelectorAll('.booking-row');

            rows.forEach(row => {
                // 1. Kiểm tra Text
                let rowContent = "";
                row.querySelectorAll('.search-target').forEach(t => rowContent += t.innerText.toLowerCase() + " ");
                const matchSearch = rowContent.includes(searchText);

                // 2. Kiểm tra Trạng thái
                const rowStatus = row.getAttribute('data-status');
                const matchStatus = (statusFilter === 'all' || rowStatus === statusFilter);

                // 3. Kiểm tra Thời gian
                const rowDate = row.getAttribute('data-date');
                let matchDate = true;
                if (dateFrom && rowDate < dateFrom) matchDate = false;
                if (dateTo && rowDate > dateTo) matchDate = false;

                // Nếu thỏa mãn tất cả điều kiện -> Hiển thị dòng đó
                if (matchSearch && matchStatus && matchDate) {
                    row.style.display = '';
                    visibleRowsInGroup++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Nếu Group (Tour) không có dòng nào thỏa mãn, ẩn luôn cả Group đó đi
            if (visibleRowsInGroup > 0) {
                group.style.display = '';
                visibleGroups++;
            } else {
                group.style.display = 'none';
            }
        });

        // Hiển thị thông báo "Không có dữ liệu" nếu toàn bộ group bị ẩn
        const noDataMsg = document.getElementById('noDataMsg');
        if (noDataMsg) {
            if (visibleGroups === 0 && groups.length > 0) {
                noDataMsg.classList.remove('d-none');
            } else {
                noDataMsg.classList.add('d-none');
            }
        }
    }
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>