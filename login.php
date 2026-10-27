<?php include 'header.php'; ?>
<div class="login-wrap">
    <div class="card card-app login-card">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="brand-icon-lg mx-auto"><i class="bi bi-capsule-pill"></i></div>
                <h4 class="fw-bold mt-3 mb-1">Selamat Datang</h4>
                <p class="text-muted small mb-0">Masuk untuk mengelola data apotek</p>
            </div>
            <form action="proses_login.php" method="POST">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-person text-muted"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 rounded-pill fw-semibold">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </button>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>