<?php require_once 'views/layouts/header.php'; ?>

<div class="content">
    <h1>🗂️ <?php echo htmlspecialchars($dataKategori['nama_kategori']); ?></h1>

    <?php if (!empty($dataKategori['deskripsi'])): ?>
        <p style="color:white;margin-bottom:20px;opacity:0.9"><?php echo htmlspecialchars($dataKategori['deskripsi']); ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div style="margin-bottom:20px;display:flex;gap:10px">
        <a href="index.php?page=kategori&action=alat_create&kategori_id=<?php echo $dataKategori['kategori_id']; ?>" class="btn">+ Tambah PS</a>
        <a href="index.php?page=kategori&action=index" class="btn btn-danger">← Kembali</a>
    </div>

    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama PS</th>
                <th>Tipe</th>
                <th>Status</th>
                <th>Harga/Jam</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $rows = $stmtAlat->fetchAll(PDO::FETCH_ASSOC); ?>
            <?php if (empty($rows)): ?>
                <tr>
                    <td colspan="6" style="text-align:center;color:#94a3b8;padding:30px">
                        Belum ada PS di kategori ini. Klik "+ Tambah PS" untuk menambahkan.
                    </td>
                </tr>
            <?php else: foreach ($rows as $row): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['nama_ps']); ?></td>
                <td><?php echo htmlspecialchars($row['tipe']); ?></td>
                <td>
                    <span class="badge badge-<?php echo $row['status']; ?>">
                        <?php echo ucfirst($row['status']); ?>
                    </span>
                </td>
                <td>Rp <?php echo number_format($row['harga_per_jam'], 0, ',', '.'); ?></td>
                <td>
                    <a href="index.php?page=kategori&action=alat_edit&id=<?php echo $row['id']; ?>&kategori_id=<?php echo $dataKategori['kategori_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <?php if ($row['status'] === 'dipinjam'): ?>
                        <button class="btn btn-danger btn-sm" disabled style="opacity:0.4;cursor:not-allowed" title="Sedang dipinjam">Hapus</button>
                    <?php else: ?>
                        <a href="index.php?page=kategori&action=alat_delete&id=<?php echo $row['id']; ?>&kategori_id=<?php echo $dataKategori['kategori_id']; ?>"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus PS ini?')">Hapus</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; endif; ?>
        </tbody>
    </table>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
