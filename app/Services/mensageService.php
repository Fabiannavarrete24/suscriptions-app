<?php

namespace App\Services;
use App\Jobs\SendCampaignJob;
class mensageService
{
    public function create($user, $data, $plan)
    {
        if ($user->campaigns()->count() >= $plan->max_campaigns) {
            throw new \Exception("Has alcanzado el límite de campañas.");
        }

        if (isset($data['media'])) {
            $data['media'] = $data['media']->store('campaigns');
        }

        $data['next_run_at'] = now()->addDays($plan->send_frequency_days);
        $data['status'] = 'scheduled';

        $campaign = $user->campaigns()->create($data);

        // 👇 AQUÍ VA
        SendCampaignJob::dispatch($campaign);

        return $campaign;
    }
}
