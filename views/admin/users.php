<?php include '../views/layouts/header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<?php
$customers = [];
$staffs = [];

foreach ($users as $u) {
    if ($u['role'] === 'customer') {
        $customers[] = $u;
    } else {
        $staffs[] = $u;
    }
}
?>
<style>
    :root {
        --primary-color: #4e73df;
        --secondary-color: #858796;
    }
    body { background-color: #f8f9fc; color: #333; }
    .card { border: none; border-radius: 12px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1); }
    .table thead th { 
        background-color: #f8f9fc; 
        text-transform: uppercase; 
        font-size: 0.8rem; 
        letter-spacing: 0.05rem;
        font-weight: 700;
        border-bottom: 2px solid #e3e6f0;
    }
    .table td { vertical-align: middle; border-color: #f1f1f1; }
    .badge { padding: 0.5em 0.8em; border-radius: 6px; font-weight: 500; }
    .btn-action { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px; margin-right: 2px; }
    .user-avatar { width: 35px; height: 35px; background: #e3e6f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #4e73df; }
    /* TAB STYLE */
.nav-tabs .nav-link {
    border: none;
    color: #858796;
    font-weight: 500;
    padding: 10px 18px;
    border-radius: 8px 8px 0 0;
    transition: all 0.2s ease;
}

/* Hover nhẹ */
.nav-tabs .nav-link:hover {
    background-color: #eef2ff;
    color: #4e73df;
}

/* ACTIVE - xanh nhạt */
.nav-tabs .nav-link.active {
    background-color: #e8f0fe;
    color: #4e73df;
    font-weight: 600;
    border-bottom: 2px solid #4e73df;
}
.nav-link span {
    background: #dbeafe;
    color: #4e73df;
    padding: 2px 8px;
    border-radius: 10px;
    margin-left: 5px;
    font-size: 12px;
}
</style>
<ul class="nav nav-tabs mb-3" id="userTab">
    <li class="nav-item">
        <button type="button" id="tab-customer" class="nav-link active" onclick="showTab('customer')">
            👤 Khách hàng (<?= count($customers) ?>)
        </button>
    </li>
    <li class="nav-item">
        <button type="button" id="tab-staff" class="nav-link" onclick="showTab('staff')">
            🏢 Nhân sự (<?= count($staffs) ?>)
        </button>
    </li>
</ul>
<div class="container py-5">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Quản lý người dùng</h1>
        <a href="admin.php?action=create" class="btn btn-primary shadow-sm px-4 py-2">
            <i class="fas fa-plus fa-sm text-white-50 me-2"></i> Thêm người dùng mới
        </a>
    </div>

<div id="customerTab">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th class="ps-4">Khách hàng</th>
                <th>Email</th>
                <th>Trạng thái</th>
                <th class="text-end pe-4">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $u): ?>
            <tr>
                <td class="ps-4">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3">
                            <?= strtoupper(substr($u['full_name'], 0, 1)) ?>
                        </div>
                        <div>
                            <div class="fw-bold"><?= $u['full_name'] ?></div>
                            <small>ID: #<?= $u['user_id'] ?></small>
                        </div>
                    </div>
                </td>
                <td><?= $u['email'] ?></td>
                <td>
                    <?= $u['status'] == 'active' 
                        ? '<span class="text-success">Hoạt động</span>' 
                        : '<span class="text-danger">Đã khóa</span>' ?>
                </td>
                <td class="text-end pe-4">

            <!-- Edit -->
            <a class="btn btn-light btn-action text-warning" 
            href="admin.php?action=edit&id=<?= $u['user_id'] ?>&tab=customer" title="Sửa">
                <i class="fas fa-edit"></i>
            </a>

            <!-- Lock -->
            <a class="btn btn-light btn-action text-info" 
            href="admin.php?action=toggle&id=<?= $u['user_id'] ?>&tab=customer" title="Khóa/Mở">
                <i class="fas <?= $u['status']=='active' ? 'fa-lock' : 'fa-unlock' ?>"></i>
            </a>

            <!-- Reset -->
            <a class="btn btn-light btn-action text-secondary" 
            href="admin.php?action=reset&id=<?= $u['user_id'] ?>&tab=customer" title="Reset">
                <i class="fas fa-undo"></i>
            </a>

            <!-- Delete -->
            <a class="btn btn-light btn-action text-danger" 
            href="admin.php?action=delete&id=<?= $u['user_id'] ?>&tab=customer"
            onclick="return confirm('Xác nhận xóa?')" title="Xóa">
                <i class="fas fa-trash"></i>
            </a>

        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
</div>
<div id="staffTab" style="display:none;">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th class="ps-4">Nhân sự</th>
                <th>Email</th>
                <th>Trạng thái</th>
                <th class="text-end pe-4">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($staffs as $u): ?>
            <tr>
                <td class="ps-4">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar me-3">
                            <?= strtoupper(substr($u['full_name'], 0, 1)) ?>
                        </div>
                        <div>
                            <div class="fw-bold"><?= $u['full_name'] ?></div>
                            <small>ID: #<?= $u['user_id'] ?></small>
                        </div>
                    </div>
                </td>
                <td><?= $u['email'] ?></td>
                <td>
                    <?= $u['status'] == 'active' 
                        ? '<span class="text-success">Hoạt động</span>' 
                        : '<span class="text-danger">Đã khóa</span>' ?>
                </td>
                <td class="text-end pe-4">

    <!-- Edit -->
    <a class="btn btn-light btn-action text-warning" 
       href="admin.php?action=edit&id=<?= $u['user_id'] ?>&tab=staff" title="Sửa">
        <i class="fas fa-edit"></i>
    </a>

    <!-- Lock -->
    <a class="btn btn-light btn-action text-info" 
       href="admin.php?action=toggle&id=<?= $u['user_id'] ?>&tab=staff" title="Khóa/Mở">
        <i class="fas <?= $u['status']=='active' ? 'fa-lock' : 'fa-unlock' ?>"></i>
    </a>

    <!-- Reset -->
    <a class="btn btn-light btn-action text-secondary" 
       href="admin.php?action=reset&id=<?= $u['user_id'] ?>&tab=staff" title="Reset">
        <i class="fas fa-undo"></i>
    </a>

    <!-- Delete -->
    <a class="btn btn-light btn-action text-danger" 
       href="admin.php?action=delete&id=<?= $u['user_id'] ?>&tab=staff" 
       onclick="return confirm('Xác nhận xóa?')" title="Xóa">
        <i class="fas fa-trash"></i>
    </a>

</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function showTab(type) {
    // Ẩn tab
    document.getElementById('customerTab').style.display = 'none';
    document.getElementById('staffTab').style.display = 'none';

    // Remove active
    document.getElementById('tab-customer').classList.remove('active');
    document.getElementById('tab-staff').classList.remove('active');

    // Show đúng tab + highlight
    if(type === 'customer'){
        document.getElementById('customerTab').style.display = 'block';
        document.getElementById('tab-customer').classList.add('active');
    } else {
        document.getElementById('staffTab').style.display = 'block';
        document.getElementById('tab-staff').classList.add('active');
    }
}

// 👉 giữ tab khi reload
window.onload = function() {
    const params = new URLSearchParams(window.location.search);
    const tab = params.get('tab') || 'customer';
    showTab(tab);
}
</script>
<?php include '../views/layouts/footer.php'; ?>