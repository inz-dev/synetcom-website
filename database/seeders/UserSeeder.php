<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Mockery\Undefined;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $super_admin = User::create([
            'lastname' => 'Webmaster',
            'firstname' => 'Synetcom',
            'sex' => 'M',
            'email' => 'webmaster@synetcom-niger.com',
            'password' => Hash::make('password')
        ]);
        $super_admin_role = Role::firstOrcreate(['name' => 'Super-administrateur']);
        $super_admin_role->givePermissionTo(Permission::where('name', '<>', 'guest')->get());
        $super_admin->assignRole($super_admin_role);
    }
}
