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
            'name' => 'Jhonathan',
            'email' => 'tester@gmail.com',
            'password' => bcrypt('Jhonathan@123'),
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
            'image' => 'image-products/Y7dSmqQvrCeedeAgHq6RzBEhwM0JYyJimmpCl8sP.png'
        ]);

        Furniture::create([
            'name' => 'Mammut',
            'price' => 85000,
            'type' => 'Chair',
            'color' => 'White',
            'image' => 'image-products/Osqh2lNDuyOWGg13o9zzBGWvIRZEUqUCY45RRtW6.png'
        ]);

        Furniture::create([
            'name' => 'Hemlingby',
            'price' => 1850000,
            'type' => 'Chair',
            'color' => 'Black',
            'image' => 'image-products/5GebR0P0M26rzfLsGCtIl42jWBCsEBUayZmHC6US.png'
        ]);

        Furniture::create([
            'name' => 'Teodores',
            'price' => 125000,
            'type' => 'Chair',
            'color' => 'White',
            'image' => 'image-products/m3RApAj1GAglLknOslyYTxOe6ChBJ4QJDGyFo9q7.png'
        ]);

        Furniture::create([
            'name' => 'Jessheim',
            'price' => 850000,
            'type' => 'Bed',
            'color' => 'Blue',
            'image' => 'image-products/viMnOLq9jBsVq0axR22DItKbkUpW9UPN8euAgvOd.png'
        ]);
        Furniture::create([
            'name' => 'Grimsbu',
            'price' => 1850000,
            'type' => 'Bed',
            'color' => 'White',
            'image' => 'image-products/nT1tPOlDI1S17vy4gFdxYgfF6A0RlAxZJMV3hXPJ.png'
        ]);
        Furniture::create([
            'name' => 'Knarrevik',
            'price' => 185000,
            'type' => 'Table',
            'color' => 'Black',
            'image' => 'image-products/90unHsfhoPwbkG2eNJPgcoKuyQZKOGMeUhEAUuf6.png'
        ]);
        Furniture::create([
            'name' => 'Lack',
            'price' => 145000,
            'type' => 'Table',
            'color' => 'Black',
            'image' => 'image-products/UmqWJM3hnKomlVuFiRFoGvyS8VzefMbThLKwmuEZ.png'
        ]);
        Furniture::create([
            'name' => 'Melltorp',
            'price' => 225000,
            'type' => 'Table',
            'color' => 'White',
            'image' => 'image-products/1WW90HdDUhEPCj0hufHYVStGcGRSez9YRC7TnC9D.png'
        ]);
        Furniture::create([
            'name' => 'Vuku',
            'price' => 450000,
            'type' => 'Storage',
            'color' => 'White',
            'image' => 'image-products/9ccSaNSE6NSXV318tvQuObLqvyN6sTRZWEL4fPMC.png'
        ]);


    }
}
