<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Outfit;
use Item;

class OutfitItems extends Model
{
    protected $table = 'outfit_items';

    protected $fillable = [
        'outfit_id',
        'item_id',
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
     * Model belongs to Outfit's model.
     *
     */
    public function Outfit()
    {
        return $this->belongsTo(Outfit::class, 'outfit_id', 'id');
    }

    /**
     * Model belongs to item's model.
     *
     */
    public function Item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
