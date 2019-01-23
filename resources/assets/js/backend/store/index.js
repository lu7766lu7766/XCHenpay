import Vue from "vue"
import Vuex from "vuex"
import createPersistedState from "vuex-persistedstate"

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        userInfo: {}
    },
    mutations: {
        setUserInfo(state, context) {
            state.userInfo = context
        }
    },
    actions: {
        getUserInfo: async ({commit}) => {
            var res = await Vue.prototype.$callApi('userInfo')
            commit('setUserInfo', res.data)
        }
    },
    plugins: [createPersistedState()]
});
