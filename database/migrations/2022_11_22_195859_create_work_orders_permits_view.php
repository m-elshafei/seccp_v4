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
        DB::statement("CREATE OR REPLACE VIEW work_orders_permits_v AS
            SELECT
                wop.*,
                pt.name AS permit_type_name,
                (SELECT IFNULL(wo.work_order_number, wo.mission_number) FROM work_orders wo,work_order_work_orders_permit p WHERE wo.id = p.work_order_id AND p.work_orders_permit_id = wop.id LIMIT 1) AS work_order_number,
                (wop.period - DATEDIFF(CURDATE(), wop.issue_date)) AS total_permit_period_day
            FROM
                work_orders_permits wop,
                work_orders_permit_types pt
            WHERE
                wop.work_orders_permit_type_id = pt.id;

                ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS work_orders_permits_v');
        //Schema::dropIfExists('work_orders_permits_view');
    }
};
