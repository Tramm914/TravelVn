<?php 
// --- THUẬT TOÁN SẮP XẾP THÔNG MINH ---
// Ưu tiên: 1. Đang diễn ra -> 2. Chờ khởi hành -> 3. Đã hoàn thành (Đẩy xuống cuối)
if (!empty($departures)) {
    usort($departures, function($a, $b) {
        $order = ['ongoing' => 1, 'upcoming' => 2, 'completed' => 3];
        $rankA = $order[$a['status']] ?? 99;
        $rankB = $order[$b['status']] ?? 99;
        
        // Nếu khác trạng thái thì xếp theo độ ưu tiên trên
        if ($rankA !== $rankB) {
            return $rankA <=> $rankB;
        }
        // Nếu cùng trạng thái thì xếp theo ngày khởi hành (gần nhất lên trước)
        return strtotime($a['start_date']) <=> strtotime($b['start_date']);
    });
}
?>

<?php include __DIR__ . '/../layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --app-primary: #0ea5e9;
        --app-primary-bg: #e0f2fe;
        --app-success: #10b981;
        --app-success-bg: #d1fae5;
        --app-warning: #f59e0b;
        --app-warning-bg: #fef3c7;
        --app-muted: #64748b;
        --app-muted-bg: #f1f5f9;
        --app-bg: #f8fafc;
        --app-card: #ffffff;
        --app-text: #0f172a;
        --app-border: #e2e8f0;
        --font-main: 'Plus Jakarta Sans', sans-serif;
    }

    body { background-color: var(--app-bg); font-family: var(--font-main); color: var(--app-text); }

    .schedule-container { max-width: 1200px; margin: 0 auto; padding: 40px 15px; }

    /* --- HEADER & FILTER --- */
    .page-header { margin-bottom: 30px; }
    .page-title { font-size: 2rem; font-weight: 800; color: var(--app-text); margin-bottom: 8px; display: flex; align-items: center; gap: 12px;}
    .page-title i { color: var(--app-primary); font-size: 2.2rem;}
    .page-subtitle { color: var(--app-muted); font-size: 1.05rem; margin: 0; }

    .filter-box {
        background: var(--app-card);
        border: 1px solid var(--app-border);
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 35px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    }
    .filter-label { font-size: 0.85rem; font-weight: 700; color: var(--app-muted); text-transform: uppercase; margin-bottom: 8px; display: block;}
    .filter-input { background: var(--app-bg); border: 1px solid var(--app-border); border-radius: 10px; font-weight: 600; color: var(--app-text); padding: 10px 15px;}
    .filter-input:focus { border-color: var(--app-primary); box-shadow: 0 0 0 3px var(--app-primary-bg); }
    .btn-filter { background: var(--app-primary); color: white; border: none; border-radius: 10px; padding: 10px 20px; font-weight: 700; transition: 0.2s; height: 100%; display: flex; align-items: center; justify-content: center; gap: 8px;}
    .btn-filter:hover { background: #0284c7; box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3); }

    /* --- LƯỚI CARD TOUR --- */
    .tour-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 25px;
    }

    /* --- CARD TOUR ĐƠN --- */
    .tour-card {
        background: var(--app-card);
        border-radius: 20px;
        padding: 25px;
        border: 1px solid var(--app-border);
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        transition: all 0.3s ease;
        display: flex; flex-direction: column; height: 100%;
        position: relative; overflow: hidden;
    }
    .tour-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        border-color: #cbd5e1;
    }
    
    .tour-card::before { content: ""; position: absolute; left: 0; top: 0; bottom: 0; width: 6px; background: var(--app-primary); }
    .tour-card.status-ongoing::before { background: var(--app-success); }
    /* Giảm độ nổi bật của các tour đã hoàn thành */
    .tour-card.status-completed { opacity: 0.7; background: #fafafa; }
    .tour-card.status-completed:hover { opacity: 1; }
    .tour-card.status-completed::before { background: var(--app-muted); }

    .tour-header { margin-bottom: 20px; }
    .tour-name { font-size: 1.25rem; font-weight: 800; color: var(--app-text); line-height: 1.4; margin-bottom: 15px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;}
    
    .tour-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 50px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;}
    .badge-upcoming { background: var(--app-primary-bg); color: var(--app-primary); }
    .badge-ongoing { background: var(--app-success-bg); color: var(--app-success); }
    .badge-completed { background: var(--app-border); color: var(--app-muted); }

    .tour-info { display: flex; flex-direction: column; gap: 12px; margin-bottom: 25px; flex-grow: 1;}
    .info-item { display: flex; align-items: center; gap: 12px; color: var(--app-text); font-size: 1rem; font-weight: 600;}
    .info-item i { width: 35px; height: 35px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
    .icon-start { background: #fef3c7; color: #d97706; }
    .icon-end { background: #fee2e2; color: #ef4444; }

    .btn-view { background: #f8fafc; color: var(--app-primary); border: 2px solid var(--app-primary-bg); border-radius: 12px; padding: 12px; font-weight: 700; text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; transition: 0.2s;}
    .btn-view:hover { background: var(--app-primary); color: white; border-color: var(--app-primary);}
    .tour-card.status-completed .btn-view { color: var(--app-muted); border-color: var(--app-border); background: transparent; }
    .tour-card.status-completed .btn-view:hover { background: var(--app-muted-bg); color: var(--app-text); border-color: var(--app-border); }

    .empty-state { background: white; border-radius: 24px; padding: 60px 20px; text-align: center; border: 2px dashed var(--app-border); }
    .empty-state i { font-size: 4rem; color: #cbd5e1; margin-bottom: 15px; }
    .empty-state h4 { font-weight: 800; color: var(--app-text); margin-bottom: 10px;}
    .empty-state p { color: var(--app-muted); margin: 0;}
</style>

<div class="schedule-container">
    
    <div class="page-header">
        <h1 class="page-title"><i class="bi bi-briefcase-fill"></i> Lịch phân công dẫn đoàn</h1>
        <p class="page-subtitle">Quản lý và theo dõi tiến độ các chuyến đi của bạn.</p>
    </div>

    <div class="filter-box">
        <form method="GET" action="" class="row g-3 align-items-end">
            <input type="hidden" name="action" value="schedule"> <div class="col-md-3">
                <label class="filter-label"><i class="bi bi-funnel"></i> Trạng thái</label>
                <select name="status" class="form-select filter-input">
                    <option value="">-- Tất cả trạng thái --</option>
                    <option value="upcoming" <?= (isset($_GET['status']) && $_GET['status'] == 'upcoming') ? 'selected' : '' ?>>Chờ khởi hành</option>
                    <option value="ongoing" <?= (isset($_GET['status']) && $_GET['status'] == 'ongoing') ? 'selected' : '' ?>>Đang diễn ra</option>
                    <option value="completed" <?= (isset($_GET['status']) && $_GET['status'] == 'completed') ? 'selected' : '' ?>>Đã hoàn thành</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <label class="filter-label"><i class="bi bi-calendar2-minus"></i> Khởi hành từ</label>
                <input type="date" name="start_date" class="form-control filter-input" value="<?= $_GET['start_date'] ?? '' ?>">
            </div>
            
            <div class="col-md-3">
                <label class="filter-label"><i class="bi bi-calendar2-plus"></i> Khởi hành đến</label>
                <input type="date" name="end_date" class="form-control filter-input" value="<?= $_GET['end_date'] ?? '' ?>">
            </div>
            
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn-filter flex-grow-1">
                    <i class="bi bi-search"></i> Lọc
                </button>
                <a href="?action=schedule" class="btn btn-light border filter-input text-muted d-flex align-items-center justify-content-center" title="Xóa bộ lọc" style="width: 50px;">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </form>
    </div>

    <?php if (empty($departures)): ?>
        <div class="empty-state">
            <i class="bi bi-calendar-x"></i>
            <h4>Không tìm thấy chuyến đi nào</h4>
            <p>Thử thay đổi bộ lọc hoặc hiện tại bạn chưa được phân công.</p>
        </div>
    <?php else: ?>
        <div class="tour-grid">
            <?php foreach ($departures as $d): 
                $startDate = !empty($d['start_date']) ? date('d/m/Y', strtotime($d['start_date'])) : '--';
                $endDate = !empty($d['end_date']) ? date('d/m/Y', strtotime($d['end_date'])) : '--';
                
                $statusClass = 'status-upcoming';
                $badgeClass = 'badge-upcoming';
                $statusText = 'Chờ khởi hành';
                $iconStatus = 'bi-hourglass-split';

                if ($d['status'] == 'ongoing') {
                    $statusClass = 'status-ongoing';
                    $badgeClass = 'badge-ongoing';
                    $statusText = 'Đang diễn ra';
                    $iconStatus = 'bi-play-circle-fill';
                } elseif ($d['status'] == 'completed') {
                    $statusClass = 'status-completed';
                    $badgeClass = 'badge-completed';
                    $statusText = 'Đã hoàn thành';
                    $iconStatus = 'bi-check-circle-fill';
                }
            ?>
                
                <div class="tour-card <?= $statusClass ?>">
                    <div class="tour-header">
                        <div class="tour-badge <?= $badgeClass ?> mb-3">
                            <i class="bi <?= $iconStatus ?>"></i> <?= $statusText ?>
                        </div>
                        <h3 class="tour-name" title="<?= htmlspecialchars($d['tour_name'] ?? '') ?>">
                            <?= htmlspecialchars($d['tour_name'] ?? '') ?>
                        </h3>
                    </div>

                    <div class="tour-info">
                        <div class="info-item">
                            <i class="bi bi-calendar-event-fill icon-start"></i>
                            <div>
                                <span class="d-block text-muted" style="font-size: 0.8rem; font-weight: 500;">Khởi hành</span>
                                <?= $startDate ?>
                            </div>
                        </div>
                        <div class="info-item">
                            <i class="bi bi-flag-fill icon-end"></i>
                            <div>
                                <span class="d-block text-muted" style="font-size: 0.8rem; font-weight: 500;">Kết thúc</span>
                                <?= $endDate ?>
                            </div>
                        </div>
                    </div>

                    <a href="guide.php?action=viewDeparture&id=<?= $d['departure_id'] ?>" class="btn-view">
                        Xem chi tiết đoàn <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>