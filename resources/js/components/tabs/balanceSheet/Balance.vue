<template>
    <div class="container">
        <div class="row align-items-center height-100">
            <div class="container text-center h5">
                <!--        Current balance        -->
                <div class="h4">
                    <div class="row justify-content-center mb-3">Current Balance:</div>
                    <div class="row justify-content-center">
                        <div class="col-9 border border-dark rounded">
                            <div class="text-center my-2">
                                {{ getBalanceData.getTotalBalance(getCurrenciesData.selectedCurrency) }} {{ getCurrenciesData.selectedCurrency.symbol }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-1">=</div>

                <!--        Balance formula        -->
                <div class="row justify-content-center">
                    <div class="col-4 pr-0 text-right">assets</div>
                    <div class="col-2">-</div>
                    <div class="col-4 pl-0 text-left">liabilities</div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-5 py-2 my-0 border-left border-right h6">
                        {{ getBalanceData.getTotalAssets(getCurrenciesData.selectedCurrency) }} {{ getCurrenciesData.selectedCurrency.symbol }}
                    </div>
                    <div class="col-1"></div>
                    <div class="col-5 py-2 my-0 border-left border-right h6">
                        {{ getBalanceData.getTotalLiabilities(getCurrenciesData.selectedCurrency) }} {{ getCurrenciesData.selectedCurrency.symbol }}
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-5 py-2 border-left border-right border-bottom">
                        <button type="button" class="btn btn-outline-success px-4" @click="settab('assets')">
                            Edit
                        </button>
                    </div>
                    <div class="col-1"></div>
                    <div class="col-5 py-2 border-left border-right border-bottom">
                        <button type="button" class="btn btn-outline-success px-4" @click="settab('liabilities')">
                            Edit
                        </button>
                    </div>
                </div>

                <hr>

                <!--        Month budget        -->
                <div class="h4">
                    <div class="row justify-content-center mb-3">Month Budget:</div>
                    <div class="row justify-content-center">
                        <div class="col-9 border border-dark rounded">
                            <div class="text-center my-2">
                                {{ getBalanceData.getTotalBudget(getCurrenciesData.selectedCurrency) }} {{ getCurrenciesData.selectedCurrency.symbol }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-1">=</div>

                <!--        Budget formula        -->
                <div class="row justify-content-center">
                    <div class="col-4 pr-0 text-right">incomes</div>
                    <div class="col-2">-</div>
                    <div class="col-4 pl-0 text-left">expenses</div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-5 py-2 my-0 border-left border-right h6">
                        {{ getBalanceData.getTotalIncomes(getCurrenciesData.selectedCurrency) }} {{ getCurrenciesData.selectedCurrency.symbol }}
                    </div>
                    <div class="col-1"></div>
                    <div class="col-5 py-2 my-0 border-left border-right h6">
                        {{ getBalanceData.getTotalExpenses(getCurrenciesData.selectedCurrency) }} {{ getCurrenciesData.selectedCurrency.symbol }}
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-5 py-2 border-left border-right border-bottom">
                        <button type="button" class="btn btn-outline-success px-4" @click="settab('incomes')">
                            Edit
                        </button>
                    </div>
                    <div class="col-1"></div>
                    <div class="col-5 py-2 border-left border-right border-bottom">
                        <button type="button" class="btn btn-outline-success px-4" @click="settab('expenses')">
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "Balance",

    props: {
        settab: {
            type: Function,
            required: true,
        },
    },

    computed: {
        ...mapGetters(["getBalanceData", "getCurrenciesData"]),
    },
}
</script>

<style scoped>

</style>
