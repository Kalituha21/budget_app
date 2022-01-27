import {BalanceData} from "../../models/balanceData.model"
import {Currencies} from "../../models/currencies";

export default {
    state: {
        /** @type {BalanceData} */
        balanceData: new BalanceData(),
        currenciesData: new Currencies(),
    },

    getters: {
        getBalanceData(state) {
            return state.balanceData;
        },

        getCurrenciesData(state) {
            return state.currenciesData;
        },
    },

    actions: {
        setBalanceData(context) {
            axios.post('/balance/get-user-balance').then((response) => {
                context.commit('loadBalanceData', response.data);
            }).catch((error) => {
                // TODO handle errors, not just simply log in console !!!
                console.log(error);
            });
        },

        setCurrencyRates(context) {
            axios.post('/currency/get-rates').then((response) => {
                context.commit('loadCurrencyRateData', response.data);
            }).catch((error) => {
                // TODO handle errors, not just simply log in console !!!
                console.log(error);
            });
        }
    },

    mutations: {
        loadBalanceData(state, data) {
            state.balanceData = BalanceData.fromArray(data);
        },

        loadCurrencyRateData(state, data) {
            state.currenciesData.loadRates(data['rates']);
        },
    }
}
