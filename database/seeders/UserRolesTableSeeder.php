<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::table('users')->pluck('id')->toArray();
        $roles = DB::table('roles')->pluck('id')->toArray();

        $userRoles = [];

        foreach ($users as $userId) {
            // Assign 1 role secara random ke setiap user
            $roleId = $roles[array_rand($roles)];
            $userRoles[] = [
                'user_id' => $userId,
                'role_id' => $roleId,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('user_roles')->insert($userRoles);
    }
}
