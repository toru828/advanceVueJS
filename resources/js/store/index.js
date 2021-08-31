import Vue from "vue"
import Vuex from 'vuex'

import accessToken from './modules/accessToken';
import persistedState from "vuex-persistedstate";
import Cookies from "js-cookie";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: { accessor: accessToken },
    plugins: [
        persistedState({
            paths: ['accessor.accessToken'],
            storage: {
                getItem: key => Cookies.get(key),
                setItem: (key, value) => Cookies.set(key, value, { expires: 3, secure: false }),
                removeItem: key => Cookies.remove(key, { path: '/', domain: window.location.hostname })
            }
        })
    ]
})
