<?php require_once 'views/layouts/header.php'; ?>
<?php // Form pengajuan peminjaman baru oleh peminjam. ?>

<div class="content">
    <h1>Ajukan Peminjaman</h1>
    
    <div class="form-container">
        <?php // Kirim data form ke action store pada modul peminjaman. ?>
        <form method="POST" action="index.php?page=peminjaman&action=store">
            <div class="form-group">
                <label>No. KTP (Jaminan) <span style="color:red">*</span></label>
                <input type="text" name="no_ktp" maxlength="20" pattern="[0-9]{16}" placeholder="Masukkan 16 digit nomor KTP" required>
            </div>

            <div class="form-group">
                <label>No. Telepon <span style="color:red">*</span></label>
                <input type="text" name="no_telepon" maxlength="15" placeholder="Contoh: 08123456789" required>
            </div>

            <div class="form-group">
                <label>Pilih PS</label>
                <select name="ps_id" id="ps_id" required onchange="calculateTotal()">
                    <option value="">Pilih PS</option>
                    <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo $row['id']; ?>" data-harga="<?php echo $row['harga_per_jam']; ?>">
                            <?php echo htmlspecialchars($row['nama_ps'] ?? ''); ?> - <?php echo $row['tipe'] ?? ''; ?> (Rp <?php echo number_format($row['harga_per_jam'], 0, ',', '.'); ?>/jam)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal Pinjam</label>
                <input type="datetime-local" name="tanggal_pinjam" id="tanggal_pinjam" required>
            </div>

            <div class="form-group">
                <label>Durasi (Jam)</label>
                <input type="number" name="durasi_jam" id="durasi_jam" min="1" required onchange="calculateTotal()">
            </div>

            <div class="form-group">
                <label>Total Harga</label>
                <input type="text" id="total_harga_display" readonly style="background: #f5f5f5;">
                <input type="hidden" name="total_harga" id="total_harga">
            </div>
            
            <?php // Tombol submit pengajuan dan tombol kembali ke daftar peminjaman. ?>
            <button type="submit" class="btn">Ajukan</button>
            <a href="index.php?page=peminjaman&action=index" class="btn btn-danger">Batal</a>
        </form>
    </div>
</div>

<script>
// Hitung total harga berdasarkan harga PS terpilih x durasi peminjaman.
function calculateTotal() {
    // Ambil elemen input yang dipakai untuk perhitungan.
    const psSelect = document.getElementById('ps_id');
    const durasi = document.getElementById('durasi_jam').value;
    
    // Proses hitung hanya jika PS dan durasi sudah diisi.
    if(psSelect.value && durasi) {
        const harga = psSelect.options[psSelect.selectedIndex].getAttribute('data-harga');
        const total = harga * durasi;
        
        // Simpan nilai numerik untuk backend, dan format rupiah untuk tampilan.
        document.getElementById('total_harga').value = total;
        document.getElementById('total_harga_display').value = 'Rp ' + total.toLocaleString('id-ID');
    }
}
</script>

<?php require_once 'views/layouts/footer.php'; ?>
