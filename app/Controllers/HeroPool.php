<?php

namespace App\Controllers;

use App\Models\HeroPoolModel;
use App\Models\PemainModel;
use App\Models\RoleModel;
use CodeIgniter\Controller;

class HeroPool extends Controller
{
    protected $heroPoolModel;
    protected $pemainModel;
    protected $roleModel;

    public function __construct()
    {
        $this->heroPoolModel = new HeroPoolModel();
        $this->pemainModel = new PemainModel();
        $this->roleModel = new RoleModel();
    }

    public function index($id_mlbb)
    {
        $data['pemain'] = $this->pemainModel->find($id_mlbb);
        $data['roles'] = $this->roleModel->findAll();
        $data['heropool'] = $this->heroPoolModel->where('id_mlbb', $id_mlbb)->findAll();
        return view('heropool/index', $data);
    }

    public function edit($id_mlbb)
    {
        $pemain = $this->pemainModel->find($id_mlbb);
        if (!$pemain) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Pemain tidak ditemukan");
        }

        // Semua hero yang tersedia, dikelompokkan per role
        $allHeroes = [
            'Tank' => ['Akai', 'Atlas', 'Baxia', 'Belerick', 'Chip', 'Franco', 'Fredrinn', 'Gatotkaca', 'Gloo', 'Grock', 'Hilda', 'Johnson', 'Khufra', 'Lolita', 'Minotaur', 'Tigreal', 'Uranus'],
            'Fighter' => ['Aldous', 'Alpha', 'Arlott', 'Aulus', 'Badang', 'Balmond', 'Barats', 'Bane', 'Cici', 'Chou', 'Dyrroth', 'Freya', 'Guinevere', 'Jawhead', 'Julian', 'Kaja', 'Khaleed', 'Lapu-Lapu', 'Leomord', 'Martis', 'Masha', 'Minsitthar', 'Paquito', 'Phoveus', 'Roger', 'Ruby', 'Silvanna', 'Sun', 'Terizla', 'Thamuz', 'X.Borg', 'Yin', 'Yu Zhong', 'Zilong'],
            'Assassin' => ['Aamon', 'Alucard', 'Fanny', 'Gusion', 'Hanzo', 'Hayabusa', 'Helcurt', 'Karina', 'Lancelot', 'Ling', 'Natalia', 'Saber', 'Nolan'],
            'Mage' => ['Alice', 'Aurora', 'Cecilion', 'Chang\'e', 'Cyclops', 'Eudora', 'Esmeralda', 'Gord', 'Harith', 'Harley', 'Kagura', 'Kadita', 'Lylia', 'Luo Yi', 'Lunox', 'Novaria', 'Odette', 'Pharsa', 'Valentina', 'Vale', 'Vexana', 'Xavier', 'Yve', 'Zhask', 'Zhuxin', 'Zetian', 'Valir'],
            'Marksman' => ['Beatrix', 'Brody', 'Bruno', 'Claude', 'Clint', 'Granger', 'Hanabi', 'Irithel', 'Karrie', 'Layla', 'Lesley', 'Miya', 'Moskov', 'Natan', 'Popol dan Kupa', 'Wanwan', 'Obsidia'],
            'Support' => ['Angela', 'Carmilla', 'Diggie', 'Estes', 'Floryn', 'Kalea', 'Rafaela']
        ];

        // Hero pool pemain yang sudah ada
        $existingHeroes = $this->heroPoolModel
            ->where('id_mlbb', $id_mlbb)
            ->findColumn('hero'); // ambil array nama hero saja

        $data = [
            'pemain' => $pemain,
            'roles' => $this->roleModel->findAll(),
            'allHeroes' => $allHeroes,
            'existingHeroes' => $existingHeroes ?? []
        ];

        return view('heropool/edit', $data);
    }

    public function update($id_mlbb)
    {
        $selectedHeroes = $this->request->getPost('heroes') ?? [];

        // Hapus semua hero pool lama
        $this->heroPoolModel->where('id_mlbb', $id_mlbb)->delete();

        // Masukkan yang baru jika ada
        if (!empty($selectedHeroes)) {
            foreach ($selectedHeroes as $hero) {
                $this->heroPoolModel->insert([
                    'id_mlbb' => $id_mlbb,
                    'hero' => $hero
                ]);
            }
        }

        return redirect()->to("/heropool/index/$id_mlbb")
                        ->with('success', 'Hero Pool berhasil diperbarui!');
    }

}
