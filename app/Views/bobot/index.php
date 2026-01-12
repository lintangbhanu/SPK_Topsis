<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Kelola Bobot</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
<style>
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
        min-width: 120px;
    }
    table.table th[rowspan="2"] {
        min-width: 200px;
    }

    table.table thead th {
        position: sticky;
        top: 0;
        background: #343a40;
        color: #fff;
        z-index: 10;
    }

    table.table th:first-child,
    table.table td:first-child {
        position: sticky;
        left: 0;
        background: #fff;
        z-index: 5;
        text-align: left !important;
        padding-left: 10px;
    }
    table.table thead tr:nth-child(2) th {
        top: 36px; 
        background: #495057;
        z-index: 9;
    }

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
                <span class="navbar-brand">Kelola Bobot Kriteria</span>
            </div>
        </nav>

        <div class="container mt-4">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h5>Input Skor Kriteria per Role</h5>
                    <small class="text-muted">Bobot akan dihitung otomatis berdasarkan skor yang diinput</small>
                    <div class="alert alert-info mt-2 p-2">
                        <small><i class="fas fa-info-circle"></i> <strong>Skor harus diisi angka 1-9:</strong> 1 = Sangat tidak penting, 9 = Sangat penting.</small>
                    </div>
                </div>
                <div class="card-body">
                    <form action="/bobot/update" method="post">
                        <div class="table-responsive">
                            <?php
                            // Sort kriteria berdasarkan angka di id_kriteria (C1, C2, dst.)
                            usort($kriteria, function($a, $b) {
                                $numA = (int) substr($a['id_kriteria'], 1);
                                $numB = (int) substr($b['id_kriteria'], 1);
                                return $numA <=> $numB;
                            });
                            ?>
                            <table class="table table-bordered table-striped table-sm">
                                <thead class="table-dark">
                                    <tr>
                                        <th rowspan="2">Kriteria</th>
                                        <?php foreach ($roles as $role): ?>
                                            <th colspan="3"><?= esc($role['role']) ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                    <tr>
                                        <?php foreach ($roles as $role): ?>
                                            <th>Skor</th>
                                            <th>Bobot</th>
                                            <th>Atribut</th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kriteria as $k): ?>
                                        <tr>
                                            <td><strong><?= esc($k['id_kriteria']) ?> - <?= esc($k['kriteria']) ?></strong></td>
                                            <?php foreach ($roles as $role): ?>
                                                <td>
                                                    <input type="number" step="1" min="1" max="9"
                                                           name="skor_<?= esc($role['id_role']) ?>_<?= esc($k['id_kriteria']) ?>"
                                                           value="<?= esc($skorMap[$role['id_role'] . '_' . $k['id_kriteria']] ?? 0) ?>"
                                                           class="form-control form-control-sm text-center" required>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark fw-bold bobot-display"
                                                          data-role="<?= esc($role['id_role']) ?>"
                                                          data-kriteria="<?= esc($k['id_kriteria']) ?>"
                                                          style="font-size: 0.85em;">
                                                        <?= esc(number_format($bobotMap[$role['id_role'] . '_' . $k['id_kriteria']] ?? 0, 6)) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <select name="atribut_<?= esc($role['id_role']) ?>_<?= esc($k['id_kriteria']) ?>" class="form-select form-select-sm">
                                                        <option value="Benefit" <?= (isset($atributMap[$role['id_role'] . '_' . $k['id_kriteria']]) && $atributMap[$role['id_role'] . '_' . $k['id_kriteria']] == 'Benefit') ? 'selected' : '' ?>>Benefit</option>
                                                        <option value="Cost" <?= (isset($atributMap[$role['id_role'] . '_' . $k['id_kriteria']]) && $atributMap[$role['id_role'] . '_' . $k['id_kriteria']] == 'Cost') ? 'selected' : '' ?>>Cost</option>
                                                    </select>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
                                <a href="/kriteria" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </div>
                            <div class="col-md-6 text-end">
                                <small class="text-muted">
                                    <strong>Rumus Bobot:</strong> Bobot = Skor / Total Skor Semua Kriteria
                                </small>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/logout-sync.js') ?>"></script>

    <!-- Script untuk auto-update bobot -->
    <script>
    document.querySelectorAll('input[name^="skor_"]').forEach(input => {
        input.addEventListener('input', () => {
            let [_, idRole] = input.name.split('_');
            let roleInputs = document.querySelectorAll(`input[name^="skor_${idRole}_"]`);

            // Hitung total skor per role
            let total = 0;
            roleInputs.forEach(i => total += parseFloat(i.value) || 0);

            // Update bobot di tabel
            roleInputs.forEach(i => {
                let parts = i.name.split('_');
                let idRole = parts[1];
                let idKriteria = parts[2];
                let skor = parseFloat(i.value) || 0;
                let bobot = total > 0 ? skor / total : 0;

                let badge = i.closest('td').nextElementSibling.querySelector('span');
                badge.textContent = bobot.toFixed(6);
            });
        });
    });
    </script>
</body>
</html>
