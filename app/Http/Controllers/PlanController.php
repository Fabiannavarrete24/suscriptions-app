<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasActiveSubscription()) {
            return redirect()->route('subscription.show');
        }

        $plans = Plan::all();

        $currentSubscription = auth()->user()
            ->subscription()
            ->where('ends_at', '>', now())
            ->first();

        return view('plans.index', compact('plans', 'currentSubscription'));
    }
}
