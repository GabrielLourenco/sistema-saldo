<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'  => 'Gabriel Lourenço',
            'email' => 'gaabriiel.xd@gmail.com',
            'password' => bcrypt('123456'),
        ]);
    }
}
