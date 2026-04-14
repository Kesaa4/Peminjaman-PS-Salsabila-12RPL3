<?php require_once 'views/layouts/header.php'; ?>

<div class="content">
    <h1>📊 Log Aktivitas Sistem</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="form-container">
        <div style="background:linear-gradient(135deg,#dbeafe,#bfdbfe);padding:15px;border-radius:10px;margin-bottom:20px;border-left:4px solid #3b82f6;">
            <strong>ℹ️ Informasi:</strong> Log aktivitas tercatat <strong>OTOMATIS</strong> oleh sistem. Anda hanya perlu melihat dan memfilter data.
        </div>

        <form method="GET" action="index.php" style="margin-bottom:20px;">
            <input type="hidden" name="page" value="activity_log">

            <div class="form-group">
                <label>User</label>
                <select name="user_id">
                    <option value="">Semua User</option>
                    <?php foreach ($users as $u): ?>
                        <option value="<?= $u['id'] ?>" <?= (isset($_GET['user_id']) && $_GET['user_id'] == $u['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($u['nama']) ?> (<?= $u['role'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Aksi</label>
                <select name="action">
                    <option value="">Semua Aksi</option>
                    <?php foreach (['login','logout','create','update','delete','approve','reject','return'] as $act): ?>
                        <option value="<?= $act ?>" <?= (isset($_GET['action']) && $_GET['action'] === $act) ? 'selected' : '' ?>>
                            <?= ucfirst($act) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:15px;">
                <div class="form-group">
                    <label>Dari Tanggal</label>
                    <input type="date" name="date_from" value="<?= htmlspecialchars($_GET['date_from'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="date_to" value="<?= htmlspecialchars($_GET['date_to'] ?? '') ?>">
                </div>
            </div>

            <?php
            $printParams = array_merge($_GET, ['page' => 'activity_log', 'mode' => 'print']);
            $pdfParams   = array_merge($_GET, ['page' => 'activity_log', 'mode' => 'pdf']);
            ?>
            <div class="button-row">
                <button type="submit" class="btn btn-primary">🔍 Filter</button>
                <a href="index.php?page=activity_log" class="btn btn-secondary">🔄 Reset</a>
                <a href="<?= htmlspecialchars('index.php?' . http_build_query($printParams)) ?>" target="_blank" class="btn btn-success">🖨️ Cetak Laporan</a>
                <a href="<?= htmlspecialchars('index.php?' . http_build_query($pdfParams)) ?>" target="_blank" class="btn btn-warning">📄 Cetak PDF</a>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="index.php?page=activity_log&action=stats" class="btn btn-info">📊 Lihat Statistik</a>
                <?php endif; ?>
            </div>
        </form>

        <div class="table-responsive" style="margin-top:20px;">
            <table>
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:18%">Waktu</th>
                        <th style="width:20%">User</th>
                        <th style="width:12%">Aksi</th>
                        <th style="width:45%">Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($logs) > 0): ?>
                        <?php $no = 1; foreach ($logs as $log): ?>
                        <?php $badge = _activityBadge($log['action']); ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d/m/Y H:i:s', strtotime($log['created_at'])) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($log['nama']) ?></strong><br>
                                <small style="color:#64748b"><?= htmlspecialchars($log['username']) ?></small>
                            </td>
                            <td><span class="badge <?= $badge ?>"><?= strtoupper($log['action']) ?></span></td>
                            <td><?= htmlspecialchars($log['description']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center;padding:30px;color:#64748b">Tidak ada data log aktivitas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
function _activityBadge($action) {
    $map = [
        'login'   => 'badge-disetujui',
        'logout'  => 'badge-pending',
        'create'  => 'badge-tersedia',
        'update'  => 'badge-dipinjam',
        'delete'  => 'badge-ditolak',
        'approve' => 'badge-disetujui',
        'reject'  => 'badge-ditolak',
        'return'  => 'badge-selesai',
    ];
    return $map[$action] ?? 'badge-pending';
}
?>

<?php require_once 'views/layouts/footer.php'; ?>
