<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcuseSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'max_daily_hours',
        'max_monthly_hours',
        'before_request_period',
        'is_paid',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
    ];

    /**
     * Retrieve the current excuse settings.
     *
     * @return ExcuseSetting
     */
    public static function current()
    {
        return self::first() ?? self::create();
    }
}
