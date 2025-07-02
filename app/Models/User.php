<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laragear\WebAuthn\WebAuthnAuthenticatable; // Jika digunakan

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    // use WebAuthnAuthenticatable; // Uncomment jika pakai login biometrik WebAuthn

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'google_id',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi: User memiliki banyak order.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relasi: User memiliki banyak transaksi.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function chats()
{
    return $this->hasMany(\App\Models\Chat::class);
}
}
