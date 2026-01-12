<?php

namespace App\Controllers;

use App\Models\NilaiScrimModel;
use App\Models\ScrimModel;
use App\Models\PemainModel;
use App\Models\KriteriaModel;
use CodeIgniter\Controller;

class Nilai extends Controller
{
    protected $nilaiScrimModel;
    protected $scrimModel;
    protected $pemainModel;
    protected $kriteriaModel;

    public function __construct()
    {
        $this->nilaiScrimModel = new NilaiScrimModel();
        $this->scrimModel = new ScrimModel();
        $this->pemainModel = new PemainModel();
        $this->kriteriaModel = new KriteriaModel();
    }

    /**
     * Tampilkan semua nilai scrim per match (detail per scrim).
     */
    public function index()
    {
        $kriteria = $this->kriteriaModel->findAll(); // Ambil semua kriteria dinamis
        $kriteriaList = array_column($kriteria, 'id_kriteria');

        $builder = $this->nilaiScrimModel->builder();
        $builder->select('nilai_scrim.id_scrim, nilai_scrim.id_kriteria, nilai_scrim.nilai, scrim.scrim_ke, scrim.tanggal, pemain.nickname, pemain.nama');
        $builder->join('scrim', 'scrim.id_scrim = nilai_scrim.id_scrim');
        $builder->join('pemain', 'pemain.id_mlbb = scrim.id_mlbb');
        $builder->orderBy('scrim.scrim_ke', 'ASC');
        $rows = $builder->get()->getResultArray();

        // Grouping per scrim
        $nilaiGrouped = [];
        foreach ($rows as $row) {
            $id_scrim = $row['id_scrim'];

            if (!isset($nilaiGrouped[$id_scrim])) {
                $nilaiGrouped[$id_scrim] = [
                    'id_scrim' => $id_scrim,
                    'scrim_ke' => $row['scrim_ke'],
                    'tanggal' => $row['tanggal'],
                    'nickname' => $row['nickname'],
                    'nama' => $row['nama'],
                ];
                foreach ($kriteriaList as $kid) {
                    $nilaiGrouped[$id_scrim][$kid] = null; // default null
                }
            }

            $nilaiGrouped[$id_scrim][$row['id_kriteria']] = $row['nilai'];
        }

        $data['kriteria'] = $kriteria;
        $data['nilaiScrims'] = array_values($nilaiGrouped);

        return view('nilai/index', $data);
    }

    /**
     * Detail nilai per scrim (untuk 1 match).
     */
    public function detail($id_scrim)
    {
        // Ambil data scrim mentah (statistik per pemain)
        $builder = $this->scrimModel->builder();
        $builder->select('scrim.*, pemain.nickname, pemain.nama');
        $builder->join('pemain', 'pemain.id_mlbb = scrim.id_mlbb');
        $builder->where('scrim.id_scrim', $id_scrim);
        $scrim = $builder->get()->getRowArray();

        if (!$scrim) {
            return redirect()->to('/nilai')->with('error', 'Scrim tidak ditemukan');
        }

        // Ambil nilai scrim yang sudah diolah
        $nilaiScrim = $this->nilaiScrimModel->where('id_scrim', $id_scrim)->findAll();
        $nilaiData = [];
        foreach ($nilaiScrim as $nilai) {
            $nilaiData[$nilai['id_kriteria']] = $nilai['nilai'];
        }

        // Ambil kriteria
        $kriteria = $this->kriteriaModel->findAll();

        // ===== Contoh proses olahan langsung (jika mau dihitung tanpa ambil nilai_scrim) =====
        $durasiMenit = max(1, $scrim['durasi'] ?? 1); // asumsi ada kolom durasi di scrim (dalam menit)

        $olahan = [
            'gold_per_minute'     => round(($scrim['jumlah_gold'] ?? 0) / $durasiMenit, 2),
            'hero_damage_per_min' => round(($scrim['damage_hero'] ?? 0) / $durasiMenit, 2),
            'turret_damage_per_min' => round(($scrim['damage_turret'] ?? 0) / $durasiMenit, 2),
            'damage_taken_per_min'  => round(($scrim['damage_diterima'] ?? 0) / $durasiMenit, 2),
            'team_fight'          => ($scrim['jumlah_kill'] + $scrim['jumlah_assist']) . " dari " . ($scrim['total_kill'] ?? 0),
        ];

        $data = [
            'scrim'     => $scrim,       // data mentah
            'nilai'     => $nilaiData,   // data olahan dari tabel nilai_scrim
            'kriteria'  => $kriteria,
            'olahan'    => $olahan,      // hasil perhitungan manual
        ];

        return view('nilai/detail', $data);
    }

}
