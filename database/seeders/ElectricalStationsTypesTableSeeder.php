<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ElectricalStationsTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        DB::table('electrical_stations_types')->delete();
        
        DB::table('electrical_stations_types')->insert(array (
            0 => 
            array (
                'code' => 'BT',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => NULL,
                'description' => NULL,
                'electrical_type' => 1,
                'id' => 1,
                'name' => 'BT',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            1 => 
            array (
                'code' => 'AT',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => NULL,
                'description' => NULL,
                'electrical_type' => 1,
                'id' => 2,
                'name' => 'AT',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            2 => 
            array (
                'code' => 'UT',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => NULL,
                'description' => NULL,
                'electrical_type' => 1,
                'id' => 3,
                'name' => 'UT',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            3 => 
            array (
                'code' => 'HT',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => NULL,
                'description' => NULL,
                'electrical_type' => 1,
                'id' => 4,
                'name' => 'HT',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            4 => 
            array (
                'code' => 'KK',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => NULL,
                'description' => NULL,
                'electrical_type' => 1,
                'id' => 5,
                'name' => 'KK',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            5 => 
            array (
                'code' => 'OH',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => NULL,
                'description' => NULL,
                'electrical_type' => 1,
                'id' => 6,
                'name' => 'OH',
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            )
        ));
        
        
    }
}