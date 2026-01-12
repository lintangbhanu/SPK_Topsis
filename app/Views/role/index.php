<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Kelola Role</title>
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
        <a href="/perhitungan"><i class="fas fa-calculator"></i>Perhitungan</a>
        <a href="javascript:void(0);" onclick="logout()" class="fas-fa-sign-out-alt"><i class="fas fa-sign-out-alt"></i> Log out</a>
    </div>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <span class="navbar-brand">Kelola Role</span>
            </div>
        </nav>

        <div class="container mt-4">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Daftar Role</h2>
                <a href="/role/create" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Role</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>ID Role</th>
                            <th>Nama Role</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        foreach ($roles as $role): 
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= esc($role['id_role']) ?></td>
                                <td><?= esc($role['role']) ?></td>
                                <td>
                                    <a href="/role/edit/<?= esc($role['id_role']) ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="/role/delete/<?= esc($role['id_role']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus role ini?')"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/logout-sync.js') ?>"></script>
</body>

</html>
