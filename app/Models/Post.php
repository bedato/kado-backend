<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use User;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'id',
        'outfit_id',
        'user_id',
        'outfit',
        'created_at',
        'updated_at'
    ];

    /**
     * Modify date format.
     *
     * @param string $value
     * @return Date
     */
    public function getCreatedAtAttribute($value): string
    {
        return \date('Y-m-d H:i:s', strtotime($value));
    }

    /**
     * Model has one outfit model.
     *
     * @return hasOne
     */
    public function outfit(): hasOne
    {
        return $this->hasOne(Outfit::class, 'id', 'outfit_id');
    }

    /**
     * Model belongs to User's model.
     *
     * @return belongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
