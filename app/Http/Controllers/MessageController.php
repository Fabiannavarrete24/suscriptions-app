<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $plan = $user->activeSubscription?->plan;

        if (!$plan) {
            return redirect()->route('plans.index');
        }

        $messages = $user->messages()
            ->withCount('contacts')
            ->latest()
            ->get();

        return view('messages.index', compact('messages', 'plan'));
    }

    public function create()
    {
        $user = auth()->user();
        $subscription = $user->activeSubscription;
        $plan = $subscription?->plan;

        if (!$plan) {
            return redirect()->route('plans.index');
        }

        $contacts = $user->contacts()->get();
        $contactsCount = $contacts->count();

        // 👇 NUEVO
        $messagesCount = $user->messages()->count();

        return view('messages.create', compact(
            'plan',
            'contacts',
            'subscription',
            'contactsCount',
            'messagesCount'
        ));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $plan = $user->activeSubscription?->plan;

        if (!$plan) {
            return redirect()->route('plans.index');
        }

        $allowedChannels = [];

        if ($plan->allow_email) $allowedChannels[] = 'email';
        if ($plan->allow_sms) $allowedChannels[] = 'sms';
        if ($plan->allow_whatsapp) $allowedChannels[] = 'whatsapp';

        $maxContacts = (int) ($plan->max_contacts ?? 1);
        $maxUpload   = (int) ($plan->max_upload_mb ?? 1);

        $request->validate([
            'title'    => 'required|string|max:255',
            'message'  => 'required|string',
            'channel'  => 'required|in:' . implode(',', $allowedChannels),
            'contacts' => 'required|array|max:' . $maxContacts,
            'media'    => 'nullable|file|max:' . ($maxUpload * 1024),
        ]);

        $message = $user->messages()->create([
            'title'   => $request->title,
            'content' => $request->message,
            'channel' => $request->channel,
        ]);

        $message->contacts()->sync($request->contacts);

        return redirect()
            ->route('messages.index')
            ->with('success', 'Mensaje creado correctamente');
    }
}
