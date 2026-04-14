<?php require_once 'views/layouts/header.php'; ?>

<div class="content">
    <h1>Tolak Peminjaman</h1>
    <div class="form-container">
        <p style="margin-bottom:20px;color:#64748b">
            Peminjaman oleh <strong><?php echo htmlspecialchars($data['nama_peminjam']); ?></strong>
            untuk <strong><?php echo htmlspecialchars($data['nama_ps']); ?></strong>
            (<?php echo date('d/m/Y H:i', strtotime($data['tanggal_pinjam'])); ?>)
        </p>

        <form method="POST" action="index.php?page=peminjaman&action=reject">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            <div class="form-group">
                <label>Alasan Penolakan <span style="color:red">*</span></label>
                <textarea name="alasan_tolak" rows="4" required
                    placeholder="Contoh: PS sedang dalam perbaikan, slot penuh, dll."
                    style="resize:vertical"></textarea>
            </div>
            <button type="submit" class="btn btn-danger">Konfirmasi Tolak</button>
            <a href="index.php?page=peminjaman&action=index" class="btn" style="background:linear-gradient(135deg,#94a3b8,#64748b)">Batal</a>
        </form>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
