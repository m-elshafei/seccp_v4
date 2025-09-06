<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Consultant;
use Illuminate\Database\Seeder;

class ConsultantsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $consultants = config($initiationDataPath.'.consultants');

        foreach ($consultants as $consultant) {
            $consultantData = Consultant::create([
                'name' => $consultant['name'] ,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => NULL

            ]);
        }

        // \DB::table('consultants')->delete();
        
        // \DB::table('consultants')->insert(array (
        //     0 => 
        //     array (
        //         'id' => 1,
        //         'name' => 'شركة الاتحاد الهندسي السعودية',
        //         'created_at' => '2023-01-03 06:58:00',
        //         'updated_at' => '2023-01-03 06:58:00',
        //         'deleted_at' => NULL,
        //     ),
        //     1 => 
        //     array (
        //         'id' => 2,
        //         'name' => 'شركة الخدمات الاستشارية السعودية',
        //         'created_at' => '2023-01-03 06:58:00',
        //         'updated_at' => '2023-01-03 06:58:00',
        //         'deleted_at' => NULL,
        //     ),
        // ));
        
        
    }
}