<?php

namespace Database\Seeders;

use App\Models\ElectricityCompanyEmployees;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
                'name' => $electricityCompanyEmployee['name'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

        }
    }
}
