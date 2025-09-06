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
        DB::statement("CREATE OR REPLACE VIEW work_orders_v AS
            select
            wo.* ,
            d.name as district_name ,
            (select dep.name  from departments dep WHERE dep.id=wo.current_department_id) as current_department_name,
            (select  l.cabel_length_hv + l.cabel_length_lv70 + l.cabel_length_lv185+ l.cabel_length_lv300 from landscape_information l where l.work_order_id = wo.id) as total_cabel_length,
            (select  CASE WHEN li.length_total  =  0 THEN COALESCE(li.length_total_before, 0) ELSE li.length_total END as calc_length_total from landscape_information li where li.work_order_id = wo.id ) as calc_length_total ,
            (select wop.permit_number  from work_orders_permits wop ,work_order_work_orders_permit p WHERE wop.id =p.work_orders_permit_id and p.work_order_id = wo.id LIMIT 1) permit_number,
            (select wop.id  from work_orders_permits wop ,work_order_work_orders_permit p WHERE wop.id =p.work_orders_permit_id and p.work_order_id = wo.id LIMIT 1) permit_number_id,
            (select wop.status  from work_orders_permits wop ,work_order_work_orders_permit p WHERE wop.id =p.work_orders_permit_id and p.work_order_id = wo.id LIMIT 1) permit_status,
            (select DATEDIFF(CURRENT_DATE() , wop.start_date) AS date_difference  from work_orders_permits wop ,work_order_work_orders_permit p WHERE wop.id =p.work_orders_permit_id and p.work_order_id = wo.id LIMIT 1) permit_woking_days,
            (select IF(l.drilling_worker_type = 'contractor', (SELECT name FROM contractors c WHERE c.id = l.drilling_contractor_id), (SELECT name FROM employees e WHERE e.id = l.drilling_employee_id)) from landscape_information l where l.work_order_id = wo.id) as drilling_worker,
            (select drilling_complete_date from landscape_information l where l.work_order_id = wo.id) as drilling_complete_date,
            (select created_at from work_order_transactions_history w where w.work_order_id  = wo.id  order by id DESC  limit 1 ) as last_action_date_time ,
            (select wop.total_period from work_orders_permits wop, work_orders p, work_order_work_orders_permit wowop where wowop.work_order_id = p.id and wowop.work_orders_permit_id = wop.id and p.id = wo.id  LIMIT 1)  as total_period  
            from
                work_orders wo ,
                districts d ,
                work_types wot
            WHERE
                wo.district_id =d.id
                and wo.work_type_id = wot.id
                and wo.is_emergency_mission =0;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS work_orders_v');
    }
};
