<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("CREATE OR REPLACE VIEW emergency_missions_v AS
            select wo.*  ,(select dep.name  from departments dep WHERE dep.id=wo.current_department_id) as current_department_name,
            (select  l.cabel_length_hv + l.cabel_length_lv70 + l.cabel_length_lv185+ l.cabel_length_lv300 from landscape_information l where l.work_order_id = wo.id) as total_cabel_length
            ,(select wop.permit_number  from work_orders_permits wop ,work_order_work_orders_permit p WHERE wop.id =p.work_orders_permit_id and p.work_order_id = wo.id LIMIT 1) permit_number
            ,(select wop.status  from work_orders_permits wop ,work_order_work_orders_permit p WHERE wop.id =p.work_orders_permit_id and p.work_order_id = wo.id LIMIT 1) permit_status
            ,(select DATEDIFF(CURRENT_DATE() , wop.start_date) AS date_difference  from work_orders_permits wop ,work_order_work_orders_permit p WHERE wop.id =p.work_orders_permit_id and p.work_order_id = wo.id LIMIT 1) permit_woking_days
            ,(SELECT work_order_number from work_orders parent WHERE parent.id = wo.parent_id) parent_work_order
            ,(select mt.name FROM mission_types mt WHERE mt.id = wo.mission_typeـid) AS mission_type_name
            ,(select e.name from employees e ,work_order_emergency_missions wm WHERE wm.mission_received_employee = e.id and wm.work_order_id = wo.id ) mission_received_employee_name
            ,(SELECT dep.id FROM departments dep  inner JOIN employees e ON e.department_id = dep.id WHERE e.user_id = wo.current_owner_user_id) AS created_user_department_id
			,(SELECT dep.name FROM departments dep inner JOIN employees e ON e.department_id = dep.id WHERE e.user_id = wo.current_owner_user_id) AS created_user_department_name
			from work_orders wo
			where
            wo.is_emergency_mission =1;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS emergency_missions_v');
    }
};
