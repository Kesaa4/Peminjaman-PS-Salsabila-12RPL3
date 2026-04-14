<?php require_once 'views/layouts/header.php'; ?>

<div class="content">
    <h1>📊 Statistik Aktivitas</h1>
    
    <div class="form-container">
        <a href="index.php?page=activity_log" class="btn" style="background: linear-gradient(135deg, #64748b, #94a3b8); margin-bottom: 20px;">
            ← Kembali ke Log
        </a>
        
        <!-- Filter Form -->
        <form method="GET" action="index.php" style="margin-bottom: 30px;">
            <input type="hidden" name="page" value="activity_log">
            <input type="hidden" name="action" value="stats">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px;">
                <div class="form-group">
                    <label>Dari Tanggal</label>
                    <input type="date" name="date_from" value="<?= $_GET['date_from'] ?? '' ?>">
                </div>
                
                <div class="form-group">
                    <label>Sampai Tanggal</label>
                    <input type="date" name="date_to" value="<?= $_GET['date_to'] ?? '' ?>">
                </div>
                
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn" style="width: 100%;">🔍 Filter</button>
                </div>
            </div>
        </form>

        <!-- Total Stats -->
        <?php 
        $total = 0;
        foreach($stats as $stat) {
            $total += $stat['count'];
        }
        ?>
        <div style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); padding: 20px; border-radius: 15px; margin-bottom: 30px; text-align: center; border-left: 4px solid #3b82f6;">
            <h2 style="margin: 0; color: #1e40af; font-size: 24px;">Total Aktivitas: <strong><?= $total ?></strong></h2>
        </div>

        <!-- Stats Table -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 10%;">No</th>
                        <th style="width: 30%;">Jenis Aktivitas</th>
                        <th style="width: 20%;">Jumlah</th>
                        <th style="width: 40%;">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($stats) > 0): ?>
                        <?php
                        $map = ['login'=>'badge-disetujui','logout'=>'badge-pending','create'=>'badge-tersedia','update'=>'badge-dipinjam','delete'=>'badge-ditolak','approve'=>'badge-disetujui','reject'=>'badge-ditolak','return'=>'badge-selesai'];
                        $no = 1; foreach($stats as $stat):
                        $percentage  = ($stat['count'] / $total) * 100;
                        $badge_class = $map[$stat['action']] ?? 'badge-pending';
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <span class="badge <?= $badge_class ?>">
                                    <?= strtoupper($stat['action']) ?>
                                </span>
                            </td>
                            <td><strong style="font-size: 18px;"><?= $stat['count'] ?></strong></td>
                            <td>
                                <div style="background: #e2e8f0; border-radius: 10px; overflow: hidden; height: 30px; position: relative;">
                                    <div style="background: linear-gradient(135deg, #ec4899, #f472b6); height: 100%; width: <?= $percentage ?>%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 14px; transition: width 0.5s ease;">
                                        <?= number_format($percentage, 2) ?>%
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 30px; color: #64748b;">
                                Tidak ada data statistik
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
