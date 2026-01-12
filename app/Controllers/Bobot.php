<?php

namespace App\Controllers;

use App\Models\BobotModel;
use App\Models\KriteriaModel;
use App\Models\RoleModel;

class Bobot extends BaseController
{
    protected $bobotModel;
    protected $kriteriaModel;
    protected $roleModel;

    public function __construct()
    {
        $this->bobotModel   = new BobotModel();
        $this->kriteriaModel = new KriteriaModel();
        $this->roleModel     = new RoleModel();
    }

    public function index()
    {
        // Ambil semua kriteria & role
        $data['kriteria'] = $this->kriteriaModel->orderBy('id_kriteria', 'ASC')->findAll();
        $data['roles']    = $this->roleModel->findAll();

        // Ambil skor, bobot, atribut yang sudah tersimpan
        $bobot      = $this->bobotModel->findAll();
        $skorMap    = [];
        $bobotMap   = [];
        $atributMap = [];

        foreach ($bobot as $b) {
            $key = $b['id_role'] . '_' . $b['id_kriteria'];
            $skorMap[$key]    = $b['skor'];
            $bobotMap[$key]   = $b['bobot'];
            $atributMap[$key] = $b['atribut'];
        }

        $data['skorMap']    = $skorMap;
        $data['bobotMap']   = $bobotMap;
        $data['atributMap'] = $atributMap;

        return view('bobot/index', $data);
    }

    public function update()
    {
        $postData = $this->request->getPost();

        // 1. Hitung total skor per role
        $roleTotals = [];
        foreach ($postData as $key => $value) {
            if (strpos($key, 'skor_') === 0) {
                $parts   = explode('_', $key); // skor_{id_role}_{id_kriteria}
                $id_role = $parts[1];
                $roleTotals[$id_role] = ($roleTotals[$id_role] ?? 0) + (float)$value;
            }
        }

        // 2. Update skor, bobot, atribut per kriteria per role
        foreach ($postData as $key => $value) {
            if (strpos($key, 'skor_') === 0) {
                $parts       = explode('_', $key);
                $id_role     = $parts[1];
                $id_kriteria = $parts[2];
                $skor        = max(0, (float)$value);

                $totalSkor = $roleTotals[$id_role] ?? 0;
                $bobot     = $totalSkor > 0 ? $skor / $totalSkor : 0;

                $atributKey = 'atribut_' . $id_role . '_' . $id_kriteria;
                $atribut    = $postData[$atributKey] ?? 'Benefit';

                // Update ke database
                $this->bobotModel->where('id_role', $id_role)
                                 ->where('id_kriteria', $id_kriteria)
                                 ->set([
                                     'skor'    => $skor,
                                     'bobot'   => $bobot,
                                     'atribut' => $atribut,
                                 ])->update();
            }
        }

        return redirect()->to('/bobot')->with('success', 'Skor dan bobot berhasil diperbarui!');
    }
}
