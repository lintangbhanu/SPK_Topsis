<?php

namespace App\Controllers;

use App\Models\NilaiScrimModel;
use App\Models\ScrimModel;
use App\Models\PemainModel;
use App\Models\HeroPoolModel;
use App\Models\KriteriaModel;
use App\Models\RoleModel;
use App\Models\BobotModel;
use CodeIgniter\Controller;

class Topsis extends Controller
{
    protected $nilaiScrimModel;
    protected $scrimModel;
    protected $pemainModel;
    protected $heroPoolModel;
    protected $kriteriaModel;
    protected $roleModel;
    protected $bobotModel;

    public function __construct()
    {
        $this->nilaiScrimModel = new NilaiScrimModel();
        $this->scrimModel = new ScrimModel();
        $this->pemainModel = new PemainModel();
        $this->heroPoolModel = new HeroPoolModel();
        $this->kriteriaModel = new KriteriaModel();
        $this->roleModel = new RoleModel();
        $this->bobotModel = new BobotModel();
    }

    public function Topsis()
    {
        $selectedRoles = $this->request->getVar('roles') ?? [];
        $selectedPlayers = $this->request->getVar('players') ?? [];

        // --- Ambil pemain berdasarkan filter
        $pemainQuery = $this->pemainModel->builder();
        if (!empty($selectedRoles)) {
            $pemainQuery->whereIn('id_role', $selectedRoles);
        }
        if (!empty($selectedPlayers)) {
            $pemainQuery->whereIn('id_mlbb', $selectedPlayers);
        }
        $pemainList = $pemainQuery->get()->getResultArray();

        $kriteria = $this->kriteriaModel->findAll();
        $dataRataRata = [];

        foreach ($pemainList as $pemain) {
            $id_mlbb = $pemain['id_mlbb'];

            $builderRaw = $this->nilaiScrimModel->builder();
            $builderRaw->select('scrim.id_scrim, scrim.tanggal, id_kriteria, nilai');
            $builderRaw->join('scrim', 'scrim.id_scrim = nilai_scrim.id_scrim');
            $builderRaw->where('scrim.id_mlbb', $id_mlbb);
            $builderRaw->orderBy('scrim.id_scrim', 'ASC');
            $rawNilai = $builderRaw->get()->getResultArray();

            $builder = $this->nilaiScrimModel->builder();
            $builder->select('id_kriteria, AVG(nilai) as rata_nilai');
            $builder->join('scrim', 'scrim.id_scrim = nilai_scrim.id_scrim');
            $builder->where('scrim.id_mlbb', $id_mlbb);
            $builder->groupBy('id_kriteria');
            $avgNilai = $builder->get()->getResultArray();

            $nilaiMap = [];
            foreach ($avgNilai as $row) {
                // Remove rounding to keep full precision
                $nilaiMap[$row['id_kriteria']] = floatval($row['rata_nilai']);
            }

            $c11 = $pemain['winrate'] ?? 0;
            $c12 = $this->heroPoolModel->where('id_mlbb', $id_mlbb)->countAllResults();
            $c13 = $pemain['kompetisi_menang'] ?? 0;

            $dataRataRata[] = [
                'alternatif' => $pemain['nickname'],
                'nama' => $pemain['nama'],
                'id_mlbb' => $id_mlbb,
                'id_role' => $pemain['id_role'],
                'raw' => $rawNilai,
                'C1' => $nilaiMap['C1'] ?? 0,
                'C2' => $nilaiMap['C2'] ?? 0,
                'C3' => $nilaiMap['C3'] ?? 0,
                'C4' => $nilaiMap['C4'] ?? 0,
                'C5' => $nilaiMap['C5'] ?? 0,
                'C6' => $nilaiMap['C6'] ?? 0,
                'C7' => $nilaiMap['C7'] ?? 0,
                'C8' => $nilaiMap['C8'] ?? 0,
                'C9' => $nilaiMap['C9'] ?? 0,
                'C10' => $nilaiMap['C10'] ?? 0,
                'C11' => $c11,
                'C12' => $c12,
                'C13' => $c13,
            ];
        }

        $hasilTopsis = [];

        if (!empty($dataRataRata)) {
            // Group pemain berdasarkan role teks
            $groupedByRole = [];
            foreach ($dataRataRata as $row) {
                $role = $row['id_role'];
                $groupedByRole[$role][] = $row;
            }

            foreach ($groupedByRole as $role => $pemainPerRole) {
                // ambil bobot berdasarkan id_role (teks)
                $bobotData = $this->bobotModel->where('id_role', $role)->orderBy('id_kriteria', 'ASC')->findAll();
                $bobot = [];
                $atribut = [];

                foreach ($bobotData as $b) {
                    $idKriteria = $b['id_kriteria'];
                    $bobot[$idKriteria] = floatval($b['bobot']);
                    $atribut[$idKriteria] = strtolower($b['atribut']);
                }

                // Matriks Keputusan
                $matrix = [];
                foreach ($pemainPerRole as $p) {
                    for ($i = 1; $i <= 13; $i++) {
                        $matrix[$p['alternatif']]["C$i"] = $p["C$i"];
                    }
                }

                // 🔹 Normalisasi + Simpan Pembagi
                $normalisasi = [];
                $pembagiArray = [];
                for ($j = 1; $j <= 13; $j++) {
                    $sumSquares = 0;
                    foreach ($matrix as $row) {
                        $sumSquares += pow($row["C$j"], 2);
                    }
                    $pembagi = sqrt($sumSquares);
                    $pembagiArray["C$j"] = $pembagi; // simpan pembagi

                    foreach ($matrix as $alt => $row) {
                        $normalisasi[$alt]["C$j"] = ($pembagi != 0) ? $row["C$j"] / $pembagi : 0;
                    }
                }

                // Normalisasi Terbobot
                $terbobot = [];
                for ($j = 1; $j <= 13; $j++) {
                    $idKriteria = "C$j";
                    $w = $bobot[$idKriteria] ?? (1 / 13);
                    foreach ($normalisasi as $alt => $row) {
                        $terbobot[$alt][$idKriteria] = $row[$idKriteria] * $w;
                    }
                }

                // Solusi Ideal
                $idealPositif = [];
                $idealNegatif = [];
                for ($j = 1; $j <= 13; $j++) {
                    $idKriteria = "C$j";
                    $values = array_column($terbobot, $idKriteria);
                    if (($atribut[$idKriteria] ?? 'benefit') === 'benefit') {
                        $idealPositif[$idKriteria] = max($values);
                        $idealNegatif[$idKriteria] = min($values);
                    } else {
                        $idealPositif[$idKriteria] = min($values);
                        $idealNegatif[$idKriteria] = max($values);
                    }
                }

                // Jarak ke solusi ideal
                $jarakPositif = [];
                $jarakNegatif = [];
                foreach ($terbobot as $alt => $row) {
                    $sumPlus = $sumMinus = 0;
                    for ($j = 1; $j <= 13; $j++) {
                        $idKriteria = "C$j";
                        $sumPlus += pow($row[$idKriteria] - $idealPositif[$idKriteria], 2);
                        $sumMinus += pow($row[$idKriteria] - $idealNegatif[$idKriteria], 2);
                    }
                    $jarakPositif[$alt] = sqrt($sumPlus);
                    $jarakNegatif[$alt] = sqrt($sumMinus);
                }

                // Nilai preferensi
                $preferensi = [];
                foreach ($terbobot as $alt => $row) {
                    $dPlus = $jarakPositif[$alt];
                    $dMinus = $jarakNegatif[$alt];
                    $val = ($dPlus + $dMinus) > 0 ? $dMinus / ($dPlus + $dMinus) : 0;
                    // Explicit rounding to 9 decimal places to match Excel precision
                    $preferensi[$alt] = round($val, 9);
                }
                arsort($preferensi);

                // Add debug output for intermediate values for comparison
                $debugOutput = [
                    'bobot' => $bobot,
                    'atribut' => $atribut,
                    'matrix' => $matrix,
                    'pembagi' => $pembagiArray,
                    'normalisasi' => $normalisasi,
                    'terbobot' => $terbobot,
                    'idealPositif' => $idealPositif,
                    'idealNegatif' => $idealNegatif,
                    'jarakPositif' => $jarakPositif,
                    'jarakNegatif' => $jarakNegatif,
                    'preferensi' => $preferensi,
                ];

                // Simpan hasil per role
                $hasilTopsis[$role] = $debugOutput;
            }
        }

        $roles = $this->roleModel->findAll();
        $pemainAll = $this->pemainModel->findAll();

        $pemainByRole = [];
        foreach ($pemainAll as $p) {
            $pemainByRole[$p['id_role']][] = $p;
        }

        $data = [
            'rataRata' => $dataRataRata,
            'kriteria' => $kriteria,
            'roles' => $roles,
            'pemainByRole' => $pemainByRole,
            'selectedRoles' => $selectedRoles,
            'selectedPlayers' => $selectedPlayers,
            'hasilTopsis' => $hasilTopsis
        ];

        return view('perhitungan/index', $data);
    }
}
