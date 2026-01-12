<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Tambah Scrim</title>
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
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <div class="card">
                <div class="card-header">
                    <h5>Tambah Scrim</h5>
                </div>
                <div class="card-body">
                    <?= form_open('/scrim/store') ?>
                        
                        <!-- Pemain -->
                        <div class="mb-3">
                            <label for="id_mlbb" class="form-label">Pemain</label>
                            <select name="id_mlbb" id="id_mlbb" class="form-select" required>
                                <option value="">Pilih Pemain</option>
                                <?php foreach ($pemain as $p): ?>
                                    <option value="<?= esc($p['id_mlbb']) ?>" <?= old('id_mlbb') == $p['id_mlbb'] ? 'selected' : '' ?>>
                                        <?= esc($p['nickname']) ?> (<?= esc($p['nama']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Tanggal & Durasi -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= old('tanggal') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="durasi" class="form-label">Durasi (menit)</label>
                                <input type="number" name="durasi" id="durasi" class="form-control" min="1" value="<?= old('durasi') ?>" required>
                            </div>
                            
                        </div>

                        <!-- Statistik Tim -->
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="total_kill" class="form-label">Total Kill Tim</label>
                                <input type="number" name="total_kill" id="total_kill" class="form-control" min="0" value="<?= old('total_kill') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="hero_digunakan" class="form-label">Hero Digunakan</label>
                                <input type="text" name="hero_digunakan" id="hero_digunakan" class="form-control" value="<?= old('hero_digunakan') ?>" required>
                            </div>
                        </div>

                        <!-- Statistik Individu -->
                        <hr>
                        <h6>Statistik Individu</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="jumlah_kill" class="form-label">Jumlah Kill</label>
                                <input type="number" name="jumlah_kill" id="jumlah_kill" class="form-control" min="0" value="<?= old('jumlah_kill') ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="jumlah_death" class="form-label">Jumlah Death</label>
                                <input type="number" name="jumlah_death" id="jumlah_death" class="form-control" min="0" value="<?= old('jumlah_death') ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="jumlah_assist" class="form-label">Jumlah Assist</label>
                                <input type="number" name="jumlah_assist" id="jumlah_assist" class="form-control" min="0" value="<?= old('jumlah_assist') ?>" required>
                            </div>
                        </div>

                        <!-- Damage -->
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="damage_hero" class="form-label">Damage Hero</label>
                                <input type="number" name="damage_hero" id="damage_hero" class="form-control" min="0" value="<?= old('damage_hero') ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="damage_turret" class="form-label">Damage Turret</label>
                                <input type="number" name="damage_turret" id="damage_turret" class="form-control" min="0" value="<?= old('damage_turret') ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="damage_diterima" class="form-label">Damage Diterima</label>
                                <input type="number" name="damage_diterima" id="damage_diterima" class="form-control" min="0" value="<?= old('damage_diterima') ?>" required>
                            </div>
                        </div>

                        <!-- Objective -->
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="jumlah_gold" class="form-label">Jumlah Gold</label>
                                <input type="number" name="jumlah_gold" id="jumlah_gold" class="form-control" min="0" value="<?= old('jumlah_gold') ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label for="turtle" class="form-label">Turtle</label>
                                <input type="number" name="turtle" id="turtle" class="form-control" min="0" value="<?= old('turtle') ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label for="lord" class="form-label">Lord</label>
                                <input type="number" name="lord" id="lord" class="form-control" min="0" value="<?= old('lord') ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="komunikasi" class="form-label">Komunikasi</label>
                                <select name="komunikasi" id="komunikasi" class="form-select" required>
                                    <option value="">Pilih Komunikasi</option>
                                    <?php for ($i=1; $i<=5; $i++): ?>
                                        <option value="<?= $i ?>" <?= old('komunikasi') == $i ? 'selected' : '' ?>>
                                            <?= $i ?> - <?= ['Sangat Buruk','Buruk','Cukup','Baik','Sangat Baik'][$i-1] ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="/scrim" class="btn btn-secondary">Batal</a>
                        </div>

                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/js/logout-sync.js') ?>"></script>
</body>
</html>
