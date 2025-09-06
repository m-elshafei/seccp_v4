<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RolesSeeder::class,
            SystemComponentsSeeder::class,
            PermissionsSeeder::class,
            CitiesDistrictsSeeder::class,
            BranchesSeeder::class,
            DemoUserSeeder::class,
            DepartmentsSeeder::class,
            JobsEmployeesSeeder::class,
            AttachmentTypesSeeder::class,
            ElectricityCompanyEmployeesSeeder::class,
            LayersTableSeeder::class,
            ConsultantsTableSeeder::class,
            ContractorsTableSeeder::class,
            MissionTypesTableSeeder::class,
            WorkTypesSeeder::class,
            ElectricityDepartmentSeeder::class,
            workOrdersPermitTypesSeeder::class,
            workOrdersTypesSeeder::class,
            ItemsSeeder::class,
            WorkOrderServicesSeeder::class,
            BaladiesTableSeeder::class,
            LabsTableSeeder::class,
            ElectricalStationsTypesTableSeeder::class,
            FinancialDueTypesTableSeeder::class,
            SystemReleasesSeeder::class,
        ]);
    }
}
