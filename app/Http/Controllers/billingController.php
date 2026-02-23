<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class billingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payments = $request->user()->payments()
            ->latest()
            ->paginate(10);

        return view('billing.index', compact('payments'));
    }

    public function refund($paymentId)
    {
        // BETA — solo simulado
        return back()->with('success', 'Solicitud de reembolso enviada.');
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
        //
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
