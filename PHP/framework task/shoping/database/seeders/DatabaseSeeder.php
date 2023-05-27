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
            'gender' => 'Male'
        ]);

        //buat isi sample data furniture

        Furniture::create([
            'name' => 'Antilop',
            'price' => 200000,
            'type' => 'Chair',
            'color' => 'White',
            'image' => 'image-products/iMPz5rARxqNBVexXsvlCmWUnYg25vtX1P9MwXdZp.png'
        ]);

        Furniture::create([
            'name' => 'Mammut',
            'price' => 85000,
            'type' => 'Chair',
            'color' => 'White',
            'image' => 'image-products/hpCU7NKRtcynF2D3j4voV1DnYLIMeco1PZPk1PGt.png'
        ]);

        Furniture::create([
            'name' => 'Hemlingby',
            'price' => 1850000,
            'type' => 'Chair',
            'color' => 'Black',
            'image' => 'image-products/zY4cXwOp1ZSOtlO3CWx2cIUSbTAzf3R9gO7wQ7tI.png'
        ]);

        Furniture::create([
            'name' => 'Teodores',
            'price' => 125000,
            'type' => 'Chair',
            'color' => 'White',
            'image' => 'image-products/eO3knOPvA3pHON8jgINt8wiBOy17dzxC79R9tiYT.png'
        ]);

        Furniture::create([
            'name' => 'Jessheim',
            'price' => 850000,
            'type' => 'Bed',
            'color' => 'Blue',
            'image' => 'image-products/6w8dMSTXYRFdgd5JV0dsmFyMcBAoxBHEfUG2vpd7.png'
        ]);
        Furniture::create([
            'name' => 'Grimsbu',
            'price' => 1850000,
            'type' => 'Bed',
            'color' => 'White',
            'image' => 'image-products/JiZxBKnwKIBOZm5MYUstnNf8SwW4x1bR46FqHAym.png'
        ]);
        Furniture::create([
            'name' => 'Knarrevik',
            'price' => 185000,
            'type' => 'Table',
            'color' => 'Black',
            'image' => 'image-products/8d9LtBqpJnDbyMbAIyu5HEWfA8YwrGszABEVQt0w.png'
        ]);
        Furniture::create([
            'name' => 'Lack',
            'price' => 145000,
            'type' => 'Table',
            'color' => 'Black',
            'image' => 'image-products/EEcISPtZzqXIciaiCy7TnpuV2SLXdH8lpr9R4MYG.png'
        ]);
        Furniture::create([
            'name' => 'Melltorp',
            'price' => 225000,
            'type' => 'Table',
            'color' => 'White',
            'image' => 'image-products/8QaFPjX7V5cKi5nqke3tmrt5aw6D6zcm8Ma1qz93.png'
        ]);
        Furniture::create([
            'name' => 'Vuku',
            'price' => 450000,
            'type' => 'Storage',
            'color' => 'White',
            'image' => 'image-products/i60HyT36Ue29utZi75CUBES2WMGa0iYugMbwQlGn.png'
        ]);
        
        Furniture::create([
            'name' => 'Hemnes',
            'price' => 5499000,
            'type' => 'Bed',
            'color' => 'White',
            'image' => 'image-products/image-products/1oCYOI0xKclZmbBznf24G4fvFavs3E3vyScumCA5.png'
        ]);


    }
}
