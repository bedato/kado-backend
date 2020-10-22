<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Model;
use Outfit;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'user_id',
        'category',
        'category_id',
        'season',
        'color',
        'style',
        'shape',
        'created_at',
        'updated_at'
    ];

    /**
     * Modify date format.
     *
     * @param  string  $value
     * @return Date
     */
    public function getCreatedAtAttribute($value): string
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    /**
     * Modify date format.
     *
     * @param  string  $value
     * @return Date
     */
    public function getUpdatedAtAttribute($value): string
    {
        return date('Y-m-d H:i:s', strtotime($value));
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

    /**
     * Gets outfits.
     */
    public function outfits(): HasManyThrough
    {
        return $this->hasManyThrough(
            Outfit::class,
            OutfitItems::class,
            'item_id',
            'id',
            'id',
            'id'
        );
    }
}
