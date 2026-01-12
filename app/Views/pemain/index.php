<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Kelola Pemain</title>
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
                <span class="navbar-brand">Kelola Pemain</span>
            </div>
        </nav>

        <div class="container mt-4">
            <a href="/pemain/create" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Tambah Pemain Baru</a>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Pemain</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($pemain)): ?>
                        <p class="text-center">Belum ada data pemain.</p>
                    <?php else: ?>
                        <div style="overflow-x:auto;">
                        <table class="table table-bordered table-striped align-middle text-center" style="min-width: 1000px;">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nickname</th>
                                    <th>ID MLBB</th>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    <th>Rank</th>
                                    <th>Winrate</th>
                                    <th>Kompetisi Menang</th>
                                    <th>Hero Pool</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach ($pemain as $p): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= esc($p['nickname']) ?></td>
                                        <td><?= esc($p['id_mlbb']) ?></td>
                                        <td><?= esc($p['nama']) ?></td>
                                        <td>
                                            <?php
                                                $roleName = '';
                                                foreach ($roles as $role) {
                                                    if ($role['id_role'] == $p['id_role']) {
                                                        $roleName = $role['role'];
                                                        break;
                                                    }
                                                }
                                                echo '<span class="badge bg-dark">' . esc($roleName) . '</span>';
                                            ?>
                                        </td>
                                        <td><span class="badge bg-light text-dark"><?= esc($p['rank']) ?></span></td>
                                        <td><?= esc($p['winrate'] ?? 'N/A') ?>%</td>
                                        <td><?= esc($p['kompetisi_menang'] ?? 'N/A') ?></td>
                                        <td>
                                            <a href="/heropool/index/<?= esc($p['id_mlbb']) ?>" class="btn btn-primary btn-sm">
                                                <i class="fas fa-list"></i> <?= esc($p['total_hero']) ?> Heroes
                                            </a>
                                        </td>
                                        <td>
                                            <a href="/pemain/edit/<?= esc($p['id_mlbb']) ?>" class="btn btn-warning btn-sm me-1">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="/pemain/delete/<?= esc($p['id_mlbb']) ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin ingin menghapus pemain ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/logout-sync.js') ?>"></script>
</body>
</html>
