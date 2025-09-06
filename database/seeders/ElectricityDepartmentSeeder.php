<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\ElectricityDepartment;

class ElectricityDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $electricityDepartments = config('initiation-data.electricityDepartments');

        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $electricityDepartments = config($initiationDataPath.'.electricityDepartments');
        //
        foreach ($electricityDepartments as $electricityDepartment) {
            $electricityDepartmentData = ElectricityDepartment::create([
                'name' => $electricityDepartment['name'] ,
                'description' => $electricityDepartment['description'] ,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

        }
    }
}
