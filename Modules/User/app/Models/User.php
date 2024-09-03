<?php

namespace Modules\User\Models;

use App\Models\Authenticatable;
use App\Models\Concerns\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Modules\User\Database\Factories\UserFactory;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as ContractsAuditable;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements ContractsAuditable, JWTSubject
{
    use Auditable, AuthenticationLoggable;
    use HasFactory;
    use Notifiable;
    use HasSearch;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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
        'two_factor_recovery_codes',
        'two_factor_secret',
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
    
    protected static function newFactory(): UserFactory
    {
        return new UserFactory();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email' => $this->email,
            'name' => $this->name
        ];
    }
}
