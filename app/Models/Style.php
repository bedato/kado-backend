<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    protected $table = 'styles';

    protected $fillable = [
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


    public static function boot()
    {
        parent::boot();

        self::deleting(function ($style) {
            $style->delete();
        });
    }
}
