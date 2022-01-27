<template>
    <div class="container">
        <div class="row align-items-center height-100">
            <div class="container">
                <div class="row justify-content-center mb-3 h3">Current Balance:</div>

                <div class="row justify-content-center">
                    <div class="col-9 border border-dark rounded">
                        <div class="h4 text-center my-2">
                            {{ getBalanceData.getTotalBalance(getCurrenciesData.selectedCurrency) }} {{ getCurrenciesData.selectedCurrency.symbol }}
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-3 px-1 border-left border-right border-bottom border-dark">
                        <div class="h6 text-right my-2">assets:</div>
                    </div>
                    <div class="col-5 border-right border-bottom border-dark">
                        <div class="h6 text-right my-2">
                            {{ getBalanceData.getTotalAssets(getCurrenciesData.selectedCurrency) }} {{ getCurrenciesData.selectedCurrency.symbol }}
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-3 px-1 border-left border-right border-bottom border-dark">
                        <div class="h6 text-right my-2">liabilities:</div>
                    </div>
                    <div class="col-5 border-bottom border-right border-dark">
                        <div class="h6 text-right my-2">
                            {{ getBalanceData.getTotalLiabilities(getCurrenciesData.selectedCurrency) }} {{ getCurrenciesData.selectedCurrency.symbol }}
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center mt-5">
                    <div class="col-11 border border-dark rounded">
                        <div class="row justify-content-center">
                            <div class="col-5 px-1 border-left border-right border-dark bg-light-gray">
                                <div class="h5 text-center my-2">Month budget:</div></div>
                            <div class="col-6 pr-0">
                                <div class="h5 text-right my-2 text-muted">
                                    {{ getBalanceData.getTotalBudget(getCurrenciesData.selectedCurrency) }} {{ getCurrenciesData.selectedCurrency.symbol }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-9 d-flex justify-content-end">
                        <button type="button" class="btn btn-success px-4" @click="editbalance">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    name: "CurrentBalance",

    props: {
        editbalance: {
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
