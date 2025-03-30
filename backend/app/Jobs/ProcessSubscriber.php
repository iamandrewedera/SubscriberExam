<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

use App\Models\Subscriber;

class ProcessSubscriber implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $status;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $status)
    {
        $this->email = $email;
        $this->status = $status;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            Subscriber::updateOrCreate(
                ['email' => $this->email],
                ['status' => $this->status]
            );
        });
    }
}
