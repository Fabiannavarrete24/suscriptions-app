<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Plan::create([

            'name' => 'Básico',
            'price_monthly' => 29,
            'price_yearly' => 290,
            'max_contacts' => 100,
            'max_messages' => 5,
            'max_upload_mb' => 100,
            'send_frequency_days' => 7,
            'allowed_frequencies' => 1,
            'allow_email' => 1,
            'allow_sms' => 0,
            'allow_whatsapp' => 0,
            'allow_image' => 1,
            'allow_video' => 0
        ]);

        Plan::create([
            'name' => 'Profesional',
            'price_monthly' => 79,
            'price_yearly' => 790,
            'max_contacts' => 1000,
            'max_messages' => 5,
            'max_upload_mb' => 100,
            'send_frequency_days' => 7,
            'allowed_frequencies' => 1,
            'allow_email' => 1,
            'allow_sms' => 0,
            'allow_whatsapp' => 0,
            'allow_image' => 1,
            'allow_video' => 0
        ]);

        Plan::create([
            'name' => 'Empresarial',
            'price_monthly' => 199,
            'price_yearly' => 1990,
            'max_contacts' => 10000,
            'max_messages' => 5,
            'max_upload_mb' => 100,
            'send_frequency_days' => 7,
            'allowed_frequencies' => 1,
            'allow_email' => 1,
            'allow_sms' => 0,
            'allow_whatsapp' => 0,
            'allow_image' => 1,
            'allow_video' => 0
        ]);
    }
}
