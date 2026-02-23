<?php

namespace App\Console\Commands;
namespace App\Models\Campaign;

use Illuminate\Console\Command;

class ProcessCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-campaigns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $campaigns = Campaign::where('next_run_at', '<=', now())
            ->where('active', 1)->get();

        foreach ($campaigns as $campaign) {

            foreach ($campaign->user->contacts as $contact) {
                // Aquí conectarás WhatsApp / Mail / SMS
            }

            $days = $campaign->user->subscription->plan->send_frequency_days;

            $campaign->update([
                'next_run_at' => now()->addDays($days)
            ]);
        }
    }
}
