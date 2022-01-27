<template>
    <div>
        <ul class="nav nav-tabs nav-fill" role="tablist">
            <li v-for="tab in tabs" :key="tab" class="nav-item" role="presentation">
                <button
                    class="nav-link px-1"
                    :class="{ 'active': tab === selectedTab }"
                    data-toggle="tab"
                    role="tab"
                    :aria-selected="tab === selectedTab ? 'true' : 'false'"
                    @click="selectedTab = tab"
                >
                    {{ tab }}
                </button>
            </li>
        </ul>
        <div class="tab-content height-95">
            <component :is="selectedTab" :settab="setTab" class="height-100 scrollable"></component>
        </div>
    </div>
</template>

<script>
import Incomes from "./Incomes";
import Assets from "./Assets";
import Expenses from "./Expenses";
import Liabilities from "./Liabilities";
import Balance from "./Balance";

const DEFAULT_TAB = 'balance';

export default {
    name: "BalanceSheet",

    components: {
        Balance,
        Liabilities,
        Expenses,
        Assets,
        Incomes,
    },

    data() {
        return {
            tabs: [
                'balance',
                'incomes',
                'assets',
                'expenses',
                'liabilities',
            ],
            selectedTab: DEFAULT_TAB,
        };
    },

    methods: {
        setTab(tab) {
            if (this.tabs.indexOf(tab) === -1) {
                return;
            }

            this.selectedTab = tab;
        }
    },
}
</script>

<style scoped>

</style>
