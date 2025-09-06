<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\FinancialDueType;
use Illuminate\Database\Seeder;

class FinancialDueTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $financialDueTypes = config($initiationDataPath . '.FinancialDueTypes');

        foreach ($financialDueTypes as $financialDueType) {
            $financialDueTypeData = FinancialDueType::create([
                'name' => $financialDueType['name'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => NULL

            ]);
        }


        // \DB::table('financial_due_types')->delete();

        // \DB::table('financial_due_types')->insert(array (
        //     0 => 
        //     array (
        //         'id' => 1,
        //         'name' => 'مستخلصات قسم التمديدات والحفر',
        //         'created_at' => '2022-08-05 10:50:42',
        //         'updated_at' => '2022-08-05 10:50:42',
        //         'deleted_at' => NULL,
        //     ),
        //     1 => 
        //     array (
        //         'id' => 2,
        //         'name' => 'مستخلصات قسم الكهرباء',
        //         'created_at' => '2022-08-05 10:50:57',
        //         'updated_at' => '2022-08-05 10:50:57',
        //         'deleted_at' => NULL,
        //     ),
        //     2 => 
        //     array (
        //         'id' => 3,
        //         'name' => 'مستخلصات قسم الهوائى',
        //         'created_at' => '2022-08-05 10:51:08',
        //         'updated_at' => '2022-08-05 10:51:08',
        //         'deleted_at' => NULL,
        //     ),
        //     3 => 
        //     array (
        //         'id' => 4,
        //         'name' => 'مستخلصات المشاريع',
        //         'created_at' => '2022-08-05 10:51:38',
        //         'updated_at' => '2022-08-05 10:53:43',
        //         'deleted_at' => NULL,
        //     ),
        //     4 => 
        //     array (
        //         'id' => 5,
        //         'name' => 'مستخلصات قسم الطوارئ والعمليات',
        //         'created_at' => '2022-08-05 10:51:59',
        //         'updated_at' => '2022-08-05 10:51:59',
        //         'deleted_at' => NULL,
        //     ),
        // ));


    }
}
