<?php require_once 'views/layouts/header.php'; ?>
<?php // Form proses pengembalian, termasuk kondisi PS dan perhitungan denda. ?>

<div class="content">
    <h1>Form Pengembalian PS</h1>
    
    <div class="form-container">
        <h3>Detail Peminjaman</h3>
        <div class="table-responsive">
        <table style="width: 100%; margin-bottom: 20px;">
            <tr>
                <td width="30%"><strong>Peminjam</strong></td>
                <td><?php echo htmlspecialchars($data['nama_peminjam'] ?? ''); ?></td>
            </tr>
            <tr>
                <td><strong>PS</strong></td>
                <td><?php echo htmlspecialchars($data['nama_ps'] ?? ''); ?> (<?php echo $data['tipe'] ?? ''; ?>)</td>
            </tr>
            <tr>
                <td><strong>Tanggal Pinjam</strong></td>
                <td><?php echo date('d/m/Y H:i', strtotime($data['tanggal_pinjam'])); ?></td>
            </tr>
            <tr>
                <td><strong>Durasi</strong></td>
                <td><?php echo $data['durasi_jam']; ?> jam</td>
            </tr>
            <tr>
                <td><strong>Total Harga</strong></td>
                <td>Rp <?php echo number_format($data['total_harga'], 0, ',', '.'); ?></td>
            </tr>
        </table>
        </div>
        
        <hr style="margin: 30px 0;">
        
        <h3>Data Pengembalian</h3>
        <form method="POST" action="index.php?page=peminjaman&action=proses_pengembalian">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            
            <div class="form-group">
                <label>Kondisi PS <span style="color: red;">*</span></label>
                <select name="kondisi_ps" id="kondisi_ps" required onchange="toggleDenda()">
                    <option value="">Pilih Kondisi</option>
                    <option value="baik">Baik (Tidak Ada Kerusakan)</option>
                    <option value="rusak">Rusak (Ada Kerusakan)</option>
                </select>
            </div>
            
            <div class="form-group" id="denda_info" style="display: none; background: #fff3cd; padding: 15px; border-radius: 5px; border: 1px solid #ffc107;">
                <strong style="color: #856404;">⚠️ Informasi Denda</strong>
                <p style="margin: 10px 0 0 0; color: #856404;">
                    Denda otomatis: <strong>Rp 5.000 per jam</strong><br>
                    Durasi peminjaman: <strong><?php echo $data['durasi_jam']; ?> jam</strong><br>
                    Total denda: <strong style="font-size: 18px; color: red;">Rp <?php echo number_format(5000 * $data['durasi_jam'], 0, ',', '.'); ?></strong>
                </p>
            </div>
            
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" rows="4" placeholder="Catatan kerusakan atau keterangan lainnya (opsional)" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-family: Arial;"></textarea>
            </div>
            
            <div class="form-group" style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-top: 20px;">
                <h4 style="margin-top: 0;">Total Pembayaran</h4>
                <div class="table-responsive">
                <table style="width: 100%;">
                    <tr>
                        <td>Biaya Sewa:</td>
                        <td style="text-align: right;"><strong>Rp <?php echo number_format($data['total_harga'], 0, ',', '.'); ?></strong></td>
                    </tr>
                    <tr id="denda_row" style="display: none;">
                        <td>Denda:</td>
                        <td style="text-align: right; color: red;"><strong id="denda_display">Rp 0</strong></td>
                    </tr>
                    <tr style="border-top: 2px solid #ddd;">
                        <td><strong>Total:</strong></td>
                        <td style="text-align: right; font-size: 18px; color: #667eea;"><strong id="total_display">Rp <?php echo number_format($data['total_harga'], 0, ',', '.'); ?></strong></td>
                    </tr>
                </table>
                </div>
            </div>
            
            <button type="submit" class="btn" style="margin-top: 20px;">Proses Pengembalian</button>
            <a href="index.php?page=peminjaman&action=index" class="btn btn-danger">Batal</a>
        </form>
    </div>
</div>

<script>
const DENDA_PER_JAM = 5000;
const DURASI_JAM = <?php echo $data['durasi_jam']; ?>;
const BIAYA_SEWA = <?php echo $data['total_harga']; ?>;

// Menampilkan atau menyembunyikan komponen denda sesuai kondisi PS.
function toggleDenda() {
    const kondisi = document.getElementById('kondisi_ps').value;
    const dendaInfo = document.getElementById('denda_info');
    const dendaRow = document.getElementById('denda_row');
    
    if(kondisi === 'rusak') {
        dendaInfo.style.display = 'block';
        dendaRow.style.display = 'table-row';
        updateTotal();
    } else {
        dendaInfo.style.display = 'none';
        dendaRow.style.display = 'none';
        updateTotal();
    }
}

// Menghitung total pembayaran berdasarkan biaya sewa dan denda.
function updateTotal() {
    const kondisi = document.getElementById('kondisi_ps').value;
    const denda = kondisi === 'rusak' ? (DENDA_PER_JAM * DURASI_JAM) : 0;
    const total = BIAYA_SEWA + denda;
    
    document.getElementById('denda_display').textContent = 'Rp ' + denda.toLocaleString('id-ID');
    document.getElementById('total_display').textContent = 'Rp ' + total.toLocaleString('id-ID');
}
</script>

<?php require_once 'views/layouts/footer.php'; ?>
