<?php require_once 'views/layouts/header.php'; ?>

<div class="content">
    <h1>Tambah Kategori</h1>
    <div class="form-container">
        <form method="POST" action="index.php?page=kategori&action=store">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" placeholder="Contoh: Konsol, Aksesoris" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3" placeholder="Deskripsi kategori (opsional)"></textarea>
            </div>
            <button type="submit" class="btn">Simpan</button>
            <a href="index.php?page=kategori&action=index" class="btn btn-danger">Batal</a>
        </form>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
