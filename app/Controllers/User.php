<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class User extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('user/index', $data);
    }

    public function create()
    {
        // Only allow user with id=1 to create
        if (session()->get('id') != 1) {
            return redirect()->to('/user')->with('error', 'Anda tidak memiliki akses untuk menambah user.');
        }
        return view('user/create');
    }

    public function store()
    {
        // Only allow user with id=1 to create
        if (session()->get('id') != 1) {
            return redirect()->to('/user')->with('error', 'Anda tidak memiliki akses untuk menambah user.');
        }

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $existing = $this->userModel->where('name', $name)->orWhere('email', $email)->first();
        if ($existing) {
            session()->setFlashdata('error', 'Username atau Email sudah digunakan!');
            return redirect()->back()->withInput();
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];

        $this->userModel->save($data);
        return redirect()->to('/user');
    }

    public function edit($id)
    {
        $currentUserId = session()->get('id');

        // Only allow user with id=1 to edit others, or users editing themselves
        if ($currentUserId != 1 && $currentUserId != $id) {
            return redirect()->to('/user')->with('error', 'Anda hanya dapat mengedit akun Anda sendiri.');
        }

        $data['user'] = $this->userModel->find($id);
        if (!$data['user']) {
            return redirect()->to('/user')->with('error', 'User tidak ditemukan.');
        }

        return view('user/edit', $data);
    }

    public function update($id)
    {
        $currentUserId = session()->get('id');

        // Only allow user with id=1 to update others, or users updating themselves
        if ($currentUserId != 1 && $currentUserId != $id) {
            return redirect()->to('/user')->with('error', 'Anda hanya dapat mengupdate akun Anda sendiri.');
        }

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Cek nama atau email sudah ada selain user ini
        $existing = $this->userModel
            ->where('(name = "' . $name . '" OR email = "' . $email . '")')
            ->where('id !=', $id)
            ->first();

        if ($existing) {
            session()->setFlashdata('error', 'Username atau Email sudah digunakan oleh user lain!');
            return redirect()->back()->withInput();
        }

        $data = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->save($data);
        return redirect()->to('/user');
    }

    public function delete($id)
    {
        // Only allow user with id=1 to delete, and prevent deleting user id=1
        if (session()->get('id') != 1) {
            return redirect()->to('/user')->with('error', 'Anda tidak memiliki akses untuk menghapus user.');
        }

        if ($id == 1 || $id == '1') {
            return redirect()->to('/user')->with('error', 'User dengan ID 1 tidak dapat dihapus.');
        }

        $this->userModel->delete($id);
        return redirect()->to('/user');
    }
}
