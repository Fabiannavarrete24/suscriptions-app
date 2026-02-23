<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserSubscriptionController extends Controller
{
    public function show(Request $request)
    {
        $subscription = $request->user()->subscription()->with('plan')->first();

        return view('subscription.show', compact('subscription'));
    }
}
