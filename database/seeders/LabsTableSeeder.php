<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Lab;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LabsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $labs = config($initiationDataPath . '.labs');

        foreach ($labs as $lab) {
            $labData = Lab::create([
                'name' => $lab['name'],
                'branch_id' => $lab['branch_id'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => NULL

            ]);
        }

        // DB::table('labs')->delete();
        
        // DB::table('labs')->insert(array (
        //     0 => 
        //     array (
        //         'created_at' => '2022-07-12 09:15:07',
        //         'deleted_at' => NULL,
        //         'id' => 1,
        //         'name' => 'مختبر سعودي تك',
        //         'updated_at' => '2022-07-12 09:15:07',
        //         'branch_id' => 1,
        //     ),
        // ));
        
        
    }
}