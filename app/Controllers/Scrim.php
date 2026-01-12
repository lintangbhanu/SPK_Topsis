<?php

namespace App\Controllers;

use App\Models\ScrimModel;
use App\Models\NilaiScrimModel;
use App\Models\KriteriaModel;
use App\Models\PemainModel;
use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Scrim extends Controller
{
    protected $scrimModel;
    protected $nilaiScrimModel;
    protected $kriteriaModel;
    protected $pemainModel;

    public function __construct()
    {
        $this->scrimModel      = new ScrimModel();
        $this->nilaiScrimModel = new NilaiScrimModel();
        $this->kriteriaModel   = new KriteriaModel();
        $this->pemainModel     = new PemainModel();
        helper('form');
    }

    public function index()
    {
        // Ambil semua scrim dengan join pemain, urutkan berdasarkan scrim_ke ascending
        $scrims = $this->scrimModel->select('scrim.*, pemain.nickname, pemain.nama')
            ->join('pemain', 'pemain.id_mlbb = scrim.id_mlbb')
            ->orderBy('scrim.scrim_ke', 'ASC')
            ->findAll();

        $data['scrims'] = $scrims;
        return view('scrim/index', $data);
    }

    public function create()
    {
        $data['pemain'] = $this->pemainModel->findAll();
        return view('scrim/create', $data);
    }

    public function detail($id_scrim)
    {
        $scrim = $this->scrimModel->select('scrim.*, pemain.nickname, pemain.nama')
            ->join('pemain', 'pemain.id_mlbb = scrim.id_mlbb')
            ->where('scrim.id_scrim', $id_scrim)
            ->get()->getRowArray();

        if (!$scrim) {
            return redirect()->to('/scrim')->with('error', 'Scrim tidak ditemukan');
        }

        $data['scrim'] = $scrim;
        return view('scrim/detail', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $id_mlbb = $this->request->getPost('id_mlbb');
            $existing = $this->scrimModel->where('id_mlbb', $id_mlbb)->selectMax('scrim_ke')->first();
            $scrim_ke = ($existing['scrim_ke'] ?? 0) + 1;

            $turtle = (int)($this->request->getPost('turtle') ?? 0);
            $lord   = (int)($this->request->getPost('lord') ?? 0);
            $kontrol_objektif = $turtle + $lord;

            $dataScrim = [
                'id_mlbb'         => $id_mlbb,
                'scrim_ke'        => $scrim_ke,
                'tanggal'         => $this->request->getPost('tanggal'),
                'durasi'          => (float)($this->request->getPost('durasi') ?? 0), // menit
                'total_kill'      => (int)($this->request->getPost('total_kill') ?? 0),
                'hero_digunakan'  => $this->request->getPost('hero_digunakan'),
                'jumlah_kill'     => (int)($this->request->getPost('jumlah_kill') ?? 0),
                'jumlah_death'    => (int)($this->request->getPost('jumlah_death') ?? 0),
                'jumlah_assist'   => (int)($this->request->getPost('jumlah_assist') ?? 0),
                'damage_hero'     => (float)($this->request->getPost('damage_hero') ?? 0),
                'damage_turret'   => (float)($this->request->getPost('damage_turret') ?? 0),
                'damage_diterima' => (float)($this->request->getPost('damage_diterima') ?? 0),
                'jumlah_gold'     => (float)($this->request->getPost('jumlah_gold') ?? 0),
                'kontrol_objektif'=> $kontrol_objektif,
                'komunikasi'      => (float)($this->request->getPost('komunikasi') ?? 0), // pastikan input angka
            ];

            $idScrim = $this->scrimModel->insert($dataScrim);
            if (!$idScrim) {
                throw new DatabaseException('Gagal menyimpan data scrim');
            }

            // Hitung nilai untuk setiap kriteria
            $kriteria = $this->kriteriaModel
                ->whereIn('id_kriteria', ['C1','C2','C3','C4','C5','C6','C7','C8','C9','C10'])
                ->findAll();

            foreach ($kriteria as $k) {
                $nilai = $this->calculateNilai($k['id_kriteria'], $dataScrim);
                $this->nilaiScrimModel->insert([
                    'id_scrim'    => $idScrim,
                    'id_kriteria' => $k['id_kriteria'],
                    'nilai'       => $nilai
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new DatabaseException('Transaksi gagal');
            }

            return redirect()->to('/scrim')->with('success', 'Scrim berhasil ditambahkan!');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan scrim: ' . $e->getMessage());
        }
    }

    public function edit($id_scrim)
    {
        $data['scrim']  = $this->scrimModel->find($id_scrim);
        $data['pemain'] = $this->pemainModel->findAll();
        if (!$data['scrim']) {
            return redirect()->to('/scrim')->with('error', 'Scrim tidak ditemukan');
        }
        return view('scrim/edit', $data);
    }

    public function update($id_scrim)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $current = $this->scrimModel->find($id_scrim);
            if (!$current) {
                throw new \Exception("Scrim tidak ditemukan");
            }

            $scrim_ke = $current['scrim_ke']; // tetap gunakan scrim_ke lama

            $turtle = (int)($this->request->getPost('turtle') ?? 0);
            $lord   = (int)($this->request->getPost('lord') ?? 0);
            $kontrol_objektif = $turtle + $lord;

            $dataScrim = [
                'id_mlbb'         => $this->request->getPost('id_mlbb'),
                'scrim_ke'        => $scrim_ke,
                'tanggal'         => $this->request->getPost('tanggal'),
                'durasi'          => (float)($this->request->getPost('durasi') ?? 0),
                'total_kill'      => (int)($this->request->getPost('total_kill') ?? 0),
                'hero_digunakan'  => $this->request->getPost('hero_digunakan'),
                'jumlah_kill'     => (int)($this->request->getPost('jumlah_kill') ?? 0),
                'jumlah_death'    => (int)($this->request->getPost('jumlah_death') ?? 0),
                'jumlah_assist'   => (int)($this->request->getPost('jumlah_assist') ?? 0),
                'damage_hero'     => (float)($this->request->getPost('damage_hero') ?? 0),
                'damage_turret'   => (float)($this->request->getPost('damage_turret') ?? 0),
                'damage_diterima' => (float)($this->request->getPost('damage_diterima') ?? 0),
                'jumlah_gold'     => (float)($this->request->getPost('jumlah_gold') ?? 0),
                'kontrol_objektif'=> $kontrol_objektif,
                'komunikasi'      => (float)($this->request->getPost('komunikasi') ?? 0),
            ];

            $this->scrimModel->update($id_scrim, $dataScrim);

            // Hapus nilai lama
            $this->nilaiScrimModel->where('id_scrim', $id_scrim)->delete();

            // Hitung ulang nilai baru
            $kriteria = $this->kriteriaModel
                ->whereIn('id_kriteria', ['C1','C2','C3','C4','C5','C6','C7','C8','C9','C10'])
                ->findAll();

            foreach ($kriteria as $k) {
                $nilai = $this->calculateNilai($k['id_kriteria'], $dataScrim);
                $this->nilaiScrimModel->insert([
                    'id_scrim'    => $id_scrim,
                    'id_kriteria' => $k['id_kriteria'],
                    'nilai'       => $nilai
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new DatabaseException('Transaksi gagal');
            }

            return redirect()->to('/scrim')->with('success', 'Scrim berhasil diperbarui!');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui scrim: ' . $e->getMessage());
        }
    }

    public function delete($id_scrim)
    {
        // Hapus nilai terkait dulu biar bersih
        $this->nilaiScrimModel->where('id_scrim', $id_scrim)->delete();
        $this->scrimModel->delete($id_scrim);
        return redirect()->to('/scrim')->with('success', 'Scrim berhasil dihapus!');
    }

    private function calculateNilai($id_kriteria, $data)
    {
        $durasi          = (float)($data['durasi'] ?? 0);
        $jumlah_kill     = (float)($data['jumlah_kill'] ?? 0);
        $jumlah_death    = (float)($data['jumlah_death'] ?? 0);
        $jumlah_assist   = (float)($data['jumlah_assist'] ?? 0);
        $total_kill      = (float)($data['total_kill'] ?? 0);
        $damage_hero     = (float)($data['damage_hero'] ?? 0);
        $damage_turret   = (float)($data['damage_turret'] ?? 0);
        $damage_diterima = (float)($data['damage_diterima'] ?? 0);
        $jumlah_gold     = (float)($data['jumlah_gold'] ?? 0);
        $kontrol_objektif= (float)($data['kontrol_objektif'] ?? 0);
        $komunikasi      = (float)($data['komunikasi'] ?? 0);

        switch ($id_kriteria) {
            case 'C1': return $jumlah_kill;
            case 'C2': return $jumlah_death; // cost
            case 'C3': return $jumlah_assist;
            case 'C4': return $durasi > 0 ? ($jumlah_gold / $durasi) : 0;
            case 'C5': return $durasi > 0 ? ($damage_hero / $durasi) : 0;
            case 'C6': return $durasi > 0 ? ($damage_turret / $durasi) : 0;
            case 'C7': return $durasi > 0 ? ($damage_diterima / $durasi) : 0;
            case 'C8': return $total_kill > 0 ? (($jumlah_kill + $jumlah_assist) / $total_kill) : 0;
            case 'C9': return $kontrol_objektif;
            case 'C10': return $komunikasi;
            default: return 0;
        }
    }
}
