<?php

namespace Database\Seeders;

use App\Models\Furniture;
use Illuminate\Database\Seeder;

use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        // \App\Models\User::factory(10)->create();

        //membuat sample data dimana ketika melakukan migrate:fresh, data didalam database (yang dijadikan sampel) tidak hilang selama masa produksi

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'is_admin' => "Admin",
            'address' => 'Jakarta',
            'gender' => 'Male'
        ]);

        User::create([
            'name' => 'Rezky',
            'email' => 'tester@gmail.com',
            'password' => bcrypt('Rezky@123'),
            'is_admin' => "Member",
            'address' => 'Bekasi, West Java, Java Island, Indonesia, Earth Milky Way Gateway',
            'gender' => 'Female'
        ]);

        //buat isi sample data furniture

        Furniture::create([
            'name' => 'Antilop',
            'price' => 200000,
            'type' => 'Chair',
            'color' => 'White',
            'image' => 'image-products/antilop.jpg'
        ]);

        Furniture::create([
            'name' => 'Mammut',
            'price' => 85000,
            'type' => 'Chair',
            'color' => 'White',
            'image' => 'image-products/mammut.jpg'
        ]);

        Furniture::create([
            'name' => 'Hemlingby',
            'price' => 1850000,
            'type' => 'Chair',
            'color' => 'Black',
            'image' => 'image-products/hemlingby.jpg'
        ]);

        Furniture::create([
            'name' => 'Teodores',
            'price' => 125000,
            'type' => 'Chair',
            'color' => 'White',
            'image' => 'image-products/teodores.jpg'
        ]);

        Furniture::create([
            'name' => 'Jessheim',
            'price' => 850000,
            'type' => 'Bed',
            'color' => 'Blue',
            'image' => 'image-products/jessheim.jpg'
        ]);
        Furniture::create([
            'name' => 'Grimsbu',
            'price' => 1850000,
            'type' => 'Bed',
            'color' => 'White',
            'image' => 'image-products/grimsbu.jpg'
        ]);
        Furniture::create([
            'name' => 'Knarrevik',
            'price' => 185000,
            'type' => 'Table',
            'color' => 'Black',
            'image' => 'image-products/knarrevik.jpg'
        ]);
        Furniture::create([
            'name' => 'Lack',
            'price' => 145000,
            'type' => 'Table',
            'color' => 'Black',
            'image' => 'image-products/lack.jpg'
        ]);
        Furniture::create([
            'name' => 'Melltorp',
            'price' => 225000,
            'type' => 'Table',
            'color' => 'White',
            'image' => 'image-products/melltorp.jpg'
        ]);
        Furniture::create([
            'name' => 'Vuku',
            'price' => 450000,
            'type' => 'Storage',
            'color' => 'White',
            'image' => 'image-products/vuku.jpg'
        ]);


    }
}
