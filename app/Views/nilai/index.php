<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Nilai Scrim</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <style>
    /* Supaya tabel bisa discroll horizontal */
    .table-responsive {
        overflow-x: auto;
    }
    table.table {
        font-size: 0.85em;
        min-width: 1500px;
        white-space: nowrap;
    }
    table.table th, table.table td {
        vertical-align: middle;
        text-align: center;
    }
    table.table th {
        min-width: 100px;
    }
    table.table th[rowspan="2"] {
        min-width: 200px; /* kolom Kriteria lebih lebar */
    }

    /* Membekukan header tabel */
    table.table thead th {
        position: sticky;
        top: 0;
        background: #343a40;
        color: #fff;
        z-index: 10;
    }

    /* Membekukan kolom pertama (Kriteria) */
    table.table th:first-child,
    table.table td:first-child {
    background: #fff;
    text-align: left !important;
    padding-left: 10px;
    }
    
    table.table thead tr:nth-child(2) th {
    top: 36px; /* tinggi header baris pertama */
    background: #495057; /* beda sedikit warnanya */
    z-index: 9;
    }

    /* Supaya header kolom pertama tidak ketimpa */
    table.table thead th:first-child {
        z-index: 15;
        background: #343a40;
        color: #fff;
    }
</style>
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
                <span class="navbar-brand">Nilai Scrim</span>
            </div>
        </nav>

        <div class="container mt-4">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Daftar Nilai Scrim</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($nilaiScrims)): ?>
                        <p class="text-center">Belum ada data nilai scrim.</p>
                    <?php else: ?>
                        <?php 
                        $komunikasiLabels = [
                            1 => "Sangat Buruk",
                            2 => "Buruk",
                            3 => "Cukup",
                            4 => "Baik",
                            5 => "Sangat Baik"
                        ];
                        ?>
                        <div style="overflow-x:auto;">
                        <table class="table table-sm table-striped table-bordered align-middle text-center" style="min-width: 1300px;">
                            <thead class="table-dark">
                                <tr>
                                    <th>Scrim Ke</th>
                                    <th>Pemain</th>
                                    <th>Kill</th>
                                    <th>Death</th>
                                    <th>Assist</th>
                                    <th>Gold/Minute</th>
                                    <th>Hero Dmg/Minute</th>
                                    <th>Turret Dmg/Minute</th>
                                    <th>Dmg Taken/Minute</th>
                                    <th>Team Fight</th>
                                    <th>Objective Control</th>
                                    <th>Komunikasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($nilaiScrims as $nilai): ?>
                                    <tr>
                                        <td><?= esc($nilai['scrim_ke']) ?></td>
                                        <td><?= esc($nilai['nickname']) ?> (<?= esc($nilai['nama']) ?>)</td>
                                        <td><?= esc($nilai['C1']) ?></td>
                                        <td><?= esc($nilai['C2']) ?></td>
                                        <td><?= esc($nilai['C3']) ?></td>
                                        <td><?= esc($nilai['C4']) ?></td>
                                        <td><?= esc($nilai['C5']) ?></td>
                                        <td><?= esc($nilai['C6']) ?></td>
                                        <td><?= esc($nilai['C7']) ?></td>
                                        <td><?= esc($nilai['C8']) ?></td>
                                        <td><?= esc($nilai['C9']) ?></td>
                                        <td>
                                            <?= esc($nilai['C10']) ?> - 
                                            <span class="badge bg-info">
                                                <?php 
                                                    $kom = intval(round($nilai['C10'])); 
                                                    echo $komunikasiLabels[$kom] ?? 'Tidak Diketahui'; 
                                                ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="/nilai/detail/<?= $nilai['id_scrim'] ?>" class="btn btn-sm btn-info">Detail</a>
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
