<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\WorkOrdersPermitType;

class workOrdersPermitTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $workOrdersPermitTypes = config('initiation-data.workOrdersPermitTypes');
        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $workOrdersPermitTypes = config($initiationDataPath.'.workOrdersPermitTypes');
        //
        foreach ($workOrdersPermitTypes as $workOrdersPermitType) {
            $workOrdersPermitTypeData = WorkOrdersPermitType::create([
                'name' => $workOrdersPermitType['name'] ,
                'description' => $workOrdersPermitType['description'] ,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
