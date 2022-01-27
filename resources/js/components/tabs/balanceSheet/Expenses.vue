<template>
    <div class="container">
        <div class="row border border-dark mt-3 bg-white">
            <div class="col-2 h5 my-auto pr-0">Total:</div>
            <div class="col-6 h5 my-auto text-center">
                {{ getBalanceData.getTotalExpenses(getCurrenciesData.selectedCurrency) }} {{ getCurrenciesData.selectedCurrency.symbol }}
            </div>
            <div class="col-4 text-center my-auto">
                <button
                    class="btn btn-primary my-2"
                    type="button"
                    data-toggle="collapse"
                    data-target="#addExpense"
                    aria-expanded="false"
                    aria-controls="addExpense"
                >
                    + ADD
                </button>
            </div>
        </div>
        <div class="collapse row bg-white" id="addExpense">
            <div class="container">
                <div class="row my-2">
                    <div class="col-4 my-auto">Amount</div>
                    <NumericInput
                        v-model.number="newExpense.amount"
                        class="col-8"
                        :min="currencyMin"
                        :max="9999999999.99"
                        :precision="getCurrenciesData.getById(newExpense.currency).precision"
                    />
                </div>
                <div class="row mb-2">
                    <div class="col-4 my-auto">
                        <label for="currency" class="my-auto">Currency</label>
                    </div>
                    <div class="col-4 my-auto">
                        <select
                            v-model="newExpense.currency"
                            id="currency"
                            class="form-control"
                        >
                            <option
                                v-for="currency in getCurrenciesData.currencies"
                                :key="currency.id"
                                :value="currency.id"
                            >
                                {{ currency.name }}
                            </option>
                        </select>
                    </div>
                    <div class="col-4 my-auto text-right">
                        <button
                            type="button"
                            class="btn btn-outline-success"
                            @click="newExpense.saveNewExpense(setBalanceData, true)"
                        >
                            SAVE
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-for="expense in getBalanceData.expenses"
            :key="expense.id"
            class="row border border-dark my-2 bg-white"
        >
            <div class="col-5 h6 text-right px-1 my-auto">
                <span v-if="editableExpenseId === expense.id">
                    <NumericInput
                        v-model.number="expense.amount"
                        :min="getCurrencyMin(expense.currency)"
                        :max="9999999999.99"
                        :precision="getCurrenciesData.getById(expense.currency).precision"
                        input-class="text-right"
                    />
                </span>
                <span v-else>
                    {{ expense.amount }}
                </span>
            </div>
            <div class="col-1 h6 text-left px-0 my-auto">
                {{ expense.currency }}
            </div>
            <div class="col-3 my-auto pr-1 text-right">
                <button
                    v-if="editableExpenseId !== expense.id"
                    type="button"
                    class="btn btn-outline-info my-2 w-100"
                    @click="setEditableExpense(expense.id)"
                >
                    EDIT
                </button>
                <button
                    v-else
                    type="button"
                    class="btn btn-outline-success my-2 w-100"
                    @click="expense.editExpense(); unsetEditableExpense()"
                >
                    SAVE
                </button>
            </div>
            <div class="col-3 my-auto pl-1 text-right">
                <button
                    type="button"
                    class="btn btn-outline-danger my-2 w-100 text-center px-1"
                    @click="expense.deleteExpense(setBalanceData)"
                >
                    DELETE
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters, mapActions} from "vuex";
import {Expense} from "../../../models/balanceData.model";
import NumericInput from "../../elements/NumericInput";

export default {
    name: "Expenses",

    components: {
        NumericInput,
    },

    computed: {
        ...mapGetters(["getBalanceData", "getCurrenciesData"]),

        currencyMin() {
            return this.getCurrencyMin(this.newExpense.currency);
        },
    },

    data() {
        return {
            newExpense: new Expense(),
            editableExpenseId: null,
        };
    },

    created() {
        this.newExpense.currency = this.getCurrenciesData.selectedCurrency.id;
    },

    methods: {
        ...mapActions(["setBalanceData"]),

        setEditableExpense(id) {
            this.editableExpenseId = id;
        },

        unsetEditableExpense() {
            this.editableExpenseId = null;
        },

        getCurrencyMin(currencyId) {
            return 1 / Math.pow(10, this.getCurrenciesData.getById(currencyId).precision);
        },
    },
}
</script>

<style scoped>

</style>
