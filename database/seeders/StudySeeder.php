<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Study;

class StudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Study::factory()->count(10)->create();
    }
}
