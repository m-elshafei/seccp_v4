<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Job;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class JobsEmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $jobs = config('initiation-data.jobs_employees');

        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $jobs = config($initiationDataPath . '.jobs_employees');

        foreach ($jobs as $job) {
            $jobData = Job::create([
                'name' => $job['name'] ,
                'description' => $job['description'] 
            ]);

        }
        // $users = config('initiation-data.users');

        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $users = config($initiationDataPath . '.users');
    
        foreach ($users as $key =>$user) {
            $employeeData = Employee::create([
                'name' => $user['name'] ,
                'branch_id'=>1,
                'department_id'=> $user['department_id'],
                'job_id'=> $user['job_id'],
                'user_id'=> $key ,
            ]);
        }
        foreach ($jobs as $job) {
            foreach ($job['employees'] as $employee) {
                $employeeData = Employee::create([
                    'name' => $employee['name'] ,
                    'branch_id'=> $employee['branch_id'],
                    'department_id'=> $employee['department_id'],
                    'job_id'=> $employee['job_id'],
                    'user_id'=> $employee['user_id']
                ]);
            }

        }
    }
}
