<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public $models = [
        'role' => 'un rôle',
        'user' => 'un utilisateur',
        'permission' => 'une permission',
        'management' => 'gestion',

    ];
    public function run(): void
    {

        foreach ($this->models as $k => $v) {
            Permission::create(['name' => $k . '.create', 'description' => 'Peut ajouter ' . $v]);
            Permission::create(['name' => $k . '.read', 'description' => 'Peut voir ' . $v]);
            Permission::create(['name' => $k . '.update', 'description' => 'Peut modifier ' . $v]);
            Permission::create(['name' => $k . '.delete', 'description' => 'Peut supprimer ' . $v]);
        }
        Permission::create(['name' => 'manage_website', 'description' => 'Paramètrage du site vitrine']);
        Permission::create(['name' => 'manage_system', 'description' => 'Paramètre systeme']);

        Permission::create(['name' => 'guest', 'description' => 'Guest Dashbord']);
    }
}
