<?php require_once 'views/layouts/header.php'; ?>

<div class="content">
    <h1>Kelola Kategori</h1>

    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div style="margin-bottom: 20px;">
        <a href="index.php?page=kategori&action=create" class="btn">+ Tambah Kategori</a>
    </div>

    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['nama_kategori']); ?></td>
                <td><?php echo htmlspecialchars($row['deskripsi'] ?? '-'); ?></td>
                <td><?php echo date('d/m/Y', strtotime($row['created_at'])); ?></td>
                <td>
                    <a href="index.php?page=kategori&action=detail&id=<?php echo $row['kategori_id']; ?>" class="btn btn-sm" style="background:linear-gradient(135deg,#6366f1,#818cf8)">Lihat Alat</a>
                    <a href="index.php?page=kategori&action=edit&id=<?php echo $row['kategori_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="index.php?page=kategori&action=delete&id=<?php echo $row['kategori_id']; ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Hapus kategori ini? Semua alat di dalamnya ikut terhapus.')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
