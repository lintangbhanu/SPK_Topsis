<?php

namespace App\Controllers;

use App\Models\RoleModel;

class TestRole extends BaseController
{
    public function index()
    {
        $roleModel = new RoleModel();
        
        echo "<h1>Test Role CRUD</h1>";
        
        // Test 1: Cek koneksi database
        echo "<h3>1. Test Database Connection</h3>";
        try {
            $db = \Config\Database::connect();
            echo "✅ Database connected<br>";
            echo "Database: " . $db->database . "<br>";
        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }
        
        // Test 2: Cek tabel role ada
        echo "<h3>2. Test Table Exists</h3>";
        try {
            $db = \Config\Database::connect();
            if ($db->tableExists('role')) {
                echo "✅ Table 'role' exists<br>";
            } else {
                echo "❌ Table 'role' NOT exists<br>";
            }
        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }
        
        // Test 3: Ambil semua data role
        echo "<h3>3. Test Get All Roles</h3>";
        try {
            $roles = $roleModel->findAll();
            echo "✅ Found " . count($roles) . " roles<br>";
            echo "<pre>";
            print_r($roles);
            echo "</pre>";
        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }
        
        // Test 4: Insert role baru
        echo "<h3>4. Test Insert Role</h3>";
        try {
            $testData = [
                'id_role' => 'TEST' . time(),
                'role' => 'Test Role ' . date('H:i:s')
            ];
            
            if ($roleModel->insert($testData)) {
                echo "✅ Insert success<br>";
                echo "Data: " . json_encode($testData) . "<br>";
            } else {
                echo "❌ Insert failed<br>";
                echo "Errors: <pre>" . print_r($roleModel->errors(), true) . "</pre>";
            }
        } catch (\Exception $e) {
            echo "❌ Error: " . $e->getMessage() . "<br>";
        }
        
        echo "<br><a href='/role'>Go to Role Management</a>";
    }
}
