<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Layer;
use Illuminate\Database\Seeder;

class LayersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $layers = config($initiationDataPath . '.layers');

        foreach ($layers as $layer) {
            $layerData = Layer::create([
                'name' => $layer['name'],
                'order' => $layer['order'],
                'is_final' => $layer['is_final'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => NULL

            ]);
        }


        // \DB::table('layers')->delete();
        
        // \DB::table('layers')->insert(array (
        //     0 => 
        //     array (
        //         'id' => 1,
        //         'name' => 'الحماية',
        //         'order' => 1,
        //         'is_final' => 0,
        //         'created_at' => '2022-09-20 12:18:22',
        //         'updated_at' => '2022-10-22 11:07:55',
        //         'deleted_at' => NULL,
        //     ),
        //     1 => 
        //     array (
        //         'id' => 2,
        //         'name' => 'طبقة اولى',
        //         'order' => 3,
        //         'is_final' => 0,
        //         'created_at' => '2022-10-22 11:08:34',
        //         'updated_at' => '2022-12-31 08:16:51',
        //         'deleted_at' => NULL,
        //     ),
        //     2 => 
        //     array (
        //         'id' => 3,
        //         'name' => 'الثانية',
        //         'order' => 4,
        //         'is_final' => 0,
        //         'created_at' => '2022-10-22 11:08:41',
        //         'updated_at' => '2022-12-31 08:17:21',
        //         'deleted_at' => NULL,
        //     ),
        //     3 => 
        //     array (
        //         'id' => 4,
        //         'name' => 'الاخيرة',
        //         'order' => 5,
        //         'is_final' => 1,
        //         'created_at' => '2022-10-22 11:08:57',
        //         'updated_at' => '2022-12-31 08:17:44',
        //         'deleted_at' => NULL,
        //     ),
        //     4 => 
        //     array (
        //         'id' => 5,
        //         'name' => 'كشط وحرارة',
        //         'order' => 6,
        //         'is_final' => 0,
        //         'created_at' => '2022-11-17 08:32:06',
        //         'updated_at' => '2022-12-31 08:17:57',
        //         'deleted_at' => NULL,
        //     ),
        //     5 => 
        //     array (
        //         'id' => 6,
        //         'name' => 'رش MC1  وحرارة',
        //         'order' => 7,
        //         'is_final' => 0,
        //         'created_at' => '2022-11-17 08:32:28',
        //         'updated_at' => '2022-12-31 08:18:10',
        //         'deleted_at' => NULL,
        //     ),
        //     6 => 
        //     array (
        //         'id' => 7,
        //         'name' => 'دك الاسفلت',
        //         'order' => 8,
        //         'is_final' => 1,
        //         'created_at' => '2022-11-17 08:32:43',
        //         'updated_at' => '2022-12-31 08:18:18',
        //         'deleted_at' => NULL,
        //     ),
        //     7 => 
        //     array (
        //         'id' => 8,
        //         'name' => 'الخرسانة',
        //         'order' => 2,
        //         'is_final' => 0,
        //         'created_at' => '2022-12-31 08:15:56',
        //         'updated_at' => '2022-12-31 08:16:41',
        //         'deleted_at' => NULL,
        //     ),
        //     8 => 
        //     array (
        //         'id' => 9,
        //         'name' => 'الرصيف',
        //         'order' => 9,
        //         'is_final' => 1,
        //         'created_at' => '2023-01-17 07:30:36',
        //         'updated_at' => '2023-01-17 07:30:36',
        //         'deleted_at' => NULL,
        //     ),
        // ));
        
        
    }
}