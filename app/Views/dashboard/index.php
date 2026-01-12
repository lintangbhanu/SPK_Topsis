<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>

<body class="dashboard-body">
    <div class="overlay"></div>
<div class="sidebar text-center">
        <img src="<?= base_url('assets/icon/icon.png') ?>" alt="Admin Logo" style="width: 120px; height: 120px; object-fit: contain; margin-bottom: 20px;" />
        <a href="/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="/user"><i class="fas fa-users"></i> Kelola User</a>
        <a href="/role"><i class="fas fa-user-tag"></i> Kelola Role</a>
        <a href="/pemain"><i class="fas fa-users"></i> Kelola Pemain</a>
        <a href="/scrim"><i class="fas fa-gamepad"></i> Kelola Scrim</a>
        <a href="/nilai"><i class="fas fa-file-alt"></i> Nilai Scrim</a>
        <a href="/kriteria"><i class="fas fa-list-check"></i> Kriteria Penilaian</a>
        <a href="/perhitungan"><i class="fas fa-calculator"></i> Perhitungan</a>
        <a href="javascript:void(0);" onclick="logout()" class="fas-fa-sign-out-alt"><i class="fas fa-sign-out-alt"></i> Log out</a>
    </div>
    
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <span class="navbar-brand">Admin Dashboard</span>
            </div>
        </nav>

        <div class="mt-4">
            <h2>Selamat datang <?= session()->get('name'); ?>!</h2>
            <!-- Statistics Cards -->
            <div class="row g-4 mt-3">
                <div class="col-md-6">
                    <div class="card p-4">
                        <h5>Total Pemain per Role</h5>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($totalPlayersPerRole as $role => $count): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= esc($role) ?>
                                    <span class="badge bg-primary rounded-pill"><?= $count ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-4">
                        <h5>Total Scrim per Role</h5>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($totalScrimsPerRole as $role => $count): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?= esc($role) ?>
                                    <span class="badge bg-primary rounded-pill"><?= $count ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/logout-sync.js') ?>"></script>
</body>

</html>