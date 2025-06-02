<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua role_type dengan key nama sebagai indeksnya
        $roleTypes = DB::table('role_types')->pluck('id', 'name');

        DB::table('roles')->insert([
            // Software Developer
            [
                'name' => 'Java Developer',
                'role_type_id' => $roleTypes['Software Developer'],
                'description' => 'Develops backend applications primarily using Java.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PHP Developer',
                'role_type_id' => $roleTypes['Software Developer'],
                'description' => 'Specializes in PHP backend development.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Frontend Developer',
                'role_type_id' => $roleTypes['Software Developer'],
                'description' => 'Develops client-side interfaces with React, Vue, or Angular.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fullstack Developer',
                'role_type_id' => $roleTypes['Software Developer'],
                'description' => 'Handles both frontend and backend development tasks.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mobile Developer',
                'role_type_id' => $roleTypes['Software Developer'],
                'description' => 'Builds mobile apps for iOS and Android platforms.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Quality Assurance
            [
                'name' => 'Manual QA Engineer',
                'role_type_id' => $roleTypes['Quality Assurance'],
                'description' => 'Conducts manual testing to identify bugs and issues.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Automation QA Engineer',
                'role_type_id' => $roleTypes['Quality Assurance'],
                'description' => 'Creates automated tests to ensure software quality.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Project Management
            [
                'name' => 'Project Manager',
                'role_type_id' => $roleTypes['Project Management'],
                'description' => 'Leads projects and manages timelines, scope, and resources.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Scrum Master',
                'role_type_id' => $roleTypes['Project Management'],
                'description' => 'Facilitates Scrum ceremonies and team coordination.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // UI/UX Design
            [
                'name' => 'UI Designer',
                'role_type_id' => $roleTypes['UI/UX Design'],
                'description' => 'Designs user interface layouts and graphics.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'UX Designer',
                'role_type_id' => $roleTypes['UI/UX Design'],
                'description' => 'Focuses on user experience and usability improvements.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // DevOps
            [
                'name' => 'DevOps Engineer',
                'role_type_id' => $roleTypes['DevOps'],
                'description' => 'Manages deployment pipelines and cloud infrastructure.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cloud Engineer',
                'role_type_id' => $roleTypes['DevOps'],
                'description' => 'Specializes in AWS, Azure, or Google Cloud platform management.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Architecture
            [
                'name' => 'Software Architect',
                'role_type_id' => $roleTypes['Architecture'],
                'description' => 'Designs overall software system structure and frameworks.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Solution Architect',
                'role_type_id' => $roleTypes['Architecture'],
                'description' => 'Creates technical solutions based on business requirements.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Consulting
            [
                'name' => 'IT Consultant',
                'role_type_id' => $roleTypes['Consulting'],
                'description' => 'Advises clients on IT strategy and implementation.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Business Analyst',
                'role_type_id' => $roleTypes['Consulting'],
                'description' => 'Analyzes business needs and translates them into technical requirements.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Administration
            [
                'name' => 'System Administrator',
                'role_type_id' => $roleTypes['Administration'],
                'description' => 'Maintains servers, networks, and IT infrastructure.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'HR Administrator',
                'role_type_id' => $roleTypes['Administration'],
                'description' => 'Handles human resources and employee relations.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Office Administrator',
                'role_type_id' => $roleTypes['Administration'],
                'description' => 'Manages office operations and support tasks.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
