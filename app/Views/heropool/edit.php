<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Edit Hero Pool</title>
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
            <a href="/heropool/index/<?= esc($pemain['id_mlbb']) ?>" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Kembali ke Detail Pemain</a>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('error') ?>
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

            <!-- Edit Hero Pool -->
            <div class="card">
                <div class="card-header">
                    <h5>Edit Hero Pool</h5>
                </div>
                <div class="card-body">
                    <form action="/heropool/update/<?= esc($pemain['id_mlbb']) ?>" method="post">
                        <?php foreach ($allHeroes as $role => $heroes): ?>
                            <h6 class="mt-3"><strong><?= esc($role) ?></strong></h6>
                            <div class="row">
                                <?php foreach ($heroes as $hero): ?>
                                    <div class="col-md-3 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   name="heroes[]"
                                                   value="<?= esc($hero) ?>"
                                                   id="hero_<?= esc($hero) ?>"
                                                   <?= in_array($hero, $existingHeroes) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="hero_<?= esc($hero) ?>">
                                                <?= esc($hero) ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>

                        <button type="submit" class="btn btn-success mt-3">Save</button>
                        <a href="/heropool/index/<?= esc($pemain['id_mlbb']) ?>" class="btn btn-secondary mt-3">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/logout-sync.js') ?>"></script>
</body>

</html>
