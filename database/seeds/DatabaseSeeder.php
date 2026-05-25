<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       
        \DB::table('roles')->insert([
             
                [
                 'name' =>'Admin',
                 'guard_name' => 'web',
             "created_at" => date('Y-m-d H:i:s'),
             "updated_at" => date('Y-m-d H:i:s')
                 ],
                [
                'name' =>'User',
                 'guard_name' => 'web',
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
                ],
            
            ]);
        $user = User::create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('123456789'),
            'isallowed' => '1',
        ]);
        //Give admin role to inserted user
        $role_r = Role::where('id', '=', 1)->firstOrFail();
        $user->assignRole($role_r);
    }
}
