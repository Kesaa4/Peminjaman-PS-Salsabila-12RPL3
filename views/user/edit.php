<?php require_once 'views/layouts/header.php'; ?>
<?php // Form ubah data user. Password boleh dikosongkan jika tidak diubah. ?>

<div class="content">
    <h1>Edit User</h1>
    
    <div class="form-container">
        <form method="POST" action="index.php?page=user&action=update" id="user-form">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($data['username'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password">
            </div>
            
            <div class="form-group" id="nama-group">
                <label id="nama-label">Nama Lengkap</label>
                <input type="text" name="nama" id="nama-input" value="<?php echo htmlspecialchars($data['nama'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Role</label>
                <select name="role" id="role-select" required>
                    <option value="admin" <?php echo $data['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="petugas" <?php echo $data['role'] == 'petugas' ? 'selected' : ''; ?>>Petugas</option>
                    <option value="peminjam" <?php echo $data['role'] == 'peminjam' ? 'selected' : ''; ?>>Peminjam</option>
                </select>
            </div>
            
            <button type="submit" class="btn">Update</button>
            <a href="index.php?page=user&action=index" class="btn btn-danger">Batal</a>
        </form>
    </div>
</div>

<script>
(function() {
    const roleSelect = document.getElementById('role-select');
    const namaInput = document.getElementById('nama-input');
    const namaLabel = document.getElementById('nama-label');

    function syncNamaRequirement() {
        const isPetugas = roleSelect.value === 'petugas';
        namaInput.required = !isPetugas;
        namaLabel.textContent = isPetugas ? 'Nama (Opsional untuk Petugas)' : 'Nama Lengkap';
        if (isPetugas) {
            namaInput.placeholder = 'Tidak wajib untuk petugas';
        } else {
            namaInput.placeholder = '';
        }
    }

    roleSelect.addEventListener('change', syncNamaRequirement);
    syncNamaRequirement();
})();
</script>

<?php require_once 'views/layouts/footer.php'; ?>
