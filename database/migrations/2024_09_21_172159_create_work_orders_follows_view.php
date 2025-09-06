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
        DB::statement("CREATE OR REPLACE VIEW work_orders_follows_v AS
            select wop.*,wowop.work_order_id ,wo.work_order_number,wo.mission_number,wo.work_type_id ,wo.is_emergency_mission ,wo.status work_order_status
            ,wo.work_period as work_order_period
            ,wo.received_date as work_order_received_date ,p.name  layer_name ,p.lab_result_status ,p.start_date layer_date
            ,(select name from districts d where d.id = wop.district_id  ) district_name
            ,(select id from contractors c where wo.consultant_id = c.id  ) consultant
            ,(select wt.code  from work_types wt where wt.id = wo.work_type_id) work_type_code
            ,(SELECT IFNULL(wo.work_order_number, wo.mission_number) FROM work_orders wo,work_order_work_orders_permit p WHERE wo.id = p.work_order_id AND p.work_orders_permit_id = wop.id LIMIT 1),
                (wop.period - DATEDIFF(CURDATE(), wop.issue_date)) AS total_permit_period_day
            from work_order_work_orders_permit wowop
            left join work_orders wo on wowop.work_order_id = wo.id
            left join work_orders_permits wop on wowop.work_orders_permit_id  = wop.id
            left join (
                select l1.*,l2.name ,l2.is_final
                from land_layers l1,layers l2  ,(select max(id) id   from land_layers group by work_orders_permit_id) l3
                WHERE  l1.layer_id = l2.id and l1.deleted_at IS NULL AND l2.deleted_at IS NULL
                and l1.id = l3.id
                order by l1.id
             ) p ON wowop.work_orders_permit_id  = p.work_orders_permit_id
              WHERE  wo.deleted_at IS NULL and wop.deleted_at  IS NULL
            ;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS work_orders_follows_v');
    }
};
