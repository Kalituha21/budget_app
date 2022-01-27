<?php

namespace App\Repositories;

use App\Models\Currency;
use Carbon\Carbon;

class CurrencyRepository
{
    /**
     * @return Currency[]
     */
    public function getTodayRates(): array
    {
        return Currency::query()
            ->where('valid_at', (new Carbon())->startOfDay()->toDateTimeString())
            ->get()
            ->all();
    }
}
