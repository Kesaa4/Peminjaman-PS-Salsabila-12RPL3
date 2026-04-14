<?php require_once 'views/layouts/header.php'; ?>
<?php // Form ubah data peminjaman beserta perhitungan ulang total harga. ?>

<div class="content">
    <h1>Edit Peminjaman</h1>
    
    <div class="form-container">
        <form method="POST" action="index.php?page=peminjaman&action=update">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            
            <div class="form-group">
                <label>Pilih PS</label>
                <select name="ps_id" id="ps_id" required onchange="calculateTotal()">
                    <option value="<?php echo $data['ps_id']; ?>" data-harga="<?php echo $data['harga_per_jam']; ?>" selected>
                        <?php echo htmlspecialchars($data['nama_ps'] ?? ''); ?> - <?php echo $data['tipe'] ?? ''; ?>
                    </option>
                    <?php while($row = $ps_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $row['id']; ?>" data-harga="<?php echo $row['harga_per_jam']; ?>">
                            <?php echo htmlspecialchars($row['nama_ps'] ?? ''); ?> - <?php echo $row['tipe'] ?? ''; ?> (Rp <?php echo number_format($row['harga_per_jam'], 0, ',', '.'); ?>/jam)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Tanggal Pinjam</label>
                <input type="datetime-local" name="tanggal_pinjam" id="tanggal_pinjam" value="<?php echo date('Y-m-d\TH:i', strtotime($data['tanggal_pinjam'])); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Durasi (Jam)</label>
                <input type="number" name="durasi_jam" id="durasi_jam" value="<?php echo $data['durasi_jam']; ?>" min="1" required onchange="calculateTotal()">
            </div>
            
            <div class="form-group">
                <label>Total Harga</label>
                <input type="text" id="total_harga_display" value="Rp <?php echo number_format($data['total_harga'], 0, ',', '.'); ?>" readonly style="background: #f5f5f5;">
                <input type="hidden" name="total_harga" id="total_harga" value="<?php echo $data['total_harga']; ?>">
            </div>
            
            <button type="submit" class="btn">Update</button>
            <a href="index.php?page=peminjaman&action=index" class="btn btn-danger">Batal</a>
        </form>
    </div>
</div>

<script>
// Hitung ulang total harga saat PS atau durasi diubah.
function calculateTotal() {
    const psSelect = document.getElementById('ps_id');
    const durasi = document.getElementById('durasi_jam').value;
    
    if(psSelect.value && durasi) {
        const harga = psSelect.options[psSelect.selectedIndex].getAttribute('data-harga');
        const total = harga * durasi;
        
        document.getElementById('total_harga').value = total;
        document.getElementById('total_harga_display').value = 'Rp ' + total.toLocaleString('id-ID');
    }
}
</script>

<?php require_once 'views/layouts/footer.php'; ?>
