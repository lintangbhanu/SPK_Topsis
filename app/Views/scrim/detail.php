<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Detail Scrim</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body class="dashboard-body">
    <div class="overlay"></div>
    <div class="sidebar text-center">
        <img src="<?= base_url('assets/icon/icon.png') ?>" alt="Admin Logo" 
        style="width: 120px; height: 120px; object-fit: contain; margin-bottom: 20px;" />
        <a href="/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="/user"><i class="fas fa-users"></i> Kelola User</a>
        <a href="/role"><i class="fas fa-user-tag"></i> Kelola Role</a>
        <a href="/pemain"><i class="fas fa-users"></i> Kelola Pemain</a>
        <a href="/scrim"><i class="fas fa-gamepad"></i> Kelola Scrim</a>
        <a href="/nilai"><i class="fas fa-file-alt"></i> Nilai Scrim</a>
        <a href="/kriteria"><i class="fas fa-list-check"></i> Kriteria Penilaian</a>
        <a href="/perhitungan"><i class="fas fa-calculator"></i> Perhitungan</a>
        <a href="javascript:void(0);" onclick="logout()">
        <i class="fas fa-sign-out-alt"></i> Log out
        </a>
    </div>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <span class="navbar-brand">Kelola Scrim</span>
            </div>
        </nav>

        <div class="container mt-4">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Scrim</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Kolom kiri -->
                        <div class="col-md-6 mb-3">
                            <table class="table table-bordered">
                                <tr><th>Pemain</th><td><?= esc($scrim['nickname']) ?> (<?= esc($scrim['nama']) ?>)</td></tr>
                                <tr><th>Scrim Ke</th><td><?= esc($scrim['scrim_ke']) ?></td></tr>
                                <tr><th>Tanggal</th><td><?= esc($scrim['tanggal']) ?></td></tr>
                                <tr><th>Hero Digunakan</th><td><?= esc($scrim['hero_digunakan']) ?></td></tr>
                                <tr><th>Durasi</th><td><?= esc($scrim['durasi']) ?> menit</td></tr>
                                <tr><th>Total Kill Tim</th><td><?= esc($scrim['total_kill']) ?></td></tr>
                            </table>
                        </div>
                        <!-- Kolom kanan -->
                        <div class="col-md-6 mb-3">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Kill</th>
                                    <td><span class="badge bg-success"><?= esc($scrim['jumlah_kill']) ?></span></td>
                                </tr>
                                <tr>
                                    <th>Death</th>
                                    <td><span class="badge bg-danger"><?= esc($scrim['jumlah_death']) ?></span></td>
                                </tr>
                                <tr>
                                    <th>Assist</th>
                                    <td><span class="badge bg-primary"><?= esc($scrim['jumlah_assist']) ?></span></td>
                                </tr>
                                <tr><th>Damage Hero</th><td><?= number_format($scrim['damage_hero'], 0, ',', '.') ?></td></tr>
                                <tr><th>Damage Turret</th><td><?= number_format($scrim['damage_turret'], 0, ',', '.') ?></td></tr>
                                <tr><th>Damage Diterima</th><td><?= number_format($scrim['damage_diterima'], 0, ',', '.') ?></td></tr>
                                <tr><th>Gold</th><td><?= number_format($scrim['jumlah_gold'], 0, ',', '.') ?></td></tr>
                                <tr><th>Kontrol Objektif</th><td><?= esc($scrim['kontrol_objektif']) ?></td></tr>
                                <?php
                                $komunikasiLabels = [
                                    1 => "Sangat Buruk",
                                    2 => "Buruk",
                                    3 => "Cukup",
                                    4 => "Baik",
                                    5 => "Sangat Baik"
                                ];
                                ?>
                                <tr>
                                    <th>Komunikasi</th>
                                    <td>
                                        <?= esc($scrim['komunikasi']) ?> 
                                        - <span class="badge bg-info">
                                            <?= $komunikasiLabels[$scrim['komunikasi']] ?? 'Tidak Diketahui' ?>
                                        </span>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="/scrim" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="/scrim/edit/<?= $scrim['id_scrim'] ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="/scrim/delete/<?= $scrim['id_scrim'] ?>" 
                   class="btn btn-danger" 
                   onclick="return confirm('Yakin hapus data scrim ini?')">
                    <i class="fas fa-trash"></i> Hapus
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/logout-sync.js') ?>"></script>
</body>
</html>
