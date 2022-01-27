<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property float $amount
 * @property string $currency
 * @property string $every - expense repeat interval
 * @property string $start_at - timestamp
 * @property string|null $delete_at - timestamp
 */
class Expense extends Model
{
    protected $table = 'expenses';
    public $timestamps = false;
}
