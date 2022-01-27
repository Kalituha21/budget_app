<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property float $amount
 * @property string $currency
 * @property int|null $liability_expense_rule_id
 */
class Liability extends Model
{
    protected $table = 'liabilities';
    public $timestamps = false;
}
