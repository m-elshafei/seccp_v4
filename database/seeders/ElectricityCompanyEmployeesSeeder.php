<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ElectricityCompanyEmployees;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ElectricityCompanyEmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $electricityCompanyEmployees = config($initiationDataPath.'.electricityCompanyEmployees');
        foreach ($electricityCompanyEmployees as $electricityCompanyEmployee) {
            $electricityDepartmentData = ElectricityCompanyEmployees::create([
                'name' => $electricityCompanyEmployee['name'] ,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

        }
    }
}
