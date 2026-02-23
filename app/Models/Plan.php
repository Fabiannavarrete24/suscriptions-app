<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'price_monthly',
        'price_yearly',
        'max_contacts',
        'max_campaigns',        
        'max_upload_mb',
        'send_frequency_days',
        'allowed_frequencies'
    ];
}
