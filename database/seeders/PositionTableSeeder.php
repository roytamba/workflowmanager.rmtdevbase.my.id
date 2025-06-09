<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $positions = [
            ['name' => 'CEO', 'description' => 'Chief Executive Officer, leads the company', 'status' => 'active'],
            ['name' => 'CTO', 'description' => 'Chief Technology Officer, leads tech strategy', 'status' => 'active'],
            ['name' => 'Software Architect', 'description' => 'Designs high-level software architecture and technical standards', 'status' => 'active'],
            ['name' => 'HR Manager', 'description' => 'Responsible for human resources tasks', 'status' => 'active'],
            ['name' => 'Project Manager', 'description' => 'Manages project timelines and deliverables', 'status' => 'active'],
            ['name' => 'Software Developer', 'description' => 'Develops and maintains software', 'status' => 'active'],
            ['name' => 'QA Engineer', 'description' => 'Ensures software quality through testing', 'status' => 'active'],
            ['name' => 'UI/UX Designer', 'description' => 'Designs user interfaces and experiences', 'status' => 'active'],
            ['name' => 'Business Analyst', 'description' => 'Analyzes business requirements and workflows', 'status' => 'active'],
            ['name' => 'Consultant', 'description' => 'Provides expert advice to clients', 'status' => 'active'],
            ['name' => 'Sales Executive', 'description' => 'Handles sales and customer relations', 'status' => 'active'],
            ['name' => 'Marketing Specialist', 'description' => 'Plans and executes marketing campaigns', 'status' => 'active'],
            ['name' => 'Admin', 'description' => 'Manages administrative tasks and system configurations', 'status' => 'active'],
            ['name' => 'Intern', 'description' => 'Temporary position for learning', 'status' => 'inactive'],
        ];


        foreach ($positions as $position) {
            DB::table('positions')->insert([
                'name' => $position['name'],
                'description' => $position['description'],
                'status' => $position['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
