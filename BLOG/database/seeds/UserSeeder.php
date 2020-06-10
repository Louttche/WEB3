<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new App\User([
            'name' => 'Let Go',
            'email' =>'Kong@King.com',
            'profile_image' => '',
            'password' => '$2y$10$ozxPFWsnKnkzsPPpFAZrKu5JCHoHITG1btvlbPm/vAF/Pz3QJfth.']);
        $user->save();
    }
}