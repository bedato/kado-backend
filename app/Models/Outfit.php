<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Outfit extends Model
{
    protected $table = 'outfits';

    protected $fillable = [
        'user_id',
        'winterjacket_id',
        'jacket_id',
        'top_id',
        'bottom_id',
        'image_url',
        'season',
        'style',
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
     * Model belongs to Post
     *
     * @return belongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }
}
