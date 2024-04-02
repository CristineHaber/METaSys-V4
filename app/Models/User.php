<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'usertype',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function events()
    {

        return $this->hasMany(Event::class);
    }

    public function auditTrails()
    {
        return $this->hasMany(AuditTrail::class, 'created_by_user');
    }
    
    public function judge()
    {

        return $this->hasOne(Judge::class);
    }

    public function getOnlineStatusAttribute()
    {
        $session = DB::table('sessions')
            ->where('user_id', $this->id)
            ->latest('last_activity')
            ->first();
    
        return $session && !empty($session->ip_address)
            ? 'Online (' . $session->ip_address . ')'
            : 'Offline';
    }
    
}
