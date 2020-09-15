<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Merchant extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'email',
        'password',
        'api_token',
        'created_at',
        'updated_at'
    ];

    protected $table = 'merchants';

    protected $dates = ['deleted_at'];

    protected $hidden = ['password', 'remember_token'];

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }
    public function getAuthPassword()
    {
        return $this->password;
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
