<?php

namespace Database\Seeders;
use App\Models\ProjectStatus;

use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectStatus::create([
            "status_name"=>"Very Late",
            "low_range"=>0,
            "high_range"=>80,
        ]);
        
        ProjectStatus::create([
            "status_name"=>"Behind Schedule",
            "low_range"=>80,
            "high_range"=>100,
        ]);
        
        ProjectStatus::create([
            "status_name"=>"On Schedule",
            "low_range"=>100,
            "high_range"=>500,
        ]);
    }
}
