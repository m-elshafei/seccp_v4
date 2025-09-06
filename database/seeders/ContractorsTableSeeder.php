<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contractor;
use Carbon\Carbon;

class ContractorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $initiationDataPath = config('custom.general.initiationDataFolderName');
        $contractors = config($initiationDataPath.'.contractors');

        foreach ($contractors as $contractor) {
            $consultantData = Contractor::create([
                'name' => $contractor['name'] ,
                'company_name' => $contractor['company_name'] ,
                'contact_name' => $contractor['contact_name'] ,
                'contact_mobile_number' => $contractor['contact_mobile_number'] ,
                'notes' => $contractor['notes'] ,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'deleted_at' => NULL,
                'branch_id' => $contractor['branch_id'] ,

            ]);
        }
        // \DB::table('contractors')->delete();

        // \DB::table('contractors')->insert(array (
        //     0 =>
        //     array (
        //         'id' => 1,
        //         'name' => 'مؤسسة نطاق المتحدة',
        //         'company_name' => 'مؤسسة نطاق المتحدة',
        //     'contact_name' => 'فارس (ابوايمن)',
        //         'contact_mobile_number' => '0501893106',
        //         'notes' => NULL,
        //         'created_at' => '2022-10-22 06:19:56',
        //         'updated_at' => '2022-11-16 13:16:50',
        //         'deleted_at' => NULL,
        //         'branch_id' => 1,
        //     ),
        //     1 =>
        //     array (
        //         'id' => 2,
        //         'name' => 'شركة احكام',
        //         'company_name' => 'شركة احكام',
        //         'contact_name' => NULL,
        //         'contact_mobile_number' => NULL,
        //         'notes' => NULL,
        //         'created_at' => '2022-10-22 06:21:49',
        //         'updated_at' => '2022-10-22 06:24:35',
        //         'deleted_at' => NULL,
        //         'branch_id' => 1,
        //     ),
        //     2 =>
        //     array (
        //         'id' => 3,
        //         'name' => 'مؤسسة جودة التشييد',
        //         'company_name' => 'مؤسسة جودة التشييد',
        //         'contact_name' => NULL,
        //         'contact_mobile_number' => NULL,
        //         'notes' => NULL,
        //         'created_at' => '2022-10-22 06:22:58',
        //         'updated_at' => '2022-10-22 06:22:58',
        //         'deleted_at' => NULL,
        //         'branch_id' => 1,
        //     ),
        //     3 =>
        //     array (
        //         'id' => 4,
        //         'name' => 'مؤسسة زهرة الديكورات',
        //         'company_name' => 'مؤسسة زهرة الديكورات',
        //         'contact_name' => NULL,
        //         'contact_mobile_number' => NULL,
        //         'notes' => NULL,
        //         'created_at' => '2022-10-22 06:23:36',
        //         'updated_at' => '2022-10-22 06:23:36',
        //         'deleted_at' => NULL,
        //         'branch_id' => 1,
        //     ),
        //     4 =>
        //     array (
        //         'id' => 5,
        //         'name' => 'مؤسسة ديم التقنية',
        //         'company_name' => 'مؤسسة ديم التقنية',
        //         'contact_name' => NULL,
        //         'contact_mobile_number' => NULL,
        //         'notes' => NULL,
        //         'created_at' => '2022-10-22 06:24:12',
        //         'updated_at' => '2022-10-22 06:24:12',
        //         'deleted_at' => NULL,
        //         'branch_id' => 1,
        //     ),
        // ));


    }
}
