<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\RoleUser;
use Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $user = new User;
        $user->name = "SuperAdmin";
        $user->email = "superadmin@test.com";
        $user->password = Hash::make('superadmin123!'); 
        $user->save();

        $user->assignRole('SuperAdmin');

        $user = new User;
        $user->name = "Superior";
        $user->email = "superior@test.com";
        $user->password = Hash::make('superior321!'); 
        $user->save();

        $user->assignRole('Superior');
        
        $user = new User;
        $user->name = "Staff";
        $user->email = "staff@test.com";
        $user->password = Hash::make('staff321!'); 
        $user->save();

        $user->assignRole('Staff');
    }
}
