<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Perhitungan</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <style>
    .table-responsive { overflow-x: auto; }
    .table-custom {
        font-size: 0.85em;
        min-width: 1200px;
        white-space: nowrap;
    }
    .table-custom th, .table-custom td {
        vertical-align: middle;
        text-align: center;
    }
    .table-custom thead th {
        position: sticky;
        top: 0;
        background: #343a40; 
        color: #fff;
    }
    /* Warna latar belakang select2 agar beda dengan card */
.select2-container--default .select2-selection--multiple {
  background-color: #f1f5f9 !important; /* abu muda */
  border: 1px solid #ccc !important;
  border-radius: 6px !important;
  min-height: 40px;
}

/* Warna teks dan placeholder */
.select2-container--default .select2-selection--multiple .select2-selection__rendered {
  color: #000 !important;
}

/* Warna tag (item yang dipilih) */
.select2-container--default .select2-selection--multiple .select2-selection__choice {
  background-color: #2563eb !important; /* biru tua */
  color: white !important;
  border: none !important;
}

/* Hover dan fokus */
.select2-container--default.select2-container--focus .select2-selection--multiple {
  border-color: #2563eb !important;
  background-color: #e2e8f0 !important;
}

  </style>
</head>
<body class="dashboard-body">
<?php
// 🔢 Fungsi format angka seperti Excel (langsung di view)
function fmt_excel($value, $decimals = 8) {
    if (!is_numeric($value)) return $value;
    if (fmod($value, 1) == 0.0) {
        return number_format($value, 0, '.', '');
    }
    $formatted = number_format($value, $decimals, '.', '');
    return rtrim(rtrim($formatted, '0'), '.');
}
?>

  <div class="overlay"></div>

  <!-- Sidebar -->
  <div class="sidebar text-center">
    <img src="<?= base_url('assets/icon/icon.png') ?>" alt="Logo" style="width:120px;height:120px;object-fit:contain;margin-bottom:20px;" />
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

  <!-- Content -->
  <div class="content">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container-fluid">
        <span class="navbar-brand">Perhitungan TOPSIS Pemain</span>
      </div>
    </nav>

    <div class="container mt-4">

      <!-- Filter -->
      <div class="card mb-4">
        <div class="card-header"><h5>Filter Pemain</h5></div>
        <div class="card-body">
          <form method="get" action="/perhitungan">
            <div class="row">
              <div class="col-md-5">
                <label for="roles" class="form-label">Pilih Role</label>
                <select name="roles[]" id="roles" class="form-select" multiple>
                  <?php foreach ($roles as $role): ?>
                    <option value="<?= $role['id_role'] ?>" <?= in_array($role['id_role'], $selectedRoles) ? 'selected' : '' ?>>
                      <?= esc($role['role']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-5">
                <label for="players" class="form-label">Pilih Pemain</label>
                <select name="players[]" id="players" class="form-select" multiple>
                  <?php foreach ($pemainByRole as $roleId => $pemainList): ?>
                    <optgroup label="<?= esc($roles[array_search($roleId, array_column($roles, 'id_role'))]['role']) ?>">
                      <?php foreach ($pemainList as $pemain): ?>
                        <option value="<?= $pemain['id_mlbb'] ?>" <?= in_array($pemain['id_mlbb'], $selectedPlayers) ? 'selected' : '' ?>>
                          <?= esc($pemain['nickname']) ?> (<?= esc($pemain['nama']) ?>)
                        </option>
                      <?php endforeach; ?>
                    </optgroup>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Tampilkan</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <?php if (empty($rataRata)): ?>
        <p class="text-center">Belum ada data scrim.</p>
      <?php else: ?>

        <!-- Nilai Sebelum Rata-rata -->
        <div class="card mb-5">
          <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Nilai Scrim Sebelum Rata-rata</h5>
          </div>
          <div class="card-body">
            <div class="table-responsive mb-3">
              <table class="table table-bordered table-striped table-sm table-custom">
                <thead>
                  <tr>
                    <th rowspan="2" style="vertical-align: middle;">Alternatif (Nickname & Nama)</th>
                    <th colspan="13">Kriteria</th>
                  </tr>
                  <tr>
                    <?php for ($i=1; $i<=13; $i++): ?>
                      <th>C<?= $i ?></th>
                    <?php endfor; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($rataRata as $player): ?>
                    <?php $groupedScrim = []; foreach ($player['raw'] as $nilai) { 
                      $scrimId = $nilai['id_scrim']; 
                      if (!isset($groupedScrim[$scrimId])) { 
                        $groupedScrim[$scrimId] = [ 'C1'=>0,'C2'=>0,'C3'=>0,'C4'=>0,'C5'=>0,'C6'=>0,'C7'=>0,'C8'=>0,'C9'=>0,'C10'=>0,'C11'=>$player['C11'],'C12'=>$player['C12'],'C13'=>$player['C13']]; 
                      } 
                      $groupedScrim[$scrimId][$nilai['id_kriteria']] = $nilai['nilai']; 
                    } ?>
                    <?php foreach ($groupedScrim as $scrim): ?>
                      <tr>
                        <td><?= esc($player['alternatif']) ?> (<?= esc($player['nama']) ?>)</td>
                        <?php for ($i=1; $i<=13; $i++): ?>
                          <td><?= esc(fmt_excel($scrim["C$i"] ?? 0)) ?></td>
                        <?php endfor; ?>
                      </tr>
                    <?php endforeach; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Rata-rata -->
        <div class="card mb-5">
          <div class="card-header bg-dark text-white"><h5>Rata-rata Nilai Pemain (C1–C13)</h5></div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm table-custom">
                <thead>
                  <tr>
                    <th>Alternatif</th>
                    <th>Nama</th>
                    <?php for ($i=1; $i<=13; $i++): ?><th>C<?= $i ?></th><?php endfor; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($rataRata as $row): ?>
                    <tr>
                      <td><?= esc($row['alternatif']) ?></td>
                      <td><?= esc($row['nama']) ?></td>
                      <?php for ($i=1; $i<=13; $i++): ?>
                        <td><?= esc(fmt_excel($row["C$i"])) ?></td>
                      <?php endfor; ?>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Hasil TOPSIS -->
        <?php if (!empty($hasilTopsis)): ?>
          <?php foreach ($hasilTopsis as $roleId => $hasil): ?>
            <div class="card mb-5">
              <div class="card-header bg-dark text-white">
                <h5>Perhitungan TOPSIS - Role: <?= esc($roles[array_search($roleId, array_column($roles, 'id_role'))]['role']) ?></h5>
              </div>
              <div class="card-body">

                <!-- Matriks Keputusan -->
                <h5>Matriks Keputusan (X)</h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-custom">
                    <thead>
                      <tr><th>Alternatif</th><?php for ($i=1;$i<=13;$i++):?><th>C<?= $i ?></th><?php endfor;?></tr>
                    </thead>
                    <tbody>
                      <?php foreach ($hasil['matrix'] as $alt=>$vals): ?>
                        <tr>
                          <td><?= esc($alt) ?></td>
                          <?php for ($i=1;$i<=13;$i++): ?>
                            <td><?= esc(fmt_excel($vals["C$i"])) ?></td>
                          <?php endfor; ?>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

                <!-- Atribut & Bobot -->
                <h6 class="mt-3">Atribut dan Bobot Kriteria</h6>
                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-custom">
                    <thead>
                      <tr><th>Kriteria</th><?php for ($i=1;$i<=13;$i++):?><th>C<?= $i ?></th><?php endfor;?></tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><strong>Atribut</strong></td>
                        <?php for ($i=1;$i<=13;$i++): ?>
                          <td><?= esc(ucfirst($hasil['atribut']["C$i"] ?? '-')) ?></td>
                        <?php endfor; ?>
                      </tr>
                      <tr>
                        <td><strong>Bobot</strong></td>
                        <?php for ($i=1;$i<=13;$i++): ?>
                          <td><?= esc(fmt_excel($hasil['bobot']["C$i"])) ?></td>
                        <?php endfor; ?>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- Matriks Normalisasi -->
                <h5>Matriks Normalisasi (R)</h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-custom">
                    <thead>
                      <tr><th>Alternatif</th><?php for ($i=1;$i<=13;$i++):?><th>C<?= $i ?></th><?php endfor;?></tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($hasil['pembagi'])): ?>
                        <tr style="background-color:#fef3c7; font-weight:bold;">
                          <td>Pembagi</td>
                          <?php for ($i = 1; $i <= 13; $i++): ?>
                            <td><?= esc(fmt_excel($hasil['pembagi']["C$i"])) ?></td>
                          <?php endfor; ?>
                        </tr>
                      <?php endif; ?>
                      <?php foreach ($hasil['normalisasi'] as $alt=>$vals): ?>
                        <tr>
                          <td><?= esc($alt) ?></td>
                          <?php for ($i=1;$i<=13;$i++): ?>
                            <td><?= esc(fmt_excel($vals["C$i"])) ?></td>
                          <?php endfor; ?>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

                <!-- Matriks Normalisasi Terbobot -->
                <h5>Matriks Normalisasi Terbobot (Y)</h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-custom">
                    <thead><tr><th>Alternatif</th><?php for ($i=1;$i<=13;$i++):?><th>C<?= $i ?></th><?php endfor;?></tr></thead>
                    <tbody>
                      <?php foreach ($hasil['terbobot'] as $alt=>$vals): ?>
                        <tr>
                          <td><?= esc($alt) ?></td>
                          <?php for ($i=1;$i<=13;$i++): ?>
                            <td><?= esc(fmt_excel($vals["C$i"])) ?></td>
                          <?php endfor; ?>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

                <!-- Solusi Ideal -->
                <h5>Solusi Ideal Positif (A+) & Negatif (A-)</h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-custom">
                    <thead><tr><th>Kriteria</th><th>Ideal +</th><th>Ideal -</th></tr></thead>
                    <tbody>
                      <?php for ($i=1;$i<=13;$i++): ?>
                        <tr>
                          <td>C<?= $i ?></td>
                          <td><?= esc(fmt_excel($hasil['idealPositif']["C$i"])) ?></td>
                          <td><?= esc(fmt_excel($hasil['idealNegatif']["C$i"])) ?></td>
                        </tr>
                      <?php endfor; ?>
                    </tbody>
                  </table>
                </div>

                <!-- Jarak ke Solusi Ideal -->
                <h5>Jarak ke Solusi Ideal (D⁺ dan D⁻)</h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-sm table-custom">
                    <thead><tr><th>Alternatif</th><th>D⁺</th><th>D⁻</th></tr></thead>
                    <tbody>
                      <?php foreach ($hasil['jarakPositif'] as $alt=>$val): ?>
                        <tr>
                          <td><?= esc($alt) ?></td>
                          <td><?= esc(fmt_excel($val)) ?></td>
                          <td><?= esc(fmt_excel($hasil['jarakNegatif'][$alt])) ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

                <!-- Nilai Preferensi -->
                <h5>Nilai Preferensi & Ranking Akhir</h5>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped table-sm table-custom">
                    <thead><tr><th>Ranking</th><th>Alternatif</th><th>Nilai Preferensi (V)</th></tr></thead>
                    <tbody>
                      <?php $rank=1; foreach ($hasil['preferensi'] as $alt=>$val): ?>
                        <tr>
                          <td><?= $rank++ ?></td>
                          <td><?= esc($alt) ?></td>
                          <td><?= esc(fmt_excel($val)) ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
    $(function(){
      $('#roles').select2({ placeholder:'Pilih role...', allowClear:true });
      $('#players').select2({ placeholder:'Pilih pemain...', allowClear:true });
    });
  </script>
</body>
</html>
