<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // Get projects
        $project1 = Project::where('title', 'like', '%devtrack%')->first();
        $project2 = Project::where('title', 'like', '%e-commerce%')->first();

        // Get users
        $dev1 = User::where('email', 'khalid@gmail.com')->first();
        $dev2 = User::where('email', 'youssef@gmail.com')->first();
        $dev3 = User::where('email', 'abderrahman@gmail.com')->first();

        // Tasks for Project 1 (DevTrack MVP)
        Task::create([
            'title' => 'Setup Laravel with Breeze',
            'description' => 'Install Laravel, Breeze authentication, and configure database.',
            'deadline' => now()->addDays(1)->toDateString(), // URGENT (within 48h)
            'priority' => 'high',
            'status' => 'done',
            'project_id' => $project1->id,
            'assigned_to' => $dev1->id,
        ]);

        Task::create([
            'title' => 'Create Migrations',
            'description' => 'Create migrations for projects, project_user pivot, and tasks tables.',
            'deadline' => now()->addDays(2)->toDateString(), // URGENT (within 48h)
            'priority' => 'high',
            'status' => 'in_progress',
            'project_id' => $project1->id,
            'assigned_to' => $dev1->id,
        ]);

        Task::create([
            'title' => 'Implement ProjectPolicy',
            'description' => 'Create authorization rules for lead vs developer roles.',
            'deadline' => now()->addDays(5)->toDateString(), // SOON
            'priority' => 'medium',
            'status' => 'todo',
            'project_id' => $project1->id,
            'assigned_to' => $dev2->id,
        ]);

        Task::create([
            'title' => 'Build Task API Endpoint',
            'description' => 'Create GET /api/projects/{project}/tasks endpoint with TaskResource.',
            'deadline' => now()->addDays(7)->toDateString(), // ON TRACK
            'priority' => 'low',
            'status' => 'todo',
            'project_id' => $project1->id,
            'assigned_to' => $dev2->id,
        ]);

        // Tasks for Project 2 (E-commerce)
        Task::create([
            'title' => 'Design Database Schema',
            'description' => 'Create ERD for products, orders, customers, and payments.',
            'deadline' => now()->addDays(3)->toDateString(),
            'priority' => 'high',
            'status' => 'in_progress',
            'project_id' => $project2->id,
            'assigned_to' => $dev2->id,
        ]);

        Task::create([
            'title' => 'Integrate Payment Gateway',
            'description' => 'Setup Stripe/PayPal integration for checkout.',
            'deadline' => now()->addDays(15)->toDateString(),
            'priority' => 'medium',
            'status' => 'todo',
            'project_id' => $project2->id,
            'assigned_to' => $dev3->id,
        ]);
    }
}