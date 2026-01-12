<?php
// app/Controllers/Dashboard.php
namespace App\Controllers;

use App\Models\NilaiScrimModel;
use App\Models\ScrimModel;
use App\Models\PemainModel;
use App\Models\HeroPoolModel;
use App\Models\KriteriaModel;
use App\Models\RoleModel;
use App\Models\BobotModel;

class Dashboard extends BaseController
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

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $selectedRole = $this->request->getGet('role') ?? 'all';

        $roles = $this->roleModel->findAll();

        // Get total players per role
        $totalPlayersPerRole = [];
        foreach ($roles as $role) {
            $count = $this->pemainModel->where('id_role', $role['id_role'])->countAllResults();
            $totalPlayersPerRole[$role['role']] = $count;
        }

        // Get total scrim count per role
        $totalScrimsPerRole = [];
        foreach ($roles as $role) {
            $count = $this->scrimModel->join('pemain', 'pemain.id_mlbb = scrim.id_mlbb')
                                      ->where('pemain.id_role', $role['id_role'])
                                      ->countAllResults();
            $totalScrimsPerRole[$role['role']] = $count;
        }


        $data = [
            'roles' => $roles,
            'selectedRole' => $selectedRole,
            'totalPlayersPerRole' => $totalPlayersPerRole,
            'totalScrimsPerRole' => $totalScrimsPerRole,
        ];

        return view('dashboard/index', $data);
    }
}
