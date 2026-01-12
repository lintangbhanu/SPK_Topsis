<?php

namespace App\Controllers;

use App\Models\KriteriaModel;
use App\Models\BobotModel;
use App\Models\RoleModel;
use CodeIgniter\Controller;

class Kriteria extends Controller
{
    protected $kriteriaModel;
    protected $bobotModel;
    protected $roleModel;

    public function __construct()
    {
        $this->kriteriaModel = new KriteriaModel();
        $this->bobotModel = new BobotModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        // Get kriteria ordered by id_kriteria (C1, C2, C3, ...)
        $data['kriteria'] = $this->kriteriaModel->orderBy('id_kriteria', 'ASC')->findAll();
        return view('kriteria/index', $data);
    }

    public function create()
    {
        return view('kriteria/create');
    }

    public function store()
    {
        $kriteria = $this->request->getPost('kriteria');
        $atribut = $this->request->getPost('atribut');

        // Generate next C number by finding the smallest missing number
        $allKriteria = $this->kriteriaModel->orderBy('id_kriteria', 'ASC')->findAll();
        $existingNumbers = [];
        foreach ($allKriteria as $k) {
            $num = (int) substr($k['id_kriteria'], 1);
            $existingNumbers[] = $num;
        }
        sort($existingNumbers);

        $nextNumber = 1;
        foreach ($existingNumbers as $num) {
            if ($num == $nextNumber) {
                $nextNumber++;
            } else {
                break;
            }
        }
        $id_kriteria = 'C' . $nextNumber;

        $data = [
            'id_kriteria' => $id_kriteria,
            'kriteria' => $kriteria,
            'atribut' => $atribut,
        ];

        if (!$this->kriteriaModel->save($data)) {
            session()->setFlashdata('error', 'Gagal menyimpan data kriteria.');
            return redirect()->back()->withInput();
        }

        // Insert bobot rows for each role with default bobot 0 and custom id_bobot
        $roles = $this->roleModel->findAll();
        foreach ($roles as $role) {
            // Generate id_bobot prefix based on role
            $prefixMap = [
                'Goldlaner' => 'GC',
                'Explaner' => 'EC',
                'Midlaner' => 'MC',
                'Roamer' => 'RC',
                'Jungler' => 'JC'
            ];
            $prefix = $prefixMap[$role['role']] ?? 'XX';

            // Find existing bobot with this prefix to determine next number
            $existingBobots = $this->bobotModel->like('id_bobot', $prefix, 'after')->findAll();
            $existingNumbers = [];
            foreach ($existingBobots as $b) {
                $num = (int) substr($b['id_bobot'], strlen($prefix));
                $existingNumbers[] = $num;
            }
            sort($existingNumbers);
            $nextNumber = 1;
            foreach ($existingNumbers as $num) {
                if ($num == $nextNumber) {
                    $nextNumber++;
                } else {
                    break;
                }
            }
            $id_bobot = $prefix . $nextNumber;

            $this->bobotModel->insert([
                'id_bobot' => $id_bobot,
                'id_role' => $role['id_role'],
                'id_kriteria' => $id_kriteria,
                'bobot' => 0
            ]);
        }

        return redirect()->to('/kriteria');
    }

    public function edit($id_kriteria)
    {
        $data['kriteria'] = $this->kriteriaModel->find($id_kriteria);
        return view('kriteria/edit', $data);
    }

    public function update($id_kriteria)
    {
        $kriteria = $this->request->getPost('kriteria');
        $atribut = $this->request->getPost('atribut');

        $data = [
            'kriteria' => $kriteria,
            'atribut' => $atribut,
        ];

        $this->kriteriaModel->update($id_kriteria, $data);
        return redirect()->to('/kriteria');
    }

    public function delete($id_kriteria)
    {
        // Delete bobot rows first
        $this->bobotModel->where('id_kriteria', $id_kriteria)->delete();

        // Then delete kriteria
        $this->kriteriaModel->delete($id_kriteria);
        return redirect()->to('/kriteria');
    }
}
