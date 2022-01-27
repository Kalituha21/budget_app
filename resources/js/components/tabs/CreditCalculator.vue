<template>
    <div class="container h5 scrollable">
        <!--    Amount    -->
        <div class="row mt-3">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-3 my-auto">
                        <label for="amount" class="m-0">Amount:</label>
                    </div>
                    <div class="col-7 my-auto ml-auto pr-0">
                        <NumericInput
                            v-model.number="amount"
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
                id="amount"
                v-model.number="amount"
                class="slider"
                type="range"
                min="0"
                :max="currencyMax"
            >
        </div>
        <hr>

        <!--    Percentage    -->
        <div class="row mt-3">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-8 my-auto">
                        Annual credit interest rate:
                    </div>
                    <div class="col-3 my-auto ml-auto px-0">
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
                    <div class="col-3 my-auto text-right">
                        {{ period }}
                    </div>
                    <div class="col-6 my-auto pl-0">
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
                                {{ periodTypesOption }}
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

        <!--    Payment type    -->
        <div class="row mt-3">
            <div class="container">
                <div class="row">
                    <div class="col-5 my-auto pr-0">
                        <label for="paymentTypeSelect" class="m-0">Payments type:</label>
                    </div>
                    <div class="col my-auto">
                        <select
                            id="paymentTypeSelect"
                            v-model="paymentType"
                            class="form-control form-control-lg"
                        >
                            <option
                                v-for="(paymentTypesOption, index) in paymentTypes"
                                :key="index"
                                :value="paymentTypesOption"
                                :selected="paymentTypesOption === paymentType"
                            >
                                {{ paymentTypesOption }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <!--    Monthly pay    -->
        <div class="row mt-3">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-6 my-auto pr-0">
                        <label for="pay" class="m-0">Monthly pay:</label>
                        <span v-if="paymentType === 'differentiated'" class="h6"><br/>(without commissions)</span>
                    </div>
                    <div class="col-5 my-auto ml-auto pr-0">
                        <NumericInput
                            v-model.number="monthlyPay"
                            :precision="getCurrenciesData.selectedCurrency.precision"
                            :min="currencyMin"
                            :max="amount"
                            :input-class="'text-right'"
                        />
                    </div>
                    <div class="col-1 my-auto px-0 text-left">
                        {{ getCurrenciesData.selectedCurrency.symbol }}
                    </div>
                </div>
            </div>
            <input
                id="pay"
                v-model.number="monthlyPay"
                class="slider"
                type="range"
                :min="currencyMin"
                :max="amount"
            >
        </div>
        <hr>

        <!--    Total pay    -->
        <div class="row mt-3">
            <div class="container">
                <div class="row">
                    <div class="col-4 my-auto">
                        <div class="my-2">
                            Total pay:
                        </div>
                    </div>
                    <div class="col-8 my-auto border border-dark rounded bg-light-gray">
                        <div class="text-right my-2">
                            {{ totalPay }} {{ getCurrenciesData.selectedCurrency.symbol }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <!--    Pay plan    -->
        <div class="row mt-3">
            <div class="container">
                <div class="row">
                    <div class="col my-auto">
                        Payments plan
                    </div>
                    <div class="col text-right">
                        <button
                            class="btn btn-outline-dark"
                            type="button"
                            data-toggle="collapse"
                            data-target="#payPlan"
                            aria-expanded="false"
                            aria-controls="payPlan"
                            @click="isCollapsed = !isCollapsed"
                        >
                            <span v-if="isCollapsed">Hide</span>
                            <span v-else>Show</span>
                            &nbsp;&nbsp;<i class="arrow" :class="isCollapsed ? 'up' : 'down'"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="collapse row" id="payPlan">
            <div class="container mt-2 h6">
                <div v-for="(pay, index) in payPlan" :key="index" class="row justify-content-center">
                    <div class="col-4 my-auto border bg-white">
                        Pay #{{ index + 1 }}
                    </div>
                    <div class="col-5 my-auto border bg-white text-right">
                        {{ pay }} {{ getCurrenciesData.selectedCurrency.symbol }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NumericInput from "../elements/NumericInput";
import {mapGetters} from "vuex";

const DEFAULT_MAX_AMOUNT = 10000000; // 10 000 000

const PERIOD_TYPE_YEARS = 'years';
const PERIOD_TYPE_MONTHS = 'months';
const PERIOD_TYPE_DAYS = 'days';

const PERIOD_LIMIT_YEARS = 40;
const PERIOD_LIMIT_MONTHS = 36;
const PERIOD_LIMIT_DAYS = 365;

const PAYMENT_TYPE_ANNUITY = 'annuity';
const PAYMENT_TYPE_DIFFERENTIATED = 'differentiated';

export default {
    name: "CreditCalculator",

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
            return DEFAULT_MAX_AMOUNT * (1 / Math.pow(10, this.getCurrenciesData.selectedCurrency.precision / 2));
        },

        periodMax() {
            switch (this.periodType) {
                case PERIOD_TYPE_YEARS:
                    return PERIOD_LIMIT_YEARS;
                case PERIOD_TYPE_MONTHS:
                    return PERIOD_LIMIT_MONTHS;
                case PERIOD_TYPE_DAYS:
                    return PERIOD_LIMIT_DAYS;
                default:
                    return 100;
            }
        },

        totalPay() {
            let totalPay = this.amount;

            switch (this.paymentType) {
                case PAYMENT_TYPE_ANNUITY:
                    totalPay = this.totalPayByAnnuity;
                    break;
                case PAYMENT_TYPE_DIFFERENTIATED:
                    totalPay = this.totalPayByDifferentiated;
                    break;
            }

            return totalPay.toFixed(this.getCurrenciesData.selectedCurrency.precision);
        },

        totalPayByAnnuity() {
            return this.annuityMonthlyPay * this.monthCount;
        },

        totalPayByDifferentiated() {
            let totalPay = 0;
            for (const monthPay of this.differentiatedPayPlan) {
                totalPay += parseFloat(monthPay);
            }

            return totalPay;
        },

        monthlyPay: {
            get: function() {
                switch (this.paymentType) {
                    case PAYMENT_TYPE_ANNUITY:
                        return this.annuityMonthlyPay;
                    case PAYMENT_TYPE_DIFFERENTIATED:
                        return this.differentiatedMonthlyBasePay;
                }
            },
            set: function(newValue) {
                switch (this.paymentType) {
                    case PAYMENT_TYPE_ANNUITY:
                        this.annuityMonthlyPay = newValue;
                        break;
                    case PAYMENT_TYPE_DIFFERENTIATED:
                        this.differentiatedMonthlyBasePay = newValue;
                        break;
                }
            }
        },

        annuityMonthlyPay: {
            get: function() {
                const annuityCoefficient = this.monthlyRate
                    * Math.pow(1 + this.monthlyRate, this.monthCount)
                    / (Math.pow(1 + this.monthlyRate, this.monthCount) - 1);

                return parseFloat(
                    (annuityCoefficient * this.amount).toFixed(this.getCurrenciesData.selectedCurrency.precision)
                );
            },
            set: function(newValue) {
                const annuityCoefficient = newValue / this.amount;
                const monthCount = Math.log(-annuityCoefficient / (this.monthlyRate - annuityCoefficient))
                    / Math.log(this.monthlyRate + 1);

                this.setPeriodOfMonths(Math.ceil(monthCount));
            }
        },

        differentiatedMonthlyBasePay: {
            get: function() {
                return parseFloat(
                    (this.amount / this.monthCount).toFixed(this.getCurrenciesData.selectedCurrency.precision)
                );
            },
            set: function(newValue) {
                this.setPeriodOfMonths(Math.ceil(this.amount / newValue))
            }
        },

        payPlan() {
            switch (this.paymentType) {
                case PAYMENT_TYPE_ANNUITY:
                    return this.annuityPayPlan;
                case PAYMENT_TYPE_DIFFERENTIATED:
                    return this.differentiatedPayPlan;
            }
        },

        annuityPayPlan() {
            const payPlan = [];
            for (let paymentNumber = 1; paymentNumber <= this.monthCount; paymentNumber++) {
                payPlan.push(this.annuityMonthlyPay);
            }

            return payPlan;
        },

        differentiatedPayPlan() {
            const payPlan = [];
            for (let paymentNumber = 1; paymentNumber <= this.monthCount; paymentNumber++) {
                const currentCredit = this.amount - (this.differentiatedMonthlyBasePay * (paymentNumber - 1));
                const currentInterest = currentCredit * this.monthlyRate;
                const currentPay = this.differentiatedMonthlyBasePay + currentInterest;

                payPlan.push(currentPay.toFixed(this.getCurrenciesData.selectedCurrency.precision));
            }

            return payPlan;
        },

        monthCount() {
            switch (this.periodType) {
                case PERIOD_TYPE_YEARS:
                    return this.period * 12;
                case PERIOD_TYPE_DAYS:
                    return Math.ceil(this.period / 30);
                case PERIOD_TYPE_MONTHS:
                default:
                    return this.period;
            }
        },

        monthlyRate() {
            return this.rate / 12 / 100;
        },
    },

    data() {
        return {
            amount: 0,
            rate: 3,
            period: 1,
            periodType: PERIOD_TYPE_YEARS,
            periodTypes: [
                PERIOD_TYPE_YEARS,
                PERIOD_TYPE_MONTHS,
                PERIOD_TYPE_DAYS,
            ],
            paymentType: PAYMENT_TYPE_ANNUITY,
            paymentTypes: [
                PAYMENT_TYPE_ANNUITY,
                PAYMENT_TYPE_DIFFERENTIATED,
            ],
            pay: 0,
            isCollapsed: false,
        };
    },

    methods: {
        setPeriodOfMonths(monthCount) {
            switch (this.periodType) {
                case PERIOD_TYPE_YEARS:
                    this.period = parseFloat((monthCount / 12).toFixed(1));
                case PERIOD_TYPE_DAYS:
                    this.period = monthCount * 30;
                    break;
                case PERIOD_TYPE_MONTHS:
                default:
                    this.period = monthCount;
            }
        }
    },
}
</script>

<style scoped>

</style>
