<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\WorkType;
use Illuminate\Database\Seeder;

class WorkTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $workTypes = config('initiation-data.workTypes');
        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $workTypes = config($initiationDataPath.'.workTypes');
        //
        foreach ($workTypes as $workType) {
            $PrmObjectData = WorkType::create([
                'code' => trim($workType['work_order_type']) ,
                'name' => trim($workType['work_order_type_desc']) ,
                'notes' => (isset($workType['notes']))? $workType['notes'] : '',
                'needs_drilling_operations' =>(isset($workType['needs_drilling_operations']))? $workType['needs_drilling_operations'] : 1 ,
                'needs_electrical_work' => (isset($workType['needs_electrical_work']))? $workType['needs_electrical_work'] : 1 ,
                'needs_work_orders_permit' =>(isset($workType['needs_work_orders_permit']))? $workType['needs_work_orders_permit'] : 0 ,
                'default_department_id' =>(isset($workType['default_department_id']))? $workType['default_department_id'] :null ,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);

        }
    }
}
