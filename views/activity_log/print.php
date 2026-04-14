<?php require_once 'views/layouts/header.php'; ?>

<style>
    body { background: white !important; }
    .navbar, footer, .no-print { display: none !important; }
    .content { max-width: 1200px; margin: 40px auto; padding: 0 20px; background: white; }
    .print-header { margin-bottom: 25px; padding: 20px; border: 1px solid #ddd; border-radius: 14px; background: #f8fafc; }
    .print-header h1 { font-size: 28px; margin-bottom: 8px; color: #111827; }
    .print-header p  { color: #475569; margin: 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; border: 1px solid #d1d5db; font-size: 13px; }
    th, td { padding: 12px 14px; border: 1px solid #e5e7eb; text-align: left; }
    th { background: #e2e8f0; color: #0f172a; }
    tr:nth-child(even) { background: #f8fafc; }
    .badge { display: inline-block; padding: 6px 12px; border-radius: 999px; font-size: 11px; font-weight: 700; }
    .row-info { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 14px; margin-top: 18px; }
    .row-info div { background: #f8fafc; padding: 14px; border-radius: 12px; border: 1px solid #e2e8f0; }
    .row-info strong { display: block; margin-bottom: 4px; color: #111827; }
    @page { size: auto; margin: 12mm; }
    @media print {
        .content { margin: 0; padding: 0; }
        body { background: white !important; }
        .no-print { display: none !important; }
    }
</style>

<div class="content">
    <div class="print-header">
        <h1>📄 Laporan Log Aktivitas</h1>
        <p>Halaman ini mencetak semua log aktivitas sesuai filter yang Anda pilih.</p>
        <div class="row-info">
            <div><strong>Waktu Cetak</strong><?= date('d/m/Y H:i:s') ?></div>
            <div><strong>Filter User</strong><?= !empty($_GET['user_id']) ? htmlspecialchars($_GET['user_id']) : 'Semua User' ?></div>
            <div><strong>Filter Aksi</strong><?= !empty($_GET['action']) ? htmlspecialchars($_GET['action']) : 'Semua Aksi' ?></div>
            <div>
                <strong>Rentang Tanggal</strong>
                <?= (!empty($_GET['date_from']) ? htmlspecialchars($_GET['date_from']) : '-') ?>
                s/d
                <?= (!empty($_GET['date_to']) ? htmlspecialchars($_GET['date_to']) : '-') ?>
            </div>
        </div>
    </div>

    <div class="no-print" style="margin-bottom:20px;display:flex;gap:12px;flex-wrap:wrap;">
        <a href="index.php?page=activity_log" class="btn btn-secondary">🔙 Kembali</a>
        <button onclick="window.print()" class="btn btn-success">🖨️ Cetak</button>
        <span style="align-self:center;color:#475569;">Atau gunakan Ctrl+P / Cmd+P untuk memilih printer fisik.</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:5%">No</th>
                <th style="width:18%">Waktu</th>
                <th style="width:18%">User</th>
                <th style="width:12%">Aksi</th>
                <th style="width:47%">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($logs) > 0): ?>
                <?php $no = 1; foreach ($logs as $log): ?>
                <?php
                $map = [
                    'login'   => 'badge-disetujui',
                    'logout'  => 'badge-pending',
                    'create'  => 'badge-tersedia',
                    'update'  => 'badge-dipinjam',
                    'delete'  => 'badge-ditolak',
                    'approve' => 'badge-disetujui',
                    'reject'  => 'badge-ditolak',
                    'return'  => 'badge-selesai',
                ];
                $badge = $map[$log['action']] ?? 'badge-pending';
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d/m/Y H:i:s', strtotime($log['created_at'])) ?></td>
                    <td>
                        <strong><?= htmlspecialchars($log['nama']) ?></strong><br>
                        <small><?= htmlspecialchars($log['username']) ?></small>
                    </td>
                    <td><span class="badge <?= $badge ?>"><?= strtoupper($log['action']) ?></span></td>
                    <td><?= htmlspecialchars($log['description']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align:center;padding:30px;color:#64748b">Tidak ada data log aktivitas</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>window.addEventListener('load', function() { window.print(); });</script>

<?php require_once 'views/layouts/footer.php'; ?>
