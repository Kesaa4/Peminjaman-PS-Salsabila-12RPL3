<?php require_once 'views/layouts/header.php'; ?>

<div class="content">
    <h1>Edit Kategori</h1>
    <div class="form-container">
        <form method="POST" action="index.php?page=kategori&action=update">
            <input type="hidden" name="id" value="<?php echo $data['kategori_id']; ?>">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" value="<?php echo htmlspecialchars($data['nama_kategori']); ?>" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3"><?php echo htmlspecialchars($data['deskripsi'] ?? ''); ?></textarea>
            </div>
            <button type="submit" class="btn">Update</button>
            <a href="index.php?page=kategori&action=index" class="btn btn-danger">Batal</a>
        </form>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
