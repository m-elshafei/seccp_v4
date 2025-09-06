<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\WorkOrdersType;
use Illuminate\Database\Seeder;

class workOrdersTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $workOrdersTypes = config('initiation-data.workOrdersTypes');
        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $workOrdersTypes = config($initiationDataPath.'.workOrdersTypes');
        //
        foreach ($workOrdersTypes as $workOrdersType) {
            $workOrdersTypeData = WorkOrdersType::create([
                'name' => $workOrdersType['name'] ,
                //'description' => $workOrdersType['description'] ,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
