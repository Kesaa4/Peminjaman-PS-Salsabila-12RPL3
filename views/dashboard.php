<?php
AuthController::checkAuth();
require_once 'views/layouts/header.php';
?>

<div class="content">
    <h1>Dashboard</h1>

    <div class="welcome-box">
        <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!</h2>
        <p>Role: <strong><?php echo ucfirst($_SESSION['role']); ?></strong></p>
    </div>

    <div class="dashboard-cards">
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <div class="card">
                <h3>👥 Kelola User</h3>
                <p>Tambah, edit, dan hapus user sistem</p>
                <a href="index.php?page=user&action=index" class="btn">Kelola User</a>
            </div>
        <?php endif; ?>

        <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'petugas'): ?>
            <div class="card">
                <h3>🎮 Kelola PS</h3>
                <p>Tambah, edit, dan hapus data PS</p>
                <a href="index.php?page=ps&action=index" class="btn">Kelola PS</a>
            </div>
            <div class="card">
                <h3>🗂️ Kategori</h3>
                <p>Tambah, edit, dan hapus kategori</p>
                <a href="index.php?page=kategori&action=index" class="btn">Kelola Kategori</a>
            </div>
        <?php endif; ?>

        <div class="card">
            <h3>📋 Peminjaman</h3>
            <p>Lihat dan kelola data peminjaman</p>
            <a href="index.php?page=peminjaman&action=index" class="btn">Lihat Peminjaman</a>
        </div>

        <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'petugas'): ?>
            <div class="card">
                <h3>📊 Log Aktivitas</h3>
                <p>Lihat riwayat aktivitas sistem</p>
                <a href="index.php?page=activity_log" class="btn">Lihat Log</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
