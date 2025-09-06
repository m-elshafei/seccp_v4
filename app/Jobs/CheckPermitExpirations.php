<?php

namespace App\Jobs;

use App\Services\PermitService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Helper;
use App\Models\WorkOrder;
use App\Models\WorkOrdersPermit;
use Carbon\Carbon;
class CheckPermitExpirations implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    protected $permitService;


    public function __construct()
    {
        //
    }

    public function handle()
    {
        $this->permitService->checkPermitExpirations();
    }
}
