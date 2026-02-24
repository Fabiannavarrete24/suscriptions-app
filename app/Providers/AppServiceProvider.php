<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Campaign;
use App\Policies\CampaignPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public const HOME = '/dashboard';
    public function register(): void
    {
        //
    }
    protected $policies = [
        Campaign::class => CampaignPolicy::class,
    ];

    public function boot(): void
    {

    }
}
