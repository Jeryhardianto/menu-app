<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authorities = config('permission.authorities');
        // dd($authorities);
        $listPermissions = []; 
        $superAdminPermissions = []; 
        $kasirPermissions = [];
        $kitchenPermissions = []; 
        $pelangganPermissions = [];

        foreach($authorities as $label => $permissions){
            foreach($permissions as $permission){
                $listPermissions[] = [
                    'name' => $permission,
                    'guard_name' => 'web',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
          

            // Super Admin
            $superAdminPermissions[] = $permission;

            // kasir
            if(in_array($label, ['manage_posts', 'manage_categories', 'manage_tags'])){
                $kasirPermissions[] = $permission;
            }
            // Kitchen
            if(in_array($label, ['manage_posts'])){
                $kitchenPermissions[] = $permission;
            }

            // Pelanggan
            if(in_array($label, ['manage_posts'])){
               $pelangganPermissions[] = $permission;
             }
         }
        }
        // dd('Admin',$adminPermissions);
        // dd('Editor',$editor);
        // Insert permissions
        Permission::insert($listPermissions);
        // Insert Role

        // Super Admin
        $superAdmin = Role::create([      
            'name' => 'SuperAdmin',
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')]);

         // Kasir
         $kasir = Role::create([      
            'name' => 'Kasir',
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')]);

        //  Kitchen
        $kitchen = Role::create([      
            'name' => 'Kitchen',
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')]);
        
        //  Pelangan
        $pelanggan = Role::create([      
            'name' => 'Pelanggan',
            'guard_name' => 'web',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')]);

        // Role -> permissions / Memberikan permissions
        $superAdmin->givePermissionTo($superAdminPermissions);
        $kasir->givePermissionTo($kasirPermissions);
        $kitchen->givePermissionTo($kitchenPermissions);
        $pelanggan->givePermissionTo($pelangganPermissions);
    
         User::find(1)->assignRole('SuperAdmin');
         User::find(1)->assignRole('Kasir');
         User::find(1)->assignRole('Kitchen');
         User::find(1)->assignRole('Pelanggan');
    }
}
