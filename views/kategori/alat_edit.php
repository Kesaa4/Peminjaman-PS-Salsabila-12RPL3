<?php require_once 'views/layouts/header.php'; ?>

<div class="content">
    <h1>Edit PS — <?php echo htmlspecialchars($dataAlat['nama_kategori'] ?? ''); ?></h1>
    <div class="form-container">
        <form method="POST" action="index.php?page=kategori&action=alat_update">
            <input type="hidden" name="id"          value="<?php echo $dataAlat['id']; ?>">
            <input type="hidden" name="kategori_id" value="<?php echo $dataAlat['kategori_id']; ?>">

            <div class="form-group">
                <label>Nama PS</label>
                <input type="text" name="nama_ps" value="<?php echo htmlspecialchars($dataAlat['nama_ps'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Tipe</label>
                <select name="tipe" required>
                    <option value="PS3" <?php echo ($dataAlat['tipe'] ?? '') === 'PS3' ? 'selected' : ''; ?>>PS3</option>
                    <option value="PS4" <?php echo ($dataAlat['tipe'] ?? '') === 'PS4' ? 'selected' : ''; ?>>PS4</option>
                    <option value="PS5" <?php echo ($dataAlat['tipe'] ?? '') === 'PS5' ? 'selected' : ''; ?>>PS5</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="tersedia" <?php echo ($dataAlat['status'] ?? '') === 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                    <option value="dipinjam" <?php echo ($dataAlat['status'] ?? '') === 'dipinjam' ? 'selected' : ''; ?>>Dipinjam</option>
                </select>
            </div>

            <div class="form-group">
                <label>Harga per Jam (Rp)</label>
                <input type="number" name="harga_per_jam" value="<?php echo $dataAlat['harga_per_jam'] ?? 0; ?>" min="0" required>
            </div>

            <button type="submit" class="btn">Update</button>
            <a href="index.php?page=kategori&action=detail&id=<?php echo $dataAlat['kategori_id']; ?>" class="btn btn-danger">Batal</a>
        </form>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
