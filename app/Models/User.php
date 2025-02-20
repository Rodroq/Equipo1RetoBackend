<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @OA\Schema(
 *     schema="Usuario",
 *     type="object",
 *     required={"nombre", "email", "rol"},
 *     @OA\Property(property="nombre", type="string", example="David"),
 *     @OA\Property(property="email", type="string", example="Merchandising de la Liga"),
 *     @OA\Property(property="rol", type="string", example="[entrenador | director | periodista | administrador]"),
 * )
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasRoles, HasFactory, HasApiTokens, Notifiable;

    public function deleteTokens()
    {
        $this->tokens->each(function ($token) {
            $token->delete();
        });
    }

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

    /*
    crear un GateProvider: php artisan make:provider AppServiceProvider
    */

    // public function boot()
    // {
    //     // Implicitly grant "Super Admin" role all permissions
    //     // This works in the app by using gate-related functions like auth()->user->can() and @can()
    //     Gate::before(function ($user, $ability) {
    //         return $user->hasRole('Super Admin') ? true : null;
    //     });
    // }
}
