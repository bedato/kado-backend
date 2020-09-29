<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'merchant_id',
        'user_code',
        'username',
        'password',
        'email',
        'items',
        'outfits',
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['password', 'remember_token', 'merchant_id'];

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }
    public function getAuthPassword()
    {
        return $this->password;
    }

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    /**
     * Model has many items.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): hasMany
    {
        return $this->hasMany(Item::class, 'user_id');
    }

    /**
     * Model has many outfits.
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function outfits(): hasMany
    {
        return $this->hasMany(Outfit::class, 'user_id');
    }

    /**
     * Modify date format.
     *
     * @param string $value - attribute value to be casted
     *
     * @return Date
     */
    public function getCreatedAtAttribute($value): string
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    /**
     * Modify date format.
     *
     * @param string $value - attribute value to be casted
     *
     * @return Date
     */
    public function getUpdatedAtAttribute($value): string
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    /**
     * Modify date format.
     *
     * @param string $value - attribute value to be casted
     *
     * @return Date | null
     */
    public function getDeletedAtAttribute($value = null)
    {
        if (!$value) {
            return null;
        }

        return date('Y-m-d H:i:s', strtotime($value));
    }
}
