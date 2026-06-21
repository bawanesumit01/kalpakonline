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
        'mobile',
        'password',
        'role',
        'permissions',
        'otp',
        'otp_expires_at'
    ];

    protected $casts = [
        'permissions' => 'array',
        'otp_expires_at' => 'datetime',
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
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->role === 'superadmin') {
            return true;
        }

        return in_array($permission, $this->permissions ?? []);
    }

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isClient()
    {
        return $this->role === 'client';
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'user_id', 'id');
    }

    /**
     * Get the addresses for this user.
     */
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    /**
     * Get the orders for this user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the default address for this user.
     */
    public function defaultAddress()
    {
        return $this->addresses()->where('is_default', true)->first();
    }

}
