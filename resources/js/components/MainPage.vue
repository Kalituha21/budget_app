<template>
    <div>
        <!--    Navigation    -->
        <div class="d-flex justify-content-between bg-white shadow-sm p-1">
            <div class="dropdown mr-auto">
                <button
                    class="btn btn-light dropdown-toggle"
                    type="button"
                    id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    {{ getCurrenciesData.selectedCurrency.symbol }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <button
                        v-for="currency in getCurrenciesData.currencies"
                        :key="currency.id"
                        :class="{disabled: currency.id === getCurrenciesData.selectedCurrency.id}"
                        class="dropdown-item"
                        @click="setCurrentCurrency(currency)"
                    >
                        {{ currency.name }}
                    </button>
                </div>
            </div>

            <div class="dropdown ml-auto">
                <button
                    id="dropdownMenu2"
                    class="btn btn-primary dropdown-toggle"
                    type="button"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                >
                    {{ tabs[selectedTab] }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <button
                        v-for="(title, component) in tabs"
                        v-show="selectedTab !== component"
                        :key="component"
                        class="dropdown-item"
                        type="button"
                        @click="selectedTab = component"
                    >
                        {{ title }}
                    </button>
                </div>
            </div>
        </div>

        <!--    Main component body    -->
        <component :is="selectedTab" :editbalance="openBalanceTab" class="height-94"></component>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";
import CurrentBalance from "./tabs/CurrentBalance";
import BalanceSheet from "./tabs/balanceSheet/BalanceSheet";
import SavingsCalculator from "./tabs/SavingsCalculator";
import CreditCalculator from "./tabs/CreditCalculator";
import CurrencyConvertor from "./tabs/CurrencyConvertor";

const DEFAULT_TAB = 'totals';
const BALANCE_TAB = 'balance';

// https://finuslugi.ru/potrebitelskie_kredity/stat_annuitetnye_i_differentsirovannye_platezhi
// https://www.raiffeisen.ru/wiki/kak-rasschitat-procenty-po-vkladu/

export default {
    name: "MainPage",

    components: {
        "totals": CurrentBalance,
        "balance": BalanceSheet,
        "savings": SavingsCalculator,
        "credit": CreditCalculator,
        "convertor": CurrencyConvertor,
    },

    computed: {
        ...mapGetters(["getCurrenciesData"]),
    },

    data() {
        return {
            tabs: {
                totals: "Current balance",
                balance: "Balance sheet",
                savings: "Savings calculator",
                credit: "Credit calculator",
                convertor: "Currency convertor",
            },
            selectedTab: DEFAULT_TAB,
            renderComponent: true,
        };
    },

    mounted() {
        this.setBalanceData();
        this.setCurrencyRates();
    },

    methods: {
        ...mapActions(["setBalanceData", "setCurrencyRates"]),

        openBalanceTab() {
            this.selectedTab = BALANCE_TAB;
        },

        /** @param currency {Currency} */
        setCurrentCurrency(currency) {
            this.getCurrenciesData.selectedCurrency = currency;
        }
    },
}
</script>

<style scoped>

</style>
