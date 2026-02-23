<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendCampaignJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $campaigns = Campaign::where('sent', false)
            ->where('scheduled_at', '<=', now())
            ->get();

        foreach ($campaigns as $campaign) {

            foreach ($campaign->user->contacts as $contact) {
                // aquí se enviará realmente
            }

            $campaign->update(['sent' => true]);
        }
    }
}
