<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $departments = config('initiation-data.departments');

        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $departments = config($initiationDataPath.'.departments');
        //
        foreach ($departments as $department) {
            $departmentData = Department::create([
                'name' => $department['name'] ,
                'branch_id' => $department['branch_id'] ,
                'description' => $department['description'] ,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
