<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Kelola Kriteria</title>
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
                <span class="navbar-brand">Kelola Kriteria</span>
            </div>
        </nav>

        <div class="container mt-4">

            <!-- Baris tombol kiri-kanan -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="/kriteria/create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Kriteria Baru
                </a>
                <a href="/bobot" class="btn btn-success">
                    <i class="fas fa-weight-hanging"></i> Update Bobot
                </a>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="table-responsive">
                <?php
                // Sort kriteria by numeric part of id_kriteria (e.g., C1, C2, ..., C10)
                usort($kriteria, function($a, $b) {
                    $numA = (int) substr($a['id_kriteria'], 1);
                    $numB = (int) substr($b['id_kriteria'], 1);
                    return $numA <=> $numB;
                });
                ?>
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID Kriteria</th>
                            <th>Kriteria</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kriteria as $k): ?>
                            <tr>
                                <td><?= esc($k['id_kriteria']) ?></td>
                                <td><?= esc($k['kriteria']) ?></td>
                                <td>
                                    <a href="/kriteria/edit/<?= esc($k['id_kriteria']) ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="/kriteria/delete/<?= esc($k['id_kriteria']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kriteria ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
