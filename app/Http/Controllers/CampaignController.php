<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignController extends Controller
{
    private function getActivePlan($user)
    {
        $subscription = $user->subscriptions()
            ->where('active', 1)
            ->with('plan')
            ->first();

        return $subscription?->plan;
    }
    public function index()
    {
        $user = auth()->user();
        $plan = $this->getActivePlan($user);

        if (!$plan) {
            return redirect()->route('plans.index');
        }

        $campaigns = $user->campaigns()->latest()->get();

        return view('campaigns.index', compact('campaigns', 'plan'));
    }
    public function store(Request $request)
    {
        $user = auth()->user();
        $plan = $this->getActivePlan($user);

        if (!$plan) {
            return redirect()->route('plans.index');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'channel' => 'required|in:email,sms,whatsapp',
            'media' => 'nullable|file|max:' . ($plan->max_upload_mb * 1024),
        ]);

        if ($request->hasFile('media')) {
            $path = $request->file('media')->store('campaigns');
        }

        $user->campaigns()->create([
            'title' => $request->title,
            'message' => $request->message,
            'channel' => $request->channel,
            'media' => $path ?? null,
            'next_run_at' => now()->addDays($plan->send_frequency_days)
        ]);

        return redirect()->route('campaigns.index')
            ->with('success', 'Campaña creada');
    }
}
