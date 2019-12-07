<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'name' => 'Adhitya Irvansyah',
            'email' => 'adhityairvan@yahoo.com',
            'password' => Hash::make('123456'),
            'owner' => true,
        ]);
        User::create([
            'name' => 'Faris',
            'email' => 'faris@yahoo.com',
            'password' => Hash::make('123456'),
            'owner' => false,
        ]);
    }
}
