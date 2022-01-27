import Vue from 'vue'
import Vuex from 'vuex'

import userBalance from "./modules/userBalance";

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        userBalance,
    }
})
