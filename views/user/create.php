<?php require_once 'views/layouts/header.php'; ?>
<?php // Form tambah user baru beserta role akun. ?>

<div class="content">
    <h1>Tambah User</h1>
    
    <div class="form-container">
        <form method="POST" action="index.php?page=user&action=store" id="user-form">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            
            <div class="form-group" id="nama-group">
                <label id="nama-label">Nama Lengkap</label>
                <input type="text" name="nama" id="nama-input" required>
            </div>
            
            <div class="form-group">
                <label>Role</label>
                <select name="role" id="role-select" required>
                    <option value="">Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                    <option value="peminjam">Peminjam</option>
                </select>
            </div>
            
            <button type="submit" class="btn">Simpan</button>
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
