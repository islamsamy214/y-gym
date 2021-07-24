<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'super_admin',
            'password' =>bcrypt('12345678'),
            'email' => 'super_admin@app.com',
            'email_verified_at' => now(),
        ]);

        $user->attachRole('super_admin');
    }
}
