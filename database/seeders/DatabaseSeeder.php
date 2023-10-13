<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  Faker\Factory as Faker;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create();
        // dd($faker->email);exit;
        \App\Models\Roles::factory()->create([
            'name' => 'Super Admin',
            'role' => '1',
        ]);
        \App\Models\Roles::factory()->create([
            'name' => 'Admin User',
            'role' => '2',
        ]);
        \App\Models\Roles::factory()->create([
            'name' => 'Sales User',
            'role' => '3',
        ]);
        // For  super admin seed
        \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'is_admin' => 1,
            'password' => Hash::make('12345678'),
        ]);

        // for admin user seed
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'is_admin' => 2,
            'password' => Hash::make('12345678'),
        ]);

        // for sales executive
        \App\Models\User::factory()->create([
            'name' => 'Sales Executive',
            'email' => 'sales@gmail.com',
            'is_admin' => 3,
            'password' => Hash::make('12345678'),
        ]);
        $arr = [];
        $total = 29;
        for ($i = 0; $i <= $total; $i++) {
            $name = $faker->name;
            $email = $faker->email;
            if (in_array($email, $arr)) {
                $total += 1;
                continue;
            }
            $arr[] = $email;
            \App\Models\User::factory()->create([
                'name' => $name,
                'email' => $email,
                'is_admin' => 2,
                'password' => Hash::make('12345678'),
            ]);
        }
        $total = 29;
        for ($i = 0; $i <= $total; $i++) {
            $name = $faker->name;
            $email = $faker->email;
            if (in_array($email, $arr)) {
                $total += 1;
                continue;
            }
            $arr[] = $email;
            \App\Models\User::factory()->create([
                'name' => $name,
                'email' => $email,
                'is_admin' => 3,
                'password' => Hash::make('12345678'),
            ]);
        }
        for ($i = 0; $i < 5; $i++) {
            \App\Models\Category::factory()->create([
                'category_name' => 'Category ' . $i+1,
                'category_description' => $faker->sentence(),
            ]);
        }
        for ($i = 0; $i < 100; $i++) {
            \App\Models\Product::factory()->create([
                'product_name' => 'Product ' . $i+1,
                'product_description' => $faker->sentence(),
                'product_price' => (float) rand(100, 1000) / 2,
                'id_category' => rand(1, 5),
                'product_image' => 'prod-' . rand(2, 5) .'.jpg'
            ]);
        }
    }
}
