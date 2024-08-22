<?php

namespace App\Models;

use App\traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 *     @OA\Schema(
 *         schema="User",
 *         type="object",
 *         title="User",
 *         @OA\Property(
 *          property="user_id",
 *          type="integer",
 *          example=3
 *      ),
 *      @OA\Property(
 *          property="id",
 *          type="integer",
 *          example=1
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string",
 *          example="Tom"
 *      ),
 *      @OA\Property(
 *          property="email",
 *          type="string",
 *          example="Tom@gmail.com"
 *      ),
 *      @OA\Property(
 *          property="created_at",
 *          type="string",
 *          example="2024-08-15T08:55:40.000000Z"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          example="2024-08-15T08:55:40.000000Z"
 *      ),
 *   )
 */

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRolesAndPermissions, Billable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return mixed
     */
    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * @return MorphOne
     */
    public function gallery(): MorphOne
    {
        return $this->morphOne(Gallery::class, 'galleryable');
    }
}
