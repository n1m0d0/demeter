<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name ="admin";
        $user->email = "admin@ajatic.com";
        $user->password = bcrypt("123456789");
        $user->save();
        
        User::factory(10)->create();
    }
}
