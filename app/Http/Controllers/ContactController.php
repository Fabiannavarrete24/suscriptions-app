<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $subscription = $user->subscriptions()->where('active', 1)->first();
        $maxContacts = $subscription->plan->max_contacts;

        $contacts = $user->contacts()->paginate(10);

        return view('contacts.index', compact('contacts', 'maxContacts'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $plan = $user->subscription->plan;

        if ($user->contacts()->count() >= $plan->max_contacts) {
            return back()->with('error', 'Has alcanzado el límite de contactos de tu plan.');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable'
        ]);

        $user->contacts()->create($request->all());

        return back()->with('success', 'Contacto agregado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
