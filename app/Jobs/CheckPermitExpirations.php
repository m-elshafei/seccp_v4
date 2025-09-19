<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
