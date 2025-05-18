<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name'=> 'admin']);
        $role2 = Role::create(['name'=> 'freelance']);
        Permission::create(['name'=> 'admin.posts.create']);
        Permission::create(['name'=> 'admin.posts.destroy']);
        Permission::create(['name'=> 'admin.posts.edit']);

    }
}
