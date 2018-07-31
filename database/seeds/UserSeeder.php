<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'manager']);
        Role::create(['name' => 'employee']);

        $user = User::create([
                'name' => 'Manager', 'email' => 'dlindeboom19@outlook.com', 'password' => bcrypt('password')
            ]);

        $user->assignRole('manager');
    }
}
