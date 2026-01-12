<?php

namespace App\Controllers;


class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function prosesLogin()
    {
        $name = $this->request->getPost('name');
        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('name', $name)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                session()->set([
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'logged_in' => true,
                ]);
                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->with('error', 'Password salah!');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak ditemukan!');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
