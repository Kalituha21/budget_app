<?php

namespace App\Services;

use App\Models\Currency;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

class CurrencyService
{
    private const API_URL = 'http://api.exchangeratesapi.io/v1/';
    private const API_KEY = '3847ba9fde60d8c2f87ba072ad9679a2';

    private const API_ENDPOINT_LATEST_RATES = 'latest';
    private const API_ENDPOINT_AVAILABLE_CURRENCIES = 'symbols';

    private const API_PARAM_KEY = 'access_key';
    private const API_PARAM_BASE_CURRENCY = 'base';
    private const API_PARAM_CURRENCIES = 'symbols';

    public const API_AVAILABLE_CURRENCIES = [
//        Currency::EUR => 'EUR', Base currency

        Currency::USD => 'USD',
        Currency::YEN => 'JPY',
        Currency::RUB => 'RUB',
        Currency::BTC => 'BTC',
    ];

    public const API_TO_SYSTEM_CURRENCY_NAMES = [
        'EUR' => Currency::EUR,
        'USD' => Currency::USD,
        'JPY' => Currency::YEN,
        'RUB' => Currency::RUB,
        'BTC' => Currency::BTC,
    ];

    /**
     * @return Currency[]
     */
    public function loadLatestRates(): array
    {
        $rates = $this->requestLatestRates();

        if (!$rates) {
            return [];
        }

        $date = (new Carbon())->startOfDay()->toDateTimeString();
        $currencies = [];
//        $mathCurrencies = [];
        foreach ($rates as $currencyName => $rate) {
            $rate = (float) $rate;
            $currencyName = self::API_TO_SYSTEM_CURRENCY_NAMES[$currencyName] ?? $currencyName;

            $currency = new Currency();
            $currency->currency_from = Currency::SYSTEM_DEFAULT;
            $currency->currency_to = $currencyName;
            $currency->rate = $rate;
            $currency->valid_at = $date;
            $currency->save();
            $currencies[] = $currency;
//            $mathCurrencies[$currencyName] = $currency;
//
//            $currency = new Currency();
//            $currency->currency_from = $currencyName;
//            $currency->currency_to = Currency::SYSTEM_DEFAULT;
//            $currency->rate = 1 / $rate;
//            $currency->valid_at = $date;
//            $currency->save();
//            $currencies[] = $currency;
        }

//        foreach ($mathCurrencies as $mathCurrency) {
//            foreach (Currency::AVAILABLE_CURRENCIES as $currencyName) {
//                if ($currencyName === Currency::SYSTEM_DEFAULT || $currencyName === $mathCurrency->currency_to) {
//                    continue;
//                }
//
//                if (!isset($mathCurrencies[$currencyName])) {
//                    continue;
//                }
//
//                $mathCurrency2 = $mathCurrencies[$currencyName];
//
//                $currency = new Currency();
//                $currency->currency_from = $mathCurrency->currency_to;
//                $currency->currency_to = $mathCurrency2->currency_to;
//                $currency->rate = 1 / $mathCurrency->rate * $mathCurrency2->rate;
//                $currency->valid_at = $date;
//                $currency->save();
//                $currencies[] = $currency;
//            }
//        }

        return $currencies;
    }

    private function requestLatestRates(): array
    {
        $params[self::API_PARAM_KEY] = self::API_KEY;
        $params[self::API_PARAM_BASE_CURRENCY] = Currency::SYSTEM_DEFAULT;
        $params[self::API_PARAM_CURRENCIES] = implode(',', self::API_AVAILABLE_CURRENCIES);

        $url = self::API_URL . self::API_ENDPOINT_LATEST_RATES . $this->getQueryString($params);

        try {
            $response = $this->processApiRequest($url);

            if (!Arr::get($response, 'rates')) {
                throw new Exception();
            }
        } catch (Exception $e) {
            return [];
        }

        return Arr::get($response, 'rates');
    }

    public function requestApiCurrencies(): array
    {
        $params[self::API_PARAM_KEY] = self::API_KEY;
        $url = self::API_URL . self::API_ENDPOINT_AVAILABLE_CURRENCIES . $this->getQueryString($params);

        return $this->processApiRequest($url);
    }

    public function processApiRequest(string $url): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);
        curl_close($ch);

        return json_decode($json, true);
    }

    /**
     * @param array $params ['param1' => 'value1', 'param2' => 'value2', ...]
     * @return string '?param1=value1&param2=value2'
     */
    private function getQueryString(array $params): string
    {
        if (!$params) {
            return '';
        }

        foreach ($params as $key => $value) {
            $params[$key] = $key . '=' . $value;
        }

        return '?' . implode('&', $params);
    }
}
