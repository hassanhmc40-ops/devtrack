<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Get users
        $lead = User::where('email', 'hassan@gmail.com')->first();
        $dev1 = User::where('email', 'khalid@gmail.com')->first();
        $dev2 = User::where('email', 'youssef@gmail.com')->first();
        $dev3 = User::where('email', 'abderrahman@gmail.com')->first();

        // Project 1: DevTrack MVP
        $project1 = Project::create([
            'title' => 'devtrack mvp', // Will be auto-formatted to "Devtrack mvp" by mutator
            'description' => 'A simple project and task management tool for development teams.',
            'deadline' => now()->addDays(14)->toDateString(),
        ]);

        // Attach members to project (pivot table: project_user)
        $project1->users()->attach([
            $lead->id => ['role' => 'lead'],
            $dev1->id => ['role' => 'developer'],
            $dev2->id => ['role' => 'developer'],
        ]);

        // Project 2: E-commerce Website
        $project2 = Project::create([
            'title' => 'e-commerce website',
            'description' => 'Build an online store with payment integration.',
            'deadline' => now()->addDays(30)->toDateString(),
        ]);

        $project2->users()->attach([
            $lead->id => ['role' => 'lead'],
            $dev2->id => ['role' => 'developer'],
            $dev3->id => ['role' => 'developer'],
        ]);

        // Project 3: Archived Project (soft deleted)
        $project3 = Project::create([
            'title' => 'old mobile app',
            'description' => 'Legacy project that was completed last year.',
            'deadline' => now()->subDays(30)->toDateString(),
        ]);

        $project3->users()->attach([
            $lead->id => ['role' => 'lead'],
            $dev1->id => ['role' => 'developer'],
        ]);

        // Soft delete (archive) project 3
        $project3->delete();
    }
}