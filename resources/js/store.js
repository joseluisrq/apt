import Vue from 'vue'
import Vuex from 'vuex'


Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        count: 0,
        titulo: 'Roles'
    },
    mutations: {
        increment: state => state.count++,
        decrement: state => state.count--
    }
})