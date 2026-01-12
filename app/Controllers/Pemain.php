<?php

namespace App\Controllers;

use App\Models\PemainModel;
use App\Models\RoleModel;
use App\Models\HeroPoolModel;
use App\Models\ScrimModel;
use App\Models\NilaiScrimModel;
use CodeIgniter\Controller;

class Pemain extends Controller
{
    protected $pemainModel;
    protected $roleModel;
    protected $heroPoolModel;
    protected $scrimModel;
    protected $nilaiScrimModel;

    public function __construct()
    {
        $this->pemainModel = new PemainModel();
        $this->roleModel = new RoleModel();
        $this->heroPoolModel = new HeroPoolModel();
        $this->scrimModel = new ScrimModel();
        $this->nilaiScrimModel = new NilaiScrimModel();
    }

    public function index()
    {
        $pemainList = $this->pemainModel->findAll();
        $roles = $this->roleModel->findAll();

        // Hitung jumlah hero per pemain
        $heroCounts = $this->heroPoolModel
            ->select('id_mlbb, COUNT(*) as total_hero')
            ->groupBy('id_mlbb')
            ->findAll();

        $heroCountMap = [];
        foreach ($heroCounts as $hc) {
            $heroCountMap[$hc['id_mlbb']] = $hc['total_hero'];
        }

        foreach ($pemainList as &$pemain) {
            $pemain['total_hero'] = $heroCountMap[$pemain['id_mlbb']] ?? 0;
        }
        unset($pemain);

        $data['pemain'] = $pemainList;
        $data['roles'] = $roles;
        return view('pemain/index', $data);
    }

    public function create()
    {
        $data['roles'] = $this->roleModel->findAll();
        return view('pemain/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost([
            'id_mlbb',
            'nickname',
            'nama',
            'id_role',
            'rank',
            'winrate',
            'kompetisi_menang'
        ]);

        if (!$this->pemainModel->insert($data)) {
            session()->setFlashdata('error', 'Gagal menyimpan data pemain.');
            return redirect()->back()->withInput();
        }

        return redirect()->to('/pemain');
    }

    public function edit($id_mlbb)
    {
        $data['pemain'] = $this->pemainModel->find($id_mlbb);
        $data['roles'] = $this->roleModel->findAll();
        return view('pemain/edit', $data);
    }

    public function update($id_mlbb)
    {
        $data = $this->request->getPost([
            'nickname',
            'nama',
            'id_role',
            'rank',
            'winrate',
            'kompetisi_menang'
        ]);

        $this->pemainModel->update($id_mlbb, $data);
        return redirect()->to('/pemain');
    }

    public function detail($id_mlbb)
    {
        $data['pemain'] = $this->pemainModel->find($id_mlbb);
        $data['roles'] = $this->roleModel->findAll();
        $data['heropool'] = $this->heroPoolModel->where('id_mlbb', $id_mlbb)->findAll();
        $data['scrim'] = $this->scrimModel->where('id_mlbb', $id_mlbb)->findAll();

        return view('pemain/detail', $data);
    }

    public function delete($id_mlbb)
    {
        // Hapus Hero Pool dulu
        $this->heroPoolModel->where('id_mlbb', $id_mlbb)->delete();

        // Ambil semua scrim milik pemain
        $scrims = $this->scrimModel->where('id_mlbb', $id_mlbb)->findAll();

        // Hapus nilai scrim berdasarkan scrim yang ada
        foreach ($scrims as $scrim) {
            $this->nilaiScrimModel->where('id_scrim', $scrim['id_scrim'])->delete();
        }

        // Hapus scrim
        $this->scrimModel->where('id_mlbb', $id_mlbb)->delete();

        // Hapus pemain terakhir
        $this->pemainModel->delete($id_mlbb);

        return redirect()->to('/pemain')->with('success', 'Pemain berhasil dihapus!');
    }
}
