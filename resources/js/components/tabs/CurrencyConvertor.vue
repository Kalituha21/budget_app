<template>
    <div class="container">
        <div class="row align-items-center h-100 h4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-8 form-group">
                        <label for="fromSelect">From:</label>
                        <select
                            id="fromSelect"
                            v-model="fromCurrency"
                            class="form-control form-control-lg"
                        >
                            <option
                                v-for="currency in getCurrenciesData.currencies"
                                :key="currency.id"
                                :value="currency.id"
                                :selected="currency.id === fromCurrency"
                            >
                                {{ currency.name }}
                            </option>
                        </select>
                    </div>

                    <NumericInput
                        v-model="amount"
                        :precision="selectedFromCurrency.precision"
                        class="col-8"
                    />
                </div>

                <div class="row justify-content-center my-4">
                    <button
                        type="button"
                        class="col-2 btn btn-outline-secondary m-0"
                        style="font-size: 1em"
                        @click="swapCurrencies"
                    >
                        ⇵
                    </button>
                </div>

                <div class="row justify-content-center">
                    <div class="col-8 form-group">
                        <label for="toSelect">To:</label>
                        <select
                            id="toSelect"
                            v-model="toCurrency"
                            class="form-control form-control-lg"
                        >
                            <option
                                v-for="currency in getCurrenciesData.currencies"
                                v-show="currency.id !== fromCurrency"
                                :key="currency.id"
                                :value="currency.id"
                                :selected="currency.id === toCurrency"
                            >
                                {{ currency.name }}
                            </option>
                        </select>
                    </div>

                    <div class="col-8 text-center">
                        <div class="border border-dark rounded bg-light-gray my-1">
                            {{ convertedAmount }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";
import {Currencies, Currency} from "../../models/currencies";
import NumericInput from "../elements/NumericInput";

export default {
    name: "CurrencyConvertor",

    components: {
        NumericInput,
    },

    computed: {
        ...mapGetters(["getCurrenciesData"]),

        selectedFromCurrency() {
            for (let i = 0; i < this.getCurrenciesData.currencies.length; i++) {
                if (this.getCurrenciesData.currencies[i].id === this.fromCurrency) {
                    return this.getCurrenciesData.currencies[i];
                }
            }

            return new Currency();
        },

        selectedToCurrency() {
            for (let i = 0; i < this.getCurrenciesData.currencies.length; i++) {
                if (this.getCurrenciesData.currencies[i].id === this.toCurrency) {
                    return this.getCurrenciesData.currencies[i];
                }
            }

            return new Currency();
        },

        convertedAmount() {
            return (this.amount * this.selectedFromCurrency.getRate(this.toCurrency))
                .toFixed(this.selectedToCurrency.precision);
        },
    },

    data() {
        return {
            fromCurrency: Currencies.DEFAULT_CURRENCY,
            toCurrency: Currencies.DEFAULT_CURRENCY,
            amount: 0,
        };
    },

    created() {
        this.fromCurrency = this.getCurrenciesData.selectedCurrency.id;

        for (let i = 0; i < Currencies.AVAILABLE_CURRENCIES.length; i++) {
            if (Currencies.AVAILABLE_CURRENCIES[i] !== this.fromCurrency) {
                this.toCurrency = Currencies.AVAILABLE_CURRENCIES[i];
                break;
            }
        }
    },

    methods: {
        logRates() {
            axios.post(
                '/currency/get-rates'
            ).then((response) => {
                console.log(response)
            }).catch((error) => {
                console.log(error)
            });
        },

        logApiCurrencies() {
            axios.post(
                '/currency/api-list'
            ).then((response) => {
                console.log(response)
            }).catch((error) => {
                console.log(error)
            });
        },

        swapCurrencies() {
            const tempCurrency = this.fromCurrency;

            this.fromCurrency = this.toCurrency;
            this.toCurrency = tempCurrency;
        },
    },
}
</script>

<style scoped>

</style>
