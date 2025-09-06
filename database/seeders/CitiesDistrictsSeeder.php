<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\City;
use App\Models\District;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CitiesDistrictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = config('initiation-data.districts');
        //
        Schema::disableForeignKeyConstraints();

        foreach ($cities as $city_name => $districts) {
            $cityData = City::create([
                'name' => $city_name ,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 1,
                'updated_by' => 1,
                
            ]);
            foreach ($districts as $district) {
                $districtData = District::create([
                    'name' => $district ,
                    'city_id' => $cityData->id, 
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'created_by' => 1,
                    'updated_by' => 1,

                ]);
            }
        }
        
        Schema::enableForeignKeyConstraints();


    }
}
?>