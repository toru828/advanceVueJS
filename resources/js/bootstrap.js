window._ = require('lodash');
import store from './store';
import router from './router';
import Swal from 'sweetalert2';
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.interceptors.request.use(config => {
    const accessToken = store.state.accessor.accessToken;
    config.headers.common['Authorization'] = accessToken ? `Bearer ${accessToken}` : ``;
    return config;
});


axios.interceptors.response.use((response) => {
    return Promise.resolve(response);
}, error => {
    // handle the response error
    const url = error.config.url;
    console.log(store.state);
    if (error.response.status === 401) {
        if(url == '/api/login') {
            Swal.fire({
                title: `${error.response.status} ${error.response.statusText}`,
                text: "Wrong username or password.",
                icon: 'error',

            });
        } else if(url != '/api/logout') {
            Swal.fire({
                title: `${error.response.status} ${error.response.statusText}`,
                text: "Your login authentication has expired or you are not logged in. Please log in again.",
                icon: 'error',
            });
            store.dispatch('logout');
            router.push('/');
        }

    } else if (error.response.status === 404) {
        Swal.fire({
            title: `${error.response.status} ${error.response.statusText}`,
            text: "A system error has occurred. Sorry to trouble you, but please try again.",
            icon: 'error',
        });
        store.dispatch('logout');
        router.push('/');
    } else {
        Swal.fire(
            `${error.response.status} ${error.response.statusText}`,
            error.response.data.message + JSON.stringify(error.response.data.errors).replaceAll('{"email":["', "").replaceAll('"]}', ""),
            'error'
        );
        router.push('/users');
    }
    return Promise.reject(error);
});

