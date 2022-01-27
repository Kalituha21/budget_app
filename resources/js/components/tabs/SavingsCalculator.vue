<template>
    <div class="container h5">
        <!--    Deposit    -->
        <div class="row mt-3">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-4 my-auto">
                        <label for="deposit" class="m-0">Deposit:</label>
                    </div>
                    <div class="col-7 my-auto ml-auto px-0">
                        <NumericInput
                            v-model.number="deposit"
                            :precision="getCurrenciesData.selectedCurrency.precision"
                            :input-class="'text-right'"
                        />
                    </div>
                    <div class="col-1 px-0 my-auto text-left">
                        {{ getCurrenciesData.selectedCurrency.symbol }}
                    </div>
                </div>
            </div>
            <input
                id="deposit"
                v-model.number="deposit"
                class="slider"
                type="range"
                min="0"
                :max="currencyMax"
            >
        </div>
        <hr>

        <!--    Rate    -->
        <div class="row mt-3">
            <div class="container">
                <div class="row mb-2">
                    <!-- rate label -->
                    <div class="col-4 my-auto pr-0 text-left">
                        <label for="rate" class="m-0">Interest rate:</label>
                    </div>
                    <!-- rate type -->
                    <div class="col-5 my-auto">
                        <select
                            id="rateType"
                            v-model="rateType"
                            class="form-control form-control-lg"
                        >
                            <option
                                v-for="(periodTypesOption, index) in periodTypes"
                                :key="index"
                                :value="periodTypesOption"
                                :selected="periodTypesOption === rateType"
                            >
                                {{ periodTypesOption }}
                            </option>
                        </select>
                    </div>
                    <!-- rate input -->
                    <div class="col-2 my-auto ml-auto px-0">
                        <NumericInput
                            v-model.number="rate"
                            :precision="2"
                            :min="0.01"
                            input-class="text-right"
                        />
                    </div>
                    <div class="col-1 my-auto px-0 text-left">%</div>
                </div>
            </div>
            <input
                id="rate"
                v-model.number="rate"
                class="slider"
                type="range"
                min="1"
                max="100"
            >
        </div>
        <hr>

        <!--    Period    -->
        <div class="row mt-3">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-3 my-auto text-left">
                        <label for="period" class="m-0">Period:</label>
                    </div>
                    <div class="col-2 my-auto text-right">
                        {{ period }}
                    </div>
                    <div class="col-7 my-auto">
                        <select
                            id="periodType"
                            v-model="periodType"
                            class="form-control form-control-lg"
                        >
                            <option
                                v-for="(periodTypesOption, index) in periodTypes"
                                :key="index"
                                :value="periodTypesOption"
                                :selected="periodTypesOption === periodType"
                            >
                                {{ periodTypeNames[periodTypesOption] }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <input
                id="period"
                v-model.number="period"
                class="slider"
                type="range"
                min="1"
                :max="periodMax"
            >
        </div>
        <hr>

        <!--    Interest    -->
        <div class="row mt-3">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-4 my-auto">
                        <div class="my-2">Interest:</div>
                    </div>
                    <div class="col-7 my-auto ml-auto px-0">
                        <NumericInput
                            v-model.number="interest"
                            :precision="getCurrenciesData.selectedCurrency.precision"
                            :input-class="'text-right'"
                        />
                    </div>
                    <div class="col-1 px-0 my-auto text-left">
                        {{ getCurrenciesData.selectedCurrency.symbol }}
                    </div>
                </div>
            </div>
            <input
                id="pay"
                v-model.number="interest"
                class="slider"
                type="range"
                :min="currencyMin"
                :max="deposit"
            >
        </div>
        <hr>

        <!--    Savings    -->
        <div class="row mt-3">
            <div class="container">
                <div class="row">
                    <div class="col-4 my-auto">
                        <div class="my-2">
                            Savings:
                        </div>
                    </div>
                    <div class="col-8 my-auto border border-dark rounded bg-light-gray">
                        <div class="text-right my-2">
                            {{ savings }} {{ getCurrenciesData.selectedCurrency.symbol }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NumericInput from "../elements/NumericInput";
import {mapGetters} from "vuex";

const DEFAULT_MAX_DEPOSIT = 10000000; // 10 000 000
const DEFAULT_MAX_INTEREST = 10000000; // 10 000 000

const PERIOD_TYPE_ANNUAL = 'annual';
const PERIOD_TYPE_MONTHLY = 'monthly';

const PERIOD_LIMIT_ANNUAL = 40;
const PERIOD_LIMIT_MONTHLY = 36;

export default {
    name: "SavingsCalculator",

    components: {
        NumericInput,
    },

    computed: {
        ...mapGetters(["getCurrenciesData"]),

        currencyMin() {
            return parseFloat(
                (1 / Math.pow(10, this.getCurrenciesData.selectedCurrency.precision))
                    .toFixed(this.getCurrenciesData.selectedCurrency.precision)
            );
        },

        currencyMax() {
            return DEFAULT_MAX_DEPOSIT * this.currencyMaxRate;
        },

        currencyMaxRate() {
            return 1 / Math.pow(10, this.getCurrenciesData.selectedCurrency.precision / 2);
        },

        interestDefaultMax() {
            return DEFAULT_MAX_INTEREST * this.currencyMaxRate;
        },

        periodMax() {
            switch (this.periodType) {
                case PERIOD_TYPE_ANNUAL:
                    return PERIOD_LIMIT_ANNUAL;
                case PERIOD_TYPE_MONTHLY:
                    return PERIOD_LIMIT_MONTHLY;
                default:
                    return 100;
            }
        },

        savings() {
            return this.deposit + this.interest;
        },

        interest: {
            get: function() {
                const regularIncome = this.deposit * this.percentageRate;

                return parseFloat(
                    (regularIncome * this.interestPeriod).toFixed(this.getCurrenciesData.selectedCurrency.precision)
                );
            },
            set: function(newValue) {
                const regularIncome = newValue / this.interestPeriod;
                this.deposit = parseFloat(
                    (regularIncome / this.percentageRate).toFixed(this.getCurrenciesData.selectedCurrency.precision)
                );
            }
        },

        interestPeriod() {
            if (this.periodType === this.rateType) {
                return this.period;
            } else if(this.periodType === PERIOD_TYPE_ANNUAL) {
                // rate is monthly
                return this.period * 12;
            } else if (this.periodType === PERIOD_TYPE_MONTHLY) {
                //  rate is annual
                return Math.floor(this.period / 12);
            }

            // should  never execute but for safety
            return this.period;
        },

        percentageRate() {
            return this.rate / 100;
        },
    },

    data() {
        return {
            deposit: 0,
            rate: 3,
            period: 1,
            periodTypes: [
                PERIOD_TYPE_ANNUAL,
                PERIOD_TYPE_MONTHLY,
            ],
            periodTypeNames: {
                'annual': 'years', /** @see PERIOD_TYPE_ANNUAL */
                'monthly': 'months', /** @see PERIOD_TYPE_MONTHLY */
            },
            periodType: PERIOD_TYPE_ANNUAL,
            rateType: PERIOD_TYPE_ANNUAL,
        };
    },
}
</script>

<style scoped>

</style>
