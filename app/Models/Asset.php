<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property float $amount
 * @property string $currency
 * @property int|null $asset_income_rule_id
 */
class Asset extends Model
{
    protected $table = 'assets';
    public $timestamps = false;
}
