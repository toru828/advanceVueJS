export default {
    state: {
        accessToken: '',
    },
    getters: {
        getAccessToken: state => state.accessToken
    },
    mutations: {
        setAccessToken(state, accessToken) {
            state.accessToken = accessToken;
        }
    },
    actions: {
        async login ({ commit }, payload) {
            // laravel sanctum
            await axios.get('/sanctum/csrf-cookie', {});

            const url = '/api/login';
            return axios
                .post(url, {
                    email: payload.email,
                    password: payload.password,
                })
                .then((res) => {
                    const token = res.data.token;
                    commit('setAccessToken', token);
                    return token;
                });
        },
        async logout({ commit }) {
            const url = '/api/logout';
            await axios.post(url, {});
            commit('setAccessToken', '');
        },
    }
};
