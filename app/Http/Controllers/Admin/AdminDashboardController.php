<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subscription;
use App\Models\Message;
use App\Models\Payment;
class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'users' => User::count(),
            'activeSubscriptions' => Subscription::where('active', true)->count(),
            'totalMessages' => Message::count(),
            'totalRevenue' => Payment::sum('amount'),
        ]);
    }
}
