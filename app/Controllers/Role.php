<?php

namespace App\Controllers;

use App\Models\RoleModel;

class Role extends BaseController
{
    protected $roleModel;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data['roles'] = $this->roleModel->findAll();
        return view('role/index', $data);
    }

    public function create()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        return view('role/create');
    }

    public function store()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $id_role = $this->request->getPost('id_role');
        $role = $this->request->getPost('role');

        if (empty($id_role) || empty($role)) {
            return redirect()->back()->with('error', 'ID Role dan Nama Role harus diisi');
        }

        if ($this->roleModel->find($id_role)) {
            return redirect()->back()->with('error', 'ID Role sudah ada');
        }

        $this->roleModel->insert([
            'id_role' => $id_role,
            'role' => $role,
        ]);

        return redirect()->to('/role')->with('success', 'Role berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $data['role'] = $this->roleModel->find($id);
        return view('role/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $this->roleModel->update($id, [
            'role' => $this->request->getPost('role'),
        ]);

        return redirect()->to('/role')->with('success', 'Role berhasil diupdate');
    }

    public function delete($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $this->roleModel->delete($id);
        return redirect()->to('/role')->with('success', 'Role berhasil dihapus');
    }
}
