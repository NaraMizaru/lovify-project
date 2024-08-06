<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'fullname' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'number_phone' => '081234567890',
            'role' => 'admin',
        ]);

        User::create([
            'fullname' => 'client',
            'username' => 'client',
            'email' => 'client@gmail.com',
            'password' => bcrypt('client'),
            'number_phone' => '081234567890',
            'role' => 'client',
        ]);

        Category::create([
            'name' => 'venue'
        ]);

        Category::create([
            'name' => 'catering'
        ]);

        Category::create([
            'name' => 'mua'
        ]);

        Category::create([
            'name' => 'decoration'
        ]);

        Category::create([
            'name' => 'photographer'
        ]);

        Vendor::create([
            'name' => 'Vendor Random',
            'description' => 'Deskripsi Vendor Random',
            'price' => 1000000,
            'fee' => 50000,
            'total_price' => 1050000,
            'address' => 'Alamat Vendor Random',
            'total_guest' => 50,
            'qty' => 10,
            'number_phone' => '081234567890',
            'bank_number' => '1234567890',
            'category_id' => 1,
        ]);

        Vendor::create([
            'name' => 'Vendor Random',
            'description' => 'Deskripsi Vendor Random',
            'price' => 1000000,
            'fee' => 50000,
            'total_price' => 1050000,
            'address' => 'Alamat Vendor Random',
            'total_guest' => 50,
            'qty' => 10,
            'number_phone' => '081234567890',
            'bank_number' => '1234567890',
            'category_id' => 1,
        ]);
        
        Vendor::create([
            'name' => 'Vendor Random',
            'description' => 'Deskripsi Vendor Random',
            'price' => 1000000,
            'fee' => 50000,
            'total_price' => 1050000,
            'address' => 'Alamat Vendor Random',
            'total_guest' => 50,
            'qty' => 10,
            'number_phone' => '081234567890',
            'bank_number' => '1234567890',
            'category_id' => 1,
        ]);
    }
}
