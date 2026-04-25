<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    /* --- BIẾN MÀU & CẤU TRÚC CHUNG CHUẨN ADMIN --- */
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
    .table tbody tr:hover { background-color: #f1f5f9; }

    /* HÌNH ẢNH THUMBNAIL TOUR */
    .tour-thumb {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--admin-border);
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    /* NÚT HÀNH ĐỘNG MỚI */
    .action-group { display: flex; gap: 8px; justify-content: center; }
    .btn-icon {
        width: 36px; height: 36px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;
        font-size: 1.1rem; border: none; transition: 0.2s; background: #f1f5f9; color: var(--admin-text-muted); text-decoration: none;
    }
    .btn-icon-warning:hover { background: #fffbeb; color: var(--admin-warning); }
    .btn-icon-danger:hover { background: #fef2f2; color: var(--admin-danger); }

    /* BỘ LỌC TÌM KIẾM */
    .search-box { min-width: 300px; }
    .search-box .input-group-text { background: white; border-right: none; color: #94a3b8; }
    .search-box .form-control { border-left: none; box-shadow: none !important; }
    .search-box .form-control:focus { border-color: #dee2e6; }
</style>

<div class="admin-container">
    <div class="row g-4">
        
        <?php 
            $activeMenu = 'tours'; 
            include __DIR__ . '/../layouts/sidebar_manager.php'; 
        ?>

        <div class="col-lg-9">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h1 class="admin-title">Danh sách Tour</h1>
                    <p class="text-muted mb-0 fw-medium">Quản lý và cập nhật thông tin các sản phẩm du lịch.</p>
                </div>
                
                <div class="d-flex flex-wrap gap-3">
                    <div class="search-box">
                        <div class="input-group shadow-sm rounded-3">
                            <span class="input-group-text rounded-start-3"><i class="bi bi-search"></i></span>
                            <input type="text" id="searchInput" class="form-control rounded-end-3 py-2" placeholder="Tìm tên tour, mã, điểm đến..." onkeyup="filterTours()">
                        </div>
                    </div>

                    <a href="manager.php?action=createTour" class="btn btn-primary fw-bold shadow-sm rounded-3 px-4 d-flex align-items-center text-nowrap">
                        <i class="bi bi-plus-lg me-2"></i> Thêm Tour Mới
                    </a>
                </div>
            </div>

            <div class="admin-card">
                <div class="table-responsive">
                    <table class="table mb-0 align-middle" id="toursTable">
                        <thead>
                            <tr>
                                <th width="40%">Thông tin Tour</th>
                                <th width="15%">Điểm đến</th>
                                <th width="15%" class="text-end">Giá (VNĐ)</th>
                                <th width="15%" class="text-center">Thời gian</th>
                                <th width="15%" class="text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($tours) && $tours->rowCount() > 0): ?>
                                <?php while ($row = $tours->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr class="tour-row">
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="<?= !empty($row['image']) ? '/uploads/' . $row['image'] : 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=100' ?>" class="tour-thumb" alt="Tour image">
                                                <div>
                                                    <div class="fw-bold text-dark search-target mb-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                        <?= htmlspecialchars($row['tour_name']) ?>
                                                    </div>
                                                    <div class="small text-muted search-target">Mã Tour: #<?= $row['tour_id'] ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <td class="search-target">
                                            <span class="badge bg-light text-dark border border-secondary border-opacity-25 px-2 py-1">
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i> <?= htmlspecialchars($row['destination']) ?>
                                            </span>
                                        </td>
                                        
                                        <td class="text-end fw-bold text-danger" style="font-size: 1.05rem;">
                                            <?= number_format($row['price']) ?> đ
                                        </td>
                                        
                                        <td class="text-center">
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info px-2 py-1">
                                                <i class="bi bi-clock-history me-1"></i> <?= htmlspecialchars($row['duration']) ?> ngày
                                            </span>
                                        </td>
                                        
                                        <td>
                                            <div class="action-group">
                                                <a href="manager.php?action=editTour&id=<?= $row['tour_id'] ?>" class="btn-icon btn-icon-warning" title="Chỉnh sửa">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="manager.php?action=deleteTour&id=<?= $row['tour_id'] ?>" class="btn-icon btn-icon-danger" title="Xóa tour" onclick="return confirm('Bạn có chắc chắn muốn xóa tour này? Dữ liệu sẽ không thể khôi phục.')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr id="noDataRow">
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary opacity-25"></i>
                                        <h5 class="fw-bold text-dark">Chưa có dữ liệu tour</h5>
                                        <p class="mb-0">Hãy bấm nút "Thêm Tour Mới" để bắt đầu bán hàng.</p>
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
    // Logic bộ lọc tìm kiếm Real-time bằng Javascript
    function filterTours() {
        let input = document.getElementById('searchInput').value.toLowerCase();
        let rows = document.querySelectorAll('.tour-row');
        let visibleCount = 0;

        rows.forEach(row => {
            // Lấy tất cả các nội dung chứa class 'search-target' trong 1 hàng (Mã, Tên, Điểm đến)
            let targets = row.querySelectorAll('.search-target');
            let rowContent = "";
            targets.forEach(t => rowContent += t.innerText.toLowerCase() + " ");
            
            // Nếu có chứa từ khóa thì hiện, không thì ẩn
            if (rowContent.includes(input)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Xử lý thông báo nếu không tìm thấy kết quả nào
        let noDataRow = document.getElementById('noDataRow');
        if (visibleCount === 0 && rows.length > 0) {
            if (!noDataRow) {
                let tbody = document.querySelector('#toursTable tbody');
                tbody.insertAdjacentHTML('beforeend', '<tr id="noDataRow"><td colspan="5" class="text-center py-5 text-muted">Không tìm thấy tour phù hợp với từ khóa của bạn.</td></tr>');
            } else {
                noDataRow.style.display = '';
            }
        } else if (noDataRow) {
            noDataRow.style.display = 'none';
        }
    }
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>