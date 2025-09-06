<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\MissionType;
use Illuminate\Database\Seeder;

class MissionTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $missionTypes = config($initiationDataPath . '.missionTypes');

        foreach ($missionTypes as $missionType) {
            $missionTypeData = MissionType::create([
                'name' => $missionType['name'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => NULL

            ]);
        }

        // \DB::table('mission_types')->delete();
        
        // \DB::table('mission_types')->insert(array (
        //     0 => 
        //     array (
        //         'id' => 1,
        //         'name' => 'صيانة عدادات',
        //         'created_at' => '2023-01-03 07:01:22',
        //         'updated_at' => '2023-01-03 07:01:22',
        //         'deleted_at' => NULL,
        //     ),
        //     1 => 
        //     array (
        //         'id' => 2,
        //         'name' => 'صيانة الجهد المتوسط هوائي',
        //         'created_at' => '2023-01-03 07:02:38',
        //         'updated_at' => '2023-01-03 07:02:38',
        //         'deleted_at' => NULL,
        //     ),
        //     2 => 
        //     array (
        //         'id' => 3,
        //         'name' => 'صيانة الجهد المنخفض هوائي',
        //         'created_at' => '2023-01-03 07:03:45',
        //         'updated_at' => '2023-01-03 07:03:45',
        //         'deleted_at' => NULL,
        //     ),
        //     3 => 
        //     array (
        //         'id' => 4,
        //         'name' => 'صيانة الجهد المنخفض كايبل',
        //         'created_at' => '2023-01-03 07:04:15',
        //         'updated_at' => '2023-01-03 07:04:15',
        //         'deleted_at' => NULL,
        //     ),
        //     4 => 
        //     array (
        //         'id' => 5,
        //         'name' => 'صيانة الجهد المنخفض شبكة أرضية',
        //         'created_at' => '2023-01-03 07:04:45',
        //         'updated_at' => '2023-01-03 07:04:45',
        //         'deleted_at' => NULL,
        //     ),
        //     5 => 
        //     array (
        //         'id' => 6,
        //         'name' => 'صيانة المحطات هوائي',
        //         'created_at' => '2023-01-03 07:05:28',
        //         'updated_at' => '2023-01-03 07:05:28',
        //         'deleted_at' => NULL,
        //     ),
        //     6 => 
        //     array (
        //         'id' => 7,
        //         'name' => 'الفصل والاعادة',
        //         'created_at' => '2023-01-03 07:06:43',
        //         'updated_at' => '2023-01-03 07:06:43',
        //         'deleted_at' => NULL,
        //     ),
        //     7 => 
        //     array (
        //         'id' => 8,
        //         'name' => 'الكابلات المرنة',
        //         'created_at' => '2023-01-03 07:07:32',
        //         'updated_at' => '2023-01-03 07:07:32',
        //         'deleted_at' => NULL,
        //     ),
        //     8 => 
        //     array (
        //         'id' => 9,
        //         'name' => 'المولدات',
        //         'created_at' => '2023-01-03 07:07:54',
        //         'updated_at' => '2023-01-03 07:07:54',
        //         'deleted_at' => NULL,
        //     ),
        //     9 => 
        //     array (
        //         'id' => 10,
        //         'name' => 'صيانة الجهد المنخفض أرضي',
        //         'created_at' => '2023-01-03 07:07:54',
        //         'updated_at' => '2023-01-03 07:07:54',
        //         'deleted_at' => NULL,
        //     ),
        //     10 => 
        //     array (
        //         'id' => 11,
        //         'name' => 'صيانة الجهد المتوسط أرضي',
        //         'created_at' => '2023-01-03 07:07:54',
        //         'updated_at' => '2023-01-03 07:07:54',
        //         'deleted_at' => NULL,
        //     ),
        // ));
        
        
    }
}