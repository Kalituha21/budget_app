<?php

namespace App\Http\Controllers;

use App\Repositories\CurrencyRepository;
use App\Services\CurrencyService;

class CurrencyDataController extends Controller
{
    /** @var CurrencyService $currencyService */
    private $currencyService;
    /** @var CurrencyRepository $currencyRepository */
    private $currencyRepository;

    public function __construct(CurrencyService $currencyService, CurrencyRepository $currencyRepository)
    {
        $this->currencyService = $currencyService;
        $this->currencyRepository = $currencyRepository;
    }

    public function getTodayRates(): array
    {
        $isLoadedFromApi = false;
        $rates = $this->currencyRepository->getTodayRates();

        if (!$rates) {
            $rates = $this->currencyService->loadLatestRates();
            $isLoadedFromApi = true;
        }

        return [
            'api_loaded' => $isLoadedFromApi,
            'rates' => $rates,
        ];
    }

    public function getApiCurrencies(): array
    {
        return $this->currencyService->requestApiCurrencies();
    }
}
