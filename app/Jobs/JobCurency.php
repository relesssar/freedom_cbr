<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ExchangeController;

class JobCurency implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $date;
    public $tries = 50;
    /**
     * Create a new job instance.
     */
    public function __construct($date)
    {
        $this->date=$date;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (ExchangeController::updateRate($this->date)) {
            $msg = 'JobCurency @ '.date('d-m-Y H:i:s');
            Log::info($msg);
        } else {
            //throw new \Exception("Error Processing the job", 1);
            $this->release($this->attempts() * 5);
            Log::error('JobCurency failed. times='.$this->attempts());
            if ($this->attempts() == $this->tries) {
                Log::error('JobCurency failed Notification');
            }
        }
    }
}
