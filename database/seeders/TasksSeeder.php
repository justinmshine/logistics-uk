<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tasks')->insert([
            [ 
                'name' => 'Coding',
                'description' => 'Create a new feature in the codebase.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2022-01-01 10:05:00')
            ], 
            [
                'name' => 'Debugging',
                'description' => 'Be sure to check the logs for errors. They can provide valuable insights.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2022-01-02 11:10:00')
            ],
            [
                'name' => 'Testing',
                'description' => 'Fix any issues found during testing.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2022-01-02 11:10:00')
            ], 
            [
                'name' => 'Deployment',
                'description' => 'Deploy the code to production after successful testing.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', '2022-01-02 11:10:00')
            ]
        ]);
    }
}
