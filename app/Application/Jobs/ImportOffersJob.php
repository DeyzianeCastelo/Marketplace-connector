<?php

namespace App\Application\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ImportOffersJob implements ShouldQueue
{
    use Queueable;

    public function handle()
    {
        Log::info("ImportOffersJob iniciado.");

        dispatch(new ProcessOffersPageJob(1));
    }
}
