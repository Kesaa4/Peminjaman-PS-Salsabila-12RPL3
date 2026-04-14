<?php require_once 'views/layouts/header.php'; ?>

<div class="content">
    <h1>Kelola PS</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div style="margin-bottom:20px;">
        <a href="index.php?page=ps&action=create" class="btn">+ Tambah PS</a>
    </div>

    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Nama PS</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Harga/Jam</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['nama_kategori'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($row['nama_ps'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['tipe'] ?? ''); ?></td>
                <td>
                    <span class="badge badge-<?php echo $row['status']; ?>">
                        <?php echo ucfirst($row['status'] ?? ''); ?>
                    </span>
                </td>
                <td>Rp <?php echo number_format($row['harga_per_jam'], 0, ',', '.'); ?></td>
                <td>
                    <a href="index.php?page=ps&action=edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <?php if ($row['status'] === 'dipinjam'): ?>
                        <button class="btn btn-danger btn-sm" disabled style="opacity:0.4;cursor:not-allowed" title="Sedang dipinjam">Hapus</button>
                    <?php else: ?>
                        <a href="index.php?page=ps&action=delete&id=<?php echo $row['id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus PS <?php echo htmlspecialchars($row['nama_ps']); ?>?')">Hapus</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
