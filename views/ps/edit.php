<?php require_once 'views/layouts/header.php'; ?>

<div class="content">
    <h1>Edit PS</h1>
    <div class="form-container">
        <form method="POST" action="index.php?page=ps&action=update">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori_id" required>
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($kategoriList as $kat): ?>
                        <option value="<?php echo $kat['kategori_id']; ?>"
                            <?php echo ($data['kategori_id'] ?? '') == $kat['kategori_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($kat['nama_kategori']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Nama PS</label>
                <input type="text" name="nama_ps" value="<?php echo htmlspecialchars($data['nama_ps'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Tipe</label>
                <select name="tipe" required>
                    <option value="PS3" <?php echo ($data['tipe'] ?? '') === 'PS3' ? 'selected' : ''; ?>>PS3</option>
                    <option value="PS4" <?php echo ($data['tipe'] ?? '') === 'PS4' ? 'selected' : ''; ?>>PS4</option>
                    <option value="PS5" <?php echo ($data['tipe'] ?? '') === 'PS5' ? 'selected' : ''; ?>>PS5</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="tersedia" <?php echo ($data['status'] ?? '') === 'tersedia' ? 'selected' : ''; ?>>Tersedia</option>
                    <option value="dipinjam" <?php echo ($data['status'] ?? '') === 'dipinjam' ? 'selected' : ''; ?>>Dipinjam</option>
                </select>
            </div>

            <div class="form-group">
                <label>Harga per Jam (Rp)</label>
                <input type="number" name="harga_per_jam" value="<?php echo $data['harga_per_jam'] ?? 0; ?>" min="0" required>
            </div>

            <button type="submit" class="btn">Update</button>
            <a href="index.php?page=ps&action=index" class="btn btn-danger">Batal</a>
        </form>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
