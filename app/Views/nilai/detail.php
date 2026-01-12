<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Detail Nilai Scrim</title>
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
                <span class="navbar-brand">Nilai Scrim</span>
            </div>
        </nav>

        <div class="container mt-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Scrim ke-<?= esc($scrim['scrim_ke']); ?> - <?= esc($scrim['nickname']); ?> (<?= esc($scrim['nama']); ?>)</h5>
                    <a href="/nilai" class="btn btn-sm btn-secondary">Kembali</a>
                </div>
                <div class="card-body">
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
                        <table class="table table-sm table-striped table-bordered align-middle text-center" style="min-width: 1100px;">
                            <thead class="table-dark">
                                <tr>
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
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= esc($nilai['C1'] ?? '-') ?></td>
                                    <td><?= esc($nilai['C2'] ?? '-') ?></td>
                                    <td><?= esc($nilai['C3'] ?? '-') ?></td>
                                    <td><?= esc($nilai['C4'] ?? '-') ?></td>
                                    <td><?= esc($nilai['C5'] ?? '-') ?></td>
                                    <td><?= esc($nilai['C6'] ?? '-') ?></td>
                                    <td><?= esc($nilai['C7'] ?? '-') ?></td>
                                    <td><?= esc($nilai['C8'] ?? '-') ?></td>
                                    <td><?= esc($nilai['C9'] ?? '-') ?></td>
                                    <td>
                                        <?= esc($nilai['C10'] ?? '-') ?> -
                                        <span class="badge bg-info">
                                            <?php 
                                                $kom = intval(round($nilai['C10'] ?? 0));
                                                echo $komunikasiLabels[$kom] ?? 'Tidak Diketahui'; 
                                            ?>
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h6 class="mt-4">Data Mentah Scrim</h6>
                    <table class="table table-bordered table-striped">
                        <tr><th>Tanggal</th><td><?= esc($scrim['tanggal']); ?></td></tr>
                        <tr><th>Durasi (menit)</th><td><?= esc($scrim['durasi'] ?? '-'); ?></td></tr>
                        <tr><th>Total Gold</th><td><?= esc($scrim['jumlah_gold'] ?? '-'); ?></td></tr>
                        <tr><th>Hero Damage</th><td><?= esc($scrim['damage_hero'] ?? '-'); ?></td></tr>
                        <tr><th>Turret Damage</th><td><?= esc($scrim['damage_turret'] ?? '-'); ?></td></tr>
                        <tr><th>Damage Taken</th><td><?= esc($scrim['damage_diterima'] ?? '-'); ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/logout-sync.js') ?>"></script>
</body>
</html>
