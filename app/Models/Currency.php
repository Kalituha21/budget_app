<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string currency_from
 * @property string currency_to
 * @property float $rate
 * @property string $valid_at
 */
class Currency extends Model
{
    public const EUR = 'EUR';
    public const USD = 'USD';
    public const YEN = 'YEN';
    public const RUB = 'RUB';
    public const BTC = 'BTC';

    public const SYSTEM_DEFAULT = self::EUR;

    public const AVAILABLE_CURRENCIES = [
        self::EUR,
        self::USD,
        self::YEN,
        self::RUB,
        self::BTC,
    ];

    public const CURRENCY_PRECISIONS = [
        self::EUR => 2,
        self::USD => 2,
        self::YEN => 0,
        self::RUB => 2,
        self::BTC => 8,
    ];

    protected $table = 'currencies';
    public $timestamps = false;
}
