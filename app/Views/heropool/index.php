<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Kelola Heropool</title>
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
                <span class="navbar-brand">Heropool Pemain</span>
            </div>
        </nav>

        <div class="container mt-4">
            <a href="/pemain" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Pemain</a>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- Player Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Informasi Pemain</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID MLBB:</strong> <?= esc($pemain['id_mlbb']) ?></p>
                            <p><strong>Nickname:</strong> <?= esc($pemain['nickname']) ?></p>
                            <p><strong>Nama:</strong> <?= esc($pemain['nama']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Role:</strong>
                                <?php
                                $roleName = '';
                                foreach ($roles as $role) {
                                    if ($role['id_role'] == $pemain['id_role']) {
                                        $roleName = $role['role'];
                                        break;
                                    }
                                }
                                echo esc($roleName);
                                ?>
                            </p>
                            <p><strong>Rank:</strong> <?= esc($pemain['rank']) ?></p>
                            <p><strong>Winrate (%):</strong> <?= esc($pemain['winrate'] ?? '') ?></p>
                            <p><strong>Kompetisi yang Pernah Dimenangkan:</strong> <?= esc($pemain['kompetisi_menang'] ?? '') ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hero Pool -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Hero Pool</h5>
                    <a href="/heropool/edit/<?= esc($pemain['id_mlbb']) ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Edit Heropool</a>
                </div>
                <div class="card-body">
                    <!-- Tambahkan max-height agar tabel tidak terlalu panjang -->
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>Hero</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($heropool)): ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($heropool as $hp): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= esc($hp['hero']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="text-center">Belum ada hero yang ditambahkan.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/logout-sync.js') ?>"></script>
</body>

</html>
