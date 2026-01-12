<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Tambah Pemain</title>
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
        <a href="javascript:void(0);" onclick="logout()" class="fas-fa-sign-out-alt"><i class="fas fa-sign-out-alt"></i> Log out</a>
    </div>

    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <span class="navbar-brand">Kelola Pemain</span>
            </div>
        </nav>

        <div class="container mt-4">
            
            <h2>Tambah Pemain</h2>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="/pemain/store" method="post" class="mt-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_mlbb" class="form-label">ID MLBB:</label>
                        <input type="text" id="id_mlbb" name="id_mlbb" value="<?= old('id_mlbb') ?>" class="form-control" required maxlength="255">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nickname" class="form-label">Nickname:</label>
                        <input type="text" id="nickname" name="nickname" value="<?= old('nickname') ?>" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Nama:</label>
                        <input type="text" id="nama" name="nama" value="<?= old('nama') ?>" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="id_role" class="form-label">Role:</label>
                        <select id="id_role" name="id_role" class="form-select" required>
                            <option value="">--Pilih role--</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= esc($role['id_role']) ?>" <?= old('id_role') == $role['id_role'] ? 'selected' : '' ?>>
                                    <?= esc($role['role']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="rank" class="form-label">Rank:</label>
                        <input type="text" id="rank" name="rank" value="<?= old('rank') ?>" class="form-control" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="winrate" class="form-label">Winrate (%):</label>
                        <input type="number" step="0.01" id="winrate" name="winrate" value="<?= old('winrate') ?>" class="form-control" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="kompetisi_menang" class="form-label">Kompetisi yang Pernah Dimenangkan:</label>
                        <input type="text" id="kompetisi_menang" name="kompetisi_menang" value="<?= old('kompetisi_menang') ?>" class="form-control" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                <a href="/pemain" class="btn btn-secondary ms-2">Batal</a>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/logout-sync.js') ?>"></script>
</body>

</html>
