<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    /* --- BIẾN MÀU & CẤU TRÚC CHUNG --- */
    :root {
        --admin-primary: #0194f3;
        --admin-success: #10b981;
        --admin-warning: #f59e0b;
        --admin-danger: #ef4444;
        --admin-info: #0ea5e9;
        --admin-bg: #f8fafc; 
        --admin-surface: #ffffff;
        --admin-border: #e2e8f0;
        --admin-text-main: #0f172a; 
        --admin-text-muted: #64748b; 
    }

    body { background-color: var(--admin-bg); font-family: 'Inter', 'Segoe UI', sans-serif; }
    
    .admin-container { max-width: 1400px; margin: 40px auto; padding: 0 15px; }
    
    .admin-title { font-size: 1.8rem; font-weight: 800; color: var(--admin-text-main); margin-bottom: 5px; }
    
    .admin-card {
        background: var(--admin-surface);
        border-radius: 16px;
        padding: 24px;
        border: 1px solid var(--admin-border);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }
    
    /* BẢNG DỮ LIỆU */
    .table th {
        background-color: #f8fafc; color: var(--admin-text-muted); font-weight: 700;
        text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; padding: 16px;
        border-bottom: 2px solid var(--admin-border); white-space: nowrap;
    }
    .table td { padding: 16px; vertical-align: middle; color: var(--admin-text-main); border-bottom: 1px solid var(--admin-border); }
    .table tbody tr { transition: all 0.2s; }
    .table tbody tr:hover { background-color: #f8fafc; }

    /* NÚT HÀNH ĐỘNG MỚI (Icon ngang, gọn gàng) */
    .action-group { display: flex; gap: 8px; justify-content: center; }
    .btn-icon {
        width: 36px; height: 36px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;
        font-size: 1.1rem; border: none; transition: 0.2s; background: #f1f5f9; color: var(--admin-text-muted); text-decoration: none;
    }
    .btn-icon-info:hover { background: #e0f2fe; color: var(--admin-info); }
    .btn-icon-success:hover { background: #d1fae5; color: var(--admin-success); }
    .btn-icon-warning:hover { background: #fef3c7; color: var(--admin-warning); }
    .btn-icon-danger:hover { background: #fee2e2; color: var(--admin-danger); }

    /* BADGE TRẠNG THÁI */
    .badge-status { padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.75rem; display: inline-block; min-width: 90px; text-align: center; }
    .status-pending { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .status-confirmed { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
    .status-cancelled { background: #fef2f2; color: #dc2626; border: 1px solid #fecdd3; }
    .status-refunded { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

    /* BỘ LỌC TÌM KIẾM */
    .filter-tabs { display: flex; gap: 10px; margin-bottom: 20px; overflow-x: auto; padding-bottom: 5px; }
    .filter-tab {
        padding: 8px 16px; border-radius: 8px; background: white; border: 1px solid var(--admin-border);
        color: var(--admin-text-muted); font-weight: 600; cursor: pointer; transition: 0.2s; white-space: nowrap;
    }
    .filter-tab:hover { border-color: var(--admin-primary); color: var(--admin-primary); }
    .filter-tab.active { background: var(--admin-primary); color: white; border-color: var(--admin-primary); box-shadow: 0 4px 10px rgba(1, 148, 243, 0.2); }
    
    .search-box { min-width: 250px; }
    .search-box .input-group-text { background: white; border-right: none; color: #94a3b8; }
    .search-box .form-control { border-left: none; box-shadow: none !important; }
    .search-box .form-control:focus { border-color: #dee2e6; }
</style>

<div class="admin-container">
    <div class="row g-4">
        
        <?php 
            $activeMenu = 'bookings'; 
            include __DIR__ . '/../layouts/sidebar_manager.php'; 
        ?>

        <div class="col-lg-9">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
                <div>
                    <h1 class="admin-title">Quản Lý Đơn Đặt Tour</h1>
                    <p class="text-muted mb-0 fw-medium">Theo dõi giao dịch và cập nhật trạng thái đơn hàng của hệ thống.</p>
                </div>
                
                <div class="search-box">
                    <div class="input-group shadow-sm rounded-3">
                        <span class="input-group-text rounded-start-3"><i class="bi bi-search"></i></span>
                        <input type="text" id="searchInput" class="form-control rounded-end-3 py-2" placeholder="Tìm tên, mã đơn..." onkeyup="filterBookings()">
                    </div>
                </div>
            </div>

            <div class="filter-tabs" id="statusTabs">
                <button class="filter-tab active" onclick="filterByStatus('all', this)">Tất cả đơn</button>
                <button class="filter-tab" onclick="filterByStatus('pending', this)">⏳ Chờ duyệt</button>
                <button class="filter-tab" onclick="filterByStatus('confirmed', this)">✅ Đã duyệt</button>
                <button class="filter-tab" onclick="filterByStatus('cancelled', this)">❌ Đã hủy</button>
                <button class="filter-tab" onclick="filterByStatus('refunded', this)">🔄 Đã hoàn tiền</button>
            </div>

            <div class="admin-card">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle" id="bookingsTable">
                        <thead>
                            <tr>
                                <th width="12%">Mã Đơn</th>
                                <th width="20%">Khách hàng</th>
                                <th width="30%">Tour & Khởi hành</th>
                                <th width="15%" class="text-end">Tổng tiền</th>
                                <th width="10%" class="text-center">Trạng thái</th>
                                <th width="13%" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($bookings)): ?>
                                <?php foreach ($bookings as $b): ?>
                                    <tr class="booking-row" data-status="<?= $b['status'] ?>">
                                        <td>
                                            <div class="fw-bold text-primary search-target">#<?= $b['booking_id'] ?></div>
                                            <div class="small text-muted mt-1"><?= date('d/m/Y', strtotime($b['booking_date'] ?? 'now')) ?></div>
                                        </td>

                                        <td>
                                            <div class="fw-bold text-dark search-target"><?= htmlspecialchars($b['customer_name']) ?></div>
                                            <div class="small text-muted mt-1"><i class="bi bi-people-fill me-1"></i><?= $b['number_of_people'] ?> khách</div>
                                        </td>
                                        
                                        <td>
                                            <div class="fw-bold text-dark mb-1 search-target" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                <?= htmlspecialchars($b['tour_name']) ?>
                                            </div>
                                            <div class="small text-muted fw-medium"><i class="bi bi-calendar3 me-1"></i>KH: <?= date('d/m/Y', strtotime($b['start_date'])) ?></div>
                                        </td>
                                        
                                        <td class="text-end">
                                            <div class="fw-bold text-danger"><?= number_format($b['total_price']) ?> đ</div>
                                        </td>

                                        <td class="text-center">
                                            <?php if ($b['status'] == 'pending'): ?>
                                                <span class="badge-status status-pending">Chờ duyệt</span>
                                            <?php elseif ($b['status'] == 'confirmed'): ?>
                                                <span class="badge-status status-confirmed">Đã duyệt</span>
                                            <?php elseif ($b['status'] == 'cancelled'): ?>
                                                <span class="badge-status status-cancelled">Đã hủy</span>
                                            <?php elseif ($b['status'] == 'refunded'): ?>
                                                <span class="badge-status status-refunded">Hoàn tiền</span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <div class="action-group">
                                                <a href="manager.php?action=bookingDetail&id=<?= $b['booking_id'] ?>" class="btn-icon btn-icon-info" title="Xem chi tiết"><i class="bi bi-eye"></i></a>
                                                
                                                <?php if ($b['status'] == 'pending'): ?>
                                                    <a href="manager.php?action=confirmBooking&id=<?= $b['booking_id'] ?>" class="btn-icon btn-icon-success" title="Duyệt đơn" onclick="return confirm('Xác nhận duyệt đơn này?')"><i class="bi bi-check-lg"></i></a>
                                                <?php endif; ?>

                                                <?php if ($b['status'] == 'confirmed'): ?>
                                                    <a href="manager.php?action=refundBooking&id=<?= $b['booking_id'] ?>" class="btn-icon btn-icon-warning" title="Hoàn tiền" onclick="return confirm('Xác nhận hoàn tiền cho đơn này?')"><i class="bi bi-arrow-counterclockwise"></i></a>
                                                <?php endif; ?>

                                                <?php if ($b['status'] != 'cancelled' && $b['status'] != 'refunded'): ?>
                                                    <a href="manager.php?action=cancelBooking&id=<?= $b['booking_id'] ?>" class="btn-icon btn-icon-danger" title="Hủy đơn" onclick="return confirm('Chắc chắn hủy đơn này?')"><i class="bi bi-x-lg"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr id="noDataRow">
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary opacity-25"></i>
                                        <h5 class="fw-bold text-dark">Chưa có đơn đặt nào</h5>
                                        <p class="mb-0">Các đơn đặt tour mới sẽ xuất hiện tại đây.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script>
    let currentStatusFilter = 'all';

    // Hàm Lọc theo Trạng thái (Click vào Tabs)
    function filterByStatus(status, btnElement) {
        currentStatusFilter = status;
        
        // Đổi màu tab active
        document.querySelectorAll('.filter-tab').forEach(btn => btn.classList.remove('active'));
        btnElement.classList.add('active');
        
        applyFilters();
    }

    // Hàm Lọc theo Text (Gõ vào ô Search)
    function filterBookings() {
        applyFilters();
    }

    // Hàm Gộp Cả 2 Bộ Lọc (Tìm kiếm + Tabs Trạng thái)
    function applyFilters() {
        let input = document.getElementById('searchInput').value.toLowerCase();
        let rows = document.querySelectorAll('.booking-row');
        let visibleCount = 0;

        rows.forEach(row => {
            let rowStatus = row.getAttribute('data-status');
            
            // Lấy text của các cột có gắn class search-target (Mã đơn, Khách hàng, Tên Tour)
            let targets = row.querySelectorAll('.search-target');
            let rowContent = "";
            targets.forEach(t => rowContent += t.innerText.toLowerCase() + " ");

            // Kiểm tra điều kiện: Đúng tab trạng thái VÀ chứa từ khóa tìm kiếm
            let matchStatus = (currentStatusFilter === 'all' || rowStatus === currentStatusFilter);
            let matchSearch = rowContent.includes(input);

            if (matchStatus && matchSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Xử lý hiện thông báo nếu lọc không ra kết quả nào
        let noDataRow = document.getElementById('noDataRow');
        if(visibleCount === 0 && rows.length > 0) {
            if(!noDataRow) {
                let tbody = document.querySelector('#bookingsTable tbody');
                tbody.insertAdjacentHTML('beforeend', '<tr id="noDataRow"><td colspan="6" class="text-center py-5 text-muted">Không tìm thấy kết quả phù hợp.</td></tr>');
            } else {
                noDataRow.style.display = '';
            }
        } else if(noDataRow) {
            noDataRow.style.display = 'none';
        }
    }
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>