<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_types')->insert([
            [
                'name' => 'Software Developer',
                'description' => 'Roles related to coding and development',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Quality Assurance',
                'description' => 'Testing and validation roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Project Management',
                'description' => 'Roles responsible for project delivery and team coordination',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'UI/UX Design',
                'description' => 'Design-focused roles for user experience and interface',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'DevOps',
                'description' => 'Infrastructure and deployment automation roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Architecture',
                'description' => 'High-level technical planning and systems architecture',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Consulting',
                'description' => 'Client-facing and advisory roles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Administration',
                'description' => 'Administrative roles including system and office administration',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
