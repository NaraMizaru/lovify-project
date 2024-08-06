<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorAttachment;
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

        for ($i = 1; $i <= 6; $i++) {
            $price = rand(1000000, 5000000);
            $fee = 0.02 * $price;
            $total_price = $price + $fee;
            Vendor::create([
                'name' => 'Venue ' . $i,
                'description' => 'Deskripsi untuk Venue ' . $i,
                'price' => $price,
                'fee' => $fee,
                'total_price' => $total_price,
                'address' => 'Alamat Venue ' . $i,
                'total_guest' => rand(100, 500),
                'number_phone' => '08' . rand(1000000000, 9999999999),
                'bank_number' => rand(10000000, 99999999),
                'category_id' => 1,
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            $price = rand(1000000, 5000000);
            $fee = 0.02 * $price;
            $total_price = $price + $fee;
            Vendor::create([
                'name' => 'Catering ' . $i,
                'description' => 'Deskripsi untuk Catering ' . $i,
                'price' => $price,
                'fee' => $fee,
                'total_price' => $total_price,
                'qty' => rand(50, 1000),
                'address' => 'Alamat Catering ' . $i,
                'number_phone' => '08' . rand(1000000000, 9999999999),
                'bank_number' => rand(10000000, 99999999),
                'category_id' => 2,
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            $price = rand(1000000, 5000000);
            $fee = 0.02 * $price;
            $total_price = $price + $fee;
            Vendor::create([
                'name' => 'MUA ' . $i,
                'description' => 'Deskripsi untuk MUA ' . $i,
                'price' => $price,
                'fee' => $fee,
                'total_price' => $total_price,
                'address' => 'Alamat MUA ' . $i,
                'number_phone' => '08' . rand(1000000000, 9999999999),
                'bank_number' => rand(10000000, 99999999),
                'category_id' => 3,
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            $price = rand(1000000, 5000000);
            $fee = 0.02 * $price;
            $total_price = $price + $fee;
            Vendor::create([
                'name' => 'Decoration ' . $i,
                'description' => 'Deskripsi untuk Decoration ' . $i,
                'price' => $price,
                'fee' => $fee,
                'total_price' => $total_price,
                'address' => 'Alamat Decoration ' . $i,
                'number_phone' => '08' . rand(1000000000, 9999999999),
                'bank_number' => rand(10000000, 99999999),
                'category_id' => 4,
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            $price = rand(1000000, 5000000);
            $fee = 0.02 * $price;
            $total_price = $price + $fee;
            Vendor::create([
                'name' => 'Photographer ' . $i,
                'description' => 'Deskripsi untuk Photographer ' . $i,
                'price' => $price,
                'fee' => $fee,
                'total_price' => $total_price,
                'address' => 'Alamat Photographer ' . $i,
                'number_phone' => '08' . rand(1000000000, 9999999999),
                'bank_number' => rand(10000000, 99999999),
                'category_id' => 5,
            ]);
        }

        // Venue
        for ($i = 1; $i <= 6; $i++) {
            VendorAttachment::create([
                'vendor_id' => $i,
                'image_path' => "seeder/vendor/venue/image-" . $i . ".jpg",
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            VendorAttachment::create([
                'vendor_id' => $i,
                'image_path' => "seeder/vendor/venue/image-" . ($i + 6) . ".jpg",
            ]);
        }

        // Catering
        for ($i = 1; $i <= 6; $i++) {
            VendorAttachment::create([
                'vendor_id' => $i + 6,
                'image_path' => "seeder/vendor/catering/image-" . $i . ".jpg",
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            VendorAttachment::create([
                'vendor_id' => $i + 6,
                'image_path' => "seeder/vendor/catering/image-" . ($i + 6) . ".jpg",
            ]);
        }

        // MUA
        for ($i = 1; $i <= 6; $i++) {
            VendorAttachment::create([
                'vendor_id' => $i + 12,
                'image_path' => "seeder/vendor/mua/image-" . $i . ".jpg",
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            VendorAttachment::create([
                'vendor_id' => $i + 12,
                'image_path' => "seeder/vendor/mua/image-" . ($i + 6) . ".jpg",
            ]);
        }

        // Decoration
        for ($i = 1; $i <= 6; $i++) {
            VendorAttachment::create([
                'vendor_id' => $i + 18,
                'image_path' => "seeder/vendor/decoration/image-" . $i . ".jpg",
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            VendorAttachment::create([
                'vendor_id' => $i + 18,
                'image_path' => "seeder/vendor/decoration/image-" . ($i + 6) . ".jpg",
            ]);
        }

        // Photographer
        for ($i = 1; $i <= 6; $i++) {
            VendorAttachment::create([
                'vendor_id' => $i + 24,
                'image_path' => "seeder/vendor/photographer/image-" . $i . ".jpg",
            ]);
        }

        for ($i = 1; $i <= 6; $i++) {
            VendorAttachment::create([
                'vendor_id' => $i + 24,
                'image_path' => "seeder/vendor/photographer/image-" . ($i + 6) . ".jpg",
            ]);
        }

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
