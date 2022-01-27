class Currencies {
    constructor() {
        const eur = new Currency(Currencies.EUR, Currencies.NAME_EUR, Currencies.SYMBOL_EUR, Currencies.PRECISION_EUR);
        const usd = new Currency(Currencies.USD, Currencies.NAME_USD, Currencies.SYMBOL_USD, Currencies.PRECISION_USD);
        const yen = new Currency(Currencies.YEN, Currencies.NAME_YEN, Currencies.SYMBOL_YEN, Currencies.PRECISION_YEN);
        const rub = new Currency(Currencies.RUB, Currencies.NAME_RUB, Currencies.SYMBOL_RUB, Currencies.PRECISION_RUB);
        const btc = new Currency(Currencies.BTC, Currencies.NAME_BTC, Currencies.SYMBOL_BTC, Currencies.PRECISION_BTC);

        this.currencies = [eur, usd, yen, rub, btc];
        this.selectedCurrency = eur;
    }

    getById(id) {
        for (let i = 0; i < this.currencies.length; i++) {
            if (this.currencies[i].id === id) {
                return this.currencies[i];
            }
        }
    }

    loadRates(responseRates) {
        const rates = this.calculateAllRates(responseRates);
        for (let i = 0; i < this.currencies.length; i++) {
            let currency = this.currencies[i];

            if (typeof rates[currency.id] !== 'undefined') {
                currency.rates = rates[currency.id];
            }
        }
    }

    calculateAllRates(responseRates) {
        const rates = {};

        // loading rates
        for (let i = 0; i < responseRates.length; i++) {
            let rate = responseRates[i];

            if (typeof rates[rate['currency_from']] === 'undefined') {
                rates[rate['currency_from']] = {};
            }

            rates[rate['currency_from']][rate['currency_to']] = parseFloat(rate['rate']);
        }

        const systemCurrency = Currencies.DEFAULT_CURRENCY;

        if (typeof rates[systemCurrency] === 'undefined') {
            return rates;
        }

        // calculating rates
        for (let i = 0; i < Currencies.AVAILABLE_CURRENCIES.length; i++) {
            let currencyFrom = Currencies.AVAILABLE_CURRENCIES[i];

            if (currencyFrom === systemCurrency) {
                // rate should be already loaded
                continue;
            }

            if (typeof rates[systemCurrency][currencyFrom] === 'undefined') {
                // no rate to system currency => not possible to calculate related rates
                continue;
            }

            let rateFromToSystem = rates[systemCurrency][currencyFrom];
            let rateSystemToFrom = 1 / rateFromToSystem;

            for (let j = 0; j < Currencies.AVAILABLE_CURRENCIES.length; j++) {
                let currencyTo = Currencies.AVAILABLE_CURRENCIES[j];

                if (currencyFrom === currencyTo) {
                    continue;
                }

                let rateToToSystem = 1;

                if (currencyTo === systemCurrency) {
                    // do nothing (already set)
                } else if (typeof rates[systemCurrency][currencyTo] === 'undefined') {
                    // no rate to system currency => not possible to calculate related rate
                    continue
                } else {
                    rateToToSystem = rates[systemCurrency][currencyTo];
                }

                if (typeof rates[currencyFrom] === 'undefined') {
                    rates[currencyFrom] = {};
                }

                rates[currencyFrom][currencyTo] = rateSystemToFrom * rateToToSystem;
            }
        }

        return rates
    }
}

class Currency {
    constructor(id = '', name = '', symbol = '', precision = 2) {
        /** @type {String} */
        this.id = id;
        /** @type {String} */
        this.name = name;
        /** @type {String} */
        this.symbol = symbol;
        /** @type {Number} */
        this.precision = precision;
        /** @type {Object} => [currency_id: rate] */
        this.rates = {};
    }

    getRate(convertCurrencyId) {
        if (typeof this.rates[convertCurrencyId] === 'undefined') {
            return 1; // Default rate
        }

        return this.rates[convertCurrencyId];
    }
}

Currencies.EUR = 'EUR';
Currencies.USD = 'USD';
Currencies.YEN = 'YEN';
Currencies.RUB = 'RUB';
Currencies.BTC = 'BTC';

Currencies.DEFAULT_CURRENCY = Currencies.EUR;

Currencies.NAME_EUR = 'EUR, €';
Currencies.NAME_USD = 'USD, $';
Currencies.NAME_YEN = 'YEN, ¥';
Currencies.NAME_RUB = 'RUB, ₽';
Currencies.NAME_BTC = 'BTC, ₿';

Currencies.SYMBOL_EUR = '€';
Currencies.SYMBOL_USD = '$';
Currencies.SYMBOL_YEN = '¥';
Currencies.SYMBOL_RUB = '₽';
Currencies.SYMBOL_BTC = '₿';

Currencies.PRECISION_EUR = 2;
Currencies.PRECISION_USD = 2;
Currencies.PRECISION_YEN = 0;
Currencies.PRECISION_RUB = 2;
Currencies.PRECISION_BTC = 8;

Currencies.AVAILABLE_CURRENCIES =  [
    Currencies.EUR,
    Currencies.USD,
    Currencies.YEN,
    Currencies.RUB,
    Currencies.BTC,
];

export {Currencies, Currency};
