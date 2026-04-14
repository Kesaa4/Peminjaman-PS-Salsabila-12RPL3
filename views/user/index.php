<?php require_once 'views/layouts/header.php'; ?>
<?php // Halaman daftar user untuk admin (lihat dan akses edit data user). ?>

<div class="content">
    <h1>Kelola User</h1>
    
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
        <a href="index.php?page=user&action=create" class="btn">+ Tambah User</a>
    </div>
    
    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Role</th>
                <th>Tanggal Dibuat</th>
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
                <td><?php echo htmlspecialchars($row['username'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['nama'] ?? ''); ?></td>
                <td><?php echo ucfirst($row['role'] ?? ''); ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                <td>
                    <a href="index.php?page=user&action=edit&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <?php if($row['id'] != $_SESSION['user_id']): ?>
                    <?php $uname = htmlspecialchars($row['username']); ?>
                    <a href="index.php?page=user&action=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Hapus user <?php echo $uname; ?>?')">Hapus</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>
