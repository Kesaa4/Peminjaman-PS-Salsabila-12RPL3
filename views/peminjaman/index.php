<?php require_once 'views/layouts/header.php'; ?>
<?php // Halaman daftar peminjaman dengan kolom dan aksi yang menyesuaikan role pengguna. ?>

<div class="content">
    <h1>Data Peminjaman</h1>
    
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <div style="margin-bottom: 20px;">
        <?php if($_SESSION['role'] == 'peminjam'): ?>
            <a href="index.php?page=peminjaman&action=create" class="btn">+ Ajukan Peminjaman</a>
        <?php endif; ?>
    </div>
    
    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <?php if($_SESSION['role'] != 'peminjam'): ?>
                <th>Peminjam</th>
                <th>KTP</th>
                <th>Telepon</th>
                <?php endif; ?>
                <th>PS</th>
                <th>Tipe</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Durasi (Jam)</th>
                <th>Total Harga</th>
                <th>Kondisi</th>
                <th>Denda</th>
                <th>Status</th>
                <?php if($_SESSION['role'] != 'peminjam'): ?>
                <th>Disetujui Oleh</th>
                <?php endif; ?>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <?php if($_SESSION['role'] != 'peminjam'): ?>
                <td><?php echo htmlspecialchars($row['nama_peminjam'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['no_ktp'] ?? '-'); ?></td>
                <td><?php echo htmlspecialchars($row['no_telepon'] ?? '-'); ?></td>
                <?php endif; ?>
                <td><?php echo htmlspecialchars($row['nama_ps'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['tipe'] ?? ''); ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($row['tanggal_pinjam'])); ?></td>
                <td><?php echo $row['tanggal_kembali'] ? date('d/m/Y H:i', strtotime($row['tanggal_kembali'])) : '-'; ?></td>
                <td><?php echo $row['durasi_jam']; ?> jam</td>
                <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?></td>
                <td>
                    <?php if($row['kondisi_ps']): ?>
                        <span class="badge badge-<?php echo $row['kondisi_ps'] == 'baik' ? 'tersedia' : 'ditolak'; ?>">
                            <?php echo ucfirst($row['kondisi_ps']); ?>
                        </span>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($row['denda'] > 0): ?>
                        <span style="color: red; font-weight: bold;">Rp <?php echo number_format($row['denda'], 0, ',', '.'); ?></span>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <span class="badge badge-<?php echo $row['status']; ?>">
                        <?php echo ucfirst($row['status']); ?>
                    </span>
                    <?php if($row['status'] == 'ditolak' && !empty($row['alasan_tolak'])): ?>
                        <br><small style="color:#ef4444;font-size:11px" title="<?php echo htmlspecialchars($row['alasan_tolak']); ?>">
                            📋 <?php echo htmlspecialchars(mb_strimwidth($row['alasan_tolak'], 0, 30, '...')); ?>
                        </small>
                    <?php endif; ?>
                </td>
                <?php if($_SESSION['role'] != 'peminjam'): ?>
                <td>
                    <?php 
                    if($row['approved_by_nama']) {
                        echo htmlspecialchars($row['approved_by_nama'] ?? '');
                        if($row['approved_at']) {
                            echo "<br><small>" . date('d/m/Y H:i', strtotime($row['approved_at'])) . "</small>";
                        }
                    } else {
                        echo '-';
                    }
                    ?>
                </td>
                <?php endif; ?>
                <td>
                    <?php if($_SESSION['role'] == 'peminjam'): ?>
                        <?php if($row['status'] == 'pending'): ?>
                            <a href="index.php?page=peminjaman&action=edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if($row['status'] == 'pending'): ?>
                            <a href="index.php?page=peminjaman&action=approve&id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Setujui peminjaman ini?')">Setujui</a>
                            <a href="index.php?page=peminjaman&action=reject&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Tolak</a>
                        <?php elseif($row['status'] == 'disetujui'): ?>
                            <a href="index.php?page=peminjaman&action=selesai&id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Proses Pengembalian</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
