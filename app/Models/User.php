<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function plan()
    {
        return $this->hasOneThrough(
            Plan::class,
            Subscriptions::class,
            'user_id',
            'id',
            'id',
            'plan_id'
        );
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscriptions::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function subscription()
    {
        return $this->hasOne(Subscriptions::class)
            ->where('active', 1)
            ->where('ends_at', '>', now());
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscription()->exists();
    }
}
