<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Kelola Scrim</title>
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
        <a href="javascript:void(0);" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Log out</a>
    </div>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <span class="navbar-brand">Kelola Scrim</span>
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
                    <h5>Daftar Scrim</h5>
                    <a href="/scrim/create" class="btn btn-primary">Tambah Scrim</a>
                </div>
                <div class="card-body">
                    <?php if (empty($scrims)): ?>
                        <p class="text-center">Belum ada data scrim. <a href="/scrim/create">Buat scrim baru</a>.</p>
                    <?php else: ?>
                        <table class="table table-striped table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Scrim Ke</th>
                                    <th>Pemain</th>
                                    <th>Tanggal</th>
                                    <th>Hero</th>
                                    <th>Durasi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($scrims as $scrim): ?>
                                    <tr>
                                        <td><?= esc($scrim['scrim_ke']) ?></td>
                                        <td><?= esc($scrim['nickname']) ?> (<?= esc($scrim['nama']) ?>)</td>
                                        <td><?= date('d M Y', strtotime($scrim['tanggal'])) ?></td>
                                        <td>
                                            <?php foreach (explode(',', $scrim['hero_digunakan']) as $hero): ?>
                                                <span class="badge bg-secondary"><?= esc(trim($hero)) ?></span>
                                            <?php endforeach; ?>
                                        </td>
                                        <td><?= esc($scrim['durasi']) ?> menit</td>
                                        <td>
                                            <a href="/scrim/detail/<?= $scrim['id_scrim'] ?>" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <a href="/scrim/edit/<?= $scrim['id_scrim'] ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="/scrim/delete/<?= $scrim['id_scrim'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data scrim ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/logout-sync.js') ?>"></script>
</body>
</html>
