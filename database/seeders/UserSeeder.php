<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {

             User::create([
                 'name' => 'ryan',
                 'username' => 'santo',// Pastikan username unik
                 'password' => bcrypt('victor123'),
                 'provinsi' => 'Jakarta utara',
                 'kota' => 'Gunungsitoli',
                 'alamat' => 'Jakarta Barat',
                 'phone' => '0857654321',
                 'email' => 'vicmend2@gmail.com',
                 'date_of_birth' => '1990-03-25',
                 'token' => 'tes'
             ]);

             User::create([
                 'name' => 'Wardi',
                 'username' => 'Los',
                 'password' => bcrypt('bruitjak2'),
                 'provinsi' => 'jawa utara',
                 'kota' => 'jogyakarta',
                 'alamat' => 'wonososbo',
                 'phone' => '09032898322',
                 'email' => 'vicmend3@gmail.com',
                 'date_of_birth' => '2000-03-29',
                 'token' => 'tes2'
             ]);
        }
}
